<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Right extends MY_Controller{
	
	public function __construct(){
		parent::__construct();
	}
	
	//输出权限列表
	public function index(){
		$data['page_title'] = '权限列表';
		$this->load->helper('form');
		
		$rightRow = $this->base_model->getData('right');
		$data['rightRow'] = $rightRow;
		$this->load->view('system/right/right_list', $data);
	}
	
	
	//添加权限
	public function add(){
		$data['page_title'] = '添加权限';
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$validation = array(
			array(
				'field' => 'name',
				'label' => '权限名称',
				'rules' => 'required'
			),
			array(
				'field' => 'right',
				'label' => '权限动作',
				'rules' => 'required'
			)
		);
		
		$this->form_validation->set_rules($validation);
		
		if($this->form_validation->run() === FALSE){
			$this->load->view('system/right/right_add', $data);
		}else{
			$rightData = array(
				'name' => trim($this->input->post('name')),
				'right' => trim($this->input->post('right'))
			);
			
			$this->base_model->addData('right', $rightData);
			util::showMessage('添加成功！', site_url('system/right'));
		}
	}
	
	//编辑权限
	public function edit(){
		$data['page_title'] = '编辑权限';
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$validation = array(
			array(
				'field' => 'name',
				'label' => '权限名称',
				'rules' => 'required'
			),
			array(
				'field' => 'right',
				'label' => '权限动作',
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
			$rightRow = $this->base_model->getDataRow('right', $where);
			
			$data['id'] = $id;
			$data['rightRow'] = $rightRow;
			
			$this->load->view('system/right/right_edit', $data);
		}else{
			$rightData = array(
				'name' => trim($this->input->post('name')),
				'right' => trim($this->input->post('right'))
			);
			
			$id = $this->input->post('id');
			$editWhere = "id = '" . $id . "'";
			$this->base_model->editData('right', $editWhere, $rightData);
			util::showMessage('修改成功！', site_url('system/right'));
		}
	}
	
	//删除权限
	public function delete(){
		$id = $this->uri->segment(4);
		
		$where = "id = '" . $id . "'";
		$rightRow = $this->base_model->getDataRow('right', $where);
		
		$role_where = "rights like '%" . $rightRow['right'] . "%'";
		$role_array = $this->base_model->getData('role', $role_where);
		
		//批量修改用户组权限
		foreach($role_array as $role_item){
			$role_item['rights'] = ',' . trim($role_item['rights']) . ',';
			$role_item['rights'] = trim(str_replace(','. $rightRow['right'], '', $role_item['rights']), ',');
			$role_item_where = "id = '" . $role_item['id'] . "'";
			$updata = array(
				'rights' => $role_item['rights']
			);
			$this->base_model->editData('role', $role_item_where, $updata);
		}
		
		$this->base_model->delData('right', $where);
		util::showMessage('删除成功');
	}
	
	//批量删除权限
	public function all_delete(){
		$ids = $this->input->post('id');
		$ids = implode(',', $ids);
		
		$where = "id in(" . $ids . ")";
		$rightData = $this->base_model->getData('right', $where);
		
		//批量修改用户组权限
		foreach($rightData as $rightItem){
			$role_where = "rights like '%" . $rightItem['right'] . "%'";
			$roleData = $this->base_model->getData('role', $role_where);
			
			foreach($roleData as $roleItem){
				$roleItem['rights'] = ',' . trim($roleItem['rights']) . ',';
				$roleItem['rights'] = trim(str_replace(','.$rightItem['right'], '', $roleItem['rights']), ',');
				$roleItemWhere = "id = '" . $roleItem['id'] . "'";
				$updata = array(
					'rights' => $roleItem['rights']
				);
				$this->base_model->editData('role', $roleItemWhere, $updata);
			}
		}
		
		$this->base_model->delData('right', $where);
		util::showMessage('删除成功！');
	}
}
