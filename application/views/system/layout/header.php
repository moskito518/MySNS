<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo $this->site_config['site_name']; ?> - 后台管理 - <?php echo !empty($page_title) ? $page_title: '' ?></title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<!-- stylesheets -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>skin/css/reset.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>skin/css/style.css" media="screen" />
		<link id="color" rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>skin/css/colors/blue.css" />
		<!-- scripts (jquery) -->
		<script type="text/javascript" src="<?php echo base_url(); ?>skin/js/jquery.js"></script>
		<script src="<?php echo base_url(); ?>skin/js/jquery-ui-1.8.custom.min.js" type="text/javascript"></script>
      	<script src="<?php echo base_url(); ?>skin/js/smooth.js" type="text/javascript"></script>
      	<script src="<?php echo base_url(); ?>skin/js/jquery.ui.selectmenu.js" type="text/javascript"></script>
      	<script src="<?php echo base_url(); ?>skin/js/smooth.form.js" type="text/javascript"></script>
      	<script src="<?php echo base_url(); ?>skin/js/admin.js" type="text/javascript"></script>
      	<script type="text/javascript" src="<?php echo base_url(); ?>skin/js/smooth.table.js"></script>
		<script type="text/javascript">
			$(document).ready(function () {
				style_path = "<?php echo base_url();?>skin/css/colors";

				$("#date-picker").datepicker();

				$("#box-tabs, #box-left-tabs").tabs();
			});
		</script>
	</head>
	<body>
		<div id="colors-switcher" class="color">
			<a href="" class="blue" title="Blue"></a>
			<a href="" class="green" title="Green"></a>
			<a href="" class="brown" title="Brown"></a>
			<a href="" class="purple" title="Purple"></a>
			<a href="" class="red" title="Red"></a>
			<a href="" class="greyblue" title="GreyBlue"></a>
		</div>
		<!-- header -->
		<div id="header">
			<!-- logo -->
			<div id="logo">
				<h1><a href="" title="Smooth Admin"><img src="<?php echo base_url(); ?>skin/images/logo.png" alt="Smooth Admin" /></a></h1>
			</div>
			<!-- end logo -->
			
			<div id="header-inner">
				<div id="home">
					<a href="" title="Home"></a>
				</div>
				<!-- user -->
            <ul id="user">
               <li class="first highlight">您好！欢迎您,<?php echo $this->admin['admin_name']; ?></li>
               <li><a href="<?php echo site_url('system/logout')?>">退出登录</a></li>
               <li class="highlight last"><a href="">网站首页</a></li>
            </ul>
            <!-- end user -->
				<div class="corner tl"></div>
				<div class="corner tr"></div>
			</div>
		</div>
		<!-- end header -->
		<!-- content -->
		<div id="content">
			<!-- end content / left -->
			<div id="left">
				<div id="menu">
				<?php foreach(menu::$menu as $firstKey => $firstVal): ?>
					<?php $firstUrl = array_values($firstVal);?>
					<h6 id="h-menu-products"<?php if($firstKey == menu::$cur_menu_arr['cur_top_menu']): ?> class="selected" <?php endif;?>>
						<a href="<?php echo site_url('system/'.$firstUrl[0]); ?>"><span><?php echo $firstKey; ?></span></a>
					</h6>
					<ul id="menu-products" <?php if($firstKey == menu::$cur_menu_arr['cur_top_menu']): ?> class="openned" <?php else: ?>class="closed"<?php endif;?>>
					<?php foreach($firstVal as $secondKey => $secondVal): ?>
						<li>
							<a href="<?php echo site_url('system/'.$secondVal); ?>"><?php echo $secondKey; ?></a>
						</li>
					<?php endforeach;?>
					</ul>
				<?php endforeach;?>
				</div>
				<div id="date-picker"></div>
			</div>
			<!-- end content / left -->
			<!-- content / right -->
			<div id="right">