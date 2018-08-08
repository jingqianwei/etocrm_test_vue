<?php

namespace App\Providers;

use App\Services\Contracts\CustomServiceInterface;
use Illuminate\Support\ServiceProvider;
use App\Services\DemoOne;
use App\Services\DemoTwo;

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
            $config = config('test', 'one'); //可以去配置这个config从而实例化不同的service

            switch ($config) {
                case 'one':
                    return new DemoOne();
                case 'two':
                    return new DemoTwo();
                default :
                    throw new \Exception('config non-existent');
            }
        });
    }
}
