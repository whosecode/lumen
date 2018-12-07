<?php

/**
 * example dao
 *
 * @author cuijiji
 * @date 2018/10/15
 */

namespace Services\Example;


use Services\Code\BaseDao;

class ExampleDao extends BaseDao
{

    /**
     * 数据库连接
     *
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'example';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id'
    ];


}