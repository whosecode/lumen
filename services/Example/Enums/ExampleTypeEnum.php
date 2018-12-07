<?php

/**
 * example类型
 *
 * @author cuijiji
 * @date 2018/11/02
 */

namespace Services\OperationLog\Enums;

use Services\Core\BaseEnum;

class ExampleTypeEnum extends BaseEnum
{
    const ADD = 1; // 增加
    const DELETE= 2; // 删除
    const UPDATE = 3; //修改
    const GET = 4; //获取
    const ALL = -1; //全部

    protected static $enums = array(
        self::ADD => '增加',
        self::DELETE => '删除',
        self::UPDATE => '修改',
        self::GET => '获取',
    );

    protected static $search = array(
        self::ALL => '全部',
    );
}