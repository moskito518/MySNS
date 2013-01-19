<?php echo form_open('simple/login'); ?>
<p>
	<label for="user_name">
		用户名：
	</label>
	<input type="text" name="user_name" id="user_name" />
</p>
<p>
	<label for="password">
		密码：
	</label>
	<input type="password" name="password" id="password" />
</p>
<p>
	<input type="submit" value="登录" />
</p>
<?php echo form_close(); ?>