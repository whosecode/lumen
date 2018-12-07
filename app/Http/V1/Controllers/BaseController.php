<?php
/**
 * base
 *
 * @author cuijiji
 * @date 2018/10/16
 */

namespace App\Http\V1\Controllers;

use Laravel\Lumen\Routing\Controller;
use Dingo\Api\Routing\Helpers;

class BaseController extends Controller
{
    const LOCATION = 0;
    const HTTP = 1;
    const RPC = 2;
    const CACHE = 3;


    use Helpers;

}
