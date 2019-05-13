<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model
{
    public static function paginate ($pageSize) {
    	return DB::table('producto')
        ->join('imagen_producto', 'producto.id_producto', '=', 'imagen_producto.id_producto')
        ->select('producto.*', DB::raw("convert_from(imagen_producto.string_img, 'UTF8') as img_producto"))
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
