<?php
/**
 * Created by PhpStorm.
 * User: chinwe.jing
 * Date: 2018/8/9
 * Time: 10:40
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    protected $fillable = [
        'title',
        'link',
        'src'
    ];
}