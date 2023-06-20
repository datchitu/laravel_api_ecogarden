<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $response->header('Access-Control-Allow-Origin', '*')->header('Access-Control-Allow-Headers', 'Content-type, X-Auth-Token, Authorization, Origin');
        return $response;
    }
}