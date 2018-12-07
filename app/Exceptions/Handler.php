<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }


    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        return parent::render($request, $e);
      /*  if (app()->environment('production')) {
            return $this->renderInProduct($request, $e);
        } else {

        }*/
    }

    /**
     * 生产环境异常处理
     */
  /*  protected function renderInProduct($request, Exception $e)
    {
        if ($e instanceof HttpException) {
            return response()->json([
                'status' => 'no',
                'message' => "HTTP 响应异常",
                'errors' => $e->getResponse() ? $e->getResponse()->getData() : []
            ], 400);
        } elseif ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        } elseif ($e instanceof AuthorizationException) {
            $e = new HttpException(403, $e->getMessage());
        } elseif ($e instanceof ValidationException && $e->getResponse()) {
            return response()->json([
                'status' => 'no',
                'message' => "验证失败",
                'errors' => $e->getResponse() ? $e->getResponse()->getData() : []
            ], 400);
        }

        $fe = FlattenException::create($e);

        return response()->json([
            'status' => 'no',
            'message' => '错误请求'
        ], $fe->getStatusCode(), $fe->getHeaders());
    }*/
}
