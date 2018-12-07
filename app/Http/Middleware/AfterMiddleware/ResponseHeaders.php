<?php

namespace App\Http\Middleware\AfterMiddleware;


class ResponseHeaders
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    public function handle()
    {
        $headersObj = new Headers($this->data);
        $headersObj->addContentType();

        return $this->data;
    }
}
