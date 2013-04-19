<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_gateway {
	
	private $_ci;
	private $user_id;

	function __construct()
	{
		$this->_ci = &get_instance();
	}

	function register_api_call($data){
		return true;
	}

	function send_online_transaction($data){
		if (isset($data) && count($data) > 0){
			return array('result'=>'000');
		}else{
			return false;
		}
	}
	
}