<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use \App\Customer;
use \App\Account;

class MyAccountController extends Controller
{
	public function show(Request $req) {
		$req->user->accountList()
			->payMethods();
		return view('account');
	}

	public function changePassword(Request $req) {
		try {
		   $success = $req->user->updatePassword(Input::get('new_password'));
			if ($success) {
				return redirect()->back()->with('success', ['Password has been changed!']);
			}
		} catch (QueryException $e) {}
		return redirect()->back()->withErrors('Unable to change password!');
	}

	public function details(Request $req, $accId) {
		try {
			$req->user->payMethods();
			$acc = Account::get($accId, $req->user->id);
			if ($acc) {
				$acc->loadDetails();
				return view('acc-details', [
					'account' => $acc
				]);
			}
		} catch (QueryException $e) {}

		return redirect()->back()->withErrors('Account "'.$accId.'" doesn\'t exists!');
	}

	public function credit(Request $req) {
		$accId = Input::get('account_id');
		$amount = Input::get('amount');
		$ccInfo = (object)[
			'customer' => $req->user->id,
			'number' => Input::get('credit_card_number'),
			'exp' => Input::get('credit_card_expiration_date'),
		];

		try {
			$acc = Account::get($accId, $req->user->id);
			if ($acc) {
				if ($acc->credit($amount, $ccInfo))
					return redirect()->back()->with('success', ['Payment has been registered!']);
			} else {
				return redirect()->back()->withErrors('Account doesn\'t exists!');
			}
		}
		catch (QueryException $e) {}

		return redirect()->back()->withErrors('Unable to register payment!');
	}
}
