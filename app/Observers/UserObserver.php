<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{

    /**
     * 参考网址： https://laravel-china.org/articles/5465/event-realization-principle-of-laravel-model
     * 监听用户创建事件.
     *但是如果用insert()创建就监听不到
     * @param  User  $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * 监听用户创建/更新事件.
     *但是如果使用 update()更新就监听不到
     * @param  User  $user
     * @return void
     */
    public function saved(User $user)
    {
        //
    }
}
