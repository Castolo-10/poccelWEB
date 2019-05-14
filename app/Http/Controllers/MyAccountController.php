<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Customer;

class MyAccountController extends Controller
{
    public function profile(Request $req) {
        $customer = $req->user;
        $customer->paidMethods();
        $customer->accountDetails();
        return view('account', [
            'my' => $customer,
        ]);
    }
}
