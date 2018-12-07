<?php

namespace App\Http\Middleware\BeforeMiddleware;


use \Exception;

/**
 * 校验服务之间调用必须传递的header信息
 * Class CheckLoginMiddleware
 * @package App\Http\Middleware
 */
class CheckHeader
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function handle()
    {

        //$serviceTenant = $this->request->header('service-tenant', '');
        //if (!$serviceTenant) {
          //  throw new Exception('PARAM_INVALID_HEADER');
        //}
        return true;
    }

}
