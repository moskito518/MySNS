<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ucenter extends MY_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->checkUser();
	}
	
	
	public function index(){
		$data['page_title'] = '用户中心首页';
		
		$this->load->view('ucenter/index');
	}
	
	public function diary(){
		$data['page_title'] = '日志';
		
		$this->load->view('ucenter/diary', $data);
	}
}