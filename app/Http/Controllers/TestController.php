<?php

namespace App\Http\Controllers;

use App\Services\Contracts\CustomServiceInterface;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //测试写一个新的provide，然后根据不同的条件来实例化不同的service
    public function index(CustomServiceInterface $customServiceInstance, Request $request)
    {
        //dd($request->input('key'));
        if (is_numeric($request->input('key'))) { //通过$request获取到传过来的值，已经去过左右空格而且还可以却确定参数的类型
            echo $customServiceInstance->testServices();
        } else {
            echo '是字符串';
        }
    }
}
