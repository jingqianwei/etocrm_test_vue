<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ExampleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 参考网址：https://laravel-china.org/topics/13290/excitement-first-contact-with-the-queue-take-a-look-at-your-mind-and-add-two-questions
     * 注意点：在这个方法中应该使用 DB 类直接对数据库进行操作，以避免如果有模型监听器的情况下，造成死循环的问题。
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
