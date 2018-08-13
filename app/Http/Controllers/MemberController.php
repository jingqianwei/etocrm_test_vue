<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberUserRequest;
use Illuminate\Support\Facades\Crypt;
use App\Http\Resources\Users;
use App\Models\User;

class MemberController extends Controller
{
    // 登录模块
    public function login()
    {
        return view('admin.login');
    }

    // 登录提交, 自定义了Request请求
    public function loginSub(MemberUserRequest $request)
    {
        dd($request->username);
        dd(new Users(User::all()));
        dd($request->all());
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
