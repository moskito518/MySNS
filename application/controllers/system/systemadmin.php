<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Systemadmin extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('util');
		$this->load->model('base_model');
	}
	
	public function login(){
		$data['page_title'] = '登录';
		echo '123';
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$validation = array(
			array(
				'field' => 'name',
				'label' => '用户名',
				'rules' => 'required'
			),
			array(
				'field' => 'password',
				'label' => '密码',
				'rules' => 'required'
			)
		);
		
		$this->form_validation->set_rules($validation);
		
		if($this->form_validation->run() === FALSE){
			$this->load->view('system/login', $data);
		}else{
			$name = trim($this->input->post('name'));
			$password = trim($this->input->post('password'));
			
			$userWhere = "name = '" . $name . "'";
			$userRow = $this->base_model->getDataRow('admin', $userWhere);
			
			if($userRow['password'] === md5($password)){
				$newData = array(
					'admin_id' => $userRow['id'],
					'admin_name' => $userRow['name'],
				);
				
				//根据角色分配权限
				if($userRow['role'] == 0){
					$newData['admin_right'] = 'administrator';
					$newData['admin_role'] = '超级管理员';
				}else{
					$where = "id = '" . $userRow['role'] . "'";
					$roleRow = $this->base_model->getDataRow('admin_role', $where);
					$newData['admin_right'] = $roleRow['rights'];
					$newData['admin_role'] = $roleRow['name'];					
				}
				
				$this->session->set_userdata($newData);
				redirect('/system/option');
			}else{
				util::showMessage('密码错误,登录失败');
			}
		}
	}
	
	//退出登录
	public function logout(){
		$this->session->sess_destroy();
		redirect(site_url('/systemadmin'));
	}
}