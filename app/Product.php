<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model
{
    public const DEFAULT_SORT = 'producto.id_producto';

    public static function paginate ($pageSize, $q='', $sort=Product::DEFAULT_SORT) {
    	return DB::table('producto')
        ->join('imagen_producto', 'producto.id_producto', '=', 'imagen_producto.id_producto')
        ->select('producto.*', DB::raw("convert_from(imagen_producto.string_img, 'UTF8') as img_producto"))
        ->where('nombre_producto', 'LIKE', '%'.$q.'%')
        ->orWhere('descripcion', 'LIKE', '%'.$q.'%')
        ->orderBy($sort)
        ->paginate($pageSize);
    }

    public static function random($size) {
    	return DB::table('producto')
        ->join('imagen_producto', 'producto.id_producto', '=', 'imagen_producto.id_producto')
        ->select('producto.*', DB::raw("convert_from(imagen_producto.string_img, 'UTF8') as img_producto"))
       	->inRandomOrder()
       	->limit($size)
        ->get();
    }
}
