<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Input;
use Closure;

class CheckCreditCardInfo
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
        $exp = Input::get('credit_card_expiration_date');
        $cc = Input::get('credit_card_number');

        if ($cc[0] == '*') {
            $cc = \App\PayMethod::unMask((object)[
                'number' => $cc,
                'exp' => $exp,
                'customer' => $request->user->id
            ]); 
            if (!$cc) return redirect()->back()->withErrors('You have entered an invalid credit card!');

            $data = $request->all();
            $data['credit_card_number'] = $cc;
            $request->merge($data);
        }

        $now = date('y/m');
        $exp = substr($exp, 3).'/'.substr($exp, 0, 2);

        if (strtotime($now) < strtotime($exp)) {
            return redirect()->back()
                ->withErrors('You have entered an expired credit card!')
                ->with('info', ['Please, check the expiration date on your credit card before paying.']);
        }

        return $next($request);
    }
}
