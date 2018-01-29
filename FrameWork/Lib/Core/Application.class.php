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

        self::_set_url();

        spl_autoload_register(array(__CLASS__,'_autoload'));

    }

    /**
     * 初始化配置项
     */
    private static function _init() {

    	//加载系统配置项
        C( include FrameWork_CONF_PATH . '/config.php' );

        //模块配置项设置
        $module_path = APP_CONF_PATH . '/config.php';

        $module_config = <<<str
<?php
return array(
		//配置项 => 配置值,
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
     * 设置外部路径
     */
    private static function _set_url() {

    	$path = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];

    	$path = str_replace('\\','/',$path);

    	define('__APP__', $path);

    	define('__ROOT__', dirname(__APP__));

    	define('__TPL__', __ROOT__ . '/' . APP_NAME . '/Tpl');
    	
    	define('__PUBLIC__', __TPL__ .'/Public');


    }

    /**
     * 自动注册
     */
    private static function _autoload( $className ) {

    	echo $className;

    }


}