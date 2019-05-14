<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use \App\Product;

class CatalogController extends Controller
{
    function paginate() {
    	$pageSize = Input::get('pageSize', env('DEFAULT_PAGE_SIZE'));
    	//$sort = Input::get('sort', Product::DEFAULT_SORT);

    	$search = Input::get('s', '');
        $products = Product::paginate($pageSize, $search);
        $products->appends(Input::except('page'));

    return view('catalog', [
        'products' => $products->items(),
        'paging' => $products->onEachSide(1)->links(),
    ])->withQuery($pageSize);

    }
}
