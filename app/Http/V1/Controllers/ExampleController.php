<?php

namespace App\Http\V1\Controllers;


use App\Http\V1\Handle\Example\TestHandle;
use Illuminate\Http\Request;

class ExampleController extends BaseController
{
    /**
     * Create a new controller instance.Å
     *
     * @return void
     */
    public function __construct()
    {

    }


    /**
     *  test
     *
     * @param Request $request
     * @return mixed
     */
    public  function test(Request $request, TestHandle $testHandle)
    {
        $validator = \Validator::make($request->all(), [
            'city' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator->errors()->first());
        }
        return $testHandle->handle($request->all());

    }
}
