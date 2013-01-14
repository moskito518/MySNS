<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu{
	private $_CI;
	
	private static $commonMenu = array('admin');
	
	public function __construct(){
		$this->_CI = & get_instance(); 
		
		$this->filter_menu();
		$this->selected();
	}
	
	public static $menu = array(
		'系统' => array(
			'后台首页' => 'admin',
			'用户列表' => 'user',
			'权限列表' => 'right',
			'角色列表' => 'role',
			'站点设置' => 'admin/site_config',
			'基本设置' => 'admin/base_config',
			'邮件设置' => 'admin/email_config'
		),
		'文章' => array(
			'文章列表' => 'article',
			'文章分类列表' => 'article_category',
			'添加文章' => 'article/create'
		)
	);
	
	public static $cur_menu_arr = array(
		'cur_top_menu' => '系统',
		'cur_sub_menu' => 'admin'
	);
	
	//当前父级菜单选择
	private function selected(){	
		$cur_uri = $this->_CI->uri->segment(2);
		
		foreach(self::$menu as $firstKey => $firstVal){
			if(is_array($firstVal)){
				foreach($firstVal as $secondKey => $secondVal){
					if($cur_uri == $secondVal){
						self::$cur_menu_arr['cur_top_menu'] = $firstKey;
						self::$cur_menu_arr['cur_sub_menu'] = $secondVal;
					}
				}
			}
		}
	}
	
	//菜单过滤
	private function filter_menu(){
		$admin_right = $this->_CI->session->userdata['admin_right'];
		
		if($admin_right != 'administrator'){
			foreach(self::$menu as $firstKey => $firstVal){
				if(is_array($firstVal)){
					foreach($firstVal as $secondKey => $secondVal){
						if(!in_array($secondVal,self::$commonMenu)){
							$secondVal = stripos($secondVal, '/') ? $secondVal : $secondVal . '/index';
							
							if(stripos(str_replace('@', '/', $admin_right), $secondVal) === false){
								unset(self::$menu[$firstKey][$secondKey]);
							}
						}
					}
					if(empty(self::$menu[$firstKey])){
						unset(self::$menu[$firstKey]);
					}
				}
			}
		}
	}
}
