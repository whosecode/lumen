<?php

return [

    'SUCCESS' => ['code' => 0, 'message' => 'success', 'data' => []],

    /**
     * ========================================    系统异常/正常对应码 ========================================
     * 100-999 http状态码
     */
    'NOT_FOUND' => ['code' => 404, 'message' => '请求的资源不存在', 'data' => []],
    'METHOD_NOT_ALLOWED' => ['code' => 405, 'message' => '该http方法不被允许', 'data' => []],

    /**
     * ========================================    网络异常/正常对应码 外部服务等依赖 ===========================
     * 1001-1999
     */


    /**
     * ========================================    业务异常/正常对应码 ========================================
     * 2000-9999
     */
    'FAIL' => ['code' => 2000, 'message' => '内部接口错误', 'data' => []],
    'SYS_ERROR' => ['code' => 2001, 'message' => '系统内部错误', 'data' => []],
    'HTTP_FAIL' => ['code' => 2002, 'message' => '内部http接口调用失败', 'data' => []],
    'PARAM_INVALID_ADD_UNIQUE' => ['code' => 2003, 'message' => '唯一识别标识重复', 'data' => []],
    'PARAM_INVALID_TOKEN' => ['code' => 2010, 'message' => 'token参数不合法'],
    'PARAM_INVALID_TOKEN_NOT_EXIST' => ['code' => 2011, 'message' => 'token不存在', 'data' => []],
    'PARAM_INVALID_HEADER' => ['code' => 2020, 'message' => '请求头信息不合法', 'data' => []],

    'CONNECTION_ERROR' => ['code' => 2100, 'message' => '依赖服务异常', 'data' => []],

    'HTTP_CODE' => [
        404 => ['code' => 404, 'message' => '请求的资源不存在', 'data' => []],
        405 => ['code' => 405, 'message' => '该http方法不被允许', 'data' => []],
        500 => ['code' => 500, 'message' => '系统内部错误', 'data' => []],
    ]
];
