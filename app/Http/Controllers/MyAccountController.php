<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use \App\Customer;
use \App\Account;

class MyAccountController extends Controller
{
    public function show(Request $req) {
        $req->user->accountList();
        return view('account');
    }

    public function changePassword(Request $req) {
    	$success = $req->user->updatePassword(Input::get('new_password'));
    	if (!$success) {
    		return redirect('/mi-cuenta')->withErrors('Unable to change your password!');
    	}
    	return redirect('/mi-cuenta')->with('success', ['Password has been changed!']);
    }

    public function details(Request $req, $accId) {
        $acc = Account::get($accId, $req->user->id);
        return view('acc-details', ['account' => $acc]);
    }
}
