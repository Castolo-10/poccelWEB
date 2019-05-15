<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use \App\Customer;

class MyAccountController extends Controller
{
    public function profile(Request $req) {
        $req->user->accountDetails()
        	->paidMethods();
        return view('account');
    }

    public function changePassword(Request $req) {
    	$success = $req->user->updatePassword(Input::get('new_password'));
    	if (!$success) {
    		return redirect('/mi-cuenta')->withErrors('Unable to change your password!');
    	}
    	return redirect('/mi-cuenta')->with('success', ['Password has been changed!']);
    }
}
