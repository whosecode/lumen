<?php
/**
 * 设置一个服务提供者
 *
 * @author cuijiji
 * @date 2018/10/25
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Services\Code\Psf;

class PsfServiceProvider extends ServiceProvider
{
    /**
     * 延迟加载
     *
     * @var boolean
     */
    protected $defer = true;

    /**
     * 启动服务提供者
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * 注册服务提供者
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('psf',function(){
            return new Psf();
        });
    }

    /**
     * 获取由提供者提供的服务.
     *
     * @return array
     */
    public function provides()
    {
        return [Psf::class];
    }

}
