<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Payment extends Model
{
	public $amount;
	public $account;

    public const TABLE = 'abono';
	public const FIELD = [
		'all' => Payment::TABLE.'.*',
		'id' => Payment::TABLE.'.id_abono',
		'account' => Payment::TABLE.'.id_cuenta',
		'amount' => Payment::TABLE.'.cantidad',
		'date' => Payment::TABLE.'.fecha',
	];

	public function __construct ($account, $amount) {
		$this->account = $account;
		$this->amount = $amount;
	}


	public static function recently ($account, $conn) {
		$n = floor(env('DEFAULT_PAGE_SIZE')/2);
		return DB::connection($conn)
			->table(Payment::TABLE)
			->where(Payment::FIELD['account'], $account)
			->orderBy(Payment::FIELD['date'], 'desc')
			->orderBy(Payment::FIELD['id'], 'desc')
			->limit($n)
			->get();
	}

	public function save_ ($conn) {
		$nextId = DB::selectOne("SELECT nextval('abono_id_abono_seq') AS val")->val;
		return DB::connection($conn)
			->table(Payment::TABLE)
			->insert([
				'id_abono' => $nextId,
				'id_cuenta' => $this->account,
				'cantidad' => $this->amount,
				'fecha' => date('Y-m-d'),
			]);
	}

}
