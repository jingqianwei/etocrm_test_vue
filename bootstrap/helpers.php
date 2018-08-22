<?php
/**
 * Created by PhpStorm.
 * User: chinwe.jing
 * Date: 2018/8/22
 * Time: 18:32
 */
if (!function_exists('dda')) {

    /**
     * @Describe: 格式化输出结果
     * @Author: chinwe.jing
     * @Data: 2018/8/22 18:33
     * @param $model
     */
    function dda($model)
    {
        if (method_exists($model, 'toArray')) {
            dd($model->toArray());
        } else {
            dd($model);
        }
    }
}