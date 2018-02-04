<?php

	/**
	 * demo
	 * 示例
	 */
	class IndexController extends Controller
	{

		public function __construct() {

			parent::__construct();

		}

		public function _before() {

            echo '1111<br />';

		}
		
		public function index()
		{
//		    echo $_SERVER['HTTP_REFERER'];
            $this->success('测试成功','','5');
		}

		public function test(){

            $this->error('测试失败','/index','5');

        }


	}

?>