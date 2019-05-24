<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Sucursal extends Model
{
	private const TABLE = 'sucursal';
	private const FIELD = [
		'id' => Sucursal::TABLE.'.id_sucursal'
	];

    public static function get ($id) {
    	return DB::table(Sucursal::TABLE)
			->where(Sucursal::FIELD['id'], $id)
			->limit(1)
			->get()[0];
    }
}
