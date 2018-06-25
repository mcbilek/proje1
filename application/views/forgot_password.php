 <div class="container">

   
 
 
 



<div class="col-md-4">
</div>
<div class="col-md-4">

	<div class="login-panel panel panel-default">
		<div class="panel-body"> 
		<img src="<?php echo base_url('images/logo.png');?>">
		

			<form method="post" class="form-signin" action="<?php echo site_url('login/forgot');?>">
					<h2 class="form-signin-heading"><?php echo $this->lang->line('login');?></h2>
		<?php 
		if($this->session->flashdata('message')){
			?>
			<?php echo $this->session->flashdata('message');?>
		<?php	
		}
		?>				  <br><br>
			<div class="form-group">	 
					<label for="inputEmail"  >Cep Telefon Numaranızı Giriniz</label> 
					<input type="text" name="ceptel" value="" class="form-control input-medium bfh-phone" data-format="5dd ddddddd" placeholder="Cep Telefon Numaranızı Giriniz" required autofocus>
			</div>
			 <br>
			<div class="form-group">	  
					 
					<button class="btn btn-lg btn-primary btn-block" type="submit">Geçici Şifre Gönder</button>
			</div>
<?php 
if($this->config->item('user_registration')){
	?>
	<a href="<?php echo site_url('login/registration');?>"><?php echo $this->lang->line('register_new_account');?></a>
	&nbsp;&nbsp;&nbsp;&nbsp;
<?php
}
?>
	<a href="<?php echo site_url('login');?>"><?php echo $this->lang->line('login');?></a>

			</form>
		</div>
	</div>

</div>
<div class="col-md-4">


</div>



</div>