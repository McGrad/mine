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

		public function __before() {

			echo 'aaaaaaaa<br />';

		}
		
		public function index()
		{
			echo 'hello world !';
		}
	}

?>