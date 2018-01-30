<?php

/**
 * 核心控制器类
 */
class Controller
{
	
	public function __construct() {

		if(method_exists($this,'__before')){
	      	$this->__before();
		}

	}


}