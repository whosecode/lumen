<?php

/**
 * 数字助手库
 *
 * @author cuijiji
 * @date 2018/10/17
 */

namespace Services\Helper;

class NumberHelper
{
    /**
     * 生成验证码
     *
     * @return string
     */
    public static function generateVerificationCode()
    {
        return self::generateRandCode();
    }

    /**
     * 生成6位随机码
     *
     * @return string
     */
    public static function generateRandCode()
    {
        return mt_rand(1,9).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9);
    }
}