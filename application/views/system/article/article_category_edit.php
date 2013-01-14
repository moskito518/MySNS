<?php $this->load->view('system/layout/header')?>
<div class="box">
   <div class="title">
      <h5><?php echo $page_title; ?></h5>
   </div>
   <div class="form">
      <?php echo form_open('system/article_category/edit'); ?>
      	 <input type="hidden" name="id" value="<?php echo !empty($id) ? $id : set_value('id'); ?>" />
         <div class="fields">
           <div class="field">
              <div class="label">
                 <label for="title">分类名称：</label>  
              </div>
              <div class="input">
      			 <input type="text" class="small" name="title" id="title" value="<?php echo !empty($AcategoryRow['title']) ? $AcategoryRow['title'] : set_value('title'); ?>" />
                 <span class="error"><?php echo form_error('title'); ?></span>
              </div>
           </div>
           <div class="field">
              <div class="label"><label>上级分类：</label></div>
              <div class="select">
              	<select name="parent" id="parent">
					<option value="0">顶级分类</option>
					<?php foreach($category_list as $category_item): ?>
					<?php $path_length = substr_count($category_item['path'], ',') - 2;?>
					<option <?php if($id == $category_item['id']) echo 'disabled'; ?> value="<?php echo $category_item['id']; ?>" <?php if(!empty($AcategoryRow['parent']) && $AcategoryRow['parent'] == $category_item['id']): ?>selected="selected"<?php endif; ?> <?php echo set_select('parent', $category_item['id'])?>><?php echo $path_length == 0 ? $category_item['title'] : str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $path_length) . '└' . $category_item['title']; ?></option>
					<?php endforeach ?>
				</select>
				<span class="error"><?php echo form_error('parent'); ?></span>
			  </div>
           </div>
		   <div class="field">
              <div class="label">
                 <label for="order">分类排序：</label>  
              </div>
              <div class="input">
      			 <input type="text" class="small" name="order" id="order" value="<?php echo !empty($AcategoryRow['order']) ? $AcategoryRow['order'] : set_value('order'); ?>" />
                 <span class="error"><?php echo form_error('order'); ?></span>
              </div>
           </div>
           <div class="field">
              <div class="label">
                 <label for="textarea1">分类简介：</label>  
              </div>
              <div class="textarea">
      			 <textarea id="textarea1" name="description" style="width: 350px;height: 150px;"><?php echo !empty($AcategoryRow['description']) ? $AcategoryRow['description'] : set_value('description'); ?></textarea>
                 <span class="error" style="margin-left: -10px;"><?php echo form_error('description'); ?></span>
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