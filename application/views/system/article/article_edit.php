<?php $this->load->view('system/layout/header')?>

<script type="text/javascript" src="<?php echo base_url(''); ?>skin/js/editor/kindeditor-min.js"></script>
<div class="box">
   <div class="title">
      <h5><?php echo $page_title;?></h5>
   </div>
   <div class="form">
      <?php echo form_open('system/article/edit'); ?>
      	 <input type="hidden" name="id" id="id" value="<?php echo !empty($id) ? $id : set_value('id'); ?>" />
         <div class="fields">
           <div class="field">
              <div class="label">
                 <label for="title">文章标题：</label>  
              </div>
              <div class="input">
                 <input type="text" class="small" value="<?php echo !empty($articleRow['title']) ? $articleRow['title'] : set_value('title'); ?>" id="title" name="title" />
                 <span class="error"><?php echo form_error('title'); ?></span>
              </div>
           </div>
           <div class="field">
              <div class="label"><label>选择分类：</label></div>
              <div class="select">
              	<select class="auto" name="category" id="category">
              		<?php foreach($category as $category_item): ?>
					<?php $path_length = substr_count($category_item['path'], ',') - 2;?>
					<option value="<?php echo $category_item['id']?>" <?php if( !empty($articleRow['category']) && $articleRow['category'] == $category_item['id']): ?>selected="selected"<?php endif ?> <?php echo set_select('category', $category_item['id'])?>><?php echo $path_length == 0 ? $category_item['title'] : str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $path_length) . '└' . $category_item['title']; ?></option>
					<?php endforeach; ?>
              	</select>
              	<span class="error"><?php echo form_error('category'); ?></span>
              </div>
           </div>
           <div class="field">
              <div class="label label-textarea"><label for="text_content">内容：</label></div>
              <div class="textarea textarea-editor">
				<textarea name="content" id="text_content" style="height:300px;width:600px"><?php echo !empty($articleRow['content']) ? $articleRow['content'] : set_value('content'); ?></textarea>
              	<span class="error"><?php echo form_error('content'); ?></span>
              </div>
           </div>
           <div class="buttons">
               <div class="highlight"><input type="submit" class="ui-button ui-widget ui-state-default ui-corner-all" value="提交" /></div>
           </div>
      	</div>
      <?php echo form_close(); ?>
   </div>
</div>

<script>
var editor;

KindEditor.ready(function(K){
	 editor = K.create('#text_content',{
		uploadJson : "<?php echo site_url() . '/system/block/upload_img_from_editor';?>",
		extraFileUploadParams: {"<?php echo $this->security->get_csrf_token_name();?>" : "<?php echo $this->security->get_csrf_hash(); ?>"},
     	items : ['source', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
				 'code', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
				 'insertunorderedlist', '|', 'emoticons', 'image', 'link', 'preview'],
	 		afterCreate: function(){
	            this.sync();
	         },
	         afterChange: function(){
	            this.sync();
	         },
	         afterBlur: function(){
	            this.sync();
	         },
     });
})
</script>

<?php $this->load->view('system/layout/footer')?>