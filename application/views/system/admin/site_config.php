<?php $this->load->view('system/layout/header')?>
<div class="box">
   <div class="title">
      <h5><?php echo $page_title; ?></h5>
      <ul class="links">
         <li><?php echo anchor('system/admin/site_config_add', '添加新配置'); ?></li>
      </ul>
   </div>
   <?php echo form_open('system/admin/site_config_all_del'); ?>
      <div class="table">
         <table>
            <col width="15%" />
            <col width="13%" />
            <col width="13%" />
            <col width="30%" />
            <col width="7%" />
            <col />
            <col width="5%" />
            <thead>
               <tr>
                  <th class="left">配置名称</th>
                  <th>配置变量</th>
				  <th>所属分类</th>
                  <th>值</th>
                  <th>状态</th>
                  <th>操作</th>
                  <th class="last">
                     <input type="checkbox" class="checkall" />
                  </th>
               </tr>
            </thead>
            <tbody>
            <?php foreach($configData as $configItem):?>
               <tr>
                  <td class="title"><b><?php echo $configItem['title']; ?></b></td>
                  <td class="date"><?php echo $configItem['var_name']; ?></td>
                  <td class="date"><?php echo $configItem['category']; ?></td>
                  <td class="date"><?php echo $configItem['value']; ?></td>
                  <td class="date"><?php echo $configItem['status']; ?></td>
                  <td class="operation">
                     <?php echo anchor('system/admin/site_config_edit/' . $configItem['id'], '［编辑］');?>
					 <a href="javascript:void(0);" onclick="delModel('<?php echo site_url('system/admin/site_config_del/'.$configItem['id']); ?>');">删除</a>
                  </td>
                  <td class="last">
                     <input type="checkbox" name='id[]' value="<?php echo $configItem['id']?>" />
                  </td>
               </tr>
            <?php endforeach; ?>
            </tbody>
         </table>
         <div class="action">
              <div class="button"><input type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-state-focus" value="批量删除" onclick="delModel();" /></div>
         </div>
      </div>
   <?php echo form_close(); ?>
</div>
<?php $this->load->view('system/layout/footer'); ?>