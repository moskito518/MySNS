<?php $this->load->view('system/layout/header')?>

<div class="box">
   <div class="title">
      <h5><?php echo $page_title; ?></h5>
   </div>
   <div class="form">
      <?php echo form_open('system/user/add'); ?>
         <div class="fields">
           <div class="field">
              <div class="label">
                 <label for="name">用户名：</label>  
              </div>
              <div class="input">
      			 <input type="text" class="small" name="name" id="name" value="<?php echo set_value('name'); ?>" />
                 <span class="error"><?php echo form_error('name'); ?></span>
              </div>
           </div>
           <div class="field">
           	<div class="label">
           		<label>选择用户组：</label>
           	</div>
           	<div class="select">
           		<select class="auto" name="role" id="role">
           			<option value="0">请选择用户组</option>
           			<?php foreach($roleData as $roleItem): ?>
           			<option value="<?php echo $roleItem['id']?>" <?php echo set_select('role', $roleItem['id']); ?>><?php echo $roleItem['name']?></option>
           			<?php endforeach; ?>
           		</select>
           		<span class="error"><?php echo form_error('role'); ?></span>
           	</div>
           </div>
		   <div class="field">
              <div class="label">
                 <label for="password">设置密码：</label>  
              </div>
              <div class="input">
      			 <input type="password" class="small" name="password" id="password" value="<?php echo set_value('password'); ?>" />
                 <span class="error"><?php echo form_error('password'); ?></span>
              </div>
           </div>
           <div class="field">
              <div class="label">
                 <label for="repassword">确认密码：</label>  
              </div>
              <div class="input">
      			 <input type="password" class="small" name="repassword" id="repassword" value="<?php echo set_value('repassword'); ?>" />
                 <span class="error"><?php echo form_error('repassword'); ?></span>
              </div>
           </div>
           <div class="field">
              <div class="label">
                 <label for="email">邮箱：</label>  
              </div>
              <div class="input">
      			 <input type="text" class="small" name="email" id="email" value="<?php echo set_value('email'); ?>" />
                 <span class="error"><?php echo form_error('email'); ?></span>
              </div>
           </div>
           <div class="buttons">
               <div class="highlight"><input type="submit" class="ui-button ui-widget ui-state-default ui-corner-all" value="提交" /></div>
           </div>
         </div>
      <?php echo form_close(); ?>
   </div>
</div>
<?php $this->load->view('system/layout/footer')?>