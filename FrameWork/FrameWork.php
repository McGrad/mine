<?php

/**
 * 框架引导文件
 *
 * 定义应用目录   application/
 *
 * 生成应用目录
 *
 * 定义常量
 *
 */
final class FrameWork {

	/**
	 * 引导方法
	 */
	public static  function run () {

		self::_set_const();

		//是否开启调试模式（默认不开启）
		defined('DEBUG') || define('DEBUG',false);

		if( DEBUG ) {

            self::_create_dir();

            self::_import_file();

        } else {

		    //屏蔽所有报错信息——安全性考虑
		    error_reporting(0);

		    require TMP_PATH.'/tmp_core.php';

        }


		Application::run();

	}

	/**
	 * 设置应用常量(文件目录)
	 */
	private static function _set_const() {

	    //获取框架目录（替换window ‘/’ 为 ‘\’）
		$path = str_replace('\\','/',__FILE__);

        //定义框架目录
		define('FrameWork_PATH',dirname($path));
		//定义框架配置项目录
        define('FrameWork_CONF_PATH',FrameWork_PATH.'/Conf');
        //定义框架模板目录
        define('FrameWork_DATA_PATH',FrameWork_PATH.'/Data');
        //定义框架类库目录
        define('FrameWork_LIB_PATH',FrameWork_PATH.'/Lib');
        //定义框架核心类文件目录
        define('FrameWork_CORE_PATH',FrameWork_LIB_PATH.'/Core');
        //定义框架方法文件目录
        define('FrameWork_Fun_PATH',FrameWork_LIB_PATH.'/Function');

        //定义扩展类库目录
        define('EXTENDS_PATH',FrameWork_PATH.'/Extends');
        //定义扩展类目录
        define('TOOL_PATH',EXTENDS_PATH.'/Tool');
        //定义第三方类库目录
        define('ORG_PATH',EXTENDS_PATH.'/Org');

        //定义应用文件目录
        define('ROOT_PATH',dirname(FrameWork_PATH));

        //定义公共文件目录
        define('COMMON_PATH',ROOT_PATH.'/Common');
        //定义公共配置文件目录
        define('COMMON_CONF_PATH',COMMON_PATH.'/Conf');
        //定义公共模型文件目录
        define('COMMON_MODEL_PATH',COMMON_PATH.'/Model');
        //定义公共类文件目录
        define('COMMON_LIB_PATH',COMMON_PATH.'/Lib');

        //定义临时文件目录
        define('TMP_PATH',ROOT_PATH.'/Tmp');
        //定义日志目录
        define('LOG_PATH',TMP_PATH.'/Log');

        //定义模块目录
        define('APP_PATH',ROOT_PATH.'/'.APP_NAME);

        //定义模块配置目录
        define('APP_CONF_PATH',APP_PATH.'/Conf');

        //定义模块模板目录
        define('APP_TPL_PATH',APP_PATH.'/Tpl');

        //定义模块控制器目录
        define('APP_CONTROLLER_PATH',APP_PATH.'/Controller');

        //定义模块model目录
        define('APP_MODEL_PATH',APP_PATH.'/Model');

        //定义模块静态文件路径
        define('APP_PUBLIC_PATH',APP_TPL_PATH.'/Public');

        //定义接值方式
        define('IS_POST',($_SERVER['REQUEST_METHOD'] == 'POST') ? true : false);
        isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' || define('IS_AJAX',false);

        defined('IS_AJAX') || define('IS_AJAX',true);

	}

	/**
     * 创建文件
     */
	public static function _create_dir () {

	    $path_arr = array(
            APP_PATH,
            APP_CONF_PATH,
            APP_TPL_PATH,
            APP_CONTROLLER_PATH,
            APP_MODEL_PATH,
            APP_PUBLIC_PATH,
            TMP_PATH,
            LOG_PATH,
            COMMON_PATH,
            COMMON_CONF_PATH,
            COMMON_MODEL_PATH,
            COMMON_LIB_PATH
        );

	    foreach ($path_arr as $k => $val) {

	        is_dir($val) || mkdir($val, 0777, true);

        }

        //创建提示模板
        is_file(APP_TPL_PATH.'/hint.html') || copy(FrameWork_DATA_PATH.'/Tpl/hint.html',APP_TPL_PATH.'/hint.html');

    }

    /**
     * 载入核心文件
     */
    public static function _import_file () {

        $file_arr = array(
            FrameWork_Fun_PATH.'/Function.php',
            FrameWork_CORE_PATH.'/Controller.class.php',
            FrameWork_CORE_PATH.'/Application.class.php',
            FrameWork_CORE_PATH.'/Log.class.php',
        );

        $str = '';

        foreach ($file_arr as $k => $val ) {

            $str .= trim(substr(file_get_contents($val),5,-2));

            require_once $val;

        }

        $str = "<?php\r\n".$str;

        file_put_contents(TMP_PATH.'/tmp_core.php',$str) || die('access not allowed !!!');

    }

}

frameWork::run();
?>