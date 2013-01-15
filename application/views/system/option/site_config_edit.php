<?php $this->load->view('system/layout/header')?>

<div class="box">
   <div class="title">
      <h5><?php echo $page_title; ?></h5>
   </div>
   <div class="form">
      <?php echo form_open('system/option/site_config_edit'); ?>
      	<input type="hidden" name="id" value="<?php echo !empty($id) ? $id : set_value('id'); ?>" />
         <div class="fields">
           <div class="field">
              <div class="label">
                 <label for="var_name">变量名：</label>  
              </div>
              <div class="input">
      			 <input type="text" class="small" name="var_name" id="var_name" value="<?php echo !empty($configData['var_name']) ? $configData['var_name'] : set_value('var_name'); ?>" />
                 <span class="error"><?php echo form_error('var_name'); ?></span>
              </div>
           </div>
           <div class="field">
              <div class="label">
                 <label for="title">设置名称：</label>  
              </div>
              <div class="input">
      			 <input type="text" class="small" name="title" id="title" value="<?php echo !empty($configData['title']) ? $configData['title'] : set_value('title'); ?>" />
                 <span class="error"><?php echo form_error('title'); ?></span>
              </div>
           </div>
           <div class="field">
           	<div class="label">
           		<label for="category">配置分类：</label>
           	</div>
           	<div class="select">
           		<select name="category" id="category">
           			<option value="base" <?php if(isset($configData['category']) && $configData['category'] == 'base'): ?>selected="selected"<?php endif; ?> <?php echo set_select('category', 'base', TRUE)?>>基本设置</option>
           			<option value="email" <?php if(isset($configData['category']) && $configData['category'] == 'email'): ?>selected="selected"<?php endif; ?> <?php echo set_select('category', 'email')?>>邮件设置</option>
           		</select>
           		<span class="error"><?php echo form_error('category'); ?></span>
           	</div>
           </div>
           <div class="field">
              <div class="label">
                 <label for="var_name">类型：</label>  
              </div>
              <div class="input">
      			 <input type="text" class="small" name="type" id="type" value="<?php echo !empty($configData['type']) ? $configData['type'] : set_value('type'); ?>" />
                 <span class="error"><?php echo form_error('type'); ?></span>
              </div>
           </div>
            <div class="field">
              <div class="label">
                 <label for="value">值：</label>  
              </div>
              <div class="input">
      			 <input type="text" class="small" name="value" id="value" value="<?php echo !empty($configData['value']) ? $configData['value'] : set_value('value'); ?>" />
                 <span class="success">*值可以为空</span>
              </div>
           </div>
           <div class="field">
           <div class="label">
           	<label for="radio-0">状态：</label>
           </div>
           <div class="radios" style="padding-top: 5px">
           	<input type="radio" name="status" id="radio-0" value="0" <?php if(isset($configData['status']) && $configData['status'] == '0'): ?>checked="checked"<?php endif;?> <?php echo set_radio('status', '0', TRUE); ?>/>
           	<label for="radio-0">启用</label>
           	<input type="radio" name="status" id="radio-1" value="1" <?php if(isset($configData['status']) && $configData['status'] == '1'): ?>checked="checked"<?php endif;?> <?php echo set_radio('status', '1'); ?>/>
           	<label for="radio-1">禁用</label>
           	<span class="error"><?php echo form_error('status'); ?></span>
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