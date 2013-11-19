<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article_category extends MY_Controller{
	public function __construct(){
		parent::__construct();
		$this->checkAdminRights();
		$this->load->library('menu');
	}
	
	//文章分类列表
	public function index(){
		$data['page_title'] = '文章分类列表';
		$where = '';
		$fields = '';
		$order = 'order ASC';
		$data['article_category'] = $this->base_model->getData('article_category', $where, $fields, $order);
		
		if(!file_exists("application/views/system/article/category.php")){
			show_404();
		}else{
			$this->load->view('system/article/article_category_list', $data);
		}
	}
	
	//文章分类添加
	public function create(){
		$data['page_title'] = '添加文章分类';
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$validation = array(
			array('field' => 'title', 'label' => '分类名称', 'rules' => 'required|max_length[24]'),
			array('field' => 'order', 'label' => '分类排序', 'rules' => 'required'),
			array('field' => 'description', 'label' => '分类描述', 'rules' => 'required')
		);
		
		$this->form_validation->set_rules($validation);
		$this->form_validation->set_rules('parent');
		
		if($this->form_validation->run() === FALSE){
			$data['category_list'] = $this->base_model->getData('article_category', '', '', 'order ASC');;
			$this->load->view('system/article/article_category_add', $data);
		}else{
			$Acategory = array(
				'title' => trim($this->input->post('title')),
				'order' => trim($this->input->post('order')),
				'description' => $this->input->post('description'),
				'parent' => $this->input->post('parent')
			);
			
			$maxid = $this->base_model->getDataRow('article_category', '', 'max(id) as max_id');
			$localId = $maxid['max_id'] ? $maxid['max_id'] + 1 : 1;
			
			
			if($Acategory['parent'] != 0){
				$where = "id = '" . $Acategory['parent'] . "'";
				$parentRow = $this->base_model->getDataRow('article_category', $where);
				$Acategory['path'] = $parentRow['path'] . $localId . ",";
			}else{
				$Acategory['path'] = ',' . $localId . ',';
			}
			
			$this->base_model->addData('article_category', $Acategory);
			redirect('/success');
		}
	}
	
	//编辑文章分类
	public function edit(){
		$data['page_title'] = '编辑文章分类';
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$validation = array(
			array('field' => 'id', 'label' => 'id', 'rules' => 'required'),
			array('field' => 'title','label' => '分类名称',	'rules' => 'required|max_length[24]'),
			array('field' => 'order','label' => '分类排序','rules' => 'required'),
			array('field' => 'description','label' => '分类简介','rules' => 'required')
		);
		
		$this->form_validation->set_rules($validation);
		$this->form_validation->set_rules('parent');
		
		if($this->form_validation->run() === FALSE){
			$data['id'] = $this->uri->segment(4);
			if($data['id']){
				$where = "id = '" . $data['id'] . "'";
			}else{
				$id = $this->input->post('id');
				$where = "id = '" . $id . "'";
			}
			
			$AcategoryRow = $this->base_model->getDataRow('article_category', $where);
			$category_list = $this->base_model->getData('article_category', '', '', 'order ASC');
			foreach($category_list as $key => $categoryItem){
				if (strpos($categoryItem['path'], $AcategoryRow['path']) !== false){
						unset($category_list[$key]);
				}
			}
			
			$data['AcategoryRow'] = $AcategoryRow;
			$data['category_list'] = $category_list;
			$this->load->view('system/article/article_category_edit', $data);
		}else{
			$AcategoryData = array(
				'title' => trim($this->input->post('title')),
				'order' => trim($this->input->post('order')),
				'description' => $this->input->post('description'),
				'parent' => $this->input->post('parent')
			);
			
			$id = $this->input->post('id');
			
			$old_where = "id = '" . $id . "'";
			$old_data = $this->base_model->getDataRow('article_category', $old_where);
			
			//判断是否需要移动
			if($AcategoryData['parent'] == $old_data['parent']){
				$isMove = false;
				$AcategoryData['path'] = $old_data['path'];
			}else{
				$isMove = true;
			}
			
			if(!isset($AcategoryData['path'])){
				//设置path的值
				if($AcategoryData['parent'] == 0){
					$AcategoryData['path'] = ',' . $id . ',';
				}else{
					$where = "id = '" . $AcategoryData['parent'] . "'";
					$parentRow = $this->base_model->getDataRow('article_category', $where);
					$AcategoryData['path'] = $parentRow['path'] . $id . ',';
				}
			}
			
			//编辑
			if($isMove == true){
				if(isset($parentRow) && $parentRow['path'] != null && strpos($parentRow['path'], ','.$id.',') !== false){
					//不能将节点移动到子节点上
					Util::showMessage('不能将节点移动到子节点上');
				}else{
					//子节点批量移动
					$old_path = $old_data['path'];
					$new_path = $AcategoryData['path'];
					$where = 'path like "'.$old_path.'%"';
					$updata = array(
						'path' => "replace(path,'".$old_path."','".$new_path."')",
					);
					$this->base_model->editData('article_category', $where, $updata, false);
				}
			}
			
			$where = "id = '" . $id . "'";
			$this->base_model->editData('article_category', $where, $AcategoryData);
			redirect('/success');
		}
	}
	
	//删除分类
	public function delete(){
		$id = $this->uri->segment(4);
		$cat_where = "id = '" .$id . "'";
		$catRow = $this->base_model->getDataRow('article_category', $cat_where);
		
		$parent_where = "path like '" . $catRow['path'] . "%'";
		$parentRow = $this->base_model->getData('article_category', $parent_where);
		
		$article_where = "category = '" . $id . "'";
		$articleRow = $this->base_model->getData('article', $article_where);
		
		if(!empty($parentRow) && count($parentRow) != 1){
			util::showMessage('此分类下还有子分类！请移动子分类后再删除！');
		}else if(!empty($articleRow)){
			util::showMessage('此分类下还有文章！请删除文章后再删除分类！');
		}else{
			$this->base_model->delData('article_category', $cat_where);
			Util::showMessage('删除成功！');
		}
	}
}
