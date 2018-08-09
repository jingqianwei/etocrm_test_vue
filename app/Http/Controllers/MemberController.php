<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberUserRequest;
use App\Http\Resources\testResource;
use Illuminate\Support\Facades\Crypt;

class MemberController extends Controller
{
    // 登录模块
    public function login()
    {
        return view('admin.login');
    }

    // 登录提交
    public function loginSub(MemberUserRequest $request)
    {
        dd($request);
        //$request = $test->toArray($request); //将请求资源转换成数组

        dd($request);

        //引入验证控制器后它会自动验证，不需其他操作
        $username = $request->input('username');
        $password = $request->input('password');

        $data = [
            'username' => $username,
            'password' => Crypt::encrypt($password),
            'login_time' => time(),
        ];



        //查询数据库验证登陆代码......等等
    }
}
