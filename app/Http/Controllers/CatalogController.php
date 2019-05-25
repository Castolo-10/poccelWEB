<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use \App\Product;

class CatalogController extends Controller
{
    function paginate(Request $req) {
    	$pageSize = Input::get('pageSize', env('DEFAULT_PAGE_SIZE'));
        $search = Input::get('s', null);

        $options = [
            'step' => env('DEFAULT_PAGE_SIZE'),
            'nPageSize' => env('N_PAGE_SIZE'),
            'sort' => $req->sort,
            'search' => $search,
        ];

        try {
            $products = Product::paginate($pageSize, $search, $req->sort);
            $products->appends(Input::except('page'));
        } catch (QueryException $e) {
            return view('catalog', [
                'options' => $options
            ])->withErrors('Unable to connect with DataBase');
        }

        return view('catalog', [
            'products' => $products,
            'options' => $options,
        ])->withQuery($pageSize);

    }

    function stock(Request $req, $id, $name=null) {
        try {
            $product = Product::get($id);
            if ($product) $product->inStock();
        } catch (QueryException $e) {
            return view('stock')->withErrors('Unable to connect with DataBase');
        }

        if ($product) {
            return view('stock', ['product' => $product]);
        }
        return redirect('/catalogo')->withErrors('Product doesn\'t exists!');
    }
}
