<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;

class TestExampleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $age)
    {
        $response = $next($request);
        
        // Perform action
        print 'amine    '.$age;

        return $response;

        return $next($request);
    }
}
