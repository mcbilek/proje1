 <div class="container">

   <?php 
   $logged_in=$this->session->userdata('logged_in');
   if ($logged_in['su']=='1') {
       echo "<h3>Bireysel Soru Çözme İstatistikleri:".$user['first_name']." ".$user['last_name']."</h3>";
   } else {
       echo "<h3>Bireysel Soru Çözme İstatistikleriniz</h3>";
   }
   ?>

  <div class="row">
 
<div class="col-md-12">
<br> 
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
		<div id="message"></div>
		
	
<table class="table table-bordered">
<tr>
 <th>Konu</th>
 <th>Doğru</th>
 <th>Yanlış</th>
<th>Başarı </th>
</tr>
<?php 
if(count($result)==0){
	?>
<tr>
 <td colspan="4"><?php echo $this->lang->line('no_record_found');?></td>
</tr>	
	
	
	<?php
}

foreach($result as $key => $val){
    $yuzde=round(100*$val['dogru']/($val['yanlis']+$val['dogru']), 2);
?>
<tr>
 <td> <?php echo $val['category_name'];?></td>
 <td><?php echo $val['dogru'];?></td>
 <td><?php echo $val['yanlis'];?></td>
 <td><?php echo "%".$yuzde;?></td>


<!-- 
<a href="<?php echo site_url('user/pre_remove_group/'.$val['gid']);?>"><img src="<?php echo base_url('images/cross.png');?>"></a>
 -->

</tr>

<?php 
}
?>
 
</table>
<a href="<?php echo site_url('user/istatistik/')."/".$uid."/1";?>" class="btn btn-success">İstatistikleri Sıfırla</a> 
 
</div>

</div>



</div>
