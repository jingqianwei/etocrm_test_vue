<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Services\Contracts\CustomServiceInterface;
use Illuminate\Http\Request;
use App\Events\MyEvent;
use App\Models\User;

class TestController extends Controller
{
    //测试写一个新的provide，然后根据不同的条件来实例化不同的service
    public function index(CustomServiceInterface $customServiceInstance, Request $request)
    {

        $data = [
            [
                'create_at'=> '2018',
                'num'=>1,
            ],
            [
                'create_at'=> '2018',
                'num'=>2,
            ],
            [
                'create_at'=> '2017',
                'num'=>3,
            ],
            [
                'create_at'=> '2016',
                'num'=>4,
            ]
        ];

        $multiplied = collect($data)->groupBy('create_at')
                                    ->map(function($item){
                                        return ['total_num' => $item->sum('num')];
                                    })->toArray();

        dd($multiplied);
        return UserResource::collection(User::all()); //用于多条数据处理接口返回的数据结构处理，可以自由的组合
        return new UserResource(User::find(2));   //用于单个数据接口返回的数据结构处理，可以自由的组合
        //return $this->response([1, 2, 3]); //响应返回
        event(new MyEvent()); //触发事件
        if (is_numeric($request->input('key'))) { //通过$request获取到传过来的值，已经去过左右空格而且还可以却确定参数的类型
            echo $customServiceInstance->testServices();
        } else {
            echo '是字符串';
        }
    }
}
