<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends MY_Controller{
	
	public function __construct(){
		parent::__construct();
	}
	
	//文章列表首页
	public function index(){
		$data['page_title'] = '文章列表';
		
		if(!file_exists("application/views/system/article/article_list.php")){
			show_404();
		}else{
			$this->load->library('pagination');
			$this->load->helper('form');

			$articleCount = $this->base_model->getCount('article');
			$config['base_url'] = site_url('system/article/index');
			$config['total_rows'] = $articleCount;
			$config['per_page'] = 20; 
			$config['use_page_numbers'] = TRUE;
			$config['uri_segment'] = 4;
		 	$this->pagination->initialize($config); 
		 	$where = '';
			$limit = $config['per_page'];
			$page = ($this->uri->segment(4) > 1) ? ($this->uri->segment(4) - 1) : 0;
			$offset = $page * $config['per_page'];
			$articleRow = $this->base_model->getData('article', $where, '', 'id desc', $limit, $offset);
			$catData = $this->base_model->getData('article_category');
			
			foreach($articleRow as $articleKey => $articleVal){
				foreach($catData as $catItem){
					if($articleVal['category'] == $catItem['id']){
						$articleRow[$articleKey]['cat_name'] = $catItem['title']; 
					}
				}
			}
			
			$authorData = $this->base_model->getData('user');
			
			foreach($articleRow as $articleKey => $articleVal){
				foreach($authorData as $authorItem){
					if($articleVal['author'] == $authorItem['id']){
						$articleRow[$articleKey]['author'] = $authorItem['name'];
					}
				}
			}
			
			$data['articles'] = $articleRow;
			$data['total_page'] = round($config['total_rows'] / $config['per_page']);
			$data['cur_page'] = $this->uri->segment(4) ? $this->uri->segment(4) : 1;
		 	
			$this->load->view('system/article/article_list', $data);
		}
	}
	
	//添加文章
	public function create(){
		$data['page_title'] = '添加文章';
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->helper('date');
		
		$validation = array(
			array(
				'field' => 'title',
				'label' => '文章名称',
				'rules' => 'required|max_length[24]|min_length[4]'
			),
			array(
				'field' => 'content',
				'label' => '文章内容',
				'rules' => 'required'
			),
		);
		
		$this->form_validation->set_rules($validation);
		$this->form_validation->set_rules('category');
		
		if($this->form_validation->run() === FALSE){
			$data['category'] = $this->base_model->getData('article_category', '', '', 'order ASC');
			$this->load->view('system/article/article_add', $data);
		}else{
			$Article_data = array(
				'title' => trim($this->input->post('title')),
				'content' => $this->input->post('content'),
				'category' => $this->input->post('category'),
				'create_time' => unix_to_human(now(), TRUE, 'zh'),
				'author' => $this->session->userdata['uid']
			);
			
			$this->base_model->addData('article', $Article_data);
			
			Util::showMessage('添加成功', site_url('system/article'));
		}
	}
	
	//编辑文章
	public function edit(){
		$data['page_title'] = '编辑文章';
		
		$this->load->helper('form');
		$this->load->library('form_validation');
	
		$validation = array(
			array(
				'field' => 'id',
				'label' => 'id',
				'rules' => 'required'
			),
			array(
				'field' => 'title',
				'label' => '文章名称',
				'rules' => 'required|max_length[24]|min_length[4]'
			),
			array(
				'field' => 'content',
				'label' => '文章内容',
				'rules' => 'required'
			)
		);
		
		$this->form_validation->set_rules($validation);
		$this->form_validation->set_rules('category');
		
		if($this->form_validation->run() === FALSE){
			$data['id'] = $this->uri->segment(4);
			$where = "id = '" . $data['id'] . "'";
			$data['articleRow'] = $this->base_model->getDataRow('article', $where);
			$data['category'] = $this->base_model->getData('article_category', '', '', 'order ASC');
			$this->load->view('system/article/article_edit', $data);
		}else{
			$Article_data = array(
				'title' => trim($this->input->post('title')),
				'content' => $this->input->post('content'),
				'category' => $this->input->post('category')
			);
			$id = $this->input->post('id');
			$where = "id = '" . $id . "'";
			$this->base_model->editData('article', $where, $Article_data);
			util::showMessage('编辑成功！', site_url('system/article'));
		}
	}
	
	//删除文章
	public function delete(){
		$id = $this->uri->segment(4);
		$where = "id = '" . $id . " '";
		$this->base_model->delData('article', $where);
		util::showMessage('删除成功！', site_url('system/article'));
	}
	
	//批量删除
	public function all_delete(){
		$ids = $this->input->post('id');
		$ids = implode(',', $ids);
		$where = "id in(" . $ids . ")";
		$this->base_model->delData('article', $where);
		util::showMessage('删除成功！');
	}
}