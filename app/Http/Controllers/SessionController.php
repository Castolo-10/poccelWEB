<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use \App\Customer;

class SessionController extends Controller
{
    function login(Request $req) {

    	$email = $req->input()['email'];
    	$password = $req->input()['password'];

        try {
            $userId = Customer::attemp($email, $password);
        } catch(QueryException $e) {
            $userId = 0;
        }

    	if ($userId) {
    		\Cookie::queue(\Cookie::make('session', $userId));
			return redirect('');
    	}

		return redirect()->back()->withErrors('Invalid email or password');
    }

    function logout() {
    	\Cookie::queue(\Cookie::forget('session'));
		return redirect('');
    }
}
