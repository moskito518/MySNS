<?php echo form_open('simple/reg'); ?>
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
	<label for="re_password">
		确认密码：
	</label>
	<input type="password" name="re_password" id="re_password" />
</p>
<p>
	<label for="email">
		邮箱：
	</label>
	<input type="text" name="email" id="email" />
</p>
<p>
	<input type="submit" value="注册" />
</p>
<?php echo form_close(); ?>