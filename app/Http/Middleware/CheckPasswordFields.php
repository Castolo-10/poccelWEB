<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Input;
use Closure;

class CheckPasswordFields
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
            'password' => 'required|max:100',
            'new_password' => 'required|max:100',
            'repeat_password' => 'required|max:100|same:new_password'
        ]);
        
        if ($request->user->isPasswordMatch(Input::get('password'))) {
            return $next($request);
        } else {
            return redirect('/mi-cuenta')->withErrors('Password entered doesn\'t match your current password!');
        }
    }
}
