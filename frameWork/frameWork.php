<?php

/**
 * 框架对外接口类
 *
 * 定义应用目录
 *
 * 生成目录
 *
 * 定义常量
 *
 */
final class frameWork {

	/**
	 * 对外接口
	 *
	 */
	public function static function run () {
		self::_set_const();
		self::_create_dir();
		self::_import_file();
		Application::run();
	
	}

	/**
	 * 设置应用目录
	 *
	 */
	private static function _set_const() {

		echo __FILE__;

		define('APP_PATH',__FILE__);
		

	}


}


