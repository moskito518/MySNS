<?php $this->load->view('system/layout/header')?>

<div class="box">
   <div class="title">
      <h5><?php echo $page_title; ?></h5>
   </div>
   <div class="form">
      <?php echo form_open('system/right/add'); ?>
         <div class="fields">
           <div class="field">
              <div class="label">
                 <label for="name">权限名称：</label>  
              </div>
              <div class="input">
      			 <input type="text" class="small" name="name" id="name" value="<?php echo set_value('name'); ?>" />
                 <span class="error"><?php echo form_error('name'); ?></span>
              </div>
           </div>
		   <div class="field">
              <div class="label">
                 <label for="right_action">权限动作：</label>  
              </div>
              <div class="input">
      			 <input type="text" class="small" name="right" id="right_action" value="<?php echo set_value('right'); ?>" />
                 <span class="error"><?php echo form_error('right'); ?></span>
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