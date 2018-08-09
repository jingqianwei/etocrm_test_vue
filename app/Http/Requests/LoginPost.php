<?php

namespace App\Http\Requests;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Http\FormRequest;

class LoginPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //return false;
        if($this->input('account') == 'aaa@abc.com') { //这个账号没有权限访问
            return false;
        }

        return true;
    }

    /**
     * @Describe: 失败账号提示信息
     * @Author: chinwe.jing
     * @Data: 2018/8/9 18:11
     * @throws AuthenticationException
     */
    protected function failedAuthorization()
    {
        throw new AuthenticationException('该帐号已被拉黑');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account'=>[
                'required',
                'regex:/^1[34578][0-9]\d{4,8}|(\w)+(\.\w+)*@(\w)+((\.\w+)+)|[0-9a-zA-Z_]+$/',//验证为手机号，邮箱，或帐号
            ],
            'password'=>'required|between:6,18',//验证密码
        ];
    }

    /**
     * @Describe: 提示信息
     * @Author: chinwe.jing
     * @Data: 2018/8/9 18:12
     * @return array
     */
    public function messages()
    {
        return [
            'account.required' => '帐号不能为空',
            'account.regex' => '帐号不合法',
            'password.required'  => '密码不能为空',
            'password.between'  => '密码错误',
        ];
    }
}
