<?php

namespace App\Providers;

use App\Services\Contracts\CustomServiceInterface;
use Illuminate\Support\ServiceProvider;

class EnvatoCustomServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CustomServiceInterface::class, function ($app) {
            $config = config('test', 'App\Services\DemoOne'); //可以去配置这个config从而实例化不同的service

            /**
                // 旧的写法，缺点是，如果类型很多，则会一直加代码，弊端很大
                switch ($config) {
                    case 'one':
                        return new DemoOne();
                    case 'two':
                        return new DemoTwo();
                    default :
                        throw new \Exception('config non-existent');
            }*/

            // 新的写法,好处是，无论有多少种类型，只要配置好对应的值即可，可以用动态实例化类，来简化工厂模式的代码
            return new $config(); //这种实例一定要注意命名空间，不然会实例化错误
        });
    }
}
