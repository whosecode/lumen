<?php

namespace App\Http\Middleware\AfterMiddleware;

class Headers
{
    private $data;
    private static $contentType;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setContentType($value = "")
    {
        if (empty($value)) {

            $accept = app("request")->headers->get("accept");

            if (strpos($accept, "text/html") !== false) {
                self::$contentType = "text/html";
            } else {
                self::$contentType = config("base.header.contentType");
            }
        } else {
            self::$contentType = $value;
        }

    }

    public function addContentType()
    {
        if (empty(self::$contentType)) {
            $this->setContentType();
        }

        $this->data->headers->set("Content-Type", self::$contentType);
    }
}
