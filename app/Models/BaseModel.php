<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * 参考网址：https://laravel-china.org/wikis/16246
     * @Describe: 在使用 Laravel 的关联查询中，我们经常使用 with 方法来避免 N+1 查询，
     * 但是 with 会将目标关联的所有字段全部查询出来，接下来介绍一个能够读取关联模型个别字段的方法：
     * @Author: chinwe.jing
     * @Data: 2018/8/23 10:01
     * @param $query
     * @param $relation
     * @param array $columns
     * @return mixed
     */
    public function scopeWithCertain($query, $relation, array $columns)
    {
        return $query->with([$relation => function ($query) use ($columns){
            $query->select(array_merge(['id'], $columns));
        }]);
    }
}
