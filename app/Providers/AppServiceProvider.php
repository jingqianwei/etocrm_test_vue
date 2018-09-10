<?php

namespace App\Providers;


use Illuminate\Database\Events\QueryExecuted;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Processor\ProcessIdProcessor;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Monolog\Processor\UidProcessor;
use Illuminate\Support\Facades\DB;
use App\Observers\UserObserver;
use App\Models\User;
use Monolog\Logger;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //更改日期提示为中文
        Carbon::setLocale('zh');
        //设置数据表字符串字段的默认长度
        Schema::defaultStringLength(150);
        //注册观察者
        User::observe(UserObserver::class);
        //取消为模型设置事件调度器
        //User::unsetEventDispatcher();

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


        //日志记录,参考网址：https://github.com/overtrue/laravel-query-logger
        \Log::info('============ URL: '.request()->fullUrl().' ===============');
        DB::listen(function (QueryExecuted $query) {
            $sqlWithPlaceholders = str_replace(['%', '?'], ['%%', '%s'], $query->sql);
            $bindings = $query->connection->prepareBindings($query->bindings);
            $pdo = $query->connection->getPdo();
            //array_map([$pdo, 'quote'], $bindings), 上面是把数组$bindings的每一个元素都执行$pdo对象的quote方法，最后结果以数组的形式返回。
            //例如$pdo->quote();方法，作用1. 为普通字符串添加引号，作用2. 转义特殊字符串
            $realSql = vsprintf($sqlWithPlaceholders, array_map([$pdo, 'quote'], $bindings));
            $duration = $this->formatDuration($query->time / 1000);
            \Log::debug(sprintf('[%s] %s', $duration, $realSql));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') { //phpstorm 提示插件,本地开发才生效
            //参考网址：https://github.com/barryvdh/laravel-ide-helper
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Format duration.
     *
     * @param float $seconds
     *
     * @return string
     */
    private function formatDuration($seconds)
    {
        if ($seconds < 0.001) {
            return round($seconds * 1000000) . 'μs';
        } elseif ($seconds < 1) {
            return round($seconds * 1000, 2) . 'ms';
        }

        return round($seconds, 2) . 's';
    }
}
