<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	//添加数据
	public function addData($dbname, $data, $filter = true){
		if($data){
			$this->db->set($data, NULL, $filter);
			$this->db->insert($dbname);
		}else{
			return false;
		}
	}
	
	//编辑数据
	public function editData($dbname, $where, $data, $filter = true){
		if(!empty($where)){
			$this->db->where($where);
		}
		
		$this->db->set($data, NULL, $filter);
		$this->db->update($dbname);
	}
	//获取多条数据
	public function getData($dbname, $where = '', $fields = '', $order = '', $limit = '', $offset = ''){
		$this->db->from($dbname);
		if(!empty($fields)){
			$this->db->select($fields);
		}
		if(!empty($where)){
			$this->db->where($where);
		}
		if(!empty($order)){
			$this->db->order_by($order);
		}
		if(!empty($limit)){
			if(!empty($offset)){
				$this->db->limit($limit, $offset);
			}else{
				$this->db->limit($limit);
			}
		}
		
		return $this->db->get()->result_array();
	}
	
	//获取单条数据
	public function getDataRow($dbname, $where = '', $fields = ''){
		$this->db->from($dbname);
		if(!empty($fields)){
			$this->db->select($fields);
		}
		if(!empty($where)){
			$this->db->where($where);
		}
		
		return $this->db->get()->row_array();
	}
	
	//删除数据
	public function delData($dbname, $where = ''){
		if(!empty($where)){
			$this->db->where($where);
			$this->db->delete($dbname);
		}else{
			return false;
		}
	}
	
	//获取数据库条数
	public function getCount($dbname, $where=''){
		$this->db->from($dbname);
		if(!empty($where)){
			$this->db->$where($where);
		}
		
		return $this->db->count_all_results();
	}
}