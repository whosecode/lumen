<?php

/**
 * API基类
 *
 * @author cuijiji
 * @date 2018/10/15
 */

namespace Services\Code;


class BaseApi
{
    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        $code = 0;  $message = 'ok';  $data = [];
        try {
            if (!method_exists($this, $method)) {
                throw new \Exception($method.'方法找不到','404');
            }
            $data = call_user_func_array(array($this, $method), $args);
        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
        }
        return [
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];

    }


}