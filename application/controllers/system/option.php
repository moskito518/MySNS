<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Option extends MY_Controller{
	
	public function __construct(){
		parent::__construct();
	}
	
	//后台首页
	public function index(){
		$data['page_title'] = '后台首页';
		$this->load->view('system/option/index', $data);
	}
	
	//站点设置首页
	public function site_config(){
		$data['page_title'] = '站点配置';
		
		$this->load->helper('form');
		
		$configData = $this->base_model->getData('site_config');
		foreach($configData as $configKey => $configVal){
			switch($configVal['category']){
				case 'base':
					$configData[$configKey]['category'] = '基本设置';
					break;
				case 'email':
					$configData[$configKey]['category'] = '邮件设置';
					break;
				default:
					$configData[$configKey]['category'] = '基本设置';
			}
			
			switch($configVal['status']){
				case 0:
					$configData[$configKey]['status'] = '启用';
					break;
				case 1:
					$configData[$configKey]['status'] = '禁用';
					break;
				default:
					$configData[$configKey]['status'] = '启用';
			}
		}
		$data['configData'] = $configData;
		$this->load->view('system/option/site_config', $data);
		
	}
	
	//添加新的站点配置
	public function site_config_add(){
		$data['page_title'] = '添加站点设置';
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$validation = array(
			array(
				'field' => 'var_name',
				'label' => '变量名',
				'rules' => 'required'
			),
			array(
				'field' => 'title',
				'label' => '设置名称',
				'rules' => 'required'
			),
			array(
				'field' => 'category',
				'label' => '配置分类',
				'rules' => 'required'
			),
			array(
				'field' => 'value',
				'label' => '值',
				'rules' => ''
			),
			array(
				'field' => 'status',
				'label' => '状态',
				'rules' => 'required'
			)
		);
		
		$this->form_validation->set_rules($validation);
		
		if($this->form_validation->run() === FALSE){
			$this->load->view('system/option/site_config_add', $data);
		}else{
			$configData = array(
				'var_name' => trim($this->input->post('var_name')),
				'title' => trim($this->input->post('title')),
				'category' => $this->input->post('category'),
				'value' => trim($this->input->post('value')),
				'status' => $this->input->post('status'),
				'type' => $this->input->post('type')
			);
			
			$checkVarWhere = "var_name = '" . $configData['var_name'] . "'";
			$checkVarData = $this->base_model->getData('site_config', $checkVarWhere);
			if(count($checkVarData) > 0){
				util::showMessage('已有名为' . $checkVarData['var_name'] . '变量的设置！', site_url('system/site_config'));
				exit;
			}
			
			$checkTitleWhere = "title = '" . $configData['title'] . "'";
			$checkTtitleData = $this->base_model->getData('site_config', $checkTitleWhere);
			if(count($checkTtitleData) > 0){
				util::showMessage('已有名为' . $configData['title'] . '名称的设置！', site_url('system/site_config'));
				exit;
			}
			
			
			$this->base_model->addData('site_config', $configData);
			util::showMessage('添加成功！', site_url('system/option/site_config'));
		}
	}
	
	//编辑站点配置
	public function site_config_edit(){
		$data['page_title'] = '编辑站点配置';
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$validation = array(
			array(
				'field' => 'var_name',
				'label' => '变量名',
				'rules' => 'required'
			),
			array(
				'field' => 'title',
				'label' => '设置名称',
				'rules' => 'required'
			),
			array(
				'field' => 'category',
				'label' => '配置分类',
				'rules' => 'required'
			),
			array(
				'field' => 'type',
				'label' => '类型',
				'rules' => 'required'
			),
			array(
				'field' => 'value',
				'label' => '值',
				'rules' => ''
			),
			array(
				'field' => 'status',
				'label' => '状态',
				'rules' => 'required'
			),
			array(
				'field' => 'id',
				'label' => 'id',
				'rules' => 'required'
			)
		);
		
		$this->form_validation->set_rules($validation);
		
		if($this->form_validation->run() === FALSE){
			$id = $this->uri->segment(4);
			$where = "id = '" . $id . "'";
			$configData = $this->base_model->getDataRow('site_config', $where);
			
			$data['configData'] = $configData;
			$data['id'] = $id;
			$this->load->view('system/option/site_config_edit', $data);
		}else{
			$configUpdata = array(
				'var_name' => trim($this->input->post('var_name')),
				'title' => trim($this->input->post('title')),
				'category' => $this->input->post('category'),
				'value' => trim($this->input->post('value')),
				'status' => $this->input->post('status'),
				'type' => $this->input->post('type')
			);
			$id = $this->input->post('id');
			
			$where = "id = '" . $id . "'";
			
			$this->base_model->editData('site_config', $where, $configUpdata);
			
			util::showMessage('修改成功！', site_url('system/option/site_config'));
		}
	}
	
	//删除配置
	public function site_config_del(){
		$id = $this->uri->segment(4);
		$where = "id = '" . $id . "'";
		$this->base_model->delData('site_config', $where);
		util::showMessage('删除成功！');
	}
	
	
	//批量删除配置
	public function site_config_all_del(){
		$ids = $this->input->post('id');
		$ids = implode(',', $ids);
		$where = "id in(" . $ids . ")";
		$this->base_model->delData('site_config', $where);
		util::showMessage('删除成功！');
	}
	
	//基本配置
	public function base_config(){
		$data['page_title'] = '网站基本配置';
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$where = "category = 'base' and status = 0";
		$base_config_data = $this->base_model->getData('site_config', $where);
		$validation = array();
		
		//循环添加表单验证规则
		foreach($base_config_data as $val){
			if($val['var_name'] != 'logo_img'){
				$validation[] = array(
					'field' => $val['var_name'],
					'label' => $val['title'],
					'rules' => 'required'
				);
			}
		}
		
		//加入以前LOGO的验证
		$validation[] = array(
			'field' => 'old_img',
			'label' => 'old_img',
			'rules' => 'required'
		);
		
		$this->form_validation->set_rules($validation);
		
		if($this->form_validation->run() === FALSE){			
			$data['base_config_data'] = $base_config_data;
			$this->load->view('system/option/base_config', $data);
		}else{
			//循环获取表单值
			foreach($base_config_data as $val){
				$updata[$val['var_name']]['value'] = $this->input->post($val['var_name']);
			}
			
			$this->load->library('upload');
			
			//上传LOGO图片
			$config['file_name'] = 'logo.jpg';
			$field = 'logo_img';
			$img_data = $this->upload->upload_img($config, $field);

			//如果没有错误，返回图片地址，如果有错误，不设置LOGO图片
			if($img_data['is_Error'] === FALSE){
				$updata['logo_img']['value'] = ltrim($img_data['data']['upload_data']['img_path'], '.');
			}else{
				unset($updata['logo_img']);
			}
			
			$update_where = '';
			
			//循环添加配置至数据库
			foreach($updata as $key => $val){
				$update_where = "var_name = '" . $key . "'";
				$this->base_model->editData('site_config', $update_where, $val);
			}
			
			Util::showMessage('修改成功！');
		}
	}

	//邮件设置
	public function email_config(){
		$data['page_title'] = '邮件配置';
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$where = 'category = \'email\' and status = 0';
		$email_config_data = $this->base_model->getData('site_config', $where);
		
		$validation = array();
		
		//循环添加表单验证规则
		foreach($email_config_data as $val){
			$validation[] = array(
				'field' => $val['var_name'],
				'label' => $val['title'],
				'rules' => 'required'
			);
		}
		
		$this->form_validation->set_rules($validation);
		
		if($this->form_validation->run() === FALSE){
			$data['email_config_data'] = $email_config_data;
			$this->load->view('system/option/email_config', $data);
		}else{
			//循环获取表单值
			foreach($email_config_data as $val){
				$updata[$val['var_name']]['value'] = $this->input->post($val['var_name']);
			}
			
			//循环添加数据库
			foreach($updata as $key => $val){
				$update_where = "var_name = '" . $key . "'";
				$this->base_model->editData('site_config', $update_where, $val);
			}
			
			Util::showMessage('修改成功！');
		}
	}
}