<script type="text/javascript">
function kurumDegistir(kurum_id,kurum_adi){
	yeniKurum();
	$('#kurumAdiYeniKurum').val(kurum_adi);
	$('#kurumIdYeniKurum').val(kurum_id);
}
function yeniKurum(){
	$('#kurumAdiYeniKurum').prop('disabled', false);
	$('#kurumIdYeniKurum').val('-1');
	$('#kurumAdiYeniKurum').val('');
	$('#kurumlarTable').bootstrapTable('scrollTo','bottom');
	$('#kurumAdiYeniKurum').focus();
}
function kadroDegistir(kodro_id,kadro_adi,uyelik_ucreti){
	yeniKadro();
	$('#ucretYeniKadro').val(uyelik_ucreti);
	$('#kadroAdiYeniKadro').val(kadro_adi);
	$('#kadroIdYeniKadro').val(kodro_id);
}
function yeniKadro(){
	$('#ucretYeniKadro').prop('disabled', false);
	$('#kadroAdiYeniKadro').prop('disabled', false);
	$('#bagliKurumId').prop('disabled', false);
	$('#bagliKurumId').selectpicker('refresh');
	$('#kadroIdYeniKadro').val('-1');
	$('#ucretYeniKadro').val('');
	$('#kadroAdiYeniKadro').val('');
	$('#kurumIdYeniKadro').val('-1');
	$('#kadro_list').bootstrapTable('scrollTo','bottom');
}

</script>
<div class="container">
 			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
 
 <h3><?php echo $title;?></h3>


<div class="col-md-5">
<br> 
 <h4 class="text-primary"><strong>Kurum-Kadro İlişki Tablosu</strong></h4>

<table id="table" 
				data-search="true"
               data-toggle="table"
               data-show-export="true"
               data-show-columns="true"
                data-height="800"
	>
<thead>
<tr>
 <th data-field="name" data-sortable="true">Kurum Adı</th>
 <th data-sortable="true">Kadro Adı </th>
 <th data-valign="middle">İşlem</th>
</tr>
</thead>
<?php 

foreach($kurum_kadro as $key => $val){
?>
<tr>
 <td><?php echo $val['kurum_adi'];?></td>
  <td><?php echo $val['kadro_adi'];?></td>
 <td ><form method="post" action="<?php echo site_url('genel/kk_sil');?>" name="sil" style="margin-bottom: 0px;">
 <input type="hidden" name="kadro_id" value="<?php echo $val['kadro_id'];?>" >
 <button type="submit" class="btn btn-primary btn-rounded my-0 center-block " > Sil</button>
	</form></td>
</tr>

<?php 
}
?>
</table>
 </div>
 
 <div id="kurumlarDiv" class="col-md-7">
<br> 
 <h4 class="text-primary"><strong>Kurum Listesi</strong></h4>

<table id="kurumlarTable" 
				data-search="true"
               data-toggle="table"
                data-height="350"
	>
<thead>
<tr>
 <th data-field="name" data-sortable="true">Kurum Adı</th>
 <th data-valign="middle">İşlem</th>
</tr>
</thead>
<?php 

