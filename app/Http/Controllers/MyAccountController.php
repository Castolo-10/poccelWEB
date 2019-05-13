<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Customer;

class MyAccountController extends Controller
{
    public function profile(Request $req) {
    	$id = \Cookie::get('userId', false);
    	if ($id) {
    		$customer = Customer::get($id);
    		if ($customer) {
    			return view('account', ['my' => $customer]);
    		}
    	}
    	return redirect('');
    }
}
