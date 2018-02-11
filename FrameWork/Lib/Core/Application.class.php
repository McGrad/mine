<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/29
 * Time: 16:27
 */

final class Application
{

	/**
	 * [run 应用类运行入口]
	 * @return [type] [description]
	 */
    public static function run() {

        self::_init();

        //指定错误发生时运行的函数
        set_error_handler(array(__CLASS__,'error'));

        //注册一个PHP终止时执行的函数
        register_shutdown_function(array(__CLASS__,'fatal_error'));

        self::_import_file();

        self::_set_url();

        spl_autoload_register(array(__CLASS__,'_autoload'));

        self::_create_demo();

        self::_app_run();

    }

    /**
     * [_init 初始化配置项]
     * @return [type] [description]
     */
    private static function _init() {

    	//加载系统配置项
        C( include FrameWork_CONF_PATH . '/config.php' );

        //加载公共配置项
        $common_path = COMMON_CONF_PATH . '/config.php';

        //模块配置项设置
        $module_path = APP_CONF_PATH . '/config.php';

        $module_config = <<<str
<?php 
return array( 
	//配置项 => 配置值
	
	);
?>
str;
        is_file($common_path)   || file_put_contents($common_path,$module_config);
        C(include $common_path);

		is_file( $module_path ) || file_put_contents($module_path, $module_config);

		//加载模块配置项
		C( include $module_path );

		//设置默认时区
		date_default_timezone_set( C( 'DEFAULT_TIMEZONE' ) );

		//设置session
		C( 'SESSION_AUTO_START' ) && session_start() ;

    }

    private static function _import_file() {

        $arr_file = C('AUTO_LOAD_COMMON_FILE');

        if(is_array($arr_file) && !empty($arr_file)) {
            foreach ($arr_file as $val) {
                require_once COMMON_LIB_PATH.'/'.$val;
            }
        }

    }


    /**
     * [_set_url 设置外部路径]
     */
    private static function _set_url() {

    	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    	$path = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];

    	$path = str_replace('\\','/',$path);

    	define('__APP__', $path);

    	define('__ROOT__', dirname(__APP__));

    	define('__TPL__', __ROOT__ . '/' . APP_NAME . '/Tpl');

    	define('__PUBLIC__', __TPL__ .'/Public');


    }

    /**
     * [_autoload  自动注册]
     * @param  [type] $className [类名]
     * @return [type]            [description]
     */
    private static function _autoload( $className ) {

        switch (true)
        {
            case strlen($className) > 10 && substr($className,-10) == 'Controller':

                $controller_path = APP_CONTROLLER_PATH . '/' . $className .'.class.php';
                if (!is_file($controller_path)) {
                    $empty_controller_path = APP_CONTROLLER_PATH . '/EmptyController.class.php';
                    if (is_file($empty_controller_path)) {
                        include $empty_controller_path;return;
                    }
                }else {
                    include $controller_path;
                }
                break;

            case strlen($className) > 5 && substr($className,-5) == 'Model':

                $controller_path = COMMON_MODEL_PATH . '/' .$className . '.class.php';
                include $controller_path;
                break;

            default:

                $controller_path = TOOL_PATH . '/' . $className .'.class.php';
                is_file($controller_path) || halt($controller_path.'   class is not found ');
                include $controller_path;
                break;
        }

    }

    /**
     * 错误信息处理
     * @param $error_no
     * @param $error
     * @param $file
     * @param $line
     */
    public static function error($error_no, $error, $file, $line) {

        switch (true) {

            case E_ERROR:
            case E_COMPILE_ERROR:
            case E_CORE_ERROR:
                $msg = $error.$file .' in line ' . $line;
                halt($msg);
                break;
            case E_STRICT:
            case E_USER_WARNING:
            case E_USER_ERROR:
            case E_USER_NOTICE:
            defalut:
                if(DEBUG) {
                    include FrameWork_DATA_PATH.'/Tpl/notice.html';
                }
                break;
        }

    }

    /**
     * 致命错误处理
     */
    public static function  fatal_error() {

        if ( $error_info = error_get_last() ) {

            self::error($error_info['type'], $error_info['message'], $error_info['file'], $error_info['line']);

        }

    }


    /**
     * [_create_demo 创建示例控制器、方法]
     * @return [type] [description]
     */
    private static function _create_demo() {

    	$demo_path = APP_CONTROLLER_PATH .'/IndexController.class.php';

    	$contents = <<<str
<?php

	/**
	 * demo
	 * 示例
	 */
	class IndexController extends Controller
	{
		
		public function index()
		{
			echo 'hello world !!! 欢迎使用我的PHP框架';
		}
		
	}

?>
str;
		
		is_file($demo_path) || file_put_contents($demo_path,$contents);

    }

    /**
     * [_app_run 实例化控制器]
     * @return [type] [description]
     */
    private static function _app_run() {

		//读取控制器
    	$controller_data = isset($_GET[C('DEFAULT_CONTROL_SIMPLE')]) ? ucwords($_GET[C('DEFAULT_CONTROL_SIMPLE')]) : 'Index';

    	//读取方法
        $method_data = isset($_GET[C('DEFAULT_METHOD_SIMPLE')]) && !empty(trim($_GET[C('DEFAULT_METHOD_SIMPLE')])) ? $_GET[C('DEFAULT_METHOD_SIMPLE')] :'index';

    	$controller = $controller_data . 'Controller';

    	//定义控制器
    	define('CONTROLLER',$controller_data);
    	//定义方法
    	define('METHOD',$method_data);

        $obj_controller = new $controller();

    	method_exists($obj_controller,$method_data) || halt($method_data.'  method is not found ');

        $obj_controller->$method_data();

    }


}
?>