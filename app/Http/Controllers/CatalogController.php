<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use \App\Product;

class CatalogController extends Controller
{
    function paginate() {
    	$pageSize = Input::get('pageSize', env('DEFAULT_PAGE_SIZE'));
    	$sort = Input::get('sort', null);
    	$search = Input::get('s', '');
        $products = Product::paginate($pageSize, $search, $sort);
        $products->appends(Input::except('page'));

    return view('catalog', [
        'products' => $products->items(),
        'paging' => $products->onEachSide(1)->links(),
    ])->withQuery($pageSize);

    }
}
