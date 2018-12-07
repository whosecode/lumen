<?php

/**
 * example api层
 *
 * @author cuijiji
 * @date 2018/10/15
 */

namespace Services\Example;

use Services\Code\BaseApi;

class ExampleApi extends BaseApi
{
    protected $service;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->service =  app(ExampleService::class);
    }

    /**
     * get operation object enum
     * @return mixed
     */
    protected function getData($param)
    {
        return $this->service->getTestData($param);
    }
}
