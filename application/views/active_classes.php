 <div class="container">

 <?php 
$logged_in=$this->session->userdata('logged_in');

if($resultstatus){ echo "<div class='alert alert-success'>".$resultstatus."</div>"; }
 ?> 	
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                         <?php if($title){ echo $title; } ?>
                        </div>
                        <!-- .panel-heading -->
                        <div class="panel-body">
                            <div class="panel-group" id="accordion">
   <?php
$logged_in=$this->session->userdata('logged_in');
if($logged_in['su']=="1"){
?>
Sohbet Sınıfı, seçili grupların kullanıcılarına canlı içerik (metin, resim veya başka ekler) gönderebileceğiniz ve kullanıcıların sizinle yada kendi aralarında sohbet edebileceği bir yerdir. <br>
Kullanıcılar yorum göndererek herhangi bir soru sorabilir ve siz (Yönetici) bu yorumları yayınlama, silme ve cevaplama yetkisine sahipsiniz.
Herhangi bir sohbet odasını kapatabilir, silebilir veya grup bazında düzenleyebilirsiniz.

<?php
}
?>
 
<br>
<br>

<?php
if($logged_in['su']=="1"){
?>
<a href="<?php echo site_url('liveclass/add_new');?>"  class="btn btn-success">Yeni Sohbet Odası Aç</a>
<?php
}
?>
<a href="<?php echo site_url('liveclass/closed_classes/');?>"  class="btn btn-warning">Kapalı Odalar</a>
<br><br>
   <table class="table table-hover">
                                    <thead>
                                   
                       <tr><th>Id</th>
<th>Oda Adı</th>
<th>Başlangıç Zamanı</th>
<th>İşlem</th></tr></thead></tbody>
<?php
if($result==false){
?>
<tr>
<td colspan="5">
Aktif bir canlı sınıf yok
</td>
</tr>
<?php

}else{
foreach($result as $row){
?>
<tr>
<td  data-th="Id"><?php echo $row['class_id'];?></td>
<td data-th="Class Name"><?php echo $row['class_name'];?></td>
<td data-th="Start Time"><?php echo date('d.m.Y H:i:s',$row['initiated_time']);?></td>
<td>
<?php
if($logged_in['su']=="1"){
?>
<a href="<?php echo site_url('liveclass/attempt/'.$row['class_id']);?>"  class="btn btn-success btn-xs">İçerik</a>
&nbsp;&nbsp;
<a href="<?php echo site_url('liveclass/close_class/'.$row['class_id']);?>"  class="btn btn-danger btn-xs">Odayı Kapat</a>
&nbsp;&nbsp;

<?php 
}else{
?>
<a href="<?php echo site_url('liveclass/attempt/'.$row['class_id']);?>"  class="btn btn-warning btn-xs">Katıl</a>
&nbsp;&nbsp;

<?php
}
?>
<?php
if($logged_in['su']=="1"){
?>

<a href="javascript: if(confirm('Do you really want to remove this class?')){ window.location='<?php echo site_url('liveclass/remove_class/'.$row['class_id'] );?>'; }" class="btn btn-danger btn-xs">Sil</a>
 <a href="<?php echo site_url('liveclass/edit_class/'.$row['class_id'] );?>"  class="btn btn-info btn-xs">Düzenle</a>
<?php
}
?>
</td>
</tr>
<?php
}
}
?>
        
			</tbody></table>				   
							   
							   




   
                              </div>
                        </div>
                        <!-- .panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
			
	
 
<?php
if($logged_in['su']=="1"){
?>

<?php
}
?>
<?php
if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; } ?>

<a href="<?php echo site_url('liveclass/index/'.$back);?>" class="btn btn-primary">Geri</a>
&nbsp;&nbsp;
<?php
 $next=$limit+($this->config->item('number_of_rows'));  ?>

<a href="<?php echo site_url('liveclass/index/'.$next);?>" class="btn btn-primary">İleri</a>





  
   
   
   </div>
   
   