foreach($kurum_list as $key => $val){
?>
<tr>
 <td><?php echo $val['kurum_adi'];?></td>
 <td >
	<form method="post" action="<?php echo site_url('genel/kurum_aktifpasif');?>" name="sil" style="margin-bottom: 0px;">
 <input type="hidden" name="kurum_id" value="<?php echo $val['kurum_id'];?>" >
 <input type="hidden" name="yenidurum" value="<?php echo $val['aktifmi']==1 ? "0" : "1";?>" >
 <button type="submit" class="btn <?php echo $val['aktifmi']==1 ? "btn-primary" : "btn-success";?> btn-rounded" ><span class="glyphicon glyphicon-wrench"></span> <?php echo $val['aktifmi']==1 ? "Pasif Yap" : "Aktif Yap";?></button>
  <button type="button" onClick="javascript:kurumDegistir(<?php echo "'".$val['kurum_id']."','".$val['kurum_adi']."'";?>)" class="btn btn-info " ><span class="glyphicon glyphicon-edit"></span> Değiştir</button>
	</form>
	</td>
</tr>

<?php 
}
?>
<tr>
    <td>
    <form method="post" action="<?php echo site_url('genel/kurum_ekle_guncelle');?>" id="kurumEkleForm" style="margin-bottom: 0px;">
        <input type="hidden" class="form-control" name="kurumIdYeniKurum" id="kurumIdYeniKurum" type="text">
        <input class="form-control" name="kurumAdiYeniKurum" id="kurumAdiYeniKurum" type="text" placeholder="Kurum Adı" disabled>
    </td>
    <td>
        <button onClick="javascript:yeniKurum()" class="btn btn-warning " ><span class="glyphicon glyphicon-plus"></span> Yeni</button>
        <button type="submit" onClick="javaScript:$( '#kurumEkleForm' ).submit();"  class="btn btn-success" ><span class="glyphicon glyphicon-ok"></span> Kaydet</button>
    </form>
    </td>
</tr>
</table>
<br>
<h4 class="text-primary"><strong>Kadro Listesi</strong></h4>
<table id="kadro_list" 
		data-toggle="table" 
		data-height="400"
		data-search="true"
		>
<thead>
<tr>
 <th data-field="kadro" data-width="%30" data-sortable="true">Kadro</th>
 <th data-field="ucret" data-width="%15" data-sortable="true">Ücret</th>
 <th data-width="%35">Durum</th>
 <th data-width="%20">İşlem</th>
</tr>
</thead>
<?php 

foreach($kadro_list as $key => $val){
?>
<tr>
 <td><?php echo $val['kadro_adi'];?></td>
 <td><?php echo $val['uyelik_ucreti'];?></td>
 <td >
	<form method="post" id="form<?php echo $val['kadro_id'];?>" action="<?php echo site_url('genel/kadro_aktifpasif');?>" name="sil" style="margin-bottom: 0px;">
 <input type="hidden" name="kadro_id" value="<?php echo $val['kadro_id'];?>" >
 <input type="hidden" name="yenidurum" value="<?php echo $val['aktifmi']==1 ? "0" : "1";?>" >
 <button type="submit" class="btn <?php echo $val['aktifmi']==1 ? "btn-primary" : "btn-success";?> " > <span class="glyphicon glyphicon-wrench"></span> <?php echo $val['aktifmi']==1 ? "Pasif Yap" : "Aktif Yap";?></button>
 <td>
 <button type="button" onClick="javascript:kadroDegistir(<?php echo "'".$val['kadro_id']."','".$val['kadro_adi']."','".$val['uyelik_ucreti']."'";?>)" class="btn btn-info " ><span class="glyphicon glyphicon-edit"></span> Değiştir</button>
 </td>
	</form>
	</td>
</tr>

<?php 
}
?>
    
<tr>
    <td>
        <input form="yeniKadroForm" class="form-control" name="kadroIdYeniKadro" id="kadroIdYeniKadro" type="hidden" value="-1">
        <input form="yeniKadroForm" class="form-control" name="kadroAdiYeniKadro" id="kadroAdiYeniKadro" type="text" placeholder="Kadro Adı Giriniz	" disabled>
    </td>
        <td>
        <input form="yeniKadroForm" class="form-control" name="ucretYeniKadro" id="ucretYeniKadro" type="text" placeholder="Ücret" disabled>
    </td>
    <td>
		<select form="yeniKadroForm" class="form-control selectpicker" id="bagliKurumId" name="bagliKurumId" title="Kurum Seçiniz" required disabled>
					<?php
    foreach ($kurum_list as $key => $val) {
        ?>
                						
                <option value="<?php echo $val['kurum_id'];?>">
                <?php echo $val['kurum_adi'];?> </option>
                						<?php
    }
    ?>
					</select>
    </td>
    <td>
        <button type="button" onClick="javascript:yeniKadro()" class="btn btn-warning" ><span class="glyphicon glyphicon-plus"></span></button>  
        <button type="submit" onClick="javaScript:$( '#yeniKadroForm' ).submit();" class="btn btn-success" ><span class="glyphicon glyphicon-ok"></span></button>
    </td>
