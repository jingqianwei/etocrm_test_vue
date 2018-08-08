<?php

namespace App\Http\Controllers;

use App\Services\Contracts\CustomServiceInterface;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //public $customServiceInterface = null;

    //测试写一个新的provide，然后根据不同的条件来实例化不同的service
    public function index(CustomServiceInterface $customServiceInstance)
    {
        echo $customServiceInstance->testServices();
    }
}
