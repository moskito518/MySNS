<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends MY_Controller{
	public function __construct(){
		parent::__construct();
		$this->checkAdminRights();
		$this->load->library('menu');
	}
	
	//用户列表
	public function index(){
		$data['page_title'] = '用户列表';
		
		$this->load->library('pagination');
		$this->load->helper('form');

		$userCount = $this->base_model->getCount('admin');
		$config['base_url'] = site_url('system/admin/index');
		$config['total_rows'] = $userCount;
		$config['per_page'] = 20; 
		$config['use_page_numbers'] = TRUE;
		$config['uri_segment'] = 4;
	 	$this->pagination->initialize($config); 
	 	
		$where = '';
		$limit = $config['per_page'];
		$page = ($this->uri->segment(4) > 1) ? ($this->uri->segment(4) - 1) : 0;
		$offset = $page * $config['per_page'];
		$userRow = $this->base_model->getData('admin', $where, '', 'id desc', $limit, $offset);
		$roleData = $this->base_model->getData('admin_role');
		
		foreach($userRow as $userKey => $userVal){
			foreach($roleData as $roleItem){
				if($userVal['role'] == $roleItem['id']){
					$userRow[$userKey]['role_name'] = $roleItem['name'];
				}
			}
		}
		
		$total_page = round($config['total_rows'] / $config['per_page']);
		$data['total_page'] = $total_page == 0 ? 1 : $total_page;
		$data['cur_page'] = $this->uri->segment(4) ? $this->uri->segment(4) : 1;
		$data['userRow'] = $userRow;
		
		
		$this->load->view('system/admin/admin_list', $data);
	}
	
	//用户添加
	public function add(){
		$data['page_title'] = '添加用户';
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->helper('date');
		
		$validation = array(
			array('field' => 'name', 'label' => '用户名', 'rules' => 'required|max_length[24]|min_length[4]'),
			array('field' => 'role', 'label' => '用户组', 'rules' => 'required|is_natural_no_zero'),
			array('field' => 'password', 'label' => '密码', 'rules' => 'required|max_length[32]|min_length[6]'),
			array('field' => 'repassword', 'label' => '确认密码', 'rules' => 'required|max_length[32]|min_length[6]|matches[password]'),
			array('field' => 'email', 'label' => '邮箱', 'rules' => 'required|valid_email')
		);
		
		$this->form_validation->set_rules($validation);
		
		if($this->form_validation->run() === FALSE){
			$roleData = $this->base_model->getData('admin_role');
			
			$data['roleData'] = $roleData;
			$this->load->view('system/admin/admin_add', $data);
		}else{
			$userData = array(
				'name' => trim($this->input->post('name')),
				'password' => md5(trim($this->input->post('password'))),
				'email' => trim($this->input->post('email')),
				'create_time' => unix_to_human(now(), TRUE, 'zh'),
				'role' => $this->input->post('role')
			);
			
			$error_message = '';
			$email_where = "email = '" . $userData['email'] . "'";
			$checkEmail = $this->base_model->getData('admin', $email_where);
			if(count($checkEmail)){
				$error_message .= '邮箱：' . $userData['email'] .'已占用\n';
			}
			
			$name_where = "name = '" . $userData['name'] . "'";
			$checkName = $this->base_model->getdata('admin', $name_where);
			if(count($checkName)){
				$error_message .= '用户名：' . $userData['name'] .'已占用\n';
			}
			
			if(!empty($error_message)){
				util::showMessage($error_message);
			}
			
			$this->base_model->addData('admin', $userData);
			util::showMessage('添加成功!', site_url('system/admin'));
		}
	}
	
	
	//用户编辑
	public function edit(){
		$data['page_title'] = '编辑用户';
		
		$this->load->helper('form');
		$this->load->library('form_validation');
				
		$validation = array(
			array('field' => 'id', 'label' => 'id',	 'rules' => 'required'),
			array('field' => 'role', 'label' => '用户组', 'rules' => 'required|is_natural_no_zero'),
			array('field' => 'name', 'label' => '用户名', 'rules' => 'required'),
			array('field' => 'password', 'label' => '密码', 'rules' => 'required|max_length[32]|min_length[6]'),
			array('field' => 'repassword', 'label' => '确认密码', 'rules' => 'required|max_length[32]|min_length[6]|matches[password]'),
			array('field' => 'email', 'label' => '邮箱', 'rules' => 'required|valid_email')
		);
		
		$this->form_validation->set_rules($validation);
		
		if($this->form_validation->run() === FALSE){
			$id = $this->uri->segment(4);
			$where = "id = '" . $id . "'";
			$userRow = $this->base_model->getDataRow('admin', $where);
			$roleData = $this->base_model->getData('admin_role');
			
			$data['userRow'] = $userRow;
			$data['roleData'] = $roleData;
			$data['id'] = $id;
			$this->load->view('system/admin/admin_edit.php', $data);
		}else{
			$id = $this->input->post('id');
			
			$userData = array(
				'password' => md5(trim($this->input->post('password'))),
				'role' => $this->input->post('role')
			);
			$oldpassword = md5(trim($this->input->post('oldpassword')));
			$checkWhere = "id = '" . $id . "'";
			$checkUser = $this->base_model->getDataRow('admin', $checkWhere);
			
			if($checkUser['password'] == $oldpassword){
				$this->base_model->editData('admin', $checkWhere, $userData);
				util::showMessage('用户修改成功!', site_url('system/admin'));
			}else{
				util::showMessage('用户密码与原始密码不符，请重新输入', site_url('system/admin/admin_edit/' . $id));
			}
		}
	}
	
	//用户删除
	public function delete(){
		$id = $this->uri->segment(4);
		$where = "id = '" . $id . "'";
		$userRow = $this->base_model->getDataRow('admin', $where);
		
		$article_where = "author = '" . $id . "'";
		$articleRow = $this->base_model->getData('article', $article_where);
		
		if($id == $this->session->userdata['admin_id']){
			util::showMessage('你不能删除自己！');
			exit;
		}
		
		if($userRow['name'] == 'admin' && $userRow['role'] == 0){
			util::showMessage('不能删除超级管理员！');
		}else if(count($articleRow) > 0){
			util::showMessage('此用户下还有文章，请删除文章后再删除用户!');
		}else{
			$this->base_model->delData('admin', $where);
			util::showMessage('删除成功');
		}
	}
	
	//批量删除
	public function all_delete(){
		$ids = $this->input->post('id');
		$ids = implode(',' , $ids);
		$where = "id in(" . $ids . ")";
		$userRow = $this->base_model->getData('admin', $where);
		
		$article_where = "author in(" . $ids . ")";
		$articleRow = $this->base_model->getData('article', $article_where);
		
		if(stripos($ids, $this->session->userdata['uid']) !== FALSE){
			util::showMessage('你不能删除自己！');
			exit;
		}
		
		foreach($userRow as $userItem){
			if($userItem['name'] == 'admin' && $userItem['role'] == 0){
				util::showMessage('不能删除超级管理员！');
				exit;
			}
		}
		
		if(count($articleRow) > 0){
			util::showMessage('此用户下还有文章，请删除文章后再删除用户!');
			exit;
		}else{
			$this->base_model->delData('admin', $where);
			util::showMessage('删除成功！');
		}
		
	}
}
