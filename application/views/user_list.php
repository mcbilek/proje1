﻿ <div class="container">

   
 <h3><?php echo $title;?></h3>
    <div class="row">
 
  <div class="col-lg-6">
    <form method="post" action="<?php echo site_url('user/index/');?>">
	<div class="input-group">
    <input type="text" class="form-control" name="search" placeholder="<?php echo $this->lang->line('search');?>...">
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit"><?php echo $this->lang->line('search');?></button>
      </span>
    </div><!-- /input-group -->
	 </form>
  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->

  <div class="row">
 
<div class="col-lg">
<br> 
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
		
<table class="table table-bordered table-sm" 				
data-search="true"
data-toggle="table"
data-sort-stable="true"
data-show-export="true">
<thead>
<tr>
 <th data-sortable="true">#</th>
 <th data-sortable="true">Email</th>
 <th data-sortable="true">Kyt.Trh</th>
<th data-sortable="true"><?php echo $this->lang->line('first_name');?> <?php echo $this->lang->line('last_name');?></th>
<th data-sortable="true">Kurum</th>
<th data-sortable="true">Kadro</th>
<th data-sortable="true">Şehir</th>
<th data-sortable="true">Durum</th>
<th data-sortable="true" ><?php echo $this->lang->line('send_notification');?> </th>
<th data-valign="middle" class="col-md-1"><?php echo $this->lang->line('action');?> </th>
</tr>
</thead>
<?php 
if(count($result)==0){
	?>
<tr>
 <td colspan="3"><?php echo $this->lang->line('no_record_found');?></td>
</tr>	
	
	
	<?php
}
foreach($result as $key => $val){
    // returns Saturday, January 30 10 02:06:34
    $old_date_timestamp = strtotime($val['registered_date']);
    $new_date = date('d.m.Y', $old_date_timestamp);
?>
<tr>
 <td><?php echo $val['uid'];?></td>
<td><?php echo $val['email'];?></td>
<td><?php echo $new_date;?></td>
<td><?php echo $val['first_name'];?> <?php echo $val['last_name'];?></td>
<td><?php echo $val['kurum_adi'];?></td>
<td><?php echo $val['kadro_adi'];?></td>
<td><?php echo $val['il_adi'];?></td>
 <td><?php echo $this->lang->line($val['user_status']);?></td>
 <td><a href="<?php echo site_url('notification/add_new/'.$val['uid']);?>">Mesaj</a>,<a href="<?php echo site_url('sendsms/send_sms/'.$val['uid']);?>">SMS</a>,<a href="<?php echo site_url('notification/add_new/'.$val['uid']);?>">Mail</a></td>
<td>
 
<a href="<?php echo site_url('user2/view_user/'.$val['uid']);?>"><i class="fa fa-eye" title="View Profile"></i></a>
 
<a href="<?php echo site_url('user/edit_user/'.$val['uid']);?>"><img src="<?php echo base_url('images/edit.png');?>"></a>
<a href="javascript:remove_entry('user/remove_user/<?php echo $val['uid'];?>');"><img src="<?php echo base_url('images/cross.png');?>"></a>

</td>
</tr>

<?php 
}
?>
</table>
</div>

</div>


<?php
if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; } ?>

<a href="<?php echo site_url('user/index/'.$back);?>"  class="btn btn-primary"><?php echo $this->lang->line('back');?></a>
&nbsp;&nbsp;
<?php
 $next=$limit+($this->config->item('number_of_rows'));  ?>

<a href="<?php echo site_url('user/index/'.$next);?>"  class="btn btn-primary"><?php echo $this->lang->line('next');?></a>





</div>
