<?php

require_once __DIR__.'/../vendor/autoload.php';

use Illuminate\Http\Request;


// 设置应用名
define("APP_NAME", "service-data");

// 设置 storage 路径
//define("STORAGE_PATH", '/var/cache/nginx/webcache/storage/' . APP_NAME);



try {
    $env = isset($_SERVER['APP_ENV']) ? ".env.{$_SERVER['APP_ENV']}"  : '.env';
    $a = (new Dotenv\Dotenv(__DIR__.'/../', $env))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

 $app->withFacades();

 $app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//    App\Http\Middleware\ExampleMiddleware::class
// ]);

// $app->routeMiddleware([
//     'auth' => App\Http\Middleware\Authenticate::class,
// ]);

//增加前后路由
$app->routeMiddleware([
    'BeforeMiddleware' => App\Http\Middleware\BeforeMiddleware::class,
    'AfterMiddleware' => App\Http\Middleware\AfterMiddleware::class,
]);
/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

// $app->register(App\Providers\AppServiceProvider::class);
// $app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);
if ($app->environment() !== 'production') {
    $app->register(Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
}
$app->register(Dingo\Api\Provider\LumenServiceProvider::class);
$app->register(Illuminate\Redis\RedisServiceProvider::class);
$app->register(App\Providers\PsfServiceProvider::class);



foreach (glob(__DIR__. "/../config/*.php") as $k => $v)
{
    $app->configure(basename($v,".php"));
}
/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

// 重新设置请求 暂时用不到
if (php_sapi_name() === "fpm-fcgi") {
    $request = Request::capture();
}

require __DIR__.'/../routes/api.php';


//线上错误处理统一返回系统内部错误 注：暂时反着来 测试一下没问题再在线上运行 暂时去log里面查看错误信息
if (!app()->environment('production')) {
    $app['Dingo\Api\Exception\Handler']->register(function (Symfony\Component\HttpKernel\Exception\HttpException $exception) {
        if (key_exists($exception->getStatusCode(), config("codeFlag")['HTTP_CODE'])) {
            return response()->json(config("codeFlag")['HTTP_CODE'][$exception->getStatusCode()],$exception->getStatusCode());
        }
        return response()->json(['code'=> $exception->getStatusCode(), 'message'=> $exception->getMessage(), 'data' => []],200);
    });
    $app['Dingo\Api\Exception\Handler']->register(function (Exception $exception) {
        return response()->json(config('codeFlag')['SYS_ERROR'],200);
    });
}

/*
$app['Dingo\Api\Exception\Handler']->setErrorFormat([
    'code' => ':code',
    'status_code' => ':status_code',
    'message' => ':message',
    'data' => []
]);*/

return $app;
