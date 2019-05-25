<?php

namespace App\Http\Middleware;

use Closure;

class RestrictSession
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
        if ($request->user) {
            return redirect('/mi-cuenta')->with('info', ['You are already logged in!']);
        }
        return $next($request);
    }
}
