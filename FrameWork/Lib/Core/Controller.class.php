<?php

/**
 * 核心控制器类
 */
class Controller
{
	
	public function __construct() {

        /**
         * 增加自动初始化功能
         */
		if(method_exists($this,'_before')){
	      	$this->_before();
		}

	}

    /**
     * 成功提示模板
     * @param $msg      提示语
     * @param null $url 跳转路径
     * @param int $wait 时间
     */
	public function success($msg,$url= null,$wait=3) {

	    $code = 1;

	    $url = $this->create_url($url);

        include APP_TPL_PATH .'/hint.html';

    }

    /**
     * 失败提示模板
     * @param $msg       提示语
     * @param null $url 跳转路径
     * @param int $wait 时间
     */
    public function error($msg,$url= null,$wait=3) {

        $code = 0;

        $url = $url ? $url : '';

        include APP_TPL_PATH .'/hint.html';

    }


    private function create_url($url) {

        $url = isset($url) ? $url : '';

        echo $url;die;

    }


}