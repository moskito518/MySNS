<?php $this->load->view('system/layout/header')?>

<div class="box">
   <div class="title">
      <h5><?php echo $page_title; ?></h5>
   </div>
   <div class="form">
      <?php echo form_open('system/admin/edit'); ?>
      	 <input type="hidden" name="id" id="id" value="<?php echo !empty($id) ? $id : set_value('id'); ?>" />
         <div class="fields">
           <div class="field">
              <div class="label">
                 <label for="name">用户名：</label>  
              </div>
              <div class="input">
      			 <input type="text" class="small" name="name" id="name" readonly="readonly" value="<?php echo !empty($userRow['name']) ? $userRow['name'] : set_value('name'); ?>" />
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
           			<option value="<?php echo $roleItem['id']?>" <?php if(!empty($userRow['role']) && $userRow['role'] == $roleItem['id']): ?>selected="selected"<?php endif; ?><?php echo set_select('role', $roleItem['id']); ?>><?php echo $roleItem['name']?></option>
           			<?php endforeach; ?>
           		</select>
           		<span class="error"><?php echo form_error('role'); ?></span>
           	</div>
           </div>
           <div class="field">
              <div class="label">
                 <label for="oldpassword">旧密码：</label>  
              </div>
              <div class="input">
      			 <input type="password" class="small" name="oldpassword" id="oldpassword" value="<?php echo set_value('oldpassword'); ?>" />
                 <span class="error"><?php echo form_error('oldpassword'); ?></span>
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
      			 <input type="text" class="small" name="email" id="email" readonly="readonly" value="<?php echo !empty($userRow['email']) ? $userRow['email'] : set_value('email'); ?>" />
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