<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
	
	public $admin = array();
	
	public function __construct(){
		parent::__construct();
		global $config;
		$this->load->helper('url');
		$this->load->library('util');
		$this->load->model('base_model');
		$this->load->library('menu');
		$this->checkAdminRights();
		$this->site_config = $this->loadSiteConfig();
		
	}
	
	
	//管理员权限验证
	public function checkAdminRights(){
		$admin = array();
		$admin['admin_name'] = $this->session->userdata['admin_name'];
		$admin['admin_id'] = $this->session->userdata['admin_id'];
		$admin['admin_right'] = $this->session->userdata['admin_right'];
		$admin['admin_role'] = $this->session->userdata['admin_role'];
		
		if($admin['admin_name'] == null && $admin['admin_id'] == null){
			redirect('systemadmin/login');
			exit;
		}
		
		$admin_where = "id = '" . $admin['admin_id'] . "'";
		$admin_row = $this->base_model->getDataRow('admin', $admin_where);
		if(!empty($admin_row)){
			if($admin_row['role'] != 0){
				$role_where = "id = '" . $admin_row['role'] . "'";
				$role_row = $this->base_model->getDataRow('admin_role', $role_where);
				if($this->checkRight($role_row['rights']) === FALSE){
					util::showMessage('没有权限！');
					exit;
				}
			}
			$this->admin = $admin;
		}else{
			util::showMessage('没有权限！');
			exit;
		}
	}
	
	//权限验证
	public function checkRight($rights){
		$actionId = $this->uri->segment(3);
		$controllerId = $this->uri->segment(2);
		
		if(empty($actionId)){
			$actionId = 'index';
		}
		
		$rightCode = $controllerId . '@' . $actionId;
		$rights = ',' . trim($rights) . ',';
		
		if($rightCode == 'admin@index') return true;
		
		if(stripos($rights, ',' . $rightCode . ',') === FALSE){
			return false;
		}else{
			return true;
		}
	}
	
	//加载site config
	public function loadSiteConfig(){
		$configData = $this->base_model->getData('site_config');
		$newConfigData = array();
		foreach($configData as $configKey => $configVal){
			$newConfigData[$configVal['var_name']] = $configVal['value'];
		}
		
		return $newConfigData;
	}
}