 <div class="container">

			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	   

  <div class="row">
    
<div class="col-md-10">

<div class="container"><h3>Ödeme Yöntemini Seçiniz </h3></div>
<div id="exTab1" class="container">	
<ul  class="nav nav-pills">
<li class="active"><a  href="#1a" data-toggle="tab">Kredi Kartı</a>
</li>
<li><a href="#2a" data-toggle="tab">Havale</a>
</li>

</ul>

<div class="tab-content clearfix">
<div class="tab-pane active" id="1a">
            
   	<br><br>
<div class="col-md-6">
<div class="login-panel panel panel-default">
<div class="panel-body"> 
<?php
if ($islemHazir!="1") {
?>
 Ücret: <strong>100,00 ?</strong><br>
 *Kredi kartı ile ödeme işlemlerinde adres girilmesi zorunludur.
 <br><br>
<div class="form-group">
	<form method="post" action="<?php echo site_url('payment/krediKarti');?>"
	name="formKart">
					
	<!-- <label>Tc Kimlik Numaranız: </label> <input type="number" name="tcKimlik" class="form-control" required><br> -->
	
	
	<label>Adresiniz: </label><input type="text" name="adres" class="form-control" required ><br>
					<input type="submit" value="Ödeme İşlemine Geç" class="btn btn-info">
							</form>

						</div><br><br>
    			<?php 
} else {
    
		if($this->session->flashdata('iyzico')){
			echo $this->session->flashdata('iyzico');	
		}
}
		?>	
</div>
</div>    
</div>
</div>
<div class="tab-pane" id="2a">
         
           
   	<br><br>
<div class="col-md-7">
<div class="login-panel panel panel-default">
<div class="panel-body"> 
 Ücret: ? 100,00 TL<br><br>
<div class="form-group">
	<form method="post" action="<?php echo site_url('payment/odemeBildirimi/3/1');?>"
	name="f1">
	<label>Havale Yaptığınız Bankayı Seçiniz: </label> 
	<select class="selectpicker" data-width="fit" title="Havale Yaptığınız Bankayı Seçiniz" required  name="bankaAdi" id="bankaAdi">
                <option value="Ziraat">Ziraat Bankası</option>
                <option value="Garanti">Garanti Bankası</option>
                <option value="isBank">İş Bankası</option>
					</select> <br>
					
	<label>Havale Yapan Kişi: </label><input type="text" name="gonderen" id="gonderen" class="form-control" required>
	<label>Havale Açıklaması: </label><input type="text" name="aciklama" id="aciklama" class="form-control" ><br>
					<input type="submit" value="Ödeme Bildirimi Yap" class="btn">
							</form>
						</div><br><br>

    
</div>
</div>
						<h3>Hesap Numaralarımız</h3>
<h4>1-Ziraat Bankası</h4>
<b>İsim</b>: Deneme Deneme , <b>IBAN</b>: TR680006200000222990028402<br>
<h4>2-Garanti Bankası</h4>
<b>İsim</b>: Deneme Deneme , <b>IBAN</b>: TR680006200000222990028402<br>
<h4>3-İş Bankası</h4>
<b>İsim</b>: Deneme Deneme , <b>IBAN</b>: TR680006200000222990028402<br>
     
</div>
         
</div>



</div> 

</div> 
 
</div>
</div>

</div> 
<?php echo $OdemeFormuScripti; ?>