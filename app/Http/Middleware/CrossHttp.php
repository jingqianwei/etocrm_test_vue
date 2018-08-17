<?php

namespace App\Http\Middleware;

use Closure;

class CrossHttp
{
    /**
     * 参考网址 https://laravel-china.org/topics/2524/laravel-opens-cross-domain-functionality
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        //可以传入一个数组，里面包含允许跨域的网址
        $response->header('Access-Control-Allow-Origin', '*'); //意思是允许所有的域都能访问这个接口。但是这时候不能传递session和cookie
        //$response->header('Access-Control-Allow-Origin', 'http://mytest.com'); 如果想要指定域名来访问，就这样写
        $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, Accept');
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS');
        $response->header('Access-Control-Allow-Credentials', 'true'); //跨域解决后，如果还要操作Cookie，

        return $response;
    }
}