</tr>
</table>
<form method="post" id="yeniKadroForm" action="<?php echo site_url('genel/kadro_ekle_guncelle');?>" style="margin-bottom: 0px;">
    </form>
 </div>
 

<div class="col-md-8">
<br> 
 <h4 class="text-primary"><strong>Kurum/Kadro/Kategori İlişki Tablosu</strong></h4>

<table id="table" 
				data-search="true"
               data-toggle="table"
               data-show-export="true"
               data-show-columns="true"
	>
<thead>
<tr>
 <th data-field="name" data-sortable="true">Kurum Adı</th>
 <th data-sortable="true">Kadro Adı </th>
 <th data-sortable="true">Kategori Adı</th>
 <th data-sortable="true">Oto Deneme<br>Soru Ad.</th>
 <th data-valign="middle">İşlem</th>
</tr>
</thead>
<?php 

foreach($kurum_kadro_kat as $key => $val){
?>
<tr>
 <td><?php echo $val['kurum_adi'];?></td>
  <td><?php echo $val['kadro_adi'];?></td>
  <td><?php echo $val['category_name'];?></td>
  <td><?php echo $val['soru_adet'];?></td>
 <td ><form method="post" action="<?php echo site_url('genel/kkk_sil');?>" name="sil" style="margin-bottom: 0px;">
 <input type="hidden" name="kat_kadro_id" value="<?php echo $val['kat_kadro_id'];?>" >
 <button type="submit" class="btn btn-primary btn-rounded my-0 center-block " > Sil</button>
	</form></td>
</tr>

<?php 
}
?>
</table>
 </div>
 <div class="col-md-4">
<br> 
 <h4 class="text-primary"><strong>Kurum/Kadro/Kategori İlişkisi Ekleme</strong></h4><br><br><p>
		<div class="login-panel panel panel-default">
		<div class="panel-body">
		<form role="form" data-toggle="validator" method="post" id="kkk_form" class="form-group" action="<?php echo site_url('genel/kkk_ekle');?>">
			<div class="form-group">
				<label>Kurum</label>
				<p>
					<select class="form-control selectpicker" name="kurum_id"
						id="kurum_id" title="Kurum" required>
					<?php
    foreach ($kurum_list as $key => $val) {
        ?>
                						
                <option value="<?php echo $val['kurum_id'];?>">
                <?php echo $val['kurum_adi'];?> </option>
                						<?php
    }
    ?>
					</select>
			<p>
				<label>Kadro</label>
					<select class="form-control selectpicker" name="kadro_id"
						id="kadro_id" title="Kadro" required>
					<?php
    foreach ($kadro_list as $key => $val) {
        ?> 
                						
                <option value="<?php echo $val['kadro_id'];?>">
                <?php echo $val['kadro_adi'];?> </option>
                						<?php
    }
    ?>
					</select>
						<p>
				<label>Kategori/Konu</label>
					<select class="form-control selectpicker" name="kategori_id"
						id="kategori_id" title="Kategori" required>
					<?php
	foreach ($kategori_list as $key => $val) {
        ?> 
                <option value="<?php echo $val['cid'];?>">
                <?php echo $val['category_name'];?> </option>
                						<?php
    }
    ?>
					</select>
					<p>
					<label for="inputEmail">Oto Deneme Soru Sayısı</label>
					<input type="number" value="0" class="form-control" name="soru_sayisi" required>
					<p>
					
					<button type="submit" class="btn btn-primary" > Kaydet</button>
					</form>
			</div>
			</div>
		</div>


	</div>


</div>
