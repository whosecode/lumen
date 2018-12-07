<?php

namespace App\Http\V1\Handle\Example;

use App\Http\V1\Handle\BaseHandle;

class TestHandle extends BaseHandle
{
    public function handle($params = [])
    {
        return psf(self::HTTP)->group('Example')->service('ExampleApi')->call('testPost', $params);
        return psf(self::HTTP)->group('Example')->service('ExampleApi')->call('getData', $params);
    }
}