<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SessionCtrl extends Controller
{
    function login(Request $req) {

    	$email = $req->input()['email'];
    	$password = $req->input()['password'];

    	$userData = DB::table('cliente')
    		->where([['correo', $email], ['password', $password]])
    		->select('id_cliente', 'nombre')
    		->get();

    	if (count($userData)) {
    		\Cookie::queue(
    			\Cookie::make('username', $userData[0]->nombre));
			\Cookie::queue(
				\Cookie::make('userId', $userData[0]->id_cliente));
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
