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

if (!function_exists('batch_updates')) {

    /**
     * 参考地址：https://www.toutiao.com/a6604960225642414595/?tt_from=weixin&utm_campaign=client_share
     * &wxshare_count=1&timestamp=1537843236&app=news_article&utm_source=weixin&iid=44304810085&utm_medium
     * =toutiao_android&group_id=6604960225642414595
     * 批量更新函数
     * @param $data array 待更新的数据，二维数组格式
     * @param array $params array 值相同的条件，键值对应的一维数组
     * @param string $field string 值不同的条件，默认为id
     * @return bool|string
     */
    function batchUpdates($data, $field, $params = [])
    {
        if (!is_array($data) || !$field || !is_array($params))
        {
            return false;
        }

        $updates = parseUpdate($data, $field);
        $where = parseParams($params);
        // 获取所有键名为$field列的值，值两边加上单引号
        // array_column()函数需要PHP5.5.0+，如果小于这个版本，可以自己实现，
        // 参考地址：http://php.net/manual/zh/function.array-column.php#118831
        $fields = implode(',', array_map(function($value) {
                    return "'".$value."'";
                }, array_column($data, $field)));
        $sql = sprintf("UPDATE `%s` SET %s WHERE `%s` IN (%s) %s", 'post', $updates, $field, $fields, $where);

        return $sql;
    }

    /**
     * 将二维数组转换成CASE WHEN THEN的批量更新条件
     * @param $data array 二维数组
     * @param $field string 列名
     * @return string sql语句
     */
    function parseUpdate($data, $field)
    {
        $sql = '';
        foreach (array_keys(current($data)) as $column) {
            $sql .= sprintf("`%s` = CASE `%s` ", $column, $field);
            foreach ($data as $line) {
                $sql .= sprintf("WHEN '%s' THEN '%s' ", $line[$field], $line[$column]);
            }

            $sql .= "END,";
        }

        return rtrim($sql, ',');
    }

    /**
     * 解析where条件
     * @param $params
     * @return array|string
     */
    function parseParams($params)
    {
        $where = [];
        foreach ($params as $key => $value) {
            $where[] = sprintf("`%s` = '%s'", $key, $value);
        }

        return $where ? ' AND ' . implode(' AND ', $where) : '';
    }

}

