 
 <div class="container">
  
 <h3><?php $logged_in=$this->session->userdata('logged_in'); if ($logged_in['gid']!=3) { echo $title;} else {echo "Zaten Özel Gruptasınız, grup değiştiremezsiniz.";}?></h3>
   
     
   <div class="row">
     
    <?php 
    $cc=0;
$colorcode=array(
'success',
'warning',
'info',
'danger'
);
    foreach($group_list as $k => $val){
        if ($logged_in['gid']!=3) {
   ?>
	                <!-- item -->
                <div class="col-md-6 text-center">
                    <div class="panel panel-<?php echo $colorcode[$cc];?> panel-pricing">
                        <div class="panel-heading">
                            <i class="fa fa-desktop"></i>
                            <h3><?php echo $val['group_name'];?></h3>
                        </div>
                        <div class="panel-body text-center">
                          
                          <?php 
                          echo $val['description'];?>
                          <hr>
                           
<?php 
 
if($val['price']==0){
echo "-";
}else{
    echo $this->config->item('base_currency_prefix').' '.$uyelik_ucreti.' '.$this->config->item('base_currency_sufix'); 
}
?>
                           
                        </div>
                        
                        <div class="panel-footer">
                         
						 
<a href="<?php echo site_url('user/upgid/'.$val['gid']);?>" class="btn btn-success"  ><?php echo $this->lang->line('subscribe');?> </a>
 

                        </div>
                    </div>
                </div>
                <!-- /item --> 
	  
	  
	  <?php 
        }
	  if($cc >= 4){
	  $cc=0;
	  }else{
	  $cc+=1;
	  }
	  
    }
    ?>
</div>
<div class="row">
    <div class="col-md-6 text-center"><img class="img-responsive" src="<?php echo site_url('images/soru_sayisi.jpeg');?>"></div>
    <div class="col-md-6 text-center"><h4>Özel Üyelik Avantajları</h4><img class="img-responsive" src="<?php echo site_url('images/ozel_avantaj.jpeg');?>"></div>
</div>

 



</div>
<script>
 
</script>
