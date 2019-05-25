<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use \App\Product;

class CatalogController extends Controller
{
    function paginate(Request $req) {
    	$pageSize = Input::get('pageSize', env('DEFAULT_PAGE_SIZE'));
        $search = Input::get('s', null);

        $products = Product::paginate($pageSize, $search, $req->sort);
        $products->appends(Input::except('page'));

    return view('catalog', [
        'products' => $products,
        'options' => [
            'step' => env('DEFAULT_PAGE_SIZE'),
            'nPageSize' => env('N_PAGE_SIZE'),
            'sort' => $req->sort,
            'search' => $search,
        ]])->withQuery($pageSize);

    }

    function stock(Request $req, $id, $name=null) {
        $product = Product::get($id);
        if ($product) {
            return view('stock', ['product' => $product->inStock()]);
        }
        return redirect()->back()->withErrors('Product doesn\'t exists!');
    }
}
