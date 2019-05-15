<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use NumberFormatter;
use DB;

class Account extends Model
{
    public $list;
    public $total;
    public $info;
    public $details = [];

    public static function allByUser ($id) {
		$data_sucursal_1 = Account::bySucursal(
			env('DB_CONNECTION_SUCURSAL_1'), $id);
		$data_sucursal_2 = Account::bySucursal(
			env('DB_CONNECTION_SUCURSAL_2'), $id);
		
		$acc = new Account();
		$acc->list = array_merge($data_sucursal_1, $data_sucursal_2);
		$acc->calcTotal();
		return $acc;
	}

	public static function get($accId, $userId) {
		$conn = Account::searchConnection($accId);

		$data = DB::connection($conn)
			->table('cuenta')
			->leftJoin('venta', 'venta.id_venta', 'cuenta.id_venta')
			->leftJoin('abono', 'cuenta.id_cuenta', 'abono.id_cuenta')
			->where([
				['venta.id_cliente', $userId],
				['cuenta.id_cuenta', $accId]])
			->select(
				'cuenta.*',
				DB::raw('venta.fecha AS fecha_compra'),
				DB::raw('SUM(abono.cantidad) AS abonado'),
				DB::raw('cuenta.saldo - SUM(abono.cantidad) AS restante'))
			->groupBy('cuenta.id_cuenta', 'venta.fecha')
			->limit(1)
			->get();

		if (count($data)) {
			$acc = new Account();
			$acc->info = $data[0];
			$acc->loadDetails($conn);
			return $acc;
		}

		return null;
	}

	private function loadDetails($conn) {
		/* abonos */
		$this->details['credit'] = DB::connection($conn)
			->table('abono')
			->where('id_cuenta', $this->info->id_cuenta)
			->orderBy('fecha', 'desc')
			->get();
		
		/* detalle compra */
		$items = DB::connection($conn)
			->table('lista_prod')
			->select(
				'id_producto',
				'cantidad',
				'precio',
				DB::raw('cantidad * precio as total'))
			->where('id_venta', $this->info->id_venta)
			->orderBy('id_producto')
			->get();
		
		$itemsId = [];

		foreach ($items as $it) {
			array_push($itemsId, $it->id_producto);
			}

		$it_name = Product::whereIn($itemsId, true)->toArray(); // onlyName=true
		usort($it_name, function($first, $second){ return $first->id_producto > $second->id_producto; });

		foreach ($items as $key => $it) {
			$items[$key]->nombre_producto = $it_name[$key]->nombre_producto;
			}

		$this->details['purchase'] = $items;
		return $this;
	}

	private static function searchConnection($accId) {
		$conn = env('DB_CONNECTION_SUCURSAL_1');
		if (!(DB::connection($conn)->table('cuenta')->where('id_cuenta', $accId)->limit(1)->exists())) {
			$conn = env('DB_CONNECTION_SUCURSAL_2');
		}
		return $conn;
	}

	private static function bySucursal ($conn, $userId) {
		$data = DB::connection($conn)->table(DB::raw(
			'(SELECT cuenta.*, venta.fecha AS fecha_compra, SUM(abono.cantidad) AS abonado, cuenta.saldo - SUM(abono.cantidad) AS restante FROM cuenta LEFT JOIN venta ON venta.id_venta = cuenta.id_venta LEFT JOIN abono ON cuenta.id_cuenta = abono.id_cuenta WHERE venta.id_cliente = ? GROUP BY cuenta.id_cuenta, venta.fecha) AS detalle_cuentas'))
		->where('restante', '>', DB::raw("'0'"))
		->setBindings([$userId])
		->get();

		return $data->toArray();
	}

	private function calcTotal () {
		$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
		$curr = 'USD';
		$total = 0.0;
		foreach ($this->list as $acc) {
			$currency = $formatter->parseCurrency($acc->restante, $curr);
			$total += $currency;
		}
		$this->total = $formatter->formatCurrency($total, $curr);
		return $this->total;
	}
}
