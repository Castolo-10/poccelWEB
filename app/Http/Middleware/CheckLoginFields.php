<?php

namespace App\Http\Middleware;

use Closure;

class CheckLoginFields
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
            'email' => 'required|email',
            'password' => 'required',
        ]);
        return $next($request);
    }
}
