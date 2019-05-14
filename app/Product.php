<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model
{
    public const SORTING_CRITERIA = [
        'name' => 'producto.nombre_producto',
        'price' => 'producto.precio_venta'
    ];

    public static function paginate ($pageSize, $q=null, $sort=null) {
    	$qry = DB::table('producto')
        ->join('imagen_producto', 'producto.id_producto', '=', 'imagen_producto.id_producto')
        ->select('producto.*', DB::raw("convert_from(imagen_producto.string_img, 'UTF8') as img_producto"));
        if ($q) {
            $qry->where('nombre_producto', 'LIKE', '%'.$q.'%')
                ->orWhere('descripcion', 'LIKE', '%'.$q.'%');
            }
        if ($sort) {
            $qry->orderBy(Product::SORTING_CRITERIA[$sort]);
            }
        
        return $qry->paginate($pageSize);
    }

    public static function random ($size) {
    	return DB::table('producto')
        ->join('imagen_producto', 'producto.id_producto', '=', 'imagen_producto.id_producto')
        ->select('producto.*', DB::raw("convert_from(imagen_producto.string_img, 'UTF8') as img_producto"))
       	->inRandomOrder()
       	->limit($size)
        ->get();
    }
}
