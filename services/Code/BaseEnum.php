<?php

/**
 * 枚举基类
 *
 * @author cuijiji
 * @date 2018/10/15
 */

namespace Services\Core;

class BaseEnum
{
    protected static $enums = array();
    protected static $search = array();

    const UNDEFINED = false;

    /**
     * 获取已经定义的常量
     *
     * @param null $key
     *
     * @return array|string
     */
    public static function get($key = null)
    {
        if (is_null($key)) {
            return static::$enums;
        } elseif (isset(static::$enums[$key])) {
            return static::$enums[$key];
        } else {
            return self::UNDEFINED;
        }
    }

    /**
     * 判断常量是否存在
     *
     * @param $const 要判断的常量
     *
     * @return bool
     */
    public static function exists($const)
    {
        static $classConsts = array();
        $subClassName = get_called_class();
        if (!isset($classConsts[$subClassName])) {
            $refObj = new \ReflectionClass($subClassName);
            $classConsts[$subClassName] = $refObj->getConstants();
        }
        return in_array($const, $classConsts[$subClassName]);
    }

    /**
     * 专用于搜索的常理
     *
     * @return array
     */
    public static function search($before = [])
    {
        if (!empty($before)) {
            return $before + static::$enums;
        } else {
            return static::$search + static::$enums;
        }
    }


    public static function isEnum($value)
    {
        if (isset(static::$enums[$value]))
            return true;

        return false;
    }
}