 <div class="container">
 <?php 
 $logged_in=$this->session->userdata('logged_in');
		
		?>  
 
   
 <h3><?php echo $title;?></h3>
    <div class="row">
 
  <div class="col-lg-6">
    <form method="post" action="<?php echo site_url('notification/index/');?>">
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
 
<div class="col-md-12">
<br> 
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		if($logged_in['su']=='1'){
		?>	
		
 <a href="<?php echo site_url('notification/add_new');?>" class="btn btn-success">Yeni Toplu Mesaj</a><a href="<?php echo site_url('sendsms/send_sms/0');?>" class="btn btn-info">Yeni Toplu SMS</a><br><br>
 <?php }?>
<table class="table table-bordered">
<tr>
 <th>#</th>
 <th><?php echo $this->lang->line('mesaj_tur');?></th>
<th><?php echo $this->lang->line('message');?> </th>
<?php
if($logged_in['su']=='1'){
?>
<th><?php echo $this->lang->line('notification_to');?> </th> 
<?php 
}
?>
<th><?php echo $this->lang->line('date');?> </th> 
</tr>
<?php 
if(count($result)==0){
	?>
<tr>
 <td colspan="6"><?php echo $this->lang->line('no_record_found');?></td>
</tr>	
	
	
	<?php
}
foreach($result as $key => $val){
?>
<tr>
 <td><?php echo $val['nid'];?></td>
 <td><?php if ($val['mesaj_turu']==0){ echo "Mesaj";} else if ($val['mesaj_turu']==1) {echo "SMS";} else {echo "Mail";}?></td>
  <td><?php echo $val['message'];?></td>
  <?php
if($logged_in['su']=='1'){
?>
 <td><?php 
 if($val['uid']==0 || $val['uid']==-1){
 ?>
 <?php echo $this->lang->line('all_users');?>
 <?php
 } else if($val['uid']==1){
     ?>
 <?php echo "Ücretsiz Üyeler";?>
 <?php
 } else if($val['uid']==3){
     ?>
 <?php echo "Özel Üyeler";?>
 <?php
  }else { 
 ?><a href="<?php echo site_url('user/edit_user/'.$val['uid']);?>"><?php echo $val['first_name'].' '.$val['last_name'];?></a>
 <?php 
 }
 ?>
 
 </td>
 <?php 
 }
 ?>
<td><?php echo  date("d.m.Y H:i:s", strtotime($val['notification_date']));?></td>
 
</tr>

<?php 
}
?>
</table>
 </div>

</div>


<?php
if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; } ?>

<a href="<?php echo site_url('notification/index/'.$back);?>"  class="btn btn-primary"><?php echo $this->lang->line('back');?></a>
&nbsp;&nbsp;
<?php
 $next=$limit+($this->config->item('number_of_rows'));  ?>

<a href="<?php echo site_url('notification/index/'.$next);?>"  class="btn btn-primary"><?php echo $this->lang->line('next');?></a>





</div>
