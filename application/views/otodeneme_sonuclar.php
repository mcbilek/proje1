 <div class="container">

   <?php 
   $logged_in=$this->session->userdata('logged_in');
   if ($logged_in['su']=='1') {
       echo "<h3>Oto Deneme Sonuçları:".$user['first_name']." ".$user['last_name']."</h3>";
   } else {
       echo "<h3>".$title."</h3>";
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
$dogru=0;
$yanlis=0;

foreach($result as $key => $val){
    $yuzde=round(100*$val['dogru']/($val['yanlis']+$val['dogru']), 2);
    $dogru=$dogru+$val['dogru'];
    $yanlis=$yanlis+$val['yanlis'];
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
$toplamYuzde=round(100*$dogru/($yanlis+$dogru), 2);
?>
<tr>
 <td><strong>TOPLAM</strong></td>
 <td><strong><?php echo $dogru;?></strong></td>
 <td><strong><?php echo $yanlis;?></strong></td>
 <td><strong><?php echo "%".$toplamYuzde;?></strong></td>
</tr>
</table>
 
</div>

</div>



</div>
