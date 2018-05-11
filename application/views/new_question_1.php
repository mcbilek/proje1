 <div class="container">

   
 <h3><?php echo $title;?></h3>
   
 

  <div class="row">
     <form method="post" action="<?php echo site_url('qbank/new_question_1/'.$nop);?>">
	
<div class="col-md-12">
<br> 
 <div class="login-panel panel panel-default">
		<div class="panel-body"> 
	
	
	
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
		
		
		
				<div class="form-group">	 
					
<?php echo $this->lang->line('multiple_choice_single_answer');?>
			</div>

			
			<div class="form-group">	 
					<label   ><?php echo $this->lang->line('select_category');?></label> 
					<select class="form-control" name="cid">
					<?php 
					foreach($category_list as $key => $val){
						?>
						
						<option value="<?php echo $val['cid'].'"'; echo $val['cid']==$sel_cat_id ? "selected" : ""; ?>><?php echo $val['category_name'];?></option>
						<?php 
					}
					?>
					</select>
			</div>
			
			
			<div class="form-group">	 
					<label   ><?php echo $this->lang->line('select_level');?></label> 
					<select class="form-control" name="lid">
					<?php 
					foreach($level_list as $key => $val){
						?>
						
						<option value="<?php echo $val['lid'];?>"><?php echo $val['level_name'];?></option>
						<?php 
					}
					?>
					</select>
			</div>

			
			

			<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('question');?></label> 
					<textarea  name="question" rows="17" class="form-control"   ></textarea>
			</div>
		<?php 
		for($i=1; $i<=$nop; $i++){
			?>
			<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('options');?> <?php echo $i;?>)</label> <br>
					<div class="radio"><label><input type="radio" name="score" value="<?php echo $i-1;?>" <?php if($i==1){ echo 'checked'; } ?> > Doğru Cevap</label> 
					<?php if ($nop==5) { ?> 
					&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="gerekirse_cikar" value="<?php echo $i-1;?>" > Gerekirse Çıkar</label></div> 
					<?php } ?>
					<input type="text"  name="option[]"  class="form-control">
			</div>
		<?php 
		}
		?>
			<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('description');?></label> 
					<textarea  name="description" rows="30" class="form-control"></textarea>
			</div>
 
	<button class="btn btn-default" type="submit">Kaydet</button>
 
		</div>
</div>
 
 
 
 
</div>
      </form>
</div>

 



</div>