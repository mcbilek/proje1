 <div class="container">
<?php 
$logged_in=$this->session->userdata('logged_in');
?>
   
  

<?php 
if($logged_in['su']=='1'){}
?>


<h3><?php echo $title;?></h3>
 

  <div class="row">
 
<div class="col-md-12">
<br> 
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
		<?php 
		if($logged_in['su']=='1'){
			?>
				<div class='alert alert-danger'><?php echo $this->lang->line('pending_message_admin');?></div>		
		<?php 
		}
		?>
<table class="table table-bordered" 
data-search="true"
data-toggle="table"
data-show-export="true">
<thead>
<tr>
 <th data-sortable="true"><?php echo $this->lang->line('result_id');?></th>
<th data-sortable="true"><?php echo $this->lang->line('first_name');?> <?php echo $this->lang->line('last_name');?></th>
 <th data-sortable="true">Tarih-Saat</th>
 <th data-sortable="true">Toplam Soru</th>
 <th data-sortable="true"><?php echo $this->lang->line('percentage_obtained');?></th>
<th><?php echo $this->lang->line('action');?> </th>
</thead>
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
 <td><?php echo $val['kayit_id'];?></td>
<td><?php echo $logged_in['first_name'];?> <?php echo $logged_in['last_name'];?></td>
 <td><?php 
 $date = new DateTime($val['deneme_tarihi']);
  echo $date->format('d.m.Y H:i');
 ?></td>
 <td><?php echo $val['soru_adet'];?></td>
 <td><?php echo $val['basari_yuzdesi'];?>%</td>
<td>
<a href="<?php echo site_url('quiz/oto_deneme_istatistik/'.$val['kayit_id']);?>" class="btn btn-success" ><?php echo $this->lang->line('view');?> </a>

</td>
</tr>

<?php 
}
?>
</table>
</div>

</div>


</div>