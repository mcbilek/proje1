 <div class="container">

   
 <h3><?php echo $title;?></h3>
   
 

  <div class="row">
     <form method="post" action="<?php echo site_url('quiz/ders_calis');?>">
	
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
			<label for="inputEmail"  >Kategori Seçiniz</label> 
			<select class="form-control" name="kategori_id">
			<option value="-1">Tümü</option>
				<?php 
				foreach($category_list as $key => $val){
					?>
					
					<option value="<?php echo $val['cid'].'"'; ?>><?php echo $val['category_name'];?></option>
					<?php 
				}
				?>
			</select>
			<label for="inputEmail"  >Soru Adedi</label> 
			<input type="number" value="20" required  name="soruAdet"  class="form-control"   > 
			</div>
			 
			<br><br>
 
			<button class="btn btn-default" type="submit">Soru Çözmeye Başla</button>
 
		</div>
</div>
 
 
 
 
</div>
      </form>
</div>

 



</div>
