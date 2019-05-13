<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Customer;

class SessionController extends Controller
{
    function login(Request $req) {

    	$email = $req->input()['email'];
    	$password = $req->input()['password'];

    	$user = Customer::attemp($email, $password);

    	if ($user) {
    		\Cookie::queue(
    			\Cookie::make('username', $user->name));
			\Cookie::queue(
				\Cookie::make('userId', $user->id));
			return redirect('');
    	}

		return view('login', [
			'error' => [
				'subject' => 'Login Error',
				'msg' => 'Invalid email or password']]);
    }

    function logout() {
    	\Cookie::queue(\Cookie::forget('username'));
		\Cookie::queue(\Cookie::forget('userId'));
		return redirect('');
    }
}
