 <style>
 td{
		font-size:14px;
		padding:4px;
	}
	
	
</style>


<script>


function submitform(){
alert('Time Over');
window.location="<?php echo site_url('quiz/submit_quiz/');?>";
}
 

</script>



<div class="container" >




<div class="save_answer_signal" id="save_answer_signal2"></div>
<div class="save_answer_signal" id="save_answer_signal1"></div>

<div style="float:left;width:300px; " >
 <h4><?php echo $title;?></h4>
</div>
	
<div style="clear:both;"></div>

<!-- Category button -->

 <div class="row"  >
 			<?php
    if ($this->session->flashdata('message')) {
        echo $this->session->flashdata('message');
    }

    function getfirstqn($cat_keys = '0', $category_range)
    {
        if ($cat_keys == 0) {
            return 0;
        } else {
            $r = 0;
            for ($g = 0; $g < $cat_keys; $g ++) {
                $r += $category_range[$g];
            }
            return $r;
        }
    }

?>
</div> 

   
 
 <div class="row"  style="margin-top:5px;">
 <div class="col-md-12">
 <form method="post" action="<?php echo site_url('quiz/submit_quiz/'.$quiz['rid']);?>" id="quiz_form" >
 
<input id="noq" type="hidden" name="noq" value="">
<input id="oid" type="hidden" name="oid" value="">
<input id="dogrumu" type="hidden" name="dogrumu" value="">
</form>
<?php 
$abc=array(
'0'=>'A',
'1'=>'B',
'2'=>'C',
'3'=>'D',
'4'=>'E',
'6'=>'F',
'7'=>'G',
'8'=>'H',
'9'=>'I',
'10'=>'J',
'11'=>'K'
);
foreach($questions as $qk => $question){
?>
 <div id="q<?php echo $qk;?>" class="question_div" style="display: block;">
 		<div id="soru<?php echo $qk;?>" class="panel panel-info question_container" >
 		 	<div class="panel-heading"><h4><?php echo $this->lang->line('question');?> <?php echo $qk+1;?></h4></div>
		 <div class="op"><?php echo $question['question']." ";?></div><hr />
		 


		<div class="option_container" >
		 <?php 
		 // multiple single choice
		 if($question['question_type']==$this->lang->line('multiple_choice_single_answer')){
			 $dogruCevap="";
			 			 			 $save_ans=array();
			 foreach($saved_answers as $svk => $saved_answer){
				 if($question['qid']==$saved_answer['qid']){
					$save_ans[]=$saved_answer['q_option'];
				 }
			 }
			 
			 
			 ?>
			 <input type="hidden"  name="question_type[]"  id="q_type<?php echo $qk;?>" value="1">
			 <fieldset id="fields<?php echo $qk;?>">
			 <?php
			$i=0;
			foreach($options as $ok => $option){
			    $score=0;
				if($option['qid']==$question['qid']){
				    if($option['score']==1) {
				        $dogruCevap=$abc[$i].") ".$option['q_option'];
				        $score=1;
				    } else {
				        $score=0;
				    }
			?>
			 
		<div class="op"><div class="radio"><label><input type="radio" name="answer[<?php echo $qk;?>][]"  id="answer_value<?php echo $qk.'-'.$i;?>" 
						value="<?php echo $option['oid'];?>" onClick="javascript:show_question_answer('<?php echo $qk;?>','<?php echo $score;?>','<?php echo $question['qid'];?>','<?php echo $option['oid'];?>');" ><?php echo $abc[$i];?>)  <?php echo $option['q_option'];?> </label></div></div>
			 
			 
			 <?php 
			 $i+=1;
				}else{
				$i=0;	
					
				}
			}
		 }
			

			
		 ?>
</fieldset>
		</div> 		
		
		
		 <div id="cevap<?php echo $qk;?>" style="display: none; margin-bottom: 0px;" class="panel panel-success question_container" >
		<div class="panel-heading"><h4><center>
		<img id="dogru<?php echo $qk;?>" style="display:none" src="<?php echo base_url('images/dogru.png');?>">
		<img id="yanlis<?php echo $qk;?>" style="display:none" src="<?php echo base_url('images/yanlis.png');?>">
		</center>
		Cevap: <?php echo $dogruCevap.". Bu soruya Toplam <b>".$question['dogru_adet']." defa Doğru, ".$question['yanlis_adet']." defa Yanlış cevap verilmiştir.</b>"?></h4>
		</div>
		 <div class="op"><h3><font face="tahoma">Kaynak:</font></h3><br>
		 <?php echo $question['description'];?>
		</div>
		</div>
		<div class="panel-footer">
		<button class="btn btn-info" data-toggle="modal" data-target="#HataModal" data-soru_id="<?php echo $question['qid'];?>">Hata Bildir</button>
		</div>
		</div>
		

 </div>
 
 
 
 <?php
 if ($qk==9) {
//10. soru dan sonra..
 }
}
?>
  <div class="col-md-4" style="padding-bottom:80px; display:none">
 <div class="affix">

