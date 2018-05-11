 <div class="container">

   
 <h3><?php echo $title;?></h3>
   
 

  <div class="row">
     <form method="post" action="<?php echo site_url('user/update_user/'.$uid);?>">
	
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
				<?php echo $this->lang->line('group_name');?>: <?php echo $result['group_name'];?> (<?php echo $this->lang->line('price_');?>: <?php echo $result['price'];?>)
				</div>
				
				
		
				<div class="form-group">	 
					<label for="inputEmail" class="sr-only"><?php echo $this->lang->line('email_address');?></label> 
					<input type="email" id="inputEmail" name="email" value="<?php echo $result['email'];?>" class="form-control" placeholder="<?php echo $this->lang->line('email_address');?>" required autofocus>
			</div>
			<div class="form-group">	  
					<label for="inputPassword" class="sr-only"><?php echo $this->lang->line('password');?></label>
					<input type="password" id="inputPassword" name="password"   value=""  class="form-control" placeholder="<?php echo $this->lang->line('password');?>"   >
			 </div>
				<div class="form-group">	 
					<label for="inputEmail" class="sr-only"><?php echo $this->lang->line('first_name');?></label> 
					<input type="text"  name="first_name"  class="form-control"  value="<?php echo $result['first_name'];?>"  placeholder="<?php echo $this->lang->line('first_name');?>"   autofocus>
			</div>
				<div class="form-group">	 
					<label for="inputEmail" class="sr-only"><?php echo $this->lang->line('last_name');?></label> 
					<input type="text"   name="last_name"  class="form-control"  value="<?php echo $result['last_name'];?>"  placeholder="<?php echo $this->lang->line('last_name');?>"   autofocus>
			</div>
			<div class="form-group">	 
					<label for="contact_no"><?php echo $this->lang->line('contact_no');?></label> 
					<input type="text" name="contact_no" value="<?php echo $result['contact_no'];?>" 	 	 class="form-control input-medium bfh-phone" data-format="5dd ddddddd" placeholder="<?php echo $this->lang->line('contact_no');?>"  required autofocus>
			</div>
			<div class="form-group">	 
					<label>Çalıştığı Kurum</label> 
					<select class="form-control" name="kurum" id="kurum">
					<?php 
					foreach($kurum_list as $key => $val){
						?>
						<option value="<?php echo $val['kurum_id'];?>" <?php if($result['kurum_id']==$val['kurum_id']){ echo 'selected';}?> ><?php echo $val['kurum_adi'];?> </option>
						<?php 
					}
					?>
					</select>
			</div>
			<div class="form-group">	 
					<label>Geçmek İstediği Kadro</label> 
					<select class="form-control" name="kadro" id="kadro">
					<?php 
					foreach($kadro_list as $key => $val){
						?>
						
						<option value="<?php echo $val['kadro_id'];?>" <?php if($result['kadro_id']==$val['kadro_id']){ echo 'selected';}?> ><?php echo $val['kadro_adi'];?> </option>
						<?php 
					}
					?>
					</select>
			</div>
				<div class="form-group">	 
					<label   ><?php echo $this->lang->line('select_group');?></label> 
					<select class="form-control" name="gid"  onChange="getexpiry();" id="gid">
					<?php 
					foreach($group_list as $key => $val){
						?>
						
						<option value="<?php echo $val['gid'];?>" <?php if($result['gid']==$val['gid']){ echo 'selected';}?> ><?php echo $val['group_name'];?> (<?php echo $this->lang->line('price_');?>: <?php echo $val['price'];?>,00TL)</option>
						<?php 
					}
					?>
					</select>
			</div>
			<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('subscription_expired');?></label> 
					<input type="text" name="subscription_expired"  id="subscription_expired" class="form-control" value="<?php if($result['subscription_expired']!='0'){ echo date('d.m.Y',$result['subscription_expired']); }else{ echo '0';} ?>" placeholder="<?php echo $this->lang->line('subscription_expired');?>"  value=""  autofocus>
			</div>


				<div class="form-group">	 
					<label   ><?php echo $this->lang->line('account_type');?></label> 
					<select class="form-control" name="su">
						<option value="0" <?php if($result['su']==0){ echo 'selected';}?>  ><?php echo $this->lang->line('user');?></option>
						<option value="1" <?php if($result['su']==1){ echo 'selected';}?>  ><?php echo $this->lang->line('administrator');?></option>
					</select>
			</div>

 				<div class="form-group">	 
					<label   ><?php echo $this->lang->line('account_status');?></label> 
					<select class="form-control" name="user_status">
						<option value="Active" <?php if($result['user_status']=='Active'){ echo 'selected';}?>  ><?php echo $this->lang->line('active');?></option>
						<option value="Inactive" <?php if($result['user_status']=='Inactive'){ echo 'selected';}?>  ><?php echo $this->lang->line('inactive');?></option>
					</select>
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
<th>Onay</th>
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
 <td><?php echo $val['amount'];?>,00₺</td>
 <td><?php echo $val['transaction_id'];?></td>
 <td><?php if ($val['payment_status']=="0") { echo "Beklemede";} else {echo "Onaylandı";}?></td>
 <td><form method="post" action="<?php echo site_url('login');?>" name="odemeOnay">
 <button type="submit" class="btn btn-primary btn-rounded btn-sm my-0 " <?php if ($val['payment_status']=="1") { echo "disabled";}?>>Onayla</button>
	</form></td>
</tr>

<?php 
}
?>
</table>

</div>

</div>


 



</div>
