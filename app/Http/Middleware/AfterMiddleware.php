<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Middleware\AfterMiddleware\ResponseHeaders;
use App\Http\Middleware\AfterMiddleware\EmptyArrayObject;

class AfterMiddleware
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
        $result = $next($request);
//由于用了dingo 暂时取消这个支持
        // 给response加上必要的报头
//        $responseHeadersObj = new ResponseHeaders($result);
//        $result = $responseHeadersObj->handle();


        return $result;
    }
}
