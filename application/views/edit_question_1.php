﻿ <div class="container">

   
 <h3><?php echo $title;?></h3>
   
 

  <div class="row">
     <form method="post" action="<?php echo site_url('qbank/edit_question_1/'.$question['qid']);?>">
	
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
					
<?php echo $this->lang->line('multiple_choice_single_answer');?>
			</div>

 	
			<div class="form-group">	 
					<label   ><?php echo $this->lang->line('select_category');?></label> 
					<select class="form-control" name="cid">
					<?php 
					foreach($category_list as $key => $val){
						?>
						
						<option value="<?php echo $val['cid'];?>"  <?php if($question['cid']==$val['cid']){ echo 'selected'; } ?> ><?php echo $val['category_name'];?></option>
						<?php 
					}
					?>
					</select>
			</div>
			<div class="form-group">	 
					<label   >2. Kategori</label> 
					<select class="form-control" name="cid2">
					<?php 
					foreach($category_list as $key => $val){
						?>
						
						<option value="<?php echo $val['cid'];?>"  <?php if($question['cid2']==$val['cid']){ echo 'selected'; } ?> ><?php echo $val['category_name'];?></option>
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
						
						<option value="<?php echo $val['lid'];?>" <?php if($question['lid']==$val['lid']){ echo 'selected'; } ?> ><?php echo $val['level_name'];?></option>
						<?php 
					}
					?>
					</select>
			</div>

			
			

			<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('question');?></label> 
					<textarea  name="question" rows="17" class="form-control"   ><?php echo $question['question'];?></textarea>
			</div>
			<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('description');?></label> 
					<textarea  name="description"  rows="30" class="form-control"><?php echo $question['description'];?></textarea>
			</div>
		<?php 
		foreach($options as $key => $val){
			?>
			<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('options');?> <?php echo ($key+1);?>)</label> <br>
					<div class="radio"><label><input type="radio" name="score" value="<?php echo $key;?>" <?php if($val['score']==1){ echo 'checked'; } ?> > Doğru Cevap </label>
					<?php if (count($options)==5) ?> 
					&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="gerekirse_cikar" value="<?php echo $key;?>" <?php if($val['gerekirse_cikar']==1){ echo 'checked'; } ?> > Gerekirse Çıkar</label></div> 
					<input type="text"  name="option[]"  class="form-control" value="<?php echo $val['q_option'];?>" >
			</div>
		<?php 
		}
		?>

 
	<button class="btn btn-default" type="submit"><?php echo $this->lang->line('submit');?></button>
 
		</div>
</div>
 
 
 
 
</div>
      </form>
	  
	  
	  	  <div class="col-md-3">
		
		
			<div class="form-group">	 
			<table class="table table-bordered">
			<tr><td><?php echo $this->lang->line('no_times_corrected');?></td><td><?php echo $question['no_time_corrected'];?></td></tr>
			<tr><td><?php echo $this->lang->line('no_times_incorrected');?></td><td><?php echo $question['no_time_incorrected'];?></td></tr>
			<tr><td><?php echo $this->lang->line('no_times_unattempted');?></td><td><?php echo $question['no_time_unattempted'];?></td></tr>

			</table>

			</div>


	  </div>
</div>

 



</div>