<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionCtrl extends Controller
{
    function login() {

    	if ( rand(0, 1) ) {
    		\Cookie::queue(\Cookie::make('username', 'Nombre Cliente'));
			\Cookie::queue(\Cookie::make('userId', '1'));
			return redirect('');
    	}
		return view('login', ['error' => ['msg' => 'Correo o contraseña incorrectos']]);
    }

    function logout() {
    	\Cookie::queue(\Cookie::forget('username'));
		\Cookie::queue(\Cookie::forget('userId'));
		return redirect('');
    }
}
