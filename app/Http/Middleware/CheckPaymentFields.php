<?php

namespace App\Http\Middleware;

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
            'credit_card_number' => 'required|size:16|regex:/\d.+/i',
            'credit_card_expiration_date' => 'required|size:7|date_format:Y-m',
            'credit_card_security_code' => 'required|size:3|regex:/\d.+/i',
            'account_id' => 'required|integer',
            'amount' => 'required|numeric',
            'allow_save' => 'present'
        ]);

        return $next($request);
    }
}
