 
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
    <div class="col-md-6 text-center"><h4><strong>
    <p class="bg-primary">* Ödeme bir defaya mahsustur ve sınav tarihine kadar geçerlidir.</p></strong>
    <p class="text-danger">Kadronuza Ait Soru Sayıları</h4></p>
      <table class="table table-bordered">
    <thead>
      <tr>
        <th>Konu</th>
        <th>Soru Sayısı</th>
      </tr>
    </thead>
    <tbody>
    <?php 
    $toplam=0;
    foreach($soru_sayilari as $key => $val){
        $toplam=$toplam+$val['soru_adet'];
    ?>
      <tr>
        <td><?php echo $val['category_name'];?></td>
        <td><?php echo $val['soru_adet'];?></td>
      </tr>
      <?php }?>
      <tr>
        <td><strong>TOPLAM</strong></td>
        <td><strong><?php echo $toplam;?></strong></td>
      </tr>
	</tbody>
	</table>     
    </div>
    <div class="col-md-6 text-center"><h4><p class="bg-primary">Özel Üyelik Avantajları</p></h4><img class="img-responsive" src="<?php echo site_url('images/ozel_avantaj.jpeg');?>"></div>
</div>

 



</div>
<script>
 
</script>
