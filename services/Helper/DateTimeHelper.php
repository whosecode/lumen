<?php

/**
 * 日期时间助手类
 *
 * @author cuijiji
 * @date 2018/10/17
 */

namespace Services\Helper;

class DateTimeHelper
{
    /**
     * 返回 00:00:00格式
     * @param $second 总秒数
     * @return string
     */
    public static function timeFormat($second)
    {
        if ($second > 3600) {
            $h = intval($second/3600);
            $h = $h >= 10 ? $h : '0' . $h;
            $i = intval(($second%3600)/60);
            $i = $i >= 10 ? $i : '0' . $i;
            $s = ($second%3600)%60;
            $s = $s >= 10 ? $s : '0' . $s;
            $timeStr = $h . ':' . $i . ':' . $s;
        } else {
            $i = intval($second/60);
            $i = $i >= 10 ? $i : '0' . $i;
            $s = $second%60;
            $s = $s >= 10 ? $s : '0' . $s;
            $timeStr = $i . ':' . $s;
        }
        return $timeStr;
    }
}