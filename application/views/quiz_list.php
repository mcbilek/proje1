 <div class="container">
<?php 
$logged_in=$this->session->userdata('logged_in');
			 
			
			?>
   
 <h3>Deneme Sınavları<?php if ($logged_in['gid']==1) { ?>  <a href="<?php echo site_url('user/switch_group');?>" class="btn btn-danger">Özel Üyeliğe Geç</a> <?php }?> </h3>
    <?php 
	if($logged_in['su']=='1'){
		?>
		<div class="row">
 
  <div class="col-lg-6">
    <form method="post" action="<?php echo site_url('quiz/index/0/'.$list_view);?>">
	<div class="input-group">
    <input type="text" class="form-control" name="search" placeholder="<?php echo $this->lang->line('search');?>...">
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit"><?php echo $this->lang->line('search');?></button>
      </span>
	 
	  
    </div><!-- /input-group -->
	 </form>
  </div><!-- /.col-lg-6 -->
  <div class="col-lg-6">
  <p style="float:right;">
  <?php 
  if($list_view=='grid'){
	  ?>
	  <a href="<?php echo site_url('quiz/index/'.$limit.'/table');?>"><?php echo $this->lang->line('table_view');?></a>
	  <?php 
  }else{
	  ?>
	   <a href="<?php echo site_url('quiz/index/'.$limit.'/grid');?>"><?php echo $this->lang->line('grid_view');?></a>
	  
	  <?php 
  }
  ?>
  </p>
  
  </div>
</div><!-- /.row -->

<?php 
	}
?>

  <div class="row">
 
