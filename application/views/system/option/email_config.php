<?php $this->load->view('system/layout/header')?>
<div class="box">
   <div class="title">
      <h5><?php echo $page_title; ?></h5>
   </div>
   <div class="form">
      <?php echo form_open_multipart('system/option/email_config'); ?>
         <div class="fields">
         <?php foreach($email_config_data as $item): ?>
           <div class="field">
              <div class="label">
                 <label for="<?php echo $item['var_name']; ?>"><?php echo $item['title']; ?>：</label>  
              </div>
              <?php if($item['type'] == 'text'):?>
              <div class="input">
      			 <input type="text" class="small" name="<?php echo $item['var_name']; ?>" id="<?php echo $item['var_name']; ?>" value="<?php echo !empty($item['value']) ? $item['value'] : set_value($item['var_name']); ?>" />
                 <span class="error"><?php echo form_error($item['var_name']); ?></span>
              </div>
              <?php elseif($item['type'] == 'textarea'):?>
              <div class="textarea">
      			  <textarea id="textarea1" name="<?php echo $item['var_name']; ?>" style="width: 350px;height: 100px;"><?php echo !empty($item['value']) ? $item['value'] : set_value($item['var_name']); ?></textarea>
                 <span class="error"><?php echo form_error($item['var_name']); ?></span>
              </div>
              <?php elseif($item['type'] == 'file'): ?>
              <div class="input inpu-file">
              	<input type="hidden" value="<?php echo !empty($item['value']) ? $item['value'] : set_value('old_img'); ?>" name="old_img">
              	<input type="file" id="file" name="<?php echo $item['var_name']; ?>" size="40" />
              	<span class="error"><?php echo form_error($item['var_name']); ?></span>
              </div>
              <?php endif;?>
           </div>
           <?php endforeach;?>
            <div class="buttons">
               <div class="highlight"><input type="submit" class="ui-button ui-widget ui-state-default ui-corner-all" value="提交" /></div>
           </div>
         </div>
      <?php echo form_close(); ?>
   </div>
</div>
<?php $this->load->view('system/layout/footer')?>