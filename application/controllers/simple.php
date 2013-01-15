<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Simple extends MY_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
	}
	
	public function reg(){
		$validation = array(
			array(
				'field' => 'user_name',
				'label' => '用户名',
				'rules' => 'requried'
			),
		);
		
		$this->validation_array($validation);
		$this->load->view('simple/reg');
	}
	
	function validation_array($validation){
		foreach($validation as $val){
			foreach($val as $item){
				var_dump($item);
			}
		}
	}
}
