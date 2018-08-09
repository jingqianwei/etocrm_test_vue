<?php

namespace App\Providers;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Processor\ProcessIdProcessor;
use Illuminate\Support\ServiceProvider;
use Monolog\Processor\UidProcessor;
use Illuminate\Support\Facades\DB;
use App\Observers\UserObserver;
use App\Models\User;
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
        //注册观察者
        User::observe(UserObserver::class);

        if (config('app.env') === 'local') { //本地开发环境才打印sql日志
            DB::listen(
                function ($sql) {
                    foreach ($sql->bindings as $i => $binding) {
                        if ($binding instanceof \DateTime) {
                            $sql->bindings[$i] = $binding->format("'Y-m-d H:i:s'");
                        } else {
                            if (is_string($binding)) {
                                $sql->bindings[$i] = "{$binding}";
                            }
                        }
                    }

                    $fileName = storage_path('logs' . DIRECTORY_SEPARATOR . 'query' .  DIRECTORY_SEPARATOR);
                    if (!file_exists($fileName)) {
                        mkdir($fileName, 0777, true);
                    }

                    // Insert bindings into query
                    $query = vsprintf(str_replace(array('%', '?'), array('%%', '%s'), $sql->sql), $sql->bindings);

                    //利用Monolog基础用法
                    $logger = new Logger('sql');
                    $logger->pushHandler(new RotatingFileHandler($fileName . 'sql.log')); //new StreamHandler('path/to/your.log', Logger::WARNING) 也可以重新定义日志路径
                    $logger->pushProcessor(new UidProcessor());
                    $logger->pushProcessor(new ProcessIdProcessor());
                    $logger->pushProcessor(function ($record) { //给日志中加入内容
                        $record['message'] = 'Hello ' . $record['message'];
                        return $record;
                    });
                    $logger->info('执行的sql语句为：' . $query, ['username' => 'jqw']); //第二个参数可以表示是谁记录的日志
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
