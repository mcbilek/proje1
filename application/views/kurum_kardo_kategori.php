 <div class="container">
 			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
 
 <h3><?php echo $title;?></h3>


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
					</select><p>
					<button type="submit" class="btn btn-primary" > Kaydet</button>
					</form>
			</div>
			</div>
		</div>


	</div>


</div>
