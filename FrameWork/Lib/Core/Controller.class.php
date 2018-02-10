<?php

/**
 * 核心控制器类
 */
class Controller
{

    private $assign_data = array();

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

    /**
     * 渲染模板
     * @param null $tpl
     */
    protected function display($tpl=NULL) {

        //未传参
        if ( is_null($tpl) ) {
            $path = APP_TPL_PATH.'/'.CONTROLLER.'/'.METHOD.'.html';
        } else {
            $ext_tpl = strrchr($tpl,'.');
            $tpl = empty($ext_tpl) ? $tpl.'.html' : $tpl;
            $path = APP_TPL_PATH.'/'.CONTROLLER.'/'.$tpl;
        }

        is_file($path) || halt($path .'模板不存在');

        //渲染数据
        extract($this->assign_data);

        include $path;

    }

    /**
     * 渲染数据
     * @param $var
     * @param $value
     */
    protected function assign($var,$value){
        $this->assign_data[$var] = $value;
    }


}
?>