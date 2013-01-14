<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Upload extends CI_Upload{
	
	private $upload_dir = './uploads/images/';
	
	//加载默认上传路径
	public function __construct($upload_dir = ''){
		parent::__construct();
		if($upload_dir = ''){
			$upload_dir = $this->upload_dir;
		}
		
		$this->setDir($upload_dir);
		$this->create_folders($this->upload_dir);
		
	}
	
	//设置上传路径
	private function setDir($dir){
		$this->upoad_dir = $dir; 
	}
	
	//检查上传路径，不存在则创建
	public function create_folders($dir){
		return is_dir($dir) or ($this->create_folders(dirname($dir)) and mkdir($dir) and chmod($dir, 0777));
	}
	
	//上传图片
	public function upload_img($config = array(), $field = 'userfile'){
		$config['upload_path'] = $this->upload_dir;
		isset($config['allowed_types']) ? $config['allowed_types'] : $config['allowed_types'] = 'gif|jpg|png';	//默认格式
		isset($config['max_size']) ? $config['max_size'] : $config['max_size'] = '2048';		//默认大小2M

		//如果没有设置图片的名称，则随机生成图片名，否则覆盖同样名称的图片
		if(isset($config['file_name']) && !empty($config['file_name'])){
			$config['overwrite'] = TRUE;
		}else{
			$config['encrypt_name'] = TRUE; 
		}
		
		//加载上传图片的配置
		$this->initialize($config);
		
		$result = array();
		$is_Error = FALSE;
		
		//开始上传
		if(!$this->do_upload($field)){
			//有错误返回错误数据
			$result['error'] = $this->display_errors();
			$result['is_Error'] = TRUE;
		}else{
			//没有错误返回上传后的图片信息
			$data = array(
				'upload_data' => $this->data()
			);
			
			//重新返回图片地址，将上传地址添加到图片路径
			$data['upload_data']['img_path'] = $this->upload_dir . $data['upload_data']['file_name'];
			
			//生成缩略图设置
			$img_dis_config['source_image'] = $data['upload_data']['img_path'];
			$img_w_h = array(
				array(
					'width' => '100',
					'height' => '100'
				),
				array(
					'width' => '175',
					'height' => '175'
				)
			);
			//上传完成后增加图片处理，生成不同规格的图片
			$this->img_dis($img_dis_config, $img_w_h);
			
			//返回数据
			$result['data'] = $data;
			$result['is_Error'] = FALSE;
		}
		
		
		return $result;
	}
	
	
	//图像处理--生成缩略图和图片大小
	public function img_dis($config = array(), $img_w_h = array()){
		$this->_CI = & get_instance(); 
		$this->_CI->load->library('image_lib');
		$config['image_library'] = 'gd2';
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;

		if(count($img_w_h) > 1){
			for($i = 0; $i < count($img_w_h); $i++){
				
				$config['width'] = $img_w_h[$i]['width'];
				$config['height'] = $img_w_h[$i]['height'];
				$config['thumb_marker'] = '_' . $config['width'] . 'x' . $config['height'];
				
				$this->_CI->image_lib->initialize($config);
				$this->_CI->image_lib->resize();
			}
		}
	}
	
}