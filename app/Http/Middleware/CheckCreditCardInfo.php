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
        $now = date('y/m');
        $exp = Input::get('credit_card_expiration_date');
        $exp = substr($exp, 3).'/'.substr($exp, 0, 2);

        if (strtotime($now) < strtotime($exp)) {
            return redirect()->back()
                ->withErrors('You have entered an expired credit card!')
                ->with('info', ['Please, check the expiration date on your credit card before paying.']);
        }

        return $next($request);
    }
}
