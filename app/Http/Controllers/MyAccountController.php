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
    		return redirect()->back()->withErrors('Unable to change password!');
    	}
    	return redirect()->back()->with('success', ['Password has been changed!']);
    }

    public function details(Request $req, $accId) {
        $acc = Account::get($accId, $req->user->id);
        if ($acc) {
            $acc->loadDetails();
            return view('acc-details', [
                'account' => $acc
            ]);
        }

        return redirect()->back()->withErrors('Account doesn\'t exists!');
    }

    public function credit(Request $req) {
        $accId = Input::get('account_id');
        $amount = Input::get('amount');

        $acc = Account::get($accId, $req->user->id);

        if ($acc) {
            if ($acc->credit($amount)) {
                return redirect()->back()->with('success', ['Payment has been registered!']);
            } else {
                return redirect()->back()->withErrors('Unable to register payment!');
            }
        } else {
            return redirect()->back()->withErrors('Account doesn\'t exists!');
        }
    }
}
