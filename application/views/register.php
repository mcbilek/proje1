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
     <form role="form" data-toggle="validator" method="post" id="uyelikForm" class="form-group" action="<?php echo site_url('login/insert_user/');?>">
	
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
					<label for="inputEmail" class="control-label"><?php echo $this->lang->line('email_address');?></label> 
					<input type="email" id="inputEmail" name="email" class="form-control" placeholder="<?php echo $this->lang->line('email_address');?>" data-error="E-Mail adresi hatalı görünüyor" required autofocus>
			<div class="help-block with-errors"></div>
			</div>
			<div class="form-group">	  
					<label for="inputPassword" class="sr-only"><?php echo $this->lang->line('password');?></label>
					<input type="password" id="inputPassword" data-minlength="6" name="password"  class="form-control" data-error="En az 6 karakter olmalı" placeholder="<?php echo $this->lang->line('password');?>" required >
			 <div class="help-block with-errors"></div>
			 </div>
			 <div class="form-group">	  
					<label for="confirmPassword" class="sr-only">Tekrar Parola</label>
					<input type="password" id="confirmPassword" data-match-error="Şifreler eşleşmiyor" data-match="#inputPassword" name="confirmPassword"  class="form-control" placeholder="Tekrar Parola" required >
			 <div class="help-block with-errors"></div>
			 </div>
				<div class="form-group">	 
					<label for="inputEmail" class="sr-only"><?php echo $this->lang->line('first_name');?></label> 
					<input type="text"  name="first_name"  class="form-control" placeholder="<?php echo $this->lang->line('first_name');?>" required  autofocus>
			</div>
				<div class="form-group">	 
					<label for="inputEmail" class="sr-only"><?php echo $this->lang->line('last_name');?></label> 
					<input type="text"   name="last_name"  class="form-control" placeholder="<?php echo $this->lang->line('last_name');?>" required  autofocus>
			</div>
			<div class="form-group">	 
					<label for="inputEmail"><?php echo $this->lang->line('contact_no');?></label> 
					<input type="text" name="contact_no" class="form-control input-medium bfh-phone" data-format="5dd ddddddd" placeholder="<?php echo $this->lang->line('contact_no');?>"  required autofocus>
			</div>
			
						<div class="form-group">
							<label>Çalıştığınız Kurum</label> <p><select
								class="form-control selectpicker"   name="kurum_id" id="kurum_id" title="Çalıştığınız Kurum" required>
					<?php
					foreach ($kurum_list as $key => $val) {
                        ?>
                						
                <option value="<?php echo $val['kurum_id'];?>">
                <?php echo $val['kurum_adi'];?> </option>
                						<?php
                    }
                    ?>
					</select>
						</div>

						<div class="form-group">
							<label>Geçmek İstediğiniz Kadro</label> <select
								class="form-control selectpicker" name="kadro_id" id="kadro_id" title="Geçmek İstediğiniz Kadro" required>
					<?php
					foreach ($kadro_list as $key => $val) {
                        ?>
                						
                <option value="<?php echo $val['kadro_id'];?>">
                <?php echo $val['kadro_adi'];?> </option>
                						<?php
                    }
                    ?>
					</select>
						</div>
					<div class="form-group">
							<label>İl Seçiniz</label> 
							<select class="form-control selectpicker" title="Şehrinizi Seçiniz" name="sehir" required >
    <option value="1">Adana</option>
    <option value="2">Adıyaman</option>
    <option value="3">Afyonkarahisar</option>
    <option value="4">Ağrı</option>
    <option value="5">Amasya</option>
    <option value="6">Ankara</option>
    <option value="7">Antalya</option>
    <option value="8">Artvin</option>
    <option value="9">Aydın</option>
    <option value="10">Balıkesir</option>
    <option value="11">Bilecik</option>
    <option value="12">Bingöl</option>
    <option value="13">Bitlis</option>
    <option value="14">Bolu</option>
    <option value="15">Burdur</option>
    <option value="16">Bursa</option>
    <option value="17">Çanakkale</option>
    <option value="18">Çankırı</option>
    <option value="19">Çorum</option>
    <option value="20">Denizli</option>
    <option value="21">Diyarbakır</option>
    <option value="22">Edirne</option>
    <option value="23">Elazığ</option>
    <option value="24">Erzincan</option>
    <option value="25">Erzurum</option>
    <option value="26">Eskişehir</option>
    <option value="27">Gaziantep</option>
    <option value="28">Giresun</option>
    <option value="29">Gümüşhane</option>
    <option value="30">Hakkâri</option>
    <option value="31">Hatay</option>
    <option value="32">Isparta</option>
    <option value="33">Mersin</option>
    <option value="34">İstanbul</option>
    <option value="35">İzmir</option>
    <option value="36">Kars</option>
    <option value="37">Kastamonu</option>
    <option value="38">Kayseri</option>
    <option value="39">Kırklareli</option>
    <option value="40">Kırşehir</option>
    <option value="41">Kocaeli</option>
    <option value="42">Konya</option>
    <option value="43">Kütahya</option>
    <option value="44">Malatya</option>
    <option value="45">Manisa</option>
    <option value="46">Kahramanmaraş</option>
    <option value="47">Mardin</option>
    <option value="48">Muğla</option>
    <option value="49">Muş</option>
    <option value="50">Nevşehir</option>
    <option value="51">Niğde</option>
    <option value="52">Ordu</option>
    <option value="53">Rize</option>
    <option value="54">Sakarya</option>
    <option value="55">Samsun</option>
    <option value="56">Siirt</option>
    <option value="57">Sinop</option>
    <option value="58">Sivas</option>
    <option value="59">Tekirdağ</option>
    <option value="60">Tokat</option>
    <option value="61">Trabzon</option>
    <option value="62">Tunceli</option>
    <option value="63">Şanlıurfa</option>
    <option value="64">Uşak</option>
    <option value="65">Van</option>
    <option value="66">Yozgat</option>
    <option value="67">Zonguldak</option>
    <option value="68">Aksaray</option>
    <option value="69">Bayburt</option>
    <option value="70">Karaman</option>
    <option value="71">Kırıkkale</option>
    <option value="72">Batman</option>
    <option value="73">Şırnak</option>
    <option value="74">Bartın</option>
    <option value="75">Ardahan</option>
    <option value="76">Iğdır</option>
    <option value="77">Yalova</option>
    <option value="78">Karabük</option>
    <option value="79">Kilis</option>
    <option value="80">Osmaniye</option>
    <option value="81">Düzce</option>
</select>
						</div>
						<div class="form-group" hidden>
							<label><?php echo $this->lang->line('select_group');?></label> <select 
								class="form-control" name="gid" id="gid">
					<?php
    foreach ($group_list as $key => $val) {
        ?>
						
<option value="<?php echo $val['gid'];?>"
									<?php if($val['gid']==$gid){ echo 'selected'; } ?>>
<?php echo $val['group_name'];?> (
<?php echo $this->lang->line('price_');?>: 
<?php echo $val['price'];?> TL)</option>
						<?php
    }
    ?>
					</select>
						</div>





						<button class="btn btn-default" type="submit"><?php echo $this->lang->line('submit');?></button>
 &nbsp;&nbsp;&nbsp;&nbsp; <a href="<?php echo site_url('login');?>"><?php echo $this->lang->line('login');?></a>
		</div>
</div>
 
 
 
 
</div>
      </form>
</div>

 



</div>
<script>

</script>
