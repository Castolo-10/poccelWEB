<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use NumberFormatter;
use DB;

class Customer extends Model
{
	public $id;
	public $email;
	public $birthdate;
	public $gender;
	public $name;
	public $p_surname;
	public $m_surname;
	public $address;
	public $phone;
	public $account = [];

	public function __construct () {}

    public static function attemp ($email, $password) {
    	$data = DB::table('cliente')
    		->where([['correo', $email], ['password', $password]])
    		->select('id_cliente')
    		->limit(1)
    		->get();

    	if (count($data)) {
    		return $data[0]->id_cliente;
    	}
    	return false;
    }

	public static function get($id) {
		$data = DB::table('cliente')
    		->where('id_cliente', $id)
    		->limit(1)
    		->get();

    	if (count($data)) {
    		$customer = new Customer();
    		$customer->id = $data[0]->id_cliente;
			$customer->email = $data[0]->correo;
			$customer->birthdate = $data[0]->fecha_nacimiento;
			$customer->gender = \strtoupper($data[0]->sexo);
			$customer->name = $data[0]->nombre;
			$customer->p_surname = $data[0]->a_paterno;
			$customer->m_surname = $data[0]->a_materno;
			$customer->phone = $data[0]->telefono;
			$customer->address = [
				'street' => $data[0]->calle,
				'number' => $data[0]->numero_dom,
				'suburb' => $data[0]->colonia,
				'city' => $data[0]->ciudad,
				'postal_code' => $data[0]->cp,
			];
			return $customer;
    	}
    	return null;
	}

	public function isPasswordMatch($passwd) {
		return DB::table('cliente')->where([
			['id_cliente', $this->id],
			['password', $passwd]
		])->exists();
	}

	public function updatePassword($passwd) {
		$res = DB::table('cliente')
			->where('id_cliente', $this->id)
			->update(['password' => $passwd]);
        return $res;
	}

	public function paidMethods () {
		$data = DB::table('info_pago')
			->where('id_cliente', $this->id)
			->orderBy('fecha', 'desc')
			->get();
		$cc_info = [];
		if (count($data)) {
			foreach ($data as $cc) {
				array_push($cc_info, [
					'number' => maskCreditCardNumber($cc->numero_tarjeta),
					'exp_date' => $cc->expiracion,
					'last_usage' => $cc->fecha,
				]);
			}
		}
		$this->account['cc_info'] = $cc_info;
		return $this;
	}

	public function accountDetails () {
		$data_sucursal_1 = $this->accountDetailsBySucursal(
			env('DB_CONNECTION_SUCURSAL_1'));
		$data_sucursal_2 = $this->accountDetailsBySucursal(
			env('DB_CONNECTION_SUCURSAL_2'));
		
		$this->account['details'] = array_merge($data_sucursal_1, $data_sucursal_2);
		
		$this->account['total'] = $this->calcTotal();
		return $this;
	}

	private function accountDetailsBySucursal ($db_conn) {
		$data = DB::connection($db_conn)->table(DB::raw(
			'(SELECT cuenta.*, venta.fecha AS fecha_compra, SUM(abono.cantidad) AS abonado, cuenta.saldo - SUM(abono.cantidad) AS restante FROM cuenta LEFT JOIN venta ON venta.id_venta = cuenta.id_venta LEFT JOIN abono ON cuenta.id_cuenta = abono.id_cuenta WHERE venta.id_cliente = ? GROUP BY cuenta.id_cuenta, venta.fecha) AS detalle_cuentas'))
		->where('restante', '>', DB::raw("'0'"))
		->setBindings([$this->id])
		->get();

		return $data->toArray();
	}

	private function calcTotal () {
		$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
		$curr = 'USD';
		$total = 0.0;
		foreach ($this->account['details'] as $acc) {
			$currency = $formatter->parseCurrency($acc->restante, $curr);
			$total += $currency;
		}
		return $formatter->formatCurrency($total, $curr);
	}
}


function maskCreditCardNumber($cc_number) {
	return substr($cc_number, 0, 6).str_repeat('*', 6).substr($cc_number, -4);
}

