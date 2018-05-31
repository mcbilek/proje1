 <script>
var aktifBlockId="#chat_thread_1";
var aktifThreadId=1;
var aktifMsgId=1;
var aktifKisiId="test";
function mesajDegistir(id,threadId) {
	//console.log(threadId);
	var mesajBlock = "#chat_" + id;
	var obje="#"+id;
	$('ul[id^=chat_thread_]').css('display', 'none'); // matches those that begin with 'tcol'
// 	$('td[name=tcol1]') // matches exactly 'tcol1'
// 	$('td[name^=tcol]') // matches those that begin with 'tcol'
// 	$('td[name$=tcol]') // matches those that end with 'tcol'
// 	$('td[name*=tcol]') // matches those that contain 'tcol'
	//$(aktifBlockId).css('display', 'none');
	$(mesajBlock).css('display', 'block');
	$("li.left.clearfix.secili").attr('class','li.left.clearfix');
	$(obje).attr('class','left clearfix secili');
//	aktifBlockId="#chat_"+id;
	aktifThreadId=threadId;
	//cevap atarken kullandığımız hidden input u güncelliyoruz.
	$("#thrd_id").val(threadId);
	}
	
function yeniMesaj() {
	$(yeniMesajGrup).show();
	$(mesajText).attr("placeholder", "Yeni Mesaj");
	$(islem_tur).val(2);
	$(emailInput).attr("required", "required");
	$(emailInput).focus();
	}
</script>
 <div class="container">
 	<link href="<?php echo base_url('css/chat.css');?>" rel="stylesheet">
 <?php 
 $logged_in=$this->session->userdata('logged_in');
		$aktifMesaj="";
		$aktifThrdId=-1;
// 		print "<pre>";
// 		print_r($mesajlar);
// 		print "</pre>";
		?>  
 
   
 <h3><?php echo $title;?></h3>
   <div class="row">
