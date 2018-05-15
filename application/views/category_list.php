 <div class="container">
   
 <h3><?php echo $title;?></h3>


  <div class="row">
 
<div class="col-md-12">
<br> 
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
		<div id="message"></div>
		
		 <form method="post" action="<?php echo site_url('qbank/insert_category/');?>">
	
<table class="table table-bordered">
<tr>
 <th><?php echo $this->lang->line('category_name');?></th>
<th><?php echo $this->lang->line('action');?> </th>
</tr>
<?php 
if(count($category_list)==0){
	?>
<tr>
 <td colspan="3"><?php echo $this->lang->line('no_record_found');?></td>
</tr>	
	
	
	<?php
}

foreach($category_list as $key => $val){
?>
<tr>
 <td><input type="text"   class="form-control"  value="<?php echo $val['category_name'];?>" onBlur="updatecategory(this.value,'<?php echo $val['cid'];?>');" ></td>
<td>
 
<a href="<?php echo site_url('qbank/pre_remove_category/'.$val['cid']);?>"><img src="<?php echo base_url('images/cross.png');?>"></a>

</td>
</tr>

<?php 
}
?>
<tr>
 <td>
 
 <input type="text"   class="form-control"   name="category_name" value="" placeholder="<?php echo $this->lang->line('category_name');?>"  required ></td>
<td>
<button class="btn btn-default" type="submit"><?php echo $this->lang->line('add_new');?></button>
 
</td>
</tr>
</table>
</form>
</div>

</div>
<div class="col-md-4">
<h3>Ders Notu/Kaynak Ekle</h3>
			<div class="form-group">
			<?php echo form_open_multipart('qbank/do_upload');?>
			<label for="inputEmail"  >Kategori Seçiniz</label> 
			<select class="form-control" name="kategori_id">
				<?php 
				foreach($category_list as $key => $val){
					?>
					
					<?php echo '<option value="'.$val['cid'].'">'; ?><?php echo $val['category_name']."</option>";?>
					<?php 
				}
				?>
			</select><br>
			<label for="inputEmail"  >Tür Seçiniz </label><br> 
			<label class="radio-inline"><input type="radio" required name="kaynak_tur" value="0" >Kaynak</label>
			<label class="radio-inline"><input type="radio" name="kaynak_tur" value="1" >Ders Notu</label>
			<br><br>
			<label for="inputEmail"  >Dosya Açıklaması</label> 
			<input type="text"   class="form-control" name="dosya_aciklama" required>
			<br><label for="inputEmail"  >PDF Dosyası Seçiniz</label> 
			<input type="file" name="dosya" class="form-control-file" accept=".pdf" required><br>
			<button type="submit" class="btn btn-primary mb-2">Yükle</button> 
			</form>
			</div>
</div>

<div class="modal fade" id="BasariModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Site Mesajı</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Tamam">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h4>Dosya Başarıyla Yüklenmiştir.</h4>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary"	data-dismiss="modal">Tamam</button>
			</div>
		</div>
	</div>
</div>
<?php 
if($this->session->flashdata('showmodal')){
    ?>
    <script type="text/javascript">
		$('#BasariModal').modal('show');
	</script>
<?php
}
?>

</div>
