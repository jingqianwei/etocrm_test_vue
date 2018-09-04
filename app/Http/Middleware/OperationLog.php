<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Facades\Agent;
use Zhuzhichao\IpLocationZh\Ip;

class OperationLog
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param null $force
     * @return mixed
     */
    public function handle($request, Closure $next, $force = null)
    {
        if ($force == 'force' || app()->environment('production')) {
            $monolog = Log::getMonolog();
            $logHandlerBak = $monolog->popHandler();
            Log::useDailyFiles(storage_path('logs/operation.log'), 180, 'debug');

            //用户id，用户名称，用户真实名称
            $userString = join(array_filter([user('id'), user('username'), user('realname')]), ' ');
            $uri = $request->path();
            $method = $request->method();
            $userAgent = Agent::getUserAgent();
            $ip = $request->getClientIp();
            $ipInfo = join(array_unique(array_filter(Ip::find($ip))), ' ');
            $queryString = http_build_query($request->except(['password', 'sn', 'token']));
            $logMsg = join([$userString, $method . ' ' . $uri . ' ' . $queryString, $userAgent, $ip, $ipInfo], ' | ');

            Log::info($logMsg . PHP_EOL);

            $monolog->popHandler();
            $monolog->pushHandler($logHandlerBak);
        }

        return $next($request);
    }
}
