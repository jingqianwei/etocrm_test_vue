<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
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
            'created_at' => is_null($this->created_at) ? null : $this->created_at->toDateTimeString(),
            'updated_at' => is_null($this->updated_at) ? null : $this->updated_at->toDateTimeString(),
            'link' => 'www.baidu.com', //这是单独加的测试使用没有实际含义，数据库中没有这个字段，但最终接口数据返回的时候，会返回这个值
        ];
    }
}
