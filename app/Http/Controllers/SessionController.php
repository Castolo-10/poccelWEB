<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Customer;

class SessionController extends Controller
{
    function login(Request $req) {

    	$email = $req->input()['email'];
    	$password = $req->input()['password'];

    	$userId = Customer::attemp($email, $password);

    	if ($userId) {
    		\Cookie::queue(
    			\Cookie::make('session', $userId));
			return redirect('');
    	}

		return view('login')->withErrors('Invalid email or password');
    }

    function logout() {
    	\Cookie::queue(\Cookie::forget('session'));
		return redirect('');
    }
}
