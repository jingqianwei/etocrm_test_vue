<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ClearProjectCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:project-cache {clear=all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '快速清除项目所有缓存';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //获取传入的参数
        $clearContent = $this->argument('clear');

        switch ($clearContent) {
            case 'route':
                Artisan::call('route:clear');
                $this->info('路由缓存清理成功！');
                break;
            case 'view':
                Artisan::call('view:clear');
                $this->info('视图缓存清理成功！');
                break;
            case 'config':
                Artisan::call('config:clear');
                $this->info('配置缓存清理成功！');
                break;
            case 'cache':
                Artisan::call('cache:clear');
                $this->info('缓存内容清理成功！');
                break;
            case 'all':
                Artisan::call('route:clear');
                Artisan::call('view:clear');
                Artisan::call('config:clear');
                Artisan::call('cache:clear');
                $this->info('项目缓存清理成功！');
                break;
            default:
                $this->info('没有对应的缓存类型！');
                break;
        }
    }
}
