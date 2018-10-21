 <div class="container">
<title>Özel üyelik bölümüne giren kişiler (son 100)</title>
   <?php 
   $logged_in=$this->session->userdata('logged_in');
       echo "<h3>Özel üyelik bölümüne giren kişiler (son 100)</h3>";
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
		
	
<table id="table" 
				data-search="true"
               data-toggle="table"
               data-show-export="true"
               data-show-columns="true"
	>
	<thead>
<tr>
 <th>Tarih-Saat</th>
 <th data-sortable="true">Email</th>
 <th data-sortable="true">Telefon Numarası</th>
 <th data-sortable="true">Özel Üye mi?</th>
</tr>
</thead>
<?php 
if(count($result)==0){
	?>
<tr>
 <td colspan="4"><?php echo $this->lang->line('no_record_found');?></td>
</tr>	
	
	
	<?php
}

foreach($result as $key => $val){
?>
<tr>
 <td> <?php echo $val['tarih_saat'];?></td>
 <td><?php echo $val['email'];?></td>
 <td><?php echo $val['contact_no'];?></td>
 <td><?php echo $val['gid']==3 ? "Evet" : "Hayır"; ?></td>

</tr>

<?php 
}
?>
 
</table>
<a href="<?php echo site_url('genel/ozeluyelik_tiklama_sil/');?>" class="btn btn-success">Kayıtları Sıfırla</a> 
 
</div>

</div>



</div>
