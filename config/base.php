<?php

$basePath = app()->basePath();

return [
    "header" => [
        "contentType" => "application/json",
        "allowOrigin" => "*.mafengwo.com",
        "allowOriginNotProduction" => "*",
        "allowMethods" => "POST,GET,PUT,DELETE,OPTIONS",
    ],
    "page" => [
        "per" => 10, // 每页条数
    ],
    "hashKeyLen" => 16,
    "hashKeyValue" => 1,
];