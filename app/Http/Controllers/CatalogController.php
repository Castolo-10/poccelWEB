<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Product;

class CatalogController extends Controller
{
    function paginate(Request $req) {
        $products = Product::paginate(8);

    return view('catalog', [
        'products' => $products->items(),
        'paging' => $products->links(),
    ]);

    }
}
