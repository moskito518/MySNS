<?php $this->load->view('system/layout/header')?>

<div class="box">
   <div class="title">
      <h5><?php echo $page_title; ?></h5>
      <ul class="links">
         <li><?php echo anchor('system/right/add', '添加新权限'); ?></li>
      </ul>
   </div>
   <?php echo form_open('system/right/all_delete'); ?>
      <div class="table">
         <table>
            <col width="45%" />
            <col width="33%" />
            <col />
            <col width="5%" />
            <thead>
               <tr>
                  <th class="left">权限名称</th>
                  <th>权限动作</th>
                  <th>操作</th>
                  <th class="last">
                     <input type="checkbox" class="checkall" />
                  </th>
               </tr>
            </thead>
            <tbody>
            <?php foreach($rightRow as $rightItem):?>
               <tr>
                  <td class="title"><b><?php echo $rightItem['name']; ?></b></td>
                  <td class="date"><?php echo $rightItem['right']; ?></td>
                  <td class="operation">
                     <?php echo anchor('system/right/edit/'.$rightItem['id'], '[编辑]'); ?>
                     <a href="javascript:void(0);" onclick="delModel('<?php echo site_url('system/right/delete/'.$rightItem['id']); ?>');">[删除]</a>
                  </td>
                  <td class="last">
                     <input type="checkbox" name='id[]' value="<?php echo $rightItem['id']?>" />
                  </td>
               </tr>
            <?php endforeach; ?>
            </tbody>
         </table>
         <div class="action">
              <div class="button"><input type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-state-focus" value="批量删除" onclick="delModel();" /></div>
         </div>
      </div>
   <?php echo form_close();?>
</div>
<?php $this->load->view('system/layout/footer'); ?>