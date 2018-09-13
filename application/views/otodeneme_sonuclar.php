 <div class="container">

   <?php 
   $logged_in=$this->session->userdata('logged_in');
   if ($logged_in['su']=='1') {
       echo "<h3>Oto Deneme Sonuçları:".$user['first_name']." ".$user['last_name']."</h3>";
   } else {
       echo "<h3>".$title."</h3>";
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
		<div id="message"></div>
		
	
<table class="table table-bordered">
<tr>
 <th>Konu</th>
 <th>Doğru</th>
 <th>Yanlış</th>
<th>Başarı </th>
</tr>
<?php 
if(count($result)==0){
	?>
<tr>
 <td colspan="4"><?php echo $this->lang->line('no_record_found');?></td>
</tr>	
	
	
	<?php
}
$dogru=0;
$yanlis=0;

foreach($result as $key => $val){
    $yuzde=round(100*$val['dogru']/($val['yanlis']+$val['dogru']), 2);
    $dogru=$dogru+$val['dogru'];
    $yanlis=$yanlis+$val['yanlis'];
?>
<tr>
 <td> <?php echo $val['category_name'];?></td>
 <td><?php echo $val['dogru'];?></td>
 <td><?php echo $val['yanlis'];?></td>
 <td><?php echo "%".$yuzde;?></td>


<!-- 
<a href="<?php echo site_url('user/pre_remove_group/'.$val['gid']);?>"><img src="<?php echo base_url('images/cross.png');?>"></a>
 -->

</tr>

<?php 
}
$toplamYuzde=round(100*$dogru/($yanlis+$dogru), 2);
?>
<tr>
 <td><strong>TOPLAM</strong></td>
 <td><strong><?php echo $dogru;?></strong></td>
 <td><strong><?php echo $yanlis;?></strong></td>
 <td><strong><?php echo "%".$toplamYuzde;?></strong></td>
</tr>
</table>
 <br>
 <br>
 <br>
</div>
<br>
 	
<h3>Ayrıntılar</h3>

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
//print_r($dogruSorular);
foreach($questions as $qkey => $question){
    $qk=$question['qid'];
//     print_r($question);
?>
 <hr>
<a name="answers_i"></a>
<div class="col-md-12 " id="q<?php echo $qkey;?>" class="" style="padding:10px;border-radius:  5px;<?php if(in_array($qk, $dogruSorular)){ ?>background-color:#abd39a;<?php }else { ?>background-color:#e29c9c;<?php } ?>">
	<div class="col-md-2 col-sm-2">
		<div style="height:45px; width:45px; background-color:#ffffff;border-radius:50%;color:#4b7d42;
		margin-top:6px;padding:14px;padding-left:15px;"><b><?php echo $qkey+1;?></b></div>
	</div>
	<div class="panel panel-success" style="border-radius: 5px; <?php if(in_array($qk, $dogruSorular)){ ?>background-color:#abd39a;<?php }else { ?>background-color:#e29c9c;<?php } ?>">

      <div class="panel-body" style=" <?php if(in_array($qk, $dogruSorular)){ ?>background-color:#abd39a;<?php }else { ?>background-color:#e29c9c;<?php } ?>">
      <span style="font-size: medium; font-family: 'tahamo';">
		<?php echo $question['question'];?><br><br>
					<?php 
					$j=0;
					foreach($options as $ok => $option){
					    if($question['qid']==$option['qid']){
					        if ($option['score']==1) {
					            $options[$ok]['secenek']=$abc[$j];
					            //print_r($options[$ok]);
					            //exit;
					        }
// 					        print("<pre>");
// 					        print_r($option);
// 					        print("</pre>");
					        echo $abc[$j]."-) ".strip_tags($option['q_option'])."<br>";
					       $j++;
					    }
					}
					        //exit();
					$j=0;
					?></span></div></div><br><p>
		 <?php

		 // multiple single choice
		 if($question['question_type']==$this->lang->line('multiple_choice_single_answer')){
			 
			 ?>
			 <input type="hidden"  name="question_type[]"  id="q_type<?php echo $qkey;?>" value="1">
			 	<div class="panel panel-success" style="border-radius: 5px;<?php if(in_array($qk, $dogruSorular)){ ?>background-color:#abd39a;<?php }else { ?>background-color:#e29c9c;<?php } ?>">
      <div class="panel-body" style="border-radius: 5px;<?php if(in_array($qk, $dogruSorular)){ ?>background-color:#abd39a;<?php }else { ?>background-color:#e29c9c;<?php } ?>">
			 
			<span style="font-size: medium; font-family: 'tahamo';">
			 <?php
			$i=0;
			$correct_options=""; 
			$secenek="";
			foreach($options as $ok => $option){
				if($option['qid']==$question['qid']){
					if($option['score'] >= 0.1){
						$correct_options=$option['q_option'];
						$secenek=$option['secenek'];
					}
			?>
			  <?php 
// 			  echo'<b>Cevabınız</b>: '.$abc[$i];
			  if(in_array($option['oid'],$save_ans)) {
			      echo'<b>Cevabınız</b>: '.$abc[$i];
			  }
			//."-) ".strip_tags($option['q_option']); } 
			?>
			 
			 
			 <?php 
			 $i+=1;
				}else{
				$i=0;	
					
				}
			}
			echo "<br>";
			echo "<b>Doğru Cevap</b>: ".$secenek;
			echo "</span></div></div>";
		 }

			
		 ?>
	<p>	<div class="panel panel-success" style="<?php if(in_array($qk, $dogruSorular)){ ?>background-color:#abd39a;<?php }else { ?>background-color:#e29c9c;<?php } ?>">
      <div class="panel-body" style="<?php if(in_array($qk, $dogruSorular)){ ?>background-color:#abd39a;<?php }else { ?>background-color:#e29c9c;<?php } ?>" >
	<?php 
 if($question['description']!='') {
				echo '<b>'.$this->lang->line('description').'</b>:';
				echo $question['description'];
			 }
			
?></p>
	
</div></div></div>
<div class="col-md-2 col-sm-2" id="q<?php echo $qkey;?>"  style="font-size:30px;">

<?php if(in_array($qk, $dogruSorular)){ ?><i class="glyphicon glyphicon-ok"></i>  <?php }else { ?><i class="glyphicon glyphicon-remove"></i> <?php }  ?>


</div>
 <div id="page_break"></div>

 
 
 <?php
}
?>
</div>
<div class="col-md-12 ">
  <h3>  Not: Boş bırakılan sorular listede görüntülenmez.</h3>            
</div>
</div>


</div>



</div>
