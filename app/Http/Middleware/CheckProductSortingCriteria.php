<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Input;
use \App\Product;
use Closure;

class CheckProductSortingCriteria
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
        $sort = Input::get('sort', '');

        if (!array_key_exists($sort, Product::SORTING_CRITERIA)) {
            $data = $request->all();
            $data['sort'] = null;
            $request->merge($data);
        }

        return $next($request);
    }
}
