<div class="row"  style="border-bottom:1px solid #dddddd;">
<div class="container"  >
<div class="col-md-1">
</div>
<div class="col-md-10">
<a href="<?php echo base_url();?>"><img src="<?php echo base_url('images/logo.png');?>"></a>
<?php echo $this->lang->line('login_tagline');?>
</div>
<div class="col-md-1">
</div>

</div>

</div>

 <div class="container">

   
 <h3><?php echo $title;?></h3>
   
 

  <div class="row">
     <form role="form" data-toggle="validator" method="post" id="onUyelikForm" class="form-group" action="<?php echo site_url('login/registration/');?>">
	
<div class="col-md-8">
<br> 
 <div class="login-panel panel panel-default">
		<div class="panel-body"> 
	
	
	
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		if ($sms_onay_iste=="") {
		?>	
		
		
				<div class="form-group">	 
					<label for="inputEmail" class="control-label"><?php echo $this->lang->line('email_address');?></label> 
					<input type="email" id="inputEmail" value="<?php echo $email;?>" name="email" class="form-control" placeholder="<?php echo $this->lang->line('email_address');?>" data-error="E-Mail adresi hatalı görünüyor" required autofocus>
			<div class="help-block with-errors"></div>
			</div>
			<div class="form-group">	 
					<label for="inputEmail"><?php echo $this->lang->line('contact_no');?> (SMS onayı için geçerli bir numara girmeye dikkat ediniz, sadece üyelik için gereklidir, herhangi bir ücret tahsilatı söz konusu değildir.)</label> 
					<input type="text" name="contact_no" value="<?php echo $contact_no;?>" class="form-control input-medium bfh-phone" data-format="5dd ddddddd" placeholder="<?php echo $this->lang->line('contact_no');?>" required autofocus>
			</div>

						<button class="btn btn-default" type="submit"><?php echo $this->lang->line('submit');?></button>
 &nbsp;&nbsp;&nbsp;&nbsp; <a href="<?php echo site_url('login');?>"><?php echo $this->lang->line('login');?></a>
 <?php } else { ?>
 				<div class="form-group">	 
					<label for="inputEmail" class="control-label"><?php echo $this->lang->line('email_address');?></label> 
					<input type="email" id="inputEmail" name="email" class="form-control" value="<?php echo $email;?>" disabled>
			<div class="help-block with-errors"></div>
			</div>
			<div class="form-group">	 
					<label for="inputEmail"><?php echo $this->lang->line('contact_no');?></label> 
					<input type="text" name="contact_no" class="form-control input-medium" value="<?php echo $contact_no;?>" disabled>
			</div>
			<div class="form-group">	 
					<label for="inputEmail">SMS Onay Kodu (Sadece üyelik teyidi için)</label> 
					<input type="text" name="sms_onay_kodu" class="form-control input-medium" required autofocus>
			</div>

						<button class="btn btn-default" type="submit"><?php echo $this->lang->line('submit');?></button>
 <?php } ?>
		</div>
</div>
 
 
 
 
</div>
      </form>
</div>

 



</div>
<script>

</script>
