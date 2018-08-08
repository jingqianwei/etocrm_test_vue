<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Monolog\Handler\StreamHandler;
use Illuminate\Support\Facades\DB;
use Monolog\Logger;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.env') === 'local') { //本地开发环境才打印sql日志
            DB::listen(
                function ($sql) {
                    foreach ($sql->bindings as $i => $binding) {
                        if ($binding instanceof \DateTime) {
                            $sql->bindings[$i] = $binding->format("'Y-m-d H:i:s'");
                        } else {
                            if (is_string($binding)) {
                                $sql->bindings[$i] = "'$binding'";
                            }
                        }
                    }

                    // Insert bindings into query
                    $query = str_replace(array('%', '?'), array('%%', '%s'), $sql->sql);
                    $query = vsprintf($query, $sql->bindings);
                    $log = new Logger('sql');
                    $log->pushHandler(new StreamHandler(storage_path('logs' . DIRECTORY_SEPARATOR . 'query' . DIRECTORY_SEPARATOR . date('Y-m-d') . '.log'),Logger::INFO) );
                    $log->addInfo('执行的sql语句为：' . $query);
                }
            );
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
