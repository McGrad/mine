<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/28
 * Time: 17:36
 */

class mine
{

    public static function start() {

        echo 'hello world ! <br />';

        self::create_app_path();

        self::create_app();

    }

    private function create_app_path() {

        echo 'app_path<br />';

    }

    private function create_app() {

        echo 'app <br />';

    }


}