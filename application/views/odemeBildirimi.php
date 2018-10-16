<style>
.nav-pills > .active > a, .nav-pills > .active > a:hover {
    background-color: red;
}
</style>
 <div class="container">

			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		$logged_in=$this->session->userdata('logged_in');
		$iller = array('Girilmedi','Adana', 'Adıyaman', 'Afyon', 'Ağrı', 'Amasya', 'Ankara', 'Antalya', 'Artvin',
		    'Aydın', 'Balıkesir', 'Bilecik', 'Bingöl', 'Bitlis', 'Bolu', 'Burdur', 'Bursa', 'Çanakkale',
		    'Çankırı', 'Çorum', 'Denizli', 'Diyarbakır', 'Edirne', 'Elazığ', 'Erzincan', 'Erzurum', 'Eskişehir',
		    'Gaziantep', 'Giresun', 'Gümüşhane', 'Hakkari', 'Hatay', 'Isparta', 'Mersin', 'İstanbul', 'İzmir',
		    'Kars', 'Kastamonu', 'Kayseri', 'Kırklareli', 'Kırşehir', 'Kocaeli', 'Konya', 'Kütahya', 'Malatya',
		    'Manisa', 'Kahramanmaraş', 'Mardin', 'Muğla', 'Muş', 'Nevşehir', 'Niğde', 'Ordu', 'Rize', 'Sakarya',
		    'Samsun', 'Siirt', 'Sinop', 'Sivas', 'Tekirdağ', 'Tokat', 'Trabzon', 'Tunceli', 'Şanlıurfa', 'Uşak',
		    'Van', 'Yozgat', 'Zonguldak', 'Aksaray', 'Bayburt', 'Karaman', 'Kırıkkale', 'Batman', 'Şırnak',
		    'Bartın', 'Ardahan', 'Iğdır', 'Yalova', 'Karabük', 'Kilis', 'Osmaniye', 'Düzce');
		?>	   

  <div class="row">
    
<div class="col-md-12">

			<div class="container">
				<h3>Ödeme Yöntemini Seçiniz</h3>
				<br>
				<form method="post" data-toggle="validator"
					action="<?php echo site_url('payment/indirimKodu');?>">
					<div class="row">
						<div class="col-sm-4">
						<div class="input-group">
							<label for="indirimKodu">İndirim Kodu: </label> 
							<input type="text" name="indirimKodu" class="input input-sm" required>
						    <span class="input-group-btn"><button class="btn btn-info" type="submit">Uygula</button></span>
						</div>
						</div>
					</div>
				</form>

			</div>
		</div>
<div id="exTab1" class="container">	
<ul  class="nav nav-pills red">
<li class="active"><a style="background-color:  #286090; color:  white;" href="#1a" data-toggle="tab">Kredi Kartı</a>
</li>
<li><a style="background-color:  #C9302C; color:  white;" href="#2a" data-toggle="tab">Havale</a>
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
 Ücret: <strong><?php echo $ucret;?>,00 ₺</strong><br>
<div class="form-group">
	<form method="post" action="<?php echo site_url('payment/krediKarti');?>"
	name="formKart">
					
	<!-- <label>Tc Kimlik Numaranız: </label> <input type="number" name="tcKimlik" class="form-control" required><br> -->
	
	
	<!-- <label>Adresiniz: </label> --> <input type="hidden" name="adres" class="form-control" value="<?php if ($iller[$logged_in['il']]!='') echo $iller[$logged_in['il']]; else echo "Girilmedi";?>" required ><br>
					<input type="submit" value="Ödeme İşlemine Geç" class="btn btn-info btn-lg">
							</form>
<br>
 *Kredi kartı ile ödeme işlemi, tamamen güvenli olarak kartınıza ait hiç bir bilgi bizim sistemimizde tutulmadan doğrudan ilgili bankanın sistemine girilerek gerçekleştirilir.
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
<div class="col-md-6">
<div class="login-panel panel panel-default">
<div class="panel-body"> 
Ücret: <strong><?php echo $ucret;?>,00 ₺</strong><br><br>
<div class="form-group">
	<form method="post" action="<?php echo site_url('payment/odemeBildirimi/3/1');?>"
	name="f1">
	<label>Havale Yaptığınız Bankayı Seçiniz: </label> 
	<select class="selectpicker" data-width="fit" title="Havale Yaptığınız Bankayı Seçiniz" required  name="bankaAdi" id="bankaAdi">
                <option value="Halk">Halk Bankası</option>
                <option value="Vakif">Vakıfbank</option>
                <option value="Ziraat">Ziraat Bankası</option>
					</select> <br>
					
	<label>Havale Yapan Kişi: </label><input type="text" name="gonderen" id="gonderen" class="form-control" required>
	<label>Havale Açıklaması: </label><input type="text" name="aciklama" id="aciklama" class="form-control" ><br>
					<input type="submit" value="Ödeme Bildirimi Yap" class="btn btn-info btn-md">
							</form>
						</div><br><br>

    
</div>
</div>

</div>
<div class="col-md-6">
						<h3>Hesap Numaramız</h3>
<h4>1- Halk Bankası</h4>
<b>İsim</b>: Gülşen Şahan, <b>IBAN</b>: <input type="text" size="35" value="TR640001200939900001016527" disabled> <br>
<b>Hesap-Şube:              </b> <input type="text" size="49" value="01016527 (399 KAZIMKARABEKİR / ANKARA ŞB.)" disabled> <br>
<h4>2- Vakıfbank</h4>
<b>İsim</b>: Nurben Dönmez, <b>IBAN</b>: <input type="text" size="35" value="TR550001500158007307531976" disabled> <br>
<b>Hesap-Şube:              </b> <input type="text" size="51" value="00158007307531976 (S00137-Şişli/İstanbul)" disabled> <br>
<h4>3- Ziraat Bankası</h4>
<b>İsim</b>: Nurben Dönmez , <b>IBAN</b>: <input type="text" size="35" value="TR460001000484592191065001" disabled> <br>
<b>Hesap-Şube:              </b> <input type="text" size="52" value="59219106-5001 (484-Şişli/İstanbul)" disabled> <br>
</div>
         
</div>



</div> 

</div> 
<div class="row">
    <div class="col-md-6 text-center"><h4>Özel Üyelik Avantajları</h4><img class="img-responsive" src="<?php echo site_url('images/ozel_avantaj.jpeg');?>"></div>
</div>

</div>
</div>

</div> 

<?php echo $OdemeFormuScripti; ?>