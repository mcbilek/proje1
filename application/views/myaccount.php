 <div class="container">

   
 <h3><?php echo $title;?></h3>
   
 

  <div class="row">
     <form method="post" role="form" data-toggle="validator" action="<?php echo site_url('user/update_user/'.$uid);?>">
	
<div class="col-md-8">
<br> 
 <div class="login-panel panel panel-default">
		<div class="panel-body"> 
	
	
	
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
		
				<div class="form-group">	 
				<?php echo $this->lang->line('group_name');?>: <?php echo $result['group_name'];?>
				
				<?php 
				if($this->config->item('allow_switch_group')){
				?>
<a href="<?php echo site_url('user/switch_group');?>" class="btn btn-danger"><?php echo $this->lang->line('change_group');?></a>
				<?php 
				}
				?>
				</div>
				
				
				<div class="form-group">	 
					<label for="inputEmail" class="sr-only"><?php echo $this->lang->line('email_address');?></label> 
					<input type="email" id="inputEmail" name="email" value="<?php echo $result['email'];?>" readonly=readonly class="form-control" placeholder="<?php echo $this->lang->line('email_address');?>" required autofocus>
			</div>
			<div class="form-group">	  
					<label for="inputPassword" class="sr-only"><?php echo $this->lang->line('password');?></label>
					<input type="password" id="inputPassword"  name="password"  class="form-control" placeholder="<?php echo $this->lang->line('password');?> (Sadece değiştirmek istiyorsanız doldurun)" >
			 </div>
				<div class="form-group">	 
					<label for="inputEmail" class="sr-only"><?php echo $this->lang->line('first_name');?></label> 
					<input type="text"  name="first_name"  class="form-control"  value="<?php echo $result['first_name'];?>"  placeholder="<?php echo $this->lang->line('first_name');?>"  required autofocus>
			</div>
				<div class="form-group">	 
					<label for="inputEmail" class="sr-only"><?php echo $this->lang->line('last_name');?></label> 
					<input type="text"   name="last_name"  class="form-control"  value="<?php echo $result['last_name'];?>"  placeholder="<?php echo $this->lang->line('last_name');?>" required  autofocus>
			</div>
			<div class="form-group">	 
					<label for="contact_no"><?php echo $this->lang->line('contact_no');?></label> 
					<input type="text" name="contact_no" value="<?php echo $result['contact_no'];?>" 	 	 class="form-control input-medium bfh-phone" data-format="5dd ddddddd" placeholder="<?php echo $this->lang->line('contact_no');?>" disabled required autofocus>
			</div>
						<div class="form-group">	 
					<label>Çalıştığı Kurum: </label>
					<?php 
					foreach($kurum_list as $key => $val){
						if($result['kurum_id']==$val['kurum_id']){ echo "<label>".$val['kurum_adi']."</label>";}
					}
					?>
			</div>
			<div class="form-group">	 
					<label>Geçmek İstediği Kadro: </label>
					<?php 
					foreach($kadro_list as $key => $val){
						if($result['kadro_id']==$val['kadro_id']){ echo "<label>".$val['kadro_adi']."</label>";}
					}
					?>

			</div>	 
 
	<button class="btn btn-default" type="submit"><?php echo $this->lang->line('submit');?></button>
 
		</div>
</div>
 
 
 
 
</div>
      </form>
</div>



<div class="row">
<div class="col-md-8">
<h3><?php echo $this->lang->line('payment_history');?></h3>
<table class="table table-bordered">
<tr>
 <th><?php echo $this->lang->line('payment_gateway');?></th>
<th><?php echo $this->lang->line('paid_date');?> </th>
<th><?php echo $this->lang->line('amount');?></th>
<th><?php echo $this->lang->line('transaction_id');?> </th>
<th><?php echo $this->lang->line('status');?> </th>
</tr>
<?php 
if(count($payment_history)==0){
	?>
<tr>
 <td colspan="5"><?php echo $this->lang->line('no_record_found');?></td>
</tr>	
	
	
	<?php
}
foreach($payment_history as $key => $val){
?>
<tr>
 <td><?php if ($val['payment_gateway']=="1") { echo "Havale";} else if ($val['payment_gateway']=="2") {echo "Kredi Kartı";} else { echo "Diğer";}?></td>
 <td><?php echo date("d.m.Y H:i:s", strtotime($val['paid_date']));?></td>
 <td><?php echo $val['amount'].",00TL";?></td>
 <td><?php echo $val['transaction_id'];?></td>
 <td><?php if ($val['payment_status']=="1") { echo "Onaylı";} else {echo "Onay Bekliyor";}?></td>
 
</tr>

<?php 
}
?>
</table>

</div>

</div>


 



</div>
