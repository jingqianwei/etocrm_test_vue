<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * 参考网址：https://laravel-china.org/docs/laravel/5.6/eloquent-resources/1407
     * 将资源转换成数组, 对接口返回的数据进行处理
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toDateTimeString() : null,
            'link' => 'www.baidu.com', //这是单独加的测试使用没有实际含义，数据库中没有这个字段，但最终接口数据返回的时候，会返回这个值
        ];
    }
}
