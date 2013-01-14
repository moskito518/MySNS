<?php $this->load->view('system/layout/header')?>

<script>
function delModel(obj){
	var delhref= obj.toString();
	if(confirm('是否删除文章分类?')){
		window.location.href = delhref;
	}else{
		return false;
	}
}
</script>

<div class="box">
   <div class="title">
      <h5><?php echo $page_title; ?></h5>
      <ul class="links">
         <li><?php echo anchor('system/article_category/create', '添加文章分类'); ?></li>
      </ul>
   </div>
      <div class="table">
         <table>
            <col width="58%" />
            <col width="13%" />
            <col width="12%" />
            <col />
            <thead>
               <tr>
                  <th class="left">文章标题</th>
                  <th>排序</th>
                  <th>对应分类</th>
                  <th class="last">操作</th>
               </tr>
            </thead>
            <tbody>
            <?php foreach($article_category as $actegory_item):?>
               <tr>
               	  <?php $path_length = substr_count($actegory_item['path'], ','); ?>
                  <td class="title"><b style="margin-left:<?php echo ($path_length - 2)*2?>0px"><?php if(($path_length-2)>0): ?>└<?php endif;?> <?php echo $actegory_item['title']; ?></b></td>
                  <td class="date"><?php echo $actegory_item['order']; ?></td>
                  <td class="category"><?php echo $actegory_item['title']; ?></td>
                  <td class="operation last">
                     <?php echo anchor('system/article_category/edit/' . $actegory_item['id'], '［编辑］');?>
                     <a href="javascript:void(0);" onclick="delModel('<?php echo site_url('system/article_category/delete/'.$actegory_item['id']); ?>');">删除</a>
                  </td>
               </tr>
            <?php endforeach; ?>
            </tbody>
         </table>
      </div>
</div>