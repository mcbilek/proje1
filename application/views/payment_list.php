 <div class="container">
 			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
 
   <div class="row">
 
  <div class="col-lg-12">   <h3><?php echo $this->lang->line('generate_report');?> </h3> 
    <form method="post" action="<?php echo site_url('payment_gateway/generate_report/');?>">
	<div class="input-group">
 <input type="text" name="date1" value="" placeholder="<?php echo $this->lang->line('date_from');?>">
 
 <input type="text" name="date2" value="" placeholder="<?php echo $this->lang->line('date_to');?>">

 <button class="btn btn-info" type="submit"><?php echo $this->lang->line('generate_report');?></button>	

 
 </div>
 </form>
 </div>
 </div>
 
 
   
 <h3><?php echo $title;?></h3>
    <div class="row">
 
  <div class="col-lg-6">
    <form method="post" action="<?php echo site_url('payment_gateway/index/');?>">
	<div class="input-group">
    <input type="text" class="form-control" name="search" placeholder="Kullanıcı Adı/Email...">
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

<table id="table" 
				data-search="true"
               data-toggle="table"
               data-show-export="true"
               data-show-columns="true"
	>
<thead>
<tr>
 <th data-field="name" data-sortable="true">Kullanıcı</th>
 <th data-sortable="true">Yöntem</th>
 <th data-sortable="true">Gönderen</th>
 <th data-sortable="true">Banka</th>
 <th data-sortable="true">Açıklama</th>
<th data-sortable="true" data-field="tarih"><?php echo $this->lang->line('paid_date');?> </th>
<th data-sortable="true"><?php echo $this->lang->line('amount');?></th>
<th data-sortable="true"><?php echo $this->lang->line('status');?> </th>
<th data-valign="middle" data-sortable="true">Onay</th>
</tr>
</thead>
<?php 
if(count($payment_history)==0){
	?>
<tr>
 <td colspan="6"><?php echo $this->lang->line('no_record_found');?></td>
</tr>	
	
	
	<?php
}
foreach($payment_history as $key => $val){
?>
<tr>
 <td><?php echo $val['email'];?></td>
 <td><?php if ($val['payment_gateway']=="1") { echo "Havale";} else if ($val['payment_gateway']=="2") {echo "Kredi Kartı";} else { echo "Diğer";}?></td>
  <td><?php echo $val['gonderen'];?></td>
  <td><?php echo $val['bankaAdi'];?></td>
  <td><?php echo $val['other_data'];?></td>
 <td><?php echo date("d.m.Y H:i:s", strtotime($val['paid_date']));?></td>
 <td><?php echo $val['amount'];?>,00₺</td>
 <td><?php if ($val['payment_status']=="0") { echo "Beklemede";} else {echo "Onaylandı";}?></td>
 <td ><form method="post" action="<?php echo site_url('payment/odemeOnay');?>" name="odemeOnay" style="margin-bottom: 0px;">
 <input type="hidden" name="payment_id" value="<?php echo $val['pid'];?>" >
 <button type="submit" class="btn btn-primary btn-rounded btn-sm my-0 " <?php if ($val['payment_status']=="1") { echo "disabled";}?>>Onayla</button>
	</form></td>
</tr>

<?php 
}
?>
</table>
 </div>

</div>



<?php
if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; } ?>

<a href="<?php echo site_url('payment_gateway/index/'.$back);?>"  class="btn btn-primary"><?php echo $this->lang->line('back');?></a>
&nbsp;&nbsp;
<?php
 $next=$limit+($this->config->item('number_of_rows'));  ?>

<a href="<?php echo site_url('payment_gateway/index/'.$next);?>"  class="btn btn-primary"><?php echo $this->lang->line('next');?></a>





</div>
