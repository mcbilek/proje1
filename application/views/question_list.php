 <div class="container">

   
 <h3><?php echo $title;?></h3>
    <div class="row">
 
  <div class="col-lg-6">
    <form method="post" action="<?php echo site_url('qbank/index/');?>">
	<div class="input-group">
    <input type="text" class="form-control" name="search" placeholder="<?php echo $this->lang->line('search');?>...">
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit"><?php echo $this->lang->line('search');?></button>
      </span>
	 
	  
    </div><!-- /input-group -->
	 </form>
  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->


  <div class="row">
 
<div class="col-md-12">
<br> 
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
						<div class="form-group">	 
					<form class="form-inline" method="post" action="<?php echo site_url('qbank/pre_question_list/'.$limit.'/'.$cid.'/'.$lid);?>">
					<select class="form-control"  name="cid">
					<option value="0"><?php echo $this->lang->line('all_category');?></option>
					<?php 
					foreach($category_list as $key => $val){
						?>
						
						<option value="<?php echo $val['cid'];?>" <?php if($val['cid']==$cid){ echo 'selected';} ?> ><?php echo $val['category_name'];?></option>
						<?php 
					}
					?>
					
					</select><select class="form-control"  name="lid">
				<option value="0"><?php echo $this->lang->line('all_level');?></option>
					<?php 
					foreach($level_list as $key => $val){
						?>
						
						<option value="<?php echo $val['lid'];?>"  <?php if($val['lid']==$lid){ echo 'selected';} ?> ><?php echo $val['level_name'];?></option>
						<?php 
					}
					?>
					</select>
					 <button class="btn btn-default" type="submit"><?php echo $this->lang->line('filter');?></button>
					 </form>
			</div>
	
<table class="table table-bordered" 				
				data-search="true"
               data-toggle="table"
               data-show-export="true"
               data-show-columns="true">
<thead><tr>
 <th data-sortable="true">#</th>
 <th data-sortable="true"><?php echo $this->lang->line('question');?></th>
<th data-sortable="true"><?php echo $this->lang->line('question_type');?></th>
<th data-sortable="true"><?php echo $this->lang->line('category_name');?> / <?php echo $this->lang->line('level_name');?></th>
 
<th data-sortable="true"><?php echo $this->lang->line('percent_corrected');?></th>
<th><?php echo $this->lang->line('action');?> </th>
</tr></thead>
<?php 
if(count($result)==0){
	?>
<tr>
 <td colspan="3"><?php echo $this->lang->line('no_record_found');?></td>
</tr>	
	
	
	<?php
}
foreach($result as $key => $val){
?>
<tr>
 <td>  <a href="javascript:show_question_stat('<?php echo $val['qid'];?>');">+</a>  <?php echo $val['qid'];?></td>
 <td><?php echo substr(strip_tags($val['question']),0,40);?>
 
 
 <span style="display:none;" id="stat-<?php echo $val['qid'];?>">
  
 
 <table class="table table-bordered">
<tr><td><?php echo $this->lang->line('no_times_corrected');?></td><td><?php echo $val['no_time_corrected'];?></td></tr>
<tr><td><?php echo $this->lang->line('no_times_incorrected');?></td><td><?php echo $val['no_time_incorrected'];?></td></tr>
<tr><td><?php echo $this->lang->line('no_times_unattempted');?></td><td><?php echo $val['no_time_unattempted'];?></td></tr>

</table>


 

 </span>
 
 
 
 </td>
<td><?php echo $val['question_type'];?></td>
<td><?php echo $val['category_name'];?> / <span style="font-size:12px;"><?php echo $val['level_name'];?></span></td>
 
<td><?php if($val['no_time_served']!='0'){ $perc=($val['no_time_corrected']/$val['no_time_served'])*100; 
?>

<div style="background:#eeeeee;width:100%;height:10px;"><div style="background:#449d44;width:<?php echo intval($perc);?>%;height:10px;"></div>
<span style="font-size:10px;"><?php echo intval($perc);?>%</span>

<?php
}else{ echo $this->lang->line('not_used');} ?></td>

<td>
<?php 
$qn=1;
if($val['question_type']==$this->lang->line('multiple_choice_single_answer')){
	$qn=1;
}
if($val['question_type']==$this->lang->line('multiple_choice_multiple_answer')){
	$qn=2;
}
if($val['question_type']==$this->lang->line('match_the_column')){
	$qn=3;
}
if($val['question_type']==$this->lang->line('short_answer')){
	$qn=4;
}
if($val['question_type']==$this->lang->line('long_answer')){
	$qn=5;
}


?>
<a href="<?php echo site_url('qbank/edit_question_'.$qn.'/'.$val['qid']);?>"><img src="<?php echo base_url('images/edit.png');?>" title="düzenle"></a>
<a href="javascript:remove_entry('qbank/remove_question/<?php echo $val['qid'];?>');"><img src="<?php echo base_url('images/delete.png');?>" title="sil"></a>
<a href="<?php echo site_url('qbank/soru_onay/'.$val['qid'])."/"; echo $val['aktifmi']=="1" ? "0" : "1";   ?>"><img src="<?php echo $val['aktifmi']=="1" ? base_url('images/cross.png').'" title="Onayı Kaldır"' : base_url('images/tick-icon.png').'" title="Onayla"'?>"></a>

</td>
</tr>

<?php 
}
?>
</table>
</div>

</div>


<?php
if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; } ?>

<a href="<?php echo site_url('qbank/index/'.$back.'/'.$cid.'/'.$lid);?>"  class="btn btn-primary"><?php echo $this->lang->line('back');?></a>
&nbsp;&nbsp;
<?php
 $next=$limit+($this->config->item('number_of_rows'));  ?>

<a href="<?php echo site_url('qbank/index/'.$next.'/'.$cid.'/'.$lid);?>"  class="btn btn-primary"><?php echo $this->lang->line('next');?></a>





<script>

function advanceconfig(){
	
	$('#advanceconfig').toggle();
	
}



</script>
<br><br><br><br>
