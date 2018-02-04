<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/4
 * Time: 17:35
 */

class log
{

    /**
     * 写入日志
     * @param $msg          错误信息
     * @param string $evel  错误级别
     * @param int $type     错误类型
     * @param null $dest    日志保存路径
     */
    static public function write($msg,$evel='ERROR',$type=3,$log_path=null) {

        if ( !C('SAVE_LOG') ) return;

        //创建日志路径文件
        if (is_null($log_path)) {

            $log_path =  LOG_PATH .'/'.date('Y-m-d'.'.log');

        }

        if ( is_dir(LOG_PATH) ) error_log('[TIME]:'.date('Y-m-d H:i:s').'{$level}:{$msg}\r\n',$type,$log_path);
 
    }

}