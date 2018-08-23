<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarouselsTable extends Migration
{
    /**
     * 参考网址，可以修改表或字段的字符集https://laravel-china.org/wikis/16247
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carousels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('link')->nullable();
            $table->string('src');
            $table->timestamps();
            $table->comment = '平台:测试表'; //表注释
        });

        DB::statement("ALTER TABLE `users` comment'平台:测试表'"); //表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carousels');
    }
}
