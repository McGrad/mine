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
    public function run() {

        self::_init();

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

        //模块配置项设置
        $module_path = APP_CONF_PATH . '/config.php';

        $module_config = <<<str
<?php 
return array( 
	//配置项 => 配置值
	
	);
?>
str;
		is_file( $module_path ) || file_put_contents($module_path, $module_config);

		//加载模块配置项
		C( include $module_path );

		//设置默认时区
		date_default_timezone_set( C( 'DEFAULT_TIMEZONE' ) );

		//设置session
		C( 'SESSION_AUTO_START' ) && session_start() ;

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

    	$className = ucwords($className);

    	$controller_path = APP_CONTROLLER_PATH . '/' . $className .'.class.php';

    	is_file($controller_path) || die('controller is not found !');

        require $controller_path;

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
    private function _app_run() {

		//读取控制器
    	$controller_data = isset($_GET[C('DEFAULT_CONTROL_SIMPLE')]) ? ucwords($_GET[C('DEFAULT_CONTROL_SIMPLE')]) : 'Index';

    	//读取方法
    	$method_data = isset($_GET[C('DEFAULT_METHOD_SIMPLE')]) ? $_GET[C('DEFAULT_METHOD_SIMPLE')] : 'index';

    	$controller = $controller_data . 'Controller';

    	$obj_controller = new $controller();

    	method_exists($obj_controller,$method_data) || die('method is not found !!');

        $obj_controller->$method_data();

    }


}
?>