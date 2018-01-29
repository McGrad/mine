<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/29
 * Time: 16:25
 */

/**
 * 打印数据
 * @param $arr
 */
function p( $arr ) {

    echo '<pre>';

    print_r($arr);

    die;

};

/**
 * 打印数据类型
 * @param $arr
 */
function v( $arr ) {

    echo '<pre>';

    var_dump($arr);

    die;

}

/**
 * 1、加载配置项  （系统配置项 || 模块配置项）
 * 2、读取配置项  （系统配置项参数）
 * 3、临时动态改变配置项  （配置项参数，配置项值）
 * @param null $var     配置参数
 * @param null $value   临时动态配置值
 */
function C( $var = NULL, $value = NULL ) {

    //初始化配置项
    static $config_arr = array();

    //加载配置项
    if ( is_array($var) ) {

        /**
         * array_merge 合并数组     （键名相同的会被覆盖）
         * array_change_key_case    将数组的所有键转换为大写
         */
        $config_arr = array_merge($config_arr,array_change_key_case($var,CASE_UPPER));

        //防止程序继续向下执行，终止程序
        return;

    }

    //读取配置项
    if ( is_string( $var ) ) {

        //转换成大写（配置项参数均为大写）
        $var = strtoupper($var);

        //两个参数时，配置项的值
        if ( !is_null($value) ) {

            $config_arr[$var] = $value;

            //终止程序
            return;

        }

        return isset($config_arr[$var]) ? $config_arr[$var] : NULL;

    }

    //返回所有配置项
    if ( is_null($var) && is_null($value) ) {

        return $config_arr;

    }



}

