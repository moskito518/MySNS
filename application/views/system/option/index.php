<?php $this->load->view('system/layout/header')?>

<div class="box">
   <div class="title">
      <h5><?php echo $page_title;?></h5>
   </div>
   <h4>管理员信息</h4>
   <ul class="square">
   	<li><b>管理员名称：</b><?php echo $this->admin['admin_name']; ?></li>
   </ul>
   <h4>网站信息</h4>
   <ul class="square">
      <li><b>网站名称：</b><?php echo $this->site_config['site_name']; ?></li>
      <li><b>网站地址：</b><a href="<?php echo base_url();?>" target="_blank"><?php echo base_url();?></a></li>
      <li><b>网站简介：</b><?php echo $this->site_config['site_description']; ?></li>
   </ul>
</div>

<?php $this->load->view('system/layout/footer')?>
