<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RecordLastActivedTime
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
        //如果是登陆用户
        if (Auth::guard('api')->check()) {
            //记录最后登陆时间
            Auth::guard('api')->user()->recordLastActivedAt();
        }

        return $next($request);
    }
}
