<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Input;
use Closure;

class CheckPaymentFields
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->validate([
            'credit_card_titular' => 'required|max:100',
            'credit_card_number' => ['required', 'size:16', 'regex:/(\d{16})|([*]{12}\d{4})/'],
            'credit_card_expiration_date' => 'required|size:5|date_format:m/y',
            'credit_card_security_code' => 'required|size:3|regex:/\d{3}/',
            'account_id' => 'required|integer',
            'amount' => 'required|numeric|regex:/\d*\.?\d+/',
            'allow_save' => 'present'
        ]);

        if (Input::get('amount') == 0) {
            return redirect()->back()->withErrors('Amount must not be zero!');
        }

        return $next($request);
    }
}
