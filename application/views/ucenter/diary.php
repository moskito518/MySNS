<?php $this->load->view('ucenter/layout/header')?>
<script type="text/javascript" src="<?php echo base_url(''); ?>skin/js/editor/kindeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url(''); ?>skin/js/editor/lang/zh_CN.js"></script>
<p>
	<?php echo $page_title; ?>
</p>
<?php echo form_open('ucenter/post_add'); ?>
<div>
	<label for="diary_name">
		日志标题
	</label>
	<input type="text" name="diary_name" id="diary_name" />
</div>
<div>
	<label for="diary_content">内容</label>
	<input type="button" value="上传图片" id="J_selectImage" />
	<textarea name="diary_content" id="diary_content" style="width:300px;height:200px;"></textarea>
</div>
<div>
	<input type="submit" value="发表" />
</div>
<?php echo form_close();?>

<script>
			KindEditor.ready(function(K) {
				var editor = K.editor({
					allowFileManager : true
				});
				K('#J_selectImage').click(function() {
					editor.loadPlugin('multiimage', function() {
						editor.plugin.multiImageDialog({
							clickFn : function(urlList) {
								var div = K('#diary_content');
								div.html('');
								K.each(urlList, function(i, data) {
									div.append('<img src="' + data.url + '">');
								});
								editor.hideDialog();
							}
						});
					});
				});
			});
		</script>
<?php $this->load->view('ucenter/layout/footer')?>