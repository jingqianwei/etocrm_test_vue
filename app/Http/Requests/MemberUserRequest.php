<?php

namespace App\Http\Requests;

use App\Rules\ValidRepository;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidLoginEmail;
use Illuminate\Http\Request;
use App\Rules\SimpleRule;

class MemberUserRequest extends FormRequest
{
    //公共部分
    public $rules = [
        'username' => 'required|max:10',
        'password' => 'required|between:6,20',
    ];

    //这里我只写了部分字段，可以定义全部字段
    protected $messages = [
        'username.required' => '用户名必填',
        'username.max' => '用户名最多为10字符',
        'username.unique' => '用户名已存在',
        'email.required' => '邮箱必填',
        'email.email' => '邮箱格式错误',
        'password.required' => '密码必填',
        'password.between' => '密码长度为6-20位字符',
        'password.confirmed' => '两次密码不一致',
        'code.required' => '验证码不能为空',
        'code.between' => '验证码输入错误'
     ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() //这个方法可以用来控制访问权限，例如禁止未付费用户访问
    {
        return true; //默认是false，使用时改成true,
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = $this->rules;
        // Request::getPathInfo()方法获取命名路由，用来区分不同页面
        if(Request::getPathInfo() == '/admin/reg_sub'){ //路由为/admin/reg_sub的特有验证部分
            $rules['email'] = new ValidLoginEmail(); //自定义了一个email的规则
            $rules['code'] = 'required|between:4,4';
            $rules['title'] = new SimpleRule(); //自定义了一个简单的规则
            $rules['repository'] = [
                'required',
                new ValidRepository($this->source(), Request()->branch)
            ];
        }

        return $rules;
    }

    /**
     * @Describe: 返回自定义消息，不使用的话为默认提示
     * @Author: chinwe.jing
     * @Data: 2018/8/9 18:27
     * @return array
     */
    public function messages() {
        return $this->messages;
    }
}
