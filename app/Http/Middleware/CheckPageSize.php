<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Input;
use Closure;

class CheckPageSize
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
        $pageSize = Input::get('pageSize', '');

        if (intval($pageSize) == 0) {
            $data = $request->all();
            $data['pageSize'] = env('DEFAULT_PAGE_SIZE');
            $request->merge($data);
        }
        return $next($request);
    }
}
