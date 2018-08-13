<?php
/**
 * Created by PhpStorm.
 * User: chinwe.jing
 * Date: 2018/8/9
 * Time: 10:40
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Carousel
 *
 * @property int $id
 * @property string $title
 * @property string|null $link
 * @property string $src
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Carousel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Carousel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Carousel whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Carousel whereSrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Carousel whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Carousel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Carousel extends Model
{
    protected $fillable = [
        'title',
        'link',
        'src'
    ];
}