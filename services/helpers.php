<?php
/**
 * 帮助函数
 *
 * @author cuijiji
 * @date 2018/10/25
 */
if (!function_exists('psf')) {

    /**
     * 获取一个psf实例
     * @param string drive 驱动名字
     * @return \Services\Code\Psf
     */
    function psf($drive = '')
    {
        return app('psf')->drive($drive);
    }
}
