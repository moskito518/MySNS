<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title></title>
	<script type="text/javascript" src="<?php echo base_url(); ?>skin/js/jquery.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>skin/js/editor/themes/default/default.css" />
</head>
<body>
	<div class="menu_container">
		<ul id="menu_list">
			<li>
				<a href="<?php echo site_url('ucenter/index'); ?>">用户中心首页</a>
			</li>
			<li>
				<a href="<?php echo site_url('ucenter/diary'); ?>">日志</a>
			</li>
		</ul>
	</div>
	<p>
		用户名：<?php echo $this->user['user_name']; ?>
	</p>
	