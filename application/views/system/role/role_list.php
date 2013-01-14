<?php $this->load->view('system/layout/header')?>

<div class="box">
   <div class="title">
      <h5><?php echo $page_title; ?></h5>
      <ul class="links">
         <li><?php echo anchor('system/role/create', '添加角色'); ?></li>
      </ul>
   </div>
   <?php echo form_open('system/role/all_delete'); ?>
      <div class="table">
         <table>
            <col width="78%" />
            <col />
            <col width="5%" />
            <thead>
               <tr>
                  <th class="left">角色名称</th>
                  <th>操作</th>
                  <th class="last">
                     <input type="checkbox" class="checkall" />
                  </th>
               </tr>
            </thead>
            <tbody>
            <?php foreach($roleRow as $roleItem): ?>
               <tr>
                  <td class="title"><b><?php echo $roleItem['name']; ?></b></td>
                  <td class="operation">
                     <?php echo anchor('system/role/edit/'.$roleItem['id'], '[编辑]'); ?>
					 <a href="javascript:void(0);" onclick="delModel('<?php echo site_url('system/role/delete/'.$roleItem['id']); ?>');">[删除]</a>
                  </td>
                  <td class="last">
                     <input type="checkbox" name='id[]' value="<?php echo $roleItem['id']?>" />
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
<?php $this->load->view('system/layout/footer'); ?>