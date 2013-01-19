<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Simple extends MY_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$user = array();
		$user['uid'] = $this->input->cookie('uid');
		$user['user_name'] = $this->input->cookie('user_name');
		$this->user = $user;
	}
	
	public function index(){
		$this->load->view('simple/index');
	}
	
	//注册用户
	public function reg(){
		if($this->user['uid'] != null && $this->user['user_name'] != null){
			redirect('simple/index');
			exit;
		}
		
		$validation = array(
			array('field' => 'user_name', 'label' => '用户名',	'rules' => 'requried|max_length[24]|min_length[4]'),
			array('field' => 'password', 'label' => '密码', 'rules' => 'requried|max_length[32]|min_length[6]'),
			array('field' => 'repassword', 'label' => '确认密码', 'rules' => 'requred|max_length[32]|min_length[6]|matches[password]'),
			array('field' => 'email', 'label' => '邮箱', 'rules' => 'required|valid_email')
		);
		
		$this->form_validation->set_rules($validation);
		
		if($this->form_validation->run() === FALSE){
			$this->load->view('simple/reg');
		}else{
			$this->load->helper('date');
			
			$regData = array(
				'user_name' => trim($this->input->post('user_name')),
				'password' => md5(trim($this->input->post('password'))),
				'email' => trim($this->input->post('email')),
				'create_time' => unix_to_human(now(), TRUE, 'zh')
			);
			
			$error_message = '';
			
			//检测邮箱和用户名是否使用
			$email_where = 'email = \'' . $regData['email'] . '\'';
			$checkEmailData = $this->base_model->getData('user', $email_where);
			if(count($checkEmailData) > 0){
				$error_message = '此邮箱已注册';
			}
			
			$name_where = 'user_name = \'' . $regData['user_name'] . '\'';
			$checkNameData = $this->base_model->getData('user', $name_where);
			if(count($checkNameData) > 0){
				$error_message = '用户名已注册';
			}
			
			//检测错误信息
			if($error_message != ''){
				Util::showMessage($error_message);
				exit;
			}
			
			//无错误添加到数据库
			$this->base_model->addData('user', $regData);
			util::showMessage('注册成功!', site_url('simple/reg'));
		}
	}
	
	//前台用户登录
	public function login(){
		if($this->user['uid'] != null && $this->user['user_name'] != null){
			redirect('simple/index');
			exit;
		}
		
		$validation = array(
			array('field' => 'user_name', 'label' => '用户名', 'rules' => 'required'),
			array('field' => 'password', 'label' => '密码', 'rules' => 'required')
		);
		$this->form_validation->set_rules($validation);
		
		if($this->form_validation->run() === FALSE){
			$this->load->view('simple/login');
		}else{
			$loginData = array(
				'user_name' => trim($this->input->post('user_name')),
				'password' => md5(trim($this->input->post('password')))
			);
			
			//检查登录信息
			$loginWhere = 'user_name = \'' . $loginData['user_name'] . '\' and password =\'' . $loginData['password'] . '\'';
			$checkLoginData = $this->base_model->getDataRow('user', $loginWhere);
			if(count($checkLoginData) > 0){
				$this->load->helper('cookie');
				set_cookie('user_name', $checkLoginData['user_name']);
				set_cookie('uid', $checkLoginData['id']);
				
				util::showMessage('登录成功！', 'simple/login');
			}else{
				util::showMessage('用户名不存在或密码不正确!');
				exit;
			}
		}
	}
	
	//前台用户退出
	public function loginout(){
		$this->load->helper('cookie');
		delete_cookie('uid');
		delete_cookie('user_name');
		redirect('simple/login');
	}
}
