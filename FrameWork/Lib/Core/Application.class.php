<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/29
 * Time: 16:27
 */

final class Application
{
    public function run() {

        self::_init();

    }

    /**
     * 初始化配置项
     */
    private function _init() {

        C( include FrameWork_CONF_PATH );

    }


}