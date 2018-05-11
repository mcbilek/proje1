 <div class="container">

   
 <h3><?php echo $title;?></h3>
   
 

  <div class="row">
     <form method="post" action="<?php echo site_url('sendsms/send_newsms');?>">
	
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
			<label for="inputEmail"  ><?php echo $this->lang->line('sms_message');?></label> 
			<textarea row="3" required  name="sms_text"  class="form-control tinymce_cancel"></textarea> 
			</div>
			 
			<?php 
			if($user_id=='0'){
			?>
 
			 <input type="hidden" required  name="uid" value="0"   > 
			<div class="form-check">
          <input class="form-check-input" type="radio" name="smskime" id="herkes" value="-1" checked>
          <label class="form-check-label" for="herkes">
            Tüm Üyeler
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="smskime" id="ucretli" value="1">
          <label class="form-check-label" for="ucretli">
            Özel Üyeler
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="smskime" id="ucretsiz" value="3">
          <label class="form-check-label" for="ucretsiz">
            Ücretsiz Üyeler
          </label>
        </div>
			<br><br>
			<?php 
			}else{
			    $nq=$this->db->query("select * from savsoft_users where uid='$user_id'");
			    $nuser=$nq->row_array();
			
			?>
			 <?php echo $this->lang->line('send_to');?>: 
			 <?php echo $nuser['first_name'];?>  <?php echo $nuser['last_name'];?> (# <?php echo $nuser['uid'];?>)<br><br>
			<input type="hidden" required  name="notification_to[]" value="<?php echo $nuser['web_token'];?>"   > 
			<input type="hidden" required  name="notification_to[]" value="<?php echo $nuser['android_token'];?>"   > 
			<input type="hidden" required  name="tel_no" value="<?php echo str_replace(' ', '', $nuser['contact_no']);?>"   > 
			<input type="hidden" required  name="smskime" value="0"   > 
			<input type="hidden" required  name="uid" value="<?php echo $user_id;?>"   > 
			<?php 
			}
			?> 
	 
 
	<button class="btn btn-default" type="submit"><?php echo $this->lang->line('submit');?></button>
 
		</div>
</div>
 
 
 
 
</div>
      </form>
</div>

 



</div>
