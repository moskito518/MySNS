<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>后台登录</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<!-- stylesheets -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>skin/css/reset.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>skin/css/style.css" media="screen" />
		<link id="color" rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>skin/css/colors/blue.css" />
		<!-- scripts (jquery) -->
		<script type="text/javascript" src="<?php echo base_url(); ?>skin/js/jquery.js"></script>
		<script src="<?php echo base_url(); ?>skin/js/jquery-ui-1.8.custom.min.js" type="text/javascript"></script>
      	<script src="<?php echo base_url(); ?>skin/js/smooth.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function () {
				style_path = "<?php echo base_url();?>skin/css/colors";

				$("input.focus").focus(function () {
					if (this.value == this.defaultValue) {
						this.value = "";
					}
					else {
						this.select();
					}
				});

				$("input.focus").blur(function () {
					if ($.trim(this.value) == "") {
						this.value = (this.defaultValue ? this.defaultValue : "");
					}
				});

				$("input:submit, input:reset").button();
			});
		</script>
	</head>
	<body>
		<div id="login">
			<!-- login -->
			<div class="title">
				<h5>管理员登录</h5>
				<div class="corner tl"></div>
				<div class="corner tr"></div>
			</div>
			<?php if(form_error('name') || form_error('password')):?>
			<div class="messages">
				<div id="message-error" class="message message-error">
					<div class="image">
						<img src="<?php echo base_url(); ?>skin/images/icons/error.png" alt="Error" height="32" />
					</div>
					<div class="text">
						<h6>错误信息:</h6>
						<span><?php echo form_error('name');?></span>
						<span><?php echo form_error('password');?></span>
					</div>
					<div class="dismiss">
						<a href="#message-error"></a>
					</div>
				</div>
			</div>
			<?php endif;?>
			<div class="inner">
				<?php echo form_open('systemadmin/login'); ?>
				<div class="form">
					<!-- fields -->
					<div class="fields">
						<div class="field">
							<div class="label">
								<label for="name">用户名:</label>
							</div>
							<div class="input">
								<input type="text" id="name" name="name" size="40" class="focus" value="<?php echo set_value();?>"/>
							</div>
						</div>
						<div class="field">
							<div class="label">
								<label for="password">密码:</label>
							</div>
							<div class="input">
								<input type="password" id="password" name="password" size="40" class="focus" />
							</div>
						</div>
						<div class="buttons">
							<input type="submit" value="登录" />
						</div>
					</div>
					<!-- end fields -->
				</div>
				<?php echo form_close(); ?>
			</div>
			<!-- end login -->
			<div id="colors-switcher" class="color">
				<a href="" class="blue" title="Blue"></a>
				<a href="" class="green" title="Green"></a>
				<a href="" class="brown" title="Brown"></a>
				<a href="" class="purple" title="Purple"></a>
				<a href="" class="red" title="Red"></a>
				<a href="" class="greyblue" title="GreyBlue"></a>
			</div>
		</div>
	</body>
</html>