<?php
/**
 * Created by PhpStorm.
 * User: chinwe.jing
 * Date: 2018/8/21
 * Time: 15:33
 */

namespace App\utils;

use Cblink\ExcelZip\CustomCollection;
use Maatwebsite\Excel\Concerns\FromCollection;
/**
 * 在你的 Export 中加上 use CustomCollection 如果你不是很熟源码，
 * 建议 不要定义collection方法，除非你可以根据源码适当修改
 * Class MemberExport
 * @package App\utils
 */
class Export implements FromCollection
{
    use CustomCollection;
}