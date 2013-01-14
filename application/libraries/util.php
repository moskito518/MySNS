<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Util{
	//弹出错误提示
	static function showMessage($message, $redirect_url = ''){
		
		if(empty($redirect_url)){
			
			$redirect_url = $_SERVER['HTTP_REFERER'];
			
		}else{
			
			if(strpos($redirect_url, 'http') === false){
				
				$redirect_url = site_url($redirect_url);
				
			}
			
		}
		
		echo '<script>alert(\'' . $message . '\');window.location.href = \'' . $redirect_url . '\';</script>';
		
		exit;
	}
	
	//弹出确认提示
	static function showConfirm($message, $redirect_url = ''){
		
		if(empty($redirect_url)){
			
			$redirect_url = $_SERVER['HTTP_REFERER'];
			
		}else{
			
			if(strpos($redirect_url, 'http') === false){
				
				$redirect_url = site_url($redirect_url);
				
			}
			
		}
		
		echo '<script>if(confirm("' . $message . '"))'.
				'{window.location.href = \'' . $redirect_url .
				'\'}else{window.location.href = \'' . $redirect_url .
				'\'}</script>';
		
		exit;
	}
}