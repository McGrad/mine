<?php

return array(
		//默认
		'DEFAULT_TIMEZONE'			=>	'PRC',
		//开启session
		'SESSION_AUTO_START'		=>	TRUE,
		//访问控制器
		'DEFAULT_CONTROL_SIMPLE' 	=> 	'act',
		//访问方法
		'DEFAULT_METHOD_SIMPLE'		=>	'm',
        //是否开启日志
        'SAVE_LOG'                  => 'true',
        //错误跳转url
        'ERROR_URL'                 => '',
        //错误提示信息
        'ERROR_MSG'                 => '网站出错了，请稍后重试。。。',
        //自动加载common/lib目录文件
        'AUTO_LOAD_COMMON_FILE'     => array(),
        //默认字符集
        'DB_CHARSET'                => 'utf8',
        //默认连接主机
        'DB_HOST'                   => 'localhost',
        //默认端口
        'DB_PORT'                   => '3306',
        //默认数据库连接用户名
        'DB_USER'                   => 'root',
        //默认数据库连接密码
        'DB_PASSWORD'               => '',
        //默认连接数据库
        'DB_DATABASE'                   => '',
        //默认数据表前缀
        'DB_PREFIX'                   => ''
	);