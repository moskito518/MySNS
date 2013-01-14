<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends MY_Controller{
	
	public function __construct(){
		parent::__construct();
	}
	
	//角色列表
	public function index(){
		$data['page_title'] = '角色列表';
		
		$this->load->library('pagination');
		$this->load->helper('form');
		
		$roleCount = $this->base_model->getCount('role');
		$config['base_url'] = site_url('system/role/index');
		$config['total_rows'] = $roleCount;
		$config['per_page'] = 20;
		$config['use_page_numbers'] = TRUE;
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		
		$where = '';
		$limit = $config['per_page'];
		$page = ($this->uri->segment(4) > 1) ? ($this->uri->segment(4) - 1) : 0;
		$offset = $page * $config['per_page'];
		
		$roleRow = $this->base_model->getData('role', $where, '', 'id desc', $limit, $offset);
		
		$data['total_page'] = round($config['total_rows'] / $config['per_page']);
		$data['cur_page'] = $this->uri->segment(4) ? $this->uri->segment(4) : 1;
		$data['roleRow'] = $roleRow;
		
		$this->load->view('system/role/role_list', $data);
	}
	
	//角色添加
	public function create(){
		$data['page_title'] = '创建角色';
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$validation = array(
			array(
				'field' => 'name',
				'label' => '名称',
				'rules' => 'required'
			),
			array(
				'field' => 'right[]',
				'label' => '权限',
				'rules' => 'required'
			),
		);
		
		$this->form_validation->set_rules($validation);
		
		if($this->form_validation->run() === FALSE){
			$rightRow = $this->base_model->getData('right');
			$data['rightRow'] = $rightRow;
			$this->load->view('system/role/role_add', $data);
		}else{
			$roleData = array(
				'name' => trim($this->input->post('name')),
			);
			
			$rightsIdArray = $this->input->post('right');
			$where = "id in(" . join(',', $rightsIdArray) . ")";
			$rightsRow = $this->base_model->getData('right', $where);
			$rightsArray = array();
			foreach($rightsRow as $key => $val){
				$rightsArray[] = trim($val['right'], ',');
			}
			
			$roleData['rights'] = join(',', $rightsArray);
			$this->base_model->addData('role', $roleData);
			util::showMessage('添加成功!', site_url('system/role'));
		}
	}
	
	//角色编辑
	public function edit(){
		$data['page_title'] = '编辑角色';
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$validation = array(
			array(
				'field' => 'name',
				'label' => '角色名称',
				'rules' => 'required'
			),
			array(
				'field' => 'right[]',
				'label' => '权限',
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
			$roleRow = $this->base_model->getDataRow('role', $where);
			
			$rightRow = $this->base_model->getData('right');
			if(count($roleRow) > 0 && count($rightRow) > 0){
				foreach($rightRow as $key => $val){
					if(strpos($roleRow['rights'], $val['right']) !== FALSE){
						$rightRow[$key]['is_check'] = true;
					}
				}
			}
			$data['id'] = $id;
			$data['roleRow'] = $roleRow;
			$data['rightRow'] = $rightRow;
			
			$this->load->view('system/role/role_edit', $data);
		}else{
			$updata = array(
				'name' => trim($this->input->post('name')),
			);
			
			$rightsIdArray = $this->input->post('right');
			$where = "id in (" . join(',', $rightsIdArray) . ")";
			$rightsRow = $this->base_model->getData('right', $where);
			
			$rightsData = array();
			
			foreach($rightsRow as $key => $val){
				$rightsData[] = trim($val['right'], ',');
			}
			
			$updata['rights'] = join(',', $rightsData);
			
			$id = $this->input->post('id');
			$editWhere = "id = '" . $id . "'";
			$this->base_model->editData('role', $editWhere, $updata);
			util::showMessage('修改成功', site_url('system/role'));
		}
	}
	
	//角色删除
	public function delete(){
		$id = $this->uri->segment(4);
		
		$checkUserWhere = "role = '" . $id . "'";
		$checkUserData = $this->base_model->getData('user', $checkUserWhere);
		
		if(count($checkUserData) > 0){
			util::showMessage('角色下还有用户，请删除用户后再删除角色!');
			exit;
		}else{
			$delWhere = "id = '" . $id . "'";
			$this->base_model->delData('role', $delWhere);
			util::showMessage('删除成功');
		}
	}
	
	//批量角色删除
	public function all_delete(){
		$ids = $this->input->post('id');
		$ids = implode(',', $ids);
		
		$checkUserWhere = "role in(" . $ids . ")";
		$checkUserData = $this->base_model->getData('user', $checkUserWhere);
		
		if(count($checkUserData) > 0){
			util::showMessage('角色下还有用户，请删除用户后再删除角色!');
			exit;
		}else{
			$delWhere = "id in(" . $ids . ")";
			$this->base_model->delData('role', $delWhere);
			util::showMessage('删除成功');
		}
	}
}
