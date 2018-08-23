<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUsersTable extends Migration
{
    /**
     * 参考网址：http://www.cnblogs.com/rianley/p/9518422.html
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('用户名称');
            $table->string('email')->unique()->comment('用户邮箱');
            $table->string('password')->comment('用户密码');
            $table->rememberToken()->comment('记住密码');
            $table->timestamps();
            $table->engine = 'InnoDB'; //指定表存储引擎
        });

        DB::statement("ALTER TABLE `admin_users` comment'后台用户表'"); //表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
    }
}
