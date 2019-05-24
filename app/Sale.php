<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Sale extends Model
{
    public const TABLE = 'venta';
    private const PRODUCTS_TABLE = 'lista_prod';

	public const FIELD = [
		'all' => Sale::TABLE.'.*',
		'id' => Sale::TABLE.'.id_venta',
		'customer' => Sale::TABLE.'.id_cliente',
		'date' => Sale::TABLE.'.fecha',
		
	];

	private const PRODUCT_FIELD = [
		'id' => Sale::PRODUCTS_TABLE.'.id_producto',
		'quantity' => Sale::PRODUCTS_TABLE.'.cantidad',
		'price' => Sale::PRODUCTS_TABLE.'.precio',
		'sale' => Sale::PRODUCTS_TABLE.'.id_venta',
	];

	public static function getDetails ($id, $conn) {
		$items = DB::connection($conn)
			->table(Sale::PRODUCTS_TABLE)
			->select(
				Sale::PRODUCT_FIELD['id'],
				Sale::PRODUCT_FIELD['quantity'],
				Sale::PRODUCT_FIELD['price'],
				DB::raw(Sale::PRODUCT_FIELD['quantity'].'*'.Sale::PRODUCT_FIELD['price'].' as total'))
			->where(Sale::PRODUCT_FIELD['sale'], $id)
			->orderBy(Sale::PRODUCT_FIELD['id'])
			->get();
		
		$itemsId = [];
		foreach ($items as $it) { array_push($itemsId, $it->id_producto); }

		$it_name = Product::whereIn($itemsId, true)->toArray(); // onlyName=true
		usort($it_name, function($first, $second){ return $first->id_producto > $second->id_producto; });

		foreach ($items as $key => $it) { $items[$key]->nombre_producto = $it_name[$key]->nombre_producto; }

		return $items;
	}

}