<div class="col-md-12">
<br> 
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
		<?php 
  if($list_view=='table'){
	  ?>
<table class="table table-bordered"
				data-search="true"
               data-toggle="table"
               data-show-export="true"
               data-show-columns="true">
<thead><tr>
 <th data-sortable="true">#</th>
 <th data-sortable="true"><?php echo $this->lang->line('quiz_name');?></th>
<th data-sortable="true"><?php echo $this->lang->line('noq');?></th>
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
 <td><?php echo $val['quid'];?></td>
 <td><?php echo substr(strip_tags($val['quiz_name']),0,50);?></td>
<td><?php echo $val['noq'];?></td>
 <td>
<a href="<?php echo site_url('quiz/quiz_detail/'.$val['quid']);?>" class="btn btn-success"  ><?php echo $this->lang->line('attempt');?> </a>

<?php 
if($logged_in['su']=='1'){
	?>
			
<a href="<?php echo site_url('quiz/edit_quiz/'.$val['quid']);?>"><img src="<?php echo base_url('images/edit.png');?>"></a>
<a href="javascript:remove_entry('quiz/remove_quiz/<?php echo $val['quid'];?>');"><img src="<?php echo base_url('images/cross.png');?>"></a>
<?php 
}
?>
</td>
</tr>

<?php 
}
?>
</table>

  <?php 
  }else{
	  ?>
	  <?php 
if(count($result)==0){
	?>
<?php echo $this->lang->line('no_record_found');?>
	<?php
}
$cc=0;
$colorcode=array(
'success',
'warning',
'info',
'danger'
);
$colorcode2=array(
'success',
'warning',
'info',
'#e0c3c3'
);
$colorcode3=array(
'success',
'warning',
'info',
'#edcbcb'
);
?>
<!-- otomatik deneme -->
<div class="col-md-4 text-center">
<div class="panel panel-#edcbcb panel-pricing" style="border:  5px solid transparent; border-color: #a94442;">
<div class="panel-heading" style="background-color:#f6b1b1;">
<i class="fa fa-desktop"></i>
<h3>Otomatik Deneme</h3>
                        </div>
                        <div class="panel-body text-center" style="background-color: #ffdfdf;">
                            <p><strong>Size Özel Otomatik Deneme</strong></p>
                        </div>
                        <ul class="list-group text-center">
                            <li class="list-group-item" style="background-color: #ffdfdf;"><i class="fa fa-check"></i> <?php echo $this->lang->line('noq');?>:  100</li>
                            <li class="list-group-item" style="background-color: #ffdfdf;"><i class="fa fa-check"></i> Sistem size özel deneme sınavı oluşturur.</li>
                            </ul>
                        <div class="panel-footer" style="background-color:#f6b1b1;">
                         
						 
<a href="<?php echo site_url('quiz/otomatik_deneme');?>" class="btn btn-danger">Sınav Oluştur</a>

<?php 
if($logged_in['su']=='1'){
	?>
			
<a href="<?php echo site_url('quiz/edit_quiz/'.$val['quid']);?>"><img src="<?php echo base_url('images/edit.png');?>"></a>
<a href="javascript:remove_entry('quiz/remove_quiz/<?php echo $val['quid'];?>');"><img src="<?php echo base_url('images/cross.png');?>"></a>
<?php 
}
?>


                        </div>
                    </div>
                </div>
                <!-- /otomatik deneme --> 
<?php
foreach($result as $key => $val){
?>
	  
	                <!-- item -->
                <div class="col-md-4 text-center">
                    <div class="panel panel-<?php echo $colorcode[$cc];?> panel-pricing">
                        <div class="panel-heading">
                            <i class="fa fa-desktop"></i>
                            <h3><?php echo substr(strip_tags($val['quiz_name']),0,50);?></h3>
                        </div>
                        <div class="panel-body text-center">
                            <p><strong><?php echo $this->lang->line('duration');?> <?php echo $val['duration'];?></strong></p>
                        </div>
                        <ul class="list-group text-center">
                            <li class="list-group-item"><i class="fa fa-check"></i> <?php echo $this->lang->line('noq');?>:  <?php echo $val['noq'];?></li>
                            <li class="list-group-item"><i class="fa fa-check"></i> <?php echo $this->lang->line('maximum_attempts');?>: <?php echo $val['maximum_attempts'];?></li>
                            </ul>
                        <div class="panel-footer">
                         
						 
<a href="<?php echo site_url('quiz/quiz_detail/'.$val['quid']);?>" class="btn btn-success"  ><?php echo $this->lang->line('attempt');?> </a>

<?php 
if($logged_in['su']=='1'){
	?>
			
<a href="<?php echo site_url('quiz/edit_quiz/'.$val['quid']);?>"><img src="<?php echo base_url('images/edit.png');?>"></a>
<a href="javascript:remove_entry('quiz/remove_quiz/<?php echo $val['quid'];?>');"><img src="<?php echo base_url('images/cross.png');?>"></a>
<?php 
}
?>


                        </div>
                    </div>
                </div>
                <!-- /item --> 
	  
	  
	  <?php 
	  if($cc >= 4){
	  $cc=0;
	  }else{
	  $cc+=1;
	  }
	  
}?>

</div>
<div class="col-md-12">
<br> 
<hr><br>
<h3>Konulara Göre Soru Çözümü</h3>
<br><br>
<?php 
foreach($calisma_result as $key => $val){
    ?>
	  
	                <!-- item -->
                <div class="col-md-4 text-center">
                    <div class="panel panel-<?php echo $colorcode[$cc];?> panel-pricing">
                        <div class="panel-heading">
                            <i class="fa fa-desktop"></i>
                            <h5><?php echo $val['category_name'];?></h5>
                            Toplam Soru Sayısı:<strong><?php echo $val['soru_adet'];?></strong>
                        </div>
                        <div style="height: 30px;padding:0" class="panel-heading"><h4 style="padding-top: 6px">Kaynaklar</h4></div>
                        <?php
                        //kaynakları ekliyoruz
                        $notvar = false;
                        foreach ($calisma_kaynak as $anahtar => $deger) {
                            if ($deger['kategori_id'] == $val['cid']) {
                                $tur = $deger['kaynak_tur'];
                                $kay_id=$deger['kaynak_id'];
                                if ($tur == 0) {
                                    $notvar = true;
                                    $i ++;
                                    $anan = $deger['dosya_adi'];
                                    $baban = $deger['dosya_aciklama'];
                                    echo $i . "-";
                      ?>
    					<a target="_blank" href="<?php echo base_url("upload/$anan");?>"><?php echo $baban;?></a>
    					<?php if($logged_in['su']=='1') {?>
    					<a title="Sil" href="<?php echo base_url('index.php/genel/kaynak_sil/')."/".$anan."/".$kay_id;?>"><img src="<?php echo base_url('images/cross.png');?>"></a>
    					<p>
                       <?php
                      } else {
                          echo "<br>";
                      }
                                }
                            }
                        }
                        if (! $notvar)
                            echo "Kaynak Eklenmemiş";
                        $i = 0;
                        ?>
                        
					<div style="height: 30px;padding:0" class="panel-heading"><strong><h4 style="padding-top: 6px">Ders Notları</h4></strong></div>
                        <?php
                        //ders notlarını ekliyoruz
                        $dersnotuvar=false;
                        foreach ($calisma_kaynak as $anahtar => $deger) {
                            if ($deger['kategori_id'] == $val['cid']) {
                                $tur = $deger['kaynak_tur'];
                                $kay_id=$deger['kaynak_id'];
                                if ($tur == 1) {
                                    $dersnotuvar=true;
                                    $i ++;
                                    $dosya_adi = $deger['dosya_adi'];
                                    $aciklama = $deger['dosya_aciklama'];
                                    echo $i . "-";
                       ?>
    					<a target="_blank" href="<?php echo base_url("upload/$dosya_adi");?>"><?php echo $aciklama;?></a>
    					<?php if($logged_in['su']=='1') {?>
    					<a title="Sil" href="<?php echo base_url('index.php/genel/kaynak_sil/')."/".$dosya_adi."/".$kay_id;?>"><img src="<?php echo base_url('images/cross.png');?>"></a>
    					<p>
                       <?php
                       } else {
                           echo "<br>";
                       }
                                }
                            }
                        }
                        if (! $dersnotuvar)
                            echo "Ders Notu Eklenmemiş";
                        else
                            $dersnotuvar=false;
                            
                        $i = 0;
                        ?>
                        
                        <form method="post" action="<?php echo site_url('quiz/ders_calis');?>" style="margin-bottom: 0px;">
                        <input id="cat_id" type="hidden" name="kategori_id" value="<?php echo $val['cid'];?>">
                            
                            <p><p>
                        <div class="panel-footer">
                         
						 <button type="submit" class="btn btn-success">Soru Getir</button>
						 </form>

<?php 
if($logged_in['su']=='1'){
	?>
<!-- 
<a href="<?php echo site_url('quiz/edit_quiz/'.$val['quid']);?>"><img src="<?php echo base_url('images/edit.png');?>"></a>
<a href="javascript:remove_entry('quiz/remove_quiz/<?php echo $val['quid'];?>');"><img src="<?php echo base_url('images/cross.png');?>"></a>
 -->
	<?php 
}
?>

                        </div>
                    </div>
                </div>
                <!-- /item --> 
	  
	  
	  <?php 
	  if($cc >= 4){
	  $cc=0;
	  }else{
	  $cc+=1;
	  }
	  
}

  }
  ?>

</div>

</div>
<br><br>

<?php
if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; } ?>

<a href="<?php echo site_url('quiz/index/'.$back.'/'.$list_view);?>"  class="btn btn-primary"><?php echo $this->lang->line('back');?></a>
&nbsp;&nbsp;
<?php
 $next=$limit+($this->config->item('number_of_rows'));  ?>

<a href="<?php echo site_url('quiz/index/'.$next.'/'.$list_view);?>"  class="btn btn-primary"><?php echo $this->lang->line('next');?></a>





</div>