<?php
/**
 * base handle
 *
 * @author cuijiji
 * @date 2018/10/16
 */

namespace App\Http\V1\Handle;

abstract class BaseHandle
{
    const LOCATION = 0;
    const HTTP = 1;
    const RPC = 2;
    const CACHE = 3;

    abstract function handle($params);
}
