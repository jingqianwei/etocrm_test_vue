<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Laravel的ORM模型在一些特定的情况下，会触发一系列的事件，目前支持的事件有这些：
     *
     * creating - 对象已经 ready 但未写入数据库
     * created - 对象已经写入数据库
     * updating - 对象已经修改但未写入数据库
     * updated - 修改已经写入数据库
     * saving - 对象创建或者已更新但未写入数据库
     * saved - 对象创建或者更新已经写入数据库
     * deleting - 删除前
     * deleted - 删除后
     * restoring - 恢复软删除前
     * restored - 恢复软删除后
     */

    /**
     * 参考网址： https://laravel-china.org/articles/5465/event-realization-principle-of-laravel-model
     * 监听用户创建事件.
     * 但是如果用insert()创建就监听不到
     * @param  User  $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * 监听用户创建/更新事件.
     * 但是如果使用 update()更新就监听不到
     * @param  User  $user
     * @return void
     */
    public function saved(User $user)
    {
        //
    }

    /**
     * 监听删除用户事件.
     * 但是如果使用 delete()更新就监听不到
     * @param User $user
     * @return void
     */
    public function deleting(User $user)
    {
        //
    }
}
