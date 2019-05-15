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
        $sort = Input::get('sort', null);
        $order = Input::get('desc', null);

        if (!array_key_exists($sort, Product::SORTING_CRITERIA)) {
            $data = $request->all();
            $data['sort'] = null;
            $request->merge($data);
            $request->sort = null;
        } else {
            $request->sort = [
                'by' => $sort,
                'order' => ($order ? 'desc' : 'asc'),
            ];
        }

        return $next($request);
    }
}
