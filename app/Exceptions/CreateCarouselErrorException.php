<?php
/**
 * Created by PhpStorm.
 * User: chinwe.jing
 * Date: 2018/8/9
 * Time: 10:41
 */

namespace App\Exceptions;

use Exception;

class CreateCarouselErrorException extends Exception
{
    // 重定义构造器使 message 变为必须被指定的属性
    public function __construct($message, $code = null) {
        // 自定义的代码, 确保所有变量都被正确赋值
        parent::__construct($message, $code);
    }
}