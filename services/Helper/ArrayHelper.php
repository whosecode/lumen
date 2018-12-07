<?php

/**
 * 数组助手类
 *
 * @author cuijiji
 * @date 2018/10/17
 */

namespace Services\Helper;

use Illuminate\Database\Eloquent\Collection;

class ArrayHelper
{

    /**
     * 按指定的key和value转换数组
     * 最常用的就是把数据库查出来的数据转换为可用来select等表单中使用
     *
     * @param array $array 待转换的数组
     * @param string $key 指定的key 一般为数据库某个字段
     * @param string $value 指定的value 一般为数据库某个字段
     *
     * @return array
     */
    public static function convertArrayByKeyAndValue($array, $key, $value)
    {
        $newArr = [];
        if (empty($array) || count($array) == 0) {
            return $newArr;
        }
        if ($array instanceof Collection) {
            foreach ($array as $v) {
                if (isset($v->$key) && isset($v->$value)) {
                    $newArr[$v->$key] = $v->$value;
                }
            }
        } else if (is_array($array)) {
            foreach ($array as $v) {
                if (array_key_exists($v[$key], $array) && array_key_exists($v[$value], $array)) {
                    $newArr[$v[$key]] = $v[$value];
                }
            }
        }
        return $newArr;
    }
}