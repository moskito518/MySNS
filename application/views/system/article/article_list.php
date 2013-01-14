<?php $this->load->view('system/layout/header')?>

<div class="box">
   <div class="title">
      <h5><?php echo $page_title; ?></h5>
      <ul class="links">
         <li><?php echo anchor('system/article/create', '添加新文章'); ?></li>
      </ul>
   </div>
   <?php echo form_open('system/article/all_delete'); ?>
      <div class="table">
         <table>
            <col width="35%" />
            <col width="10%" />
            <col width="23%" />
            <col width="10%" />
            <col />
            <col width="5%" />
            <thead>
               <tr>
                  <th class="left">文章标题</th>
                  <th>创建人</th>
                  <th>创建时间</th>
                  <th>对应分类</th>
                  <th>操作</th>
                  <th class="last">
                     <input type="checkbox" class="checkall" />
                  </th>
               </tr>
            </thead>
            <tbody>
            <?php foreach($articles as $article_item):?>
               <tr>
                  <td class="title"><b><?php echo $article_item['title']; ?></b></td>
                  <td class="date"><?php echo $article_item['author']; ?></td>
                  <td class="date"><?php echo $article_item['create_time']; ?></td>
                  <td class="category"><?php echo $article_item['cat_name']; ?></td>
                  <td class="operation">
                     <?php echo anchor('system/article/edit/' . $article_item['id'], '［编辑］');?>
                     <a href="javascript:void(0);" onclick="delModel('<?php echo site_url('system/article/delete/'.$article_item['id']); ?>', '是否要删除此文章？');">删除</a>
                  </td>
                  <td class="last">
                     <input type="checkbox" name='id[]' value="<?php echo $article_item['id']?>" />
                  </td>
               </tr>
            <?php endforeach; ?>
            </tbody>
         </table>
         <div class="pagination pagination-left">
            <div class="results"><span>当前第&nbsp;<?php echo $cur_page; ?>&nbsp;页/共&nbsp;<?php echo $total_page; ?>&nbsp;页</span></div>
            <ul class="pager"><?php echo $this->pagination->create_links(); ?></ul>
         </div>
         <div class="action">
              <div class="button"><input type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-state-focus" value="批量删除" onclick="delModel();" /></div>
         </div>
      </div>
   <?php echo form_close(); ?>
</div>