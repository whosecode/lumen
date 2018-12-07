<?php
/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| First we need to get an application instance. This creates an instance
| of the application / container and bootstraps the application so it
| is ready to receive HTTP / Console requests from the environment.
|
*/

use Illuminate\Http\Request;

$app = require __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/


/**
 * param $request come from Bootstrap.$request
 *
 * run() 传空或不传，每次运行都会生成新的 request
 *
 * 用来保持生命周期内使用同一个 request
 */
$request = isset($request) ? $request : Request::capture();
$app->run($request);
