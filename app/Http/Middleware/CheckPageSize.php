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
        $defPageSize = env('DEFAULT_PAGE_SIZE');

        $data = $request->all();
        if (intval($pageSize) == 0) {
            $data['pageSize'] = $defPageSize;
        } else if($pageSize > 0) {
            $nwPageSize = ceil($pageSize / $defPageSize);
            $nwPageSize *= $defPageSize;
            $data['pageSize'] = intval($nwPageSize);
        }
        $request->merge($data);
        return $next($request);
    }
}