<b> <?php echo $this->lang->line('questions');?></b>
	<div>
		<?php 
		for($j=0; $j < $noq; $j++ ){
			?>
			
			<div class="qbtn" onClick="javascript:show_question('<?php echo $j;?>');" id="qbtn<?php echo $j;?>"  ><?php echo ($j+1);?></div>
			
			<?php 
		}
		?>
<div style="clear:both;"></div>

	</div>
	
	
	<br>
	<hr>
	<br>
	<div>
	

	
<table>
<tr><td style="font-size:12px;"><div class="qbtn" style="background:#449d44;">&nbsp;</div> <?php echo $this->lang->line('Answered');?>  </td></tr>
<tr><td style="font-size:12px;"><div class="qbtn" style="background:#c9302c;">&nbsp;</div> <?php echo $this->lang->line('UnAnswered');?>  </td></tr>
<tr><td style="font-size:12px;"><div class="qbtn" style="background:#ec971f;">&nbsp;</div> <?php echo $this->lang->line('Review-Later');?>  </td></tr>
<tr><td style="font-size:12px;"><div class="qbtn" style="background:#212121;">&nbsp;</div> <?php echo $this->lang->line('Not-visited');?>  </td></tr>
</table>



	<div style="clear:both;"></div>

	</div>

 </div></div>
 
 
 </div>
  
 



</div>



<div class="footer_ders_calis">
<!-- 	<button class="btn btn-warning"   onClick="javascript:review_later();" style="margin-top:2px;" ><?php echo $this->lang->line('review_later');?></button>
	
	<button class="btn btn-info"  onClick="javascript:clear_response();"  style="margin-top:2px;"  ><?php echo $this->lang->line('clear');?></button>

	<button class="btn btn-success"  id="backbtn" style="visibility:hidden;" onClick="javascript:show_back_question();"  style="margin-top:2px;" ><?php echo $this->lang->line('back');?></button>
	
	<button class="btn btn-success" id="nextbtn" onClick="javascript:show_questions_answer();" style="margin-top:2px;" ><?php echo $this->lang->line('save_next');?></button>
	
	<button class="btn btn-danger"  onClick="javascript:cancelmove();" style="margin-top:2px;" ><?php echo $this->lang->line('submit_quiz');?></button>
	 -->
	 <a class="btn btn-warning"  href="<?php echo site_url('quiz/');?>"  style="margin-top:2px;"  >Çalışmayı Bitir</a>
</div>

<!-- <a href="#my_modal" data-toggle="modal" data-soru_id ="test">Open Modal</a> -->
<div class="modal" id="my_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title">Modal header</h4>
      </div>
      <div class="modal-body">
        <p>some content</p>
        <input type="text" name="bookId" value=""/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="HataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Lütfen Sorudaki Hatayı Yazınız</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="İptal">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="hataBildirForm" action="<?php echo site_url('mesajlar/hataBildir');?>">
				<div class="modal-body">
					<textarea class="form-control" rows="5" name="mesaj"></textarea>
					<input type="hidden" name="soru_no" value="">
					<input type="hidden" name="konu" value="Hatalı Soru Bildirimi">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary"	data-dismiss="modal">İptal</button>
					<button type="submit" class="btn btn-primary">Gönder</button>
				</div>
			</form>
		</div>
	</div>
</div>


<script>

noq="<?php echo $noq;?>";
show_questions_for_calis();

$('#HataModal').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget); // Button that triggered the modal
	  var soru_id = button.data('soru_id'); // Extract info from data-* attributes
	  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
	  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
	  var modal = $(this);
	  modal.find('.modal-title').text("Lütfen soruyla ilgili hatayı giriniz");
	//  modal.find('.modal-body textarea').val(soru);
	  $(event.currentTarget).find('input[name="soru_no"]').val(soru_id);
	});
	
	
$('#my_modal').on('show.bs.modal', function(e) {
    var bookId = $(e.relatedTarget).data('book-id');
    $(e.currentTarget).find('input[name="bookId"]').val(bookId);
});

$("#hataBildirForm").submit(function(event) {

    /* stop form from submitting normally */
    event.preventDefault();

    /* get the action attribute from the <form action=""> element */
    var $form = $( this ),
        url = $form.attr( 'action' );

    /* Send the data using post with element id name and name2*/
    //alert($("#hataBildirForm").serialize());
    var posting = $.post( url, $("#hataBildirForm").serialize());

    /* Alerts the results */
    posting.done(function( data ) {
        alert("Hata bildiriminiz alındı, teşekkürler.");
    	$('#HataModal').modal('hide');
    });
  });
</script>
 

 
<div  id="warning_div" style="padding:10px; position:fixed;z-index:100;display:none;width:100%;border-radius:5px;height:200px; border:1px solid #dddddd;left:4px;top:70px;background:#ffffff;">
<center><b> <?php echo $this->lang->line('really_Want_to_submit');?></b> <br><br>
<span id="processing"></span>

<a href="javascript:cancelmove();"   class="btn btn-danger"  style="cursor:pointer;"><?php echo $this->lang->line('cancel');?></a> &nbsp; &nbsp; &nbsp; &nbsp;
<a href="javascript:submit_quiz();"   class="btn btn-info"  style="cursor:pointer;"><?php echo $this->lang->line('submit_quiz');?></a>

</center>
</div>
