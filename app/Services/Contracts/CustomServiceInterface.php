<?php
/**
 * Created by PhpStorm.
 * User: chinwe.jing
 * Date: 2018/8/8
 * Time: 12:00
 */

namespace App\Services\Contracts;


Interface CustomServiceInterface
{
    //接口中标准方法，来规范所有调用接口中所有类中的方法
    public function doSomethingUseful();
}