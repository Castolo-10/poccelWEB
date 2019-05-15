<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Product;

class ItemWrapper {
	public $it;
	public function items() {
		return $this->it;
	}
}

class HomeController extends Controller
{
    public function __invoke(Request $req) {
    	$products = Product::random(4);
    	
    	$wrap = new ItemWrapper();
    	$wrap->it = $products;

    	return view('home', [
    		'products' => $wrap
    	]);
    }
}
