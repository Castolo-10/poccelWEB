<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use NumberFormatter;
use DB;

class Account extends Model
{
    public $list;
    public $total;
    public $info;
    public $details;
    public $conn;

    private $formatter;
	private $curr;

	private const TABLE = 'cuenta';
	private const FIELD = [
		'all' => Account::TABLE.'.*',
		'id' => Account::TABLE.'.id_cuenta',
		'sale' => Account::TABLE.'.id_venta',
		'balance' => Account::TABLE.'.saldo',
	];

	public function __construct () {
		$this->formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
		$this->curr = 'USD';
		$this->details = (object) [];
	}

    public static function getAllByUser ($id) {
    	try {
			$data_sucursal_1 = Account::getAllBySucursal(
				env('DB_CONNECTION_SUCURSAL_1'), $id);
		} catch (QueryException $e) {
			$data_sucursal_1 = [];
		}

		try {
			$data_sucursal_2 = Account::getAllBySucursal(
				env('DB_CONNECTION_SUCURSAL_2'), $id);
		} catch (QueryException $e) {
			$data_sucursal_2 = [];
		}
		
		$acc = new Account();
		$acc->list = array_merge($data_sucursal_1, $data_sucursal_2);
		$acc->calcTotal();
		return $acc;
	}

	public static function get ($accId, $userId) {
		$acc = new Account();
		$acc->conn = Account::searchConnection($accId);

		$data = DB::connection($acc->conn)
			->table(Account::TABLE)
			->leftJoin(Sale::TABLE, Sale::FIELD['id'], Account::FIELD['sale'])
			->leftJoin(Payment::TABLE, Account::FIELD['id'], Payment::FIELD['account'])
			->where([
				[Sale::FIELD['customer'], $userId],
				[Account::FIELD['id'], $accId]])
			->select(
				Account::FIELD['all'],
				DB::raw(Sale::FIELD['date'].' AS fecha_compra'),
				DB::raw('SUM('.Payment::FIELD['amount'].') AS abonado'),
				DB::raw(Account::FIELD['balance'].'-SUM('.Payment::FIELD['amount'].') AS restante'),
				DB::raw(Account::FIELD['balance'].'/1.16*.16 AS iva'))
			->groupBy(Account::FIELD['id'], Sale::FIELD['date'])
			->limit(1)
			->get();

		if (count($data)) {
			$acc->info = $data[0];
			return $acc;
		}

		return null;
	}

	/* abonar */
	public function credit ($amount, $ccInfo) {
		$debt = $this->formatter->parseCurrency($this->info->restante, $this->curr);

		if ($amount <= $debt) {
			$payment = new Payment($this->info->id_cuenta, $amount);
			$payMethod = new PayMethod($ccInfo);
			
			DB::connection($this->conn)->beginTransaction();
			DB::beginTransaction();

			try {
				$payment_register = $payment->save_($this->conn);
				$cc_register = $payMethod->save_();

				if ($payment_register && $cc_register) {
					DB::connection($this->conn)->commit();
					DB::commit();
					return true;
				}

			} catch (QueryException $e) {}

			DB::connection($this->conn)->rollback();
			DB::rollback();
		}
		return false;
	}

	public function loadDetails () {
		/* sucursal */
		$this->details->sucursal = Sucursal::get(substr($this->conn, -1));

		/* abonos */
		$this->details->credit = Payment::recently($this->info->id_cuenta, $this->conn);
		
		/* detalle compra */
		$this->details->purchase = Sale::getDetails($this->info->id_venta, $this->conn);
		return $this;
	}

	private static function searchConnection ($accId) {
		$conn = env('DB_CONNECTION_SUCURSAL_1');
		if (!(DB::connection($conn)
			->table(Account::TABLE)
			->where(Account::FIELD['id'], $accId)
			->limit(1)
			->exists()))
		{
			$conn = env('DB_CONNECTION_SUCURSAL_2');
		}
		return $conn;
	}

	private static function getAllBySucursal ($conn, $userId) {
		$data = DB::connection($conn)->table(DB::raw(
			'(SELECT '.Account::FIELD['all'].','.Sale::FIELD['date'].' AS fecha_compra, SUM('.Payment::FIELD['amount'].') AS abonado,'.Account::FIELD['balance'].'-SUM('.Payment::FIELD['amount'].') AS restante FROM '.Account::TABLE.' LEFT JOIN '.Sale::TABLE.' ON '.Sale::FIELD['id'].'='.Account::FIELD['sale'].' LEFT JOIN '.Payment::TABLE.' ON '.Account::FIELD['id'].'='.Payment::FIELD['account'].' WHERE '.Sale::FIELD['customer'].'=? GROUP BY '.Account::FIELD['id'].','.Sale::FIELD['date'].') AS detalle_cuentas'))
		->where('restante', '>', DB::raw("'0'"))
		->setBindings([$userId])
		->get();

		return $data->toArray();
	}

	private function calcTotal () {
		$total = 0.0;
		foreach ($this->list as $acc) {
			$currency = $this->formatter->parseCurrency($acc->restante, $this->curr);
			$total += $currency;
		}
		$this->total = $this->formatter->formatCurrency($total, $this->curr);
		return $this->total;
	}
}
