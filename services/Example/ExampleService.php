<?php

/**
 * example service 层
 *
 * @author cuijiji
 * @date 2018/10/15
 */
namespace Services\Example;

use Services\Code\BaseService;

class ExampleService extends BaseService
{

    /**
     * @var \Illuminate\Database\Eloquent\Model;
     */
    protected $dao;


    public function __construct()
    {
        $this->dao = app('Services\Example\ExampleDao');

    }


    /**
     * getData
     *
     * @param $statTime
     * @param $endTime
     * @param $opName
     * @param $opType
     * @param $opObject
     * @return mixed
     */
    public function getTestData($pageNumber=20, $page=1)
    {
         $dao = $this->dao;

        return $dao->orderby("created_at" , "DESC")
                   ->paginate($pageNumber, $columns = ['*'], $pageName = 'page', $page);
    }


}