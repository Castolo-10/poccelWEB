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
        $acc = new Account();
        if ($acc->get($accId, $req->user->id)) {
            $acc->loadDetails();
        }
        return view('acc-details', [
            'account' => $acc
        ]);
    }

    public function credit(Request $req) {
        $accId = Input::get('account_id');
        $amount = Input::get('amount');
        
        $acc = new Account();

        if ($acc->get($accId, $req->user->id)) {
            if ($acc->credit($amount)) {
                return redirect('/mi-cuenta')->with('success', ['Payment has been registered!']);
            } else {
                return redirect('/mi-cuenta')->withErrors('Unable to register your payment!');
            }
        } else {
            return redirect('/mi-cuenta')->withErrors('Account doesn\'t exists!');
        }
    }
}
