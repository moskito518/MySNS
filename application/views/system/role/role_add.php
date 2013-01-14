<?php $this->load->view('system/layout/header')?>
<div class="box">
   <div class="title">
      <h5><?php echo $page_title; ?></h5>
   </div>
   <div class="form">
      <?php echo form_open('system/role/create'); ?>
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
           	  		<label>指派权限：</label>
           	  </div>
           	  <div class="checkboxes" style="padding-top: 5px">
					<?php foreach($rightRow as $rightItem): ?>
						<input type="checkbox" name="right[]" value="<?php echo $rightItem['id']; ?>" id="<?php echo $rightItem['id']; ?>" <?php echo set_checkbox('right[]', $rightItem['id']); ?> />
						<label for="<?php echo $rightItem['id']; ?>"><?php echo $rightItem['name']?></label>
					<?php endforeach; ?>
					<span class="error"><?php echo form_error('right[]'); ?></span>
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