<div class="col-md-12">
<br>
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
      <div class="chat_container">
         <div class="col-sm-3 chat_sidebar">
    	 <div class="row">
            <div id="custom-search-input">
               <div class="input-group col-md-12">
                  <input type="text" class="  search-query form-control" placeholder="Kullanıcı Arayın" />
                  <button class="btn btn-danger" type="button">
                  <span class=" glyphicon glyphicon-search"></span>
                  </button>
               </div>
            </div>

            <div class="member_list">
               <ul class="list-unstyled">
               <?php 
               if (count($mesajlar)==0) {
                   ?>
               <li class="left clearfix">
                     <span class="chat-img pull-left">
                     </span>
                     <div class="chat-body clearfix">
                        <div class="header_sec">
                           <strong class="primary-font">Hiç Mesaj Bulunamadı!<br></strong>
                           <strong> - </strong>
                        </div>
                     </div>
                  </li>   
                   <?php 
               } else {
                   
                   $kontrol=false;
                   foreach ($mesajlar  as $i => $thread) {
//                        print "<pre>";
//                        print_r($i);
//                        print "</pre>";
               ?>
								<li onclick="mesajDegistir(this.id,this.value)"
									id="thread_<?php echo $thread['messages'][0]['thread_id']?>"
									value="<?php echo $thread['messages'][0]['thread_id']?>"
									class="left clearfix <?php
                    if (! $kontrol) {
                        echo "secili";
                        $kontrol = true;
                    }
                  
                  ?>">
                  <span class="chat-img pull-left"> </span>
									<div class="chat-body clearfix">
										<div class="header_sec">
											<strong class="primary-font"><?php 
                           $sonMesajTarihi="-";
//                            $last_key = end(array_keys($thread['messages']));
                           foreach ($thread['messages'] as $j => $mesaj) {
                                // if ($mesaj['uid']!=$logged_in['uid']) {
                                $alici=$mesaj['alici'];
                                $old_date_timestamp = strtotime($mesaj['cdate']);
                                $sonMesajTarihi = date('d.m.Y H:i', $old_date_timestamp);
                                // }
                            }
                            echo $alici;
                           ?></strong> <span class="pull-right">
                            <?php echo $sonMesajTarihi;?> </span><br>
											<strong class="pull-left">Konu: </strong> <span
												class="badge pull-left"><?php echo $mesaj['subject'];?></span>
										</div>
									</div></li>
								<?php 
                }
            }
               ?>


               </ul>
            </div></div>
         </div>
         <!--chat_sidebar-->
		 
		 
         <div class="col-sm-9 message_section" style="padding-right: 0px; padding-left:0px;">
		 <div class="row" style=" padding-left: 15px; padding-right: 15px;">
		 <div class="new_message_head" style="padding-left: 25px;padding-right: 10px;">
		 <div><button  onclick="yeniMesaj()" ><i class="fa fa-plus-square-o" aria-hidden="true"></i> Yeni Mesaj</button></div>
		 </div>
		 </div><!--new_message_head-->
		 
		 <div class="chat_area">
		 <?php
		 $kontrol=false;
		 foreach ($mesajlar  as $i => $thread) {
		     
		 ?>
		 <ul id="chat_thread_<?php echo $thread['messages'][0]['thread_id']?>" style="display:<?php if (!$kontrol) {$kontrol=true; echo "block"; $aktifThrdId=$thread['messages'][0]['thread_id']; } else {echo "none";} ?>" class="list-unstyled">
		 		<?php 
		 		foreach ($thread['messages'] as $j => $mesaj) {
		 		    $giden=false;
		 		    if ($mesaj['uid']==$logged_in['uid'])
		 		        $giden=true;
		 		    $old_date_timestamp = strtotime($mesaj['cdate']);
		 		    $mesajTarihi = date('d.m.Y H:i', $old_date_timestamp);
		 		    
		 		    if ($giden) {
		 		        
		 		?>
		 		<li class="left clearfix admin_chat">
                     <span class="chat-img1 pull-right">
                     <img src="<?php echo base_url("images/giden.png");?>" alt="User Avatar" >
                     </span>
                     <div class="chat-body2 clearfix">
                        <p><?php  echo "<strong>Siz: </strong>".$mesaj['body']; ?></p>
						<div class="chat_time pull-left"><?php echo $mesajTarihi;?></div>
                     </div>
                  </li>
				<?php } else { ?>
				<li class="left clearfix">
                     <span class="chat-img1 pull-left">
                     <img src="<?php echo base_url("images/gelen.png");?>" alt="User Avatar" >
                     </span>
                     <div class="chat-body1 clearfix">
                        <p><?php echo "<strong>".$mesaj['isim'].": </strong>".$mesaj['body']; ?></p>
						<div class="chat_time pull-right"><?php echo $mesajTarihi;?></div>
                     </div>
                  </li>
				
				<?php 
				}
				} ?>
		 
		 
		 </ul>
		 <?php } ?>
		 </div><!--chat_area-->
          <div class="message_write">
          
         
		   <div class="form-row">
		 <div class="chat_bottom">
		 <form method="post" action="<?php echo site_url('mesajlar/cevap_gonder');?>">
         <input type="hidden" value="<?php echo $aktifThrdId;?>" id="thrd_id" name="thrd_id">
         <input type="hidden" value="1" id="islem_tur" name="islem_tur">
<div class="form-group" id="yeniMesajGrup" style="display: none;">
    <div class="form-group col-md-6">
      <input type="email" class="form-control" id="emailInput" name="email" placeholder="Kullanıcı Adı (Email)">
    </div>
    <div class="form-group col-md-6">
      <input type="text" class="form-control" name="konu" placeholder="Konu">
    </div>
    </div>
    		   <div class="form-group col-md-12">
    	 <textarea class="form-control" name="mesaj" id="mesajText" placeholder="Cevap yazın" required></textarea>
    	 </div>
  </div>
 		 <input type="submit" value="Mesajı Gönder" class="pull-right btn btn-success"></div>
 		</form>
 		 
		 </div>
		 </div>
         </div> <!--message_section-->
      </div>
      </div>
      </div>

