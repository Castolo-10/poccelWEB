<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Product;

class HomeController extends Controller
{
    public function __invoke(Request $req) {
    	$products = Product::random(4);
    	return view('home', [
    		'products' => $products,
    	]);
    }
}
