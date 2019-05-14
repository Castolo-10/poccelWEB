<?php

namespace App\Http\Middleware;

use Closure;

class SessionRequired
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
        if (!$request->user) {
            return redirect('')->withMessage('You need to be logged!');
        }
        return $next($request);
    }
}
