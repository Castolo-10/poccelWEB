<?php

namespace App\Http\Middleware;

use \App\Customer;
use Closure;

class LoadSession
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
        $userId = \Cookie::get('session', '');
        $user = null;
        if ($userId) {
            $user = Customer::get($userId);
        }
        $request->user = $user;
        return $next($request);
    }
}
