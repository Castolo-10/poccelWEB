<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class PayMethod extends Model
{

	public const TABLE = 'info_pago';
	public const FIELD = [
		'customer' => PayMethod::TABLE.'.id_cliente',
		'number' => PayMethod::TABLE.'.numero_tarjeta',
		'exp' => PayMethod::TABLE.'.expiracion',
		'date' => PayMethod::TABLE.'.fecha',
	];

	public $customer;
	public $number;
	public $exp;

    public function __construct ($obj) {
    	$this->customer = $obj->customer;
    	$this->number = $obj->number;
    	$this->exp = $obj->exp;
    }

    public static function get ($customer, $mask=false) {
    	$data = DB::table(PayMethod::TABLE)
    		->distinct()
    		->select(
    			DB::raw(PayMethod::FIELD['number'].' AS number'),
    			DB::raw(PayMethod::FIELD['exp'].' AS exp'),
    			DB::raw(PayMethod::FIELD['customer'].' AS customer')
    		)
			->where(PayMethod::FIELD['customer'], $customer)
			->get();

		$cc_info = $data->toArray();

		if ($mask) {
			foreach ($data as $cc) {
				$cc->number = PayMethod::mask($cc->number);
			}
		}

		return $cc_info;
    }

    public function save_ () {
    	return DB::table(PayMethod::TABLE)
			->insert([
				'id_cliente' => $this->customer,
				'numero_tarjeta' => $this->number,
				'expiracion' => $this->exp,
				'fecha' => date('Y-m-d')
			]);
    }

    public static function mask ($cc_number) {
		return str_repeat('*', 12).substr($cc_number, -4);
	}

	public static function unMask($cc) {
		$data = DB::table(PayMethod::TABLE)
			->select(DB::raw(PayMethod::FIELD['number'].' AS number'))
			->where(PayMethod::FIELD['customer'], $cc->customer)
			->whereRaw('cast('.PayMethod::FIELD['number'].' as char(16)) like \'%'.substr($cc->number, -4).'\'')
			->where(PayMethod::FIELD['exp'], $cc->exp)
			->limit(1)
			->get();

		if (count($data)) {
			return $data[0]->number;
		}
		return null;
	}
}
