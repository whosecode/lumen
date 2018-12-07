<?php

namespace App\Http\Middleware;

use App\Http\Middleware\BeforeMiddleware\CheckHeader;
use Closure;

class BeforeMiddleware
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
        $headerObj = new CheckHeader($request);
        $headerObj->handle();

        return $next($request);
    }
}
