<?php

namespace App\Http\Controllers\Api;

use App\Models\AdminUser;
use App\Traits\ProxyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers, ProxyTrait;

    /**
     * 参考网址：https://laravel-china.org/articles/13902/passport-api-authentication-multi-table-login
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout,adminUserLogout,refreshToken');
    }

    public function adminUserLogin(Request $request)
    {
        $admin_user = AdminUser::where('email', $request->email)
            ->firstOrFail();

        if (!Hash::check($request->password, $admin_user->password)) {
            return $this->failed('密码不正确');
        }

        $admin_user->last_login_at = Carbon::now();
        $admin_user->save();

        $tokens = $this->authenticate('admin_users');
        return $this->success(['token' => $tokens, 'user' => $admin_user]);
    }

    public function adminUserLogout()
    {
        if (\Auth::guard('admin_user_api')->check()) {
//            \Auth::guard('admin_user_api')->user()->token()->revoke();
            \Auth::guard('admin_user_api')->user()->token()->delete();
        }
    }
}
