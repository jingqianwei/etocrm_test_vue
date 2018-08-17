<?php
/**
 * Created by PhpStorm.
 * User: chinwe.jing
 * Date: 2018/8/17
 * Time: 10:14
 */

namespace App\Traits;


use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

trait LastActivedAtHelper
{
    //缓存相关
    protected $hash_prefix = 'chinwe_last_actived_at_';
    protected $field_prefix = 'user_';

    /**
     * @Describe: 记录最后登陆时间
     * @Author: chinwe.jing
     * @Data: 2018/8/17 10:25
     */
    public function recordLastActivedAt()
    {
        // Redis 哈希表的命名，如：chinwe_last_actived_at_2018-5-7
        $hash = $this->getHashFromDateString(now()->toDateString());

        // 字段名称，如：user_1
        $field = $this->getHashField();

        // 当前时间，如：2017-10-21 08:35:15
        $now = now()->toDateTimeString();

        // 数据写入 Redis，如果字段已存在，则值会更新
        Redis::hSet($hash, $field, $now);
    }

    /**
     * @Describe: redis同步用户最后登录时间到数据库
     * @Author: chinwe.jing
     * @Data: 2018/8/17 10:29
     */
    public function syncUserActivedAt()
    {
        // Redis 哈希表的命名，如：chinwe_last_actived_at_2018-5-7,都是同步前一天的数据
        $hash = $this->getHashFromDateString(Carbon::yesterday()->toDateString());

        // 从Redis中获取所有哈希表中的数据
        $datas = Redis::hGetAll($hash);

        // 遍历，并同步到数据库中
        foreach ($datas as $user_id => $actived_at) {
            // 会将 `user_1` 转换为 1
            $user_id = str_replace($this->field_prefix, '', $user_id);

            // 只有当用户存在时才更新到数据库中
            if ($user = $this->find($user_id)) {
                $user->last_actived_at = $actived_at;
                $user->save();
            }
        }

        // 以数据库为中心的存储，既已同步，即可删除
        Redis::del($hash);
    }

    /**
     * @Describe: 获取用户的最后访问时间
     * @Author: chinwe.jing
     * @Data: 2018/8/17 10:39
     * @param $value
     * @return Carbon
     */
    public function getLastActivedAtAttribute($value)
    {
        // Redis 哈希表的命名，如：chinwe_last_actived_at_2018-5-7
        $hash = $this->getHashFromDateString(now()->toDateString());

        // 字段名称，如：user_1
        $field = $this->getHashField();

        // 三元运算符，优先选择 Redis 的数据，否则使用数据库中
        $datetime = Redis::hGet($hash, $field) ? : $value;

        // 如果存在的话，返回时间对应的 Carbon 实体
        if ($datetime) {
            return new Carbon($datetime);
        } else {
            // 否则使用用户注册时间
            return $this->created_at;
        }
    }

    /**
     * @Describe: Redis 哈希表的命名
     * @Author: chinwe.jing
     * @Data: 2018/8/17 10:24
     * @param $date
     * @return string
     */
    public function getHashFromDateString($date)
    {
        // Redis 哈希表的命名，如：chinwe_last_actived_at_2018-5-7
        return $this->hash_prefix . $date;
    }

    /**
     * @Describe: 字段名称
     * @Author: chinwe.jing
     * @Data: 2018/8/17 10:24
     * @return string
     */
    public function getHashField()
    {
        // 字段名称，如：user_1
        return $this->field_prefix . $this->id;
    }
}