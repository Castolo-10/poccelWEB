<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use \App\Customer;

class SessionController extends Controller
{
	function login(Request $req) {

		$email = Input::get('email');
		$password = Input::get('password');
		$remember = Input::get('remember', '');

		try {
			$userId = Customer::attemp($email, $password);
		} catch(QueryException $e) {
			$userId = 0;
		}

		if ($userId) {
			if ($remember) {
				\Cookie::queue(\Cookie::forever('session', $userId));
			} else {
				\Cookie::queue(\Cookie::make('session', $userId));
			}
			return redirect('');
		}

		return redirect()->back()->withErrors('Invalid email or password');
	}

	function logout() {
		\Cookie::queue(\Cookie::forget('session'));
		return redirect('');
	}
}
