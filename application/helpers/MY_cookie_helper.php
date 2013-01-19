<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function set_cookie($name = '', $value = '', $expire = '3600', $domain = '', $path = '/', $prefix = '', $secure = FALSE){
		// Set the config file options
		$CI =& get_instance();
		$CI->input->set_cookie($name, $value, $expire, $domain, $path, $prefix, $secure);
}