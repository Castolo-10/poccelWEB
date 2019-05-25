<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use DB;

class Product extends Model
{
    public $stock = [];

    private const TABLE = 'producto';
    private const FIELD = [
        'all' => Product::TABLE.'.*',
        'id' => Product::TABLE.'.id_producto',
        'name' => Product::TABLE.'.nombre_producto',
        'description' => Product::TABLE.'.descripcion',
        'price' => Product::TABLE.'.precio_venta'
    ];

    public const SORTING_CRITERIA = [
        'name' => Product::FIELD['name'],
        'price' => Product::FIELD['price']
    ];

    private const IMG_TABLE = 'imagen_producto';
    private const IMG_FIELD = [
        'product' => Product::IMG_TABLE.'.id_producto',
        'img' => Product::IMG_TABLE.'.string_img'
    ];

    public function __construct($obj) {
        $this->id_producto = $obj->id_producto;
        $this->nombre_producto = $obj->nombre_producto;
        $this->descripcion = $obj->descripcion;
        $this->precio_venta = $obj->precio_venta;
        $this->img_producto = $obj->img_producto;
    }

    public static function paginate ($pageSize, $q=null, $sort=null) {
    	return DB::table(Product::TABLE)
        ->join(Product::IMG_TABLE, Product::FIELD['id'], '=', Product::IMG_FIELD['product'])
        ->select(Product::FIELD['all'],
            DB::raw('convert_from('.Product::IMG_FIELD['img'].", 'UTF8') as img_producto"))
        ->when($q, function($query, $q){
            return $query->where(Product::FIELD['name'], 'LIKE', '%'.$q.'%')
                ->orWhere(Product::FIELD['description'], 'LIKE', '%'.$q.'%');
            })
        ->when($sort, function($query, $sort){
            return $query->orderBy(Product::SORTING_CRITERIA[$sort['by']], $sort['order']);
            })
        ->paginate($pageSize);
    }

    public static function get ($id) {
        $data = DB::table(Product::TABLE)
            ->join(Product::IMG_TABLE, Product::FIELD['id'], '=', Product::IMG_FIELD['product'])
            ->select(Product::FIELD['all'],
                DB::raw('convert_from('.Product::IMG_FIELD['img'].", 'UTF8') as img_producto"))
            ->where(Product::FIELD['id'], $id)
            ->limit(1)
            ->get();
        if (count($data)) {
            return new Product($data[0]);
        }
        return null;
    }

    public function inStock () {
        try {
            $s1 = Sucursal::get(1)->inStock($this->id_producto);
        } catch (QueryException $e) {
            $s1 = (object)['stock' => 0];
        }
        
        try {
            $s2 = Sucursal::get(2)->inStock($this->id_producto);
        } catch (QueryException $e) {
            $s2 = (object)['stock' => 0];
        }

        if ($s1->stock > 0) {
            array_push($this->stock, $s1);
        }
        if ($s2->stock > 0) {
            array_push($this->stock, $s2);
        }
        return $this;
    }

    public static function whereIn ($arrayIds, $onlyName=false) {
        if ($onlyName) {
            return DB::table(Product::TABLE)
                ->select(Product::FIELD['name'], Product::FIELD['id'])
                ->whereIn(Product::FIELD['id'], $arrayIds)
                ->get();
        }
        return DB::table(Product::TABLE)
            ->join(Product::IMG_TABLE, Product::FIELD['id'], '=', Product::IMG_FIELD['product'])
            ->select(Product::FIELD['all'],
                DB::raw('convert_from('.Product::IMG_FIELD['img'].", 'UTF8') as img_producto"))
            ->whereIn(Product::FIELD['id'], $arrayId)
            ->get();
    }

    public static function random ($size) {
    	return DB::table(Product::TABLE)
        ->join(Product::IMG_TABLE, Product::FIELD['id'], '=', Product::IMG_FIELD['product'])
        ->select(Product::FIELD['all'],
            DB::raw('convert_from('.Product::IMG_FIELD['img'].", 'UTF8') as img_producto"))
       	->inRandomOrder()
       	->limit($size)
        ->get();
    }
}
