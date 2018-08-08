<?php
/**
 * Created by PhpStorm.
 * User: chinwe.jing
 * Date: 2018/8/8
 * Time: 12:02
 */

namespace App\Services;

use App\Services\Contracts\CustomServiceInterface;

class DemoTwo implements CustomServiceInterface
{

    public function doSomethingUseful()
    {
        return 'Output from DemoTwo';
    }
}