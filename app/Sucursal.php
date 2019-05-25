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

	private const WH_TABLE = 'almacen';
	private const WH_FIELD = [
		'product' => Sucursal::WH_TABLE.'.id_producto',
		'stock' => Sucursal::WH_TABLE.'.existencia'
	];

	public function __construct($obj) {
		$this->id_sucursal = $obj->id_sucursal;
		$this->nombre = $obj->nombre;
		$this->calle = $obj->calle;
		$this->num_dom = $obj->num_dom;
		$this->colonia = $obj->colonia;
		$this->cp = $obj->cp;
		$this->ciudad = $obj->ciudad;
	}

    public static function get ($id) {
    	$data = DB::table(Sucursal::TABLE)
			->where(Sucursal::FIELD['id'], $id)
			->limit(1)
			->get();
		if (count($data)) {
			return new Sucursal($data[0]);
		}
		return null;
    }

    public function inStock ($id) {
    	$data = DB::connection(env('DB_CONNECTION_SUCURSAL_'.$this->id_sucursal))
    		->table(Sucursal::WH_TABLE)
    		->where(Sucursal::WH_FIELD['product'], $id)
    		->limit(1)
    		->get();

    	$stock = 0;
    	if (count($data)) {
    		$stock = $data[0]->existencia;
    	}
    	$this->stock = $stock;
    	return $this;
    }
}
