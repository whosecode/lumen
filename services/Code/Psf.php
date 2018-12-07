<?php

/**
 * 服务调用类
 *
 * @author cuijiji
 * @date 2018/10/15
 */

namespace Services\Code;

use \Jiji\Http\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class Psf
{

    CONST TTL = 60;
    /**
     * 服务驱动
     *
     * @var array
     */
    private $drives = [
        'location',
        'http',
        'rpc',
        'cache'
    ];

    private $drive;
    private $group;
    private $service;

    /**
     * 客户端环境变量
     *
     * @var array
     */
    private $env = array();

    /**
     * 设置服务驱动
     *
     * @param string $drive
     * @return $this
     */
    public function drive($drive)
    {
        $this->drive = $this->drives[$drive];
        return $this;
    }

    /**
     * 服务分组
     *
     * @param string $group
     * @return $this
     */
    public function group($group)
    {
        $this->group = $group;
        return $this;
    }

    /**
     * 服务名字
     *
     * @param string $group
     * @return $this
     */
    public function service($service)
    {
        $this->service = $service;
        return $this;
    }

    /**
     * 设置客户端环境变量
     *
     * @param mixed $key
     * @param mixed $val
     * @return $this
     */
    public function env($key, $val)
    {
        if (is_array($key)) {
            $this->env = $key;
        } else {
            $this->env[$key] = $val;
        }
        return $this;
    }


    /**
     * 发起调用
     *
     * @param string $serviceName 服务名称
     * @param array $params 参数
     * @return $Result
     */

    public function call($method, $params = array())
    {
        $action = $this->drive . 'Call';
        try {
            $result = $this->$action($method, $params);
        } catch (\Exception $e) {
            $errCode = $e->getCode() == 0 ? 9001 : $e->getCode();
            $result = array(
                'code' => $errCode,
                'message' => $e->getMessage(),
                'data' => [],
            );
        }
        if ($result['code']) {
            Log::error($result['code'] . $result['message']);
            return config('codeFlag')['FAIL'];
        }
        if ($this->drive == 'cache') {
            $key = 'cacheCall' . md5($method . json_encode($params));
            if (!Redis::exists($key)) {
                Redis::psetex($key, self::TTL, json_encode($result));
            }
        }
        return $result;

    }


    /**
     * 发起本地调用
     *
     * @param string $serviceName 服务名称
     * @param array $params 参数
     * @return $Result
     */
    public function locationCall($method, $params)
    {
        $className = 'Services\\' . $this->group . '\\' . $this->service;
        $class = new \ReflectionClass($className);
        $className = $class->newInstanceArgs();
        return call_user_func_array(array($className, $method), $params);

    }

    /**
     * 发起RPC调用
     *
     * @param string $serviceName 服务名称
     * @param array $params 参数
     * @return $Result
     */
    public function rpcCall($method, $params)
    {
        return [];
    }

    /**
     * 发起http调用
     *
     * @param string $serviceName 服务名称
     * @param array $params 参数
     * @return $Result
     */
    public function httpCall($method, $params)
    {
        $client = new Client();
        $httpConfig = config('httpMap')[$this->group][$this->service][$method];
        $method = $httpConfig['method'];
        $result = $client->$method($httpConfig['url'], $params);
        return ($result['code']==200) ? [
            'code' => 0,
            'message' => '调用成功',
            'data' => $result
        ] : config('codeFlag')['FAIL'];
    }

    /**
     * 发起cache调用
     *
     * @param string $serviceName 服务名称
     * @param array $params 参数
     * @return $Result
     */
    public function cacheCall($method, $params)
    {
        $key = 'cacheCall' . md5($method . json_encode($params));
        $result = Redis::get($key);
        if (!$result) {
            $result = $this->locationCall($method, $params);
        } else {
            $result = json_decode($result, true);
        }
        return $result;
    }
}
