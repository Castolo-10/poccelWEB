<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class PayMethod extends Model
{

	public const TABLE = 'info_pago';
	public const FIELD = [
		'customer' => PayMethod::TABLE.'.id_cliente',
		'cc_number' => PayMethod::TABLE.'.numero_tarjeta',
		'cc_exp' => PayMethod::TABLE.'.expiracion',
		'date' => PayMethod::TABLE.'.fecha',
	];

	public $customer;
	public $cc_number;
	public $cc_exp;

    public function __construct ($obj) {
    	$this->customer = $obj->customer;
    	$this->cc_number = $obj->cc_number;
    	$this->cc_exp = $obj->cc_exp;
    }

    public static function get ($customer, $mask=false) {
    	$data = DB::table(PayMethod::TABLE)
    		->distinct()
    		->select(
    			DB::raw(PayMethod::FIELD['cc_number'].' AS cc_number'),
    			DB::raw(PayMethod::FIELD['cc_exp'].' AS cc_exp'),
    			DB::raw(PayMethod::FIELD['customer'].' AS customer')
    		)
			->where(PayMethod::FIELD['customer'], $customer)
			->get();

		$cc_info = $data->toArray();

		if ($mask) {
			foreach ($data as $cc) {
				$cc->cc_number = PayMethod::mask($cc->cc_number);
			}
		}

		return $cc_info;
    }

    public function save_ () {
    	return DB::table(PayMethod::TABLE)
			->insert([
				PayMethod::FIELD['customer'] => $this->customer,
				PayMethod::FIELD['cc_number'] => $this->cc_number,
				PayMethod::FIELD['cc_exp'] => $this->cc_exp,
				PayMethod::FIELD['date'] => date('Y-m-d')
			]);
    }

    private static function mask ($cc_number) {
		return str_repeat('*', 12).substr($cc_number, -4);
	}
}
