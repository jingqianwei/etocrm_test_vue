<?php
/**
 * Created by PhpStorm.
 * User: chinwe.jing
 * Date: 2018/8/8
 * Time: 12:01
 */

namespace App\Services;

use App\Services\Contracts\CustomServiceInterface;

class DemoOne implements CustomServiceInterface
{

    //接口约束的方法
    public function doSomethingUseful()
    {
        return 'Output from DemoOne';
    }

    //不受约束的方法
    public function testServices()
    {
        return 'hello world !!';
    }
}