<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Block extends MY_Controller{
	
	public function __construct(){
		parent::__construct();
	}
	
	private function alert($msg)
	{
		header('Content-type: text/html; charset=UTF-8');
		echo json_encode(array('error' => 1, 'message' => $msg));
		exit;
	}
	
	//用户在后台编辑器里上传图片
	public function upload_img_from_editor(){
		$this->load->library('upload');
		$field = 'imgFile';
		$config['max_size'] = '3072';
		
		$img_data = $this->upload->upload_img($config, $field);
		
		if($img_data['is_Error'] == False){
			$file_path = base_url() . ltrim($img_data['data']['upload_data']['img_path'], '.');
			echo json_encode(array('error' => 0, 'url' => $file_path));
			exit;
		}else{
			$this->alert($img_data['error']);
		}
	}
}
