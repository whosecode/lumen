<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

//docker 探活使用
$app->router->get('/', function () {
    return [];
});
/**
 * @var \Dingo\Api\Routing\Router $api
 */
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    /**
     * @var \Dingo\Api\Routing\Router $api
     */
    $api->group(
        ['namespace' => 'App\Http\V1\Controllers', 'middleware' => ['BeforeMiddleware'], 'prefix' => 'example'],
        function () use ($api) {
            $api->get('/test', 'ExampleController@test');
        }
    );
});
