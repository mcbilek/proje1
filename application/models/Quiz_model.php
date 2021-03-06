<?php
Class Quiz_model extends CI_Model
{
 
  function quiz_list($limit){
	  
	  $logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']=='0'){
			$gid=$logged_in['gid'];
			$kurum_id=$logged_in['kurum_id'];
			$kadro_id=$logged_in['kadro_id'];
			
			$where="kadro_id=$kadro_id and kurum_id=$kurum_id";  
			 $this->db->where($where);
			}
			
			
	 if($this->input->post('search') && $logged_in['su']=='1'){
		 $search=$this->input->post('search');
		 $this->db->or_where('quid',$search);
		 $this->db->or_like('quiz_name',$search);
		 $this->db->or_like('description',$search);

	 }
		 $this->db->limit($this->config->item('number_of_rows'),$limit);
		$this->db->order_by('quid','desc');
		$query=$this->db->get('savsoft_quiz');
		return $query->result_array();
		
	 
 }
 
 
   function recent_quiz($limit){
	  
	 
		$this->db->limit($limit);
		$this->db->order_by('quid','desc');
		$query=$this->db->get('savsoft_quiz');
		return $query->result_array();
}
 
   function open_quiz($limit){
	  
	 
		$this->db->limit($this->config->item('number_of_rows'),$limit);
		$this->db->order_by('quid','desc');
		$query=$this->db->get('savsoft_quiz');
		return $query->result_array();
}
 
 
 function num_quiz(){
	 
	 $query=$this->db->get('savsoft_quiz');
		return $query->num_rows();
 }
 
 function insert_quiz(){
	 
	 $userdata=array(
	 'quiz_name'=>$this->input->post('quiz_name'),
	 'description'=>$this->input->post('description'),
	 'start_date'=>strtotime($this->input->post('start_date')),
	 'end_date'=>strtotime($this->input->post('end_date')),
	 'duration'=>$this->input->post('duration'),
	 'maximum_attempts'=>$this->input->post('maximum_attempts'),
	 'pass_percentage'=>$this->input->post('pass_percentage'),
	 'correct_score'=>$this->input->post('correct_score'),
	 'incorrect_score'=>$this->input->post('incorrect_score'),
	 'ip_address'=>$this->input->post('ip_address'),
	 'view_answer'=>$this->input->post('view_answer'),
	 'camera_req'=>$this->input->post('camera_req'),
	 'quiz_template'=>$this->input->post('quiz_template'),
	 'with_login'=>$this->input->post('with_login'),
	 'gids'=>implode(',',$this->input->post('gids')),
     'kurum_id'=>$this->input->post('kurum_id'),
     'kadro_id'=>$this->input->post('kadro_id'),
	 'question_selection'=>$this->input->post('question_selection')
	 );
	 	$userdata['gen_certificate']=$this->input->post('gen_certificate'); 
	 
	 if($this->input->post('certificate_text')){
		$userdata['certificate_text']=$this->input->post('certificate_text'); 
	 }
	  $this->db->insert('savsoft_quiz',$userdata);
	 $quid=$this->db->insert_id();
	return $quid;
	 
 }
 
 
 function update_quiz($quid){
	 
	 $userdata=array(
	 'quiz_name'=>$this->input->post('quiz_name'),
	 'description'=>$this->input->post('description'),
	 'start_date'=>strtotime($this->input->post('start_date')),
	 'end_date'=>strtotime($this->input->post('end_date')),
	 'duration'=>$this->input->post('duration'),
	 'maximum_attempts'=>$this->input->post('maximum_attempts'),
	 'pass_percentage'=>$this->input->post('pass_percentage'),
	 'correct_score'=>$this->input->post('correct_score'),
	 'incorrect_score'=>$this->input->post('incorrect_score'),
	 'ip_address'=>$this->input->post('ip_address'),
	 'view_answer'=>$this->input->post('view_answer'),
	 'camera_req'=>$this->input->post('camera_req'),
	  'quiz_template'=>$this->input->post('quiz_template'),
	'with_login'=>$this->input->post('with_login'),
	 'gids'=>implode(',',$this->input->post('gids'))
	 );
	  	 	 
		$userdata['gen_certificate']=$this->input->post('gen_certificate'); 
	  
	 if($this->input->post('certificate_text')){
		$userdata['certificate_text']=$this->input->post('certificate_text'); 
	 }
 
	  $this->db->where('quid',$quid);
	  $this->db->update('savsoft_quiz',$userdata);
	  
	  $this->db->where('quid',$quid);
	  $query=$this->db->get('savsoft_quiz',$userdata);
	 $quiz=$query->row_array();
	 if($quiz['question_selection']=='1'){
		 
	  $this->db->where('quid',$quid);
	  $this->db->delete('savsoft_qcl');
                $correct_i=array();
        	 $incorrect_i=array();	 
	 foreach($_POST['cid'] as $ck => $val){
		 if(isset($_POST['noq'][$ck])){
			 if($_POST['noq'][$ck] >= '1'){
		 $userdata=array(
		 'quid'=>$quid,
		 'cid'=>$val,
		 'lid'=>$_POST['lid'][$ck],
		 'i_correct'=>$_POST['i_correct'][$ck],
		 'i_incorrect'=>$_POST['i_incorrect'][$ck],
		 'noq'=>$_POST['noq'][$ck]
		 );
		 $this->db->insert('savsoft_qcl',$userdata);
		  for($i=1; $i<=$_POST['noq'][$ck]; $i++){
$correct_i[]=$_POST['i_correct'][$ck];
$incorrect_i[]=$_POST['i_incorrect'][$ck];
}
		 }
		 }
	 }
		 $userdata=array(
		 'noq'=>array_sum($_POST['noq']),
		 'correct_score'=>implode(',',$correct_i),
		 'incorrect_score'=>implode(',',$incorrect_i)
	);
	 $this->db->where('quid',$quid);
	  $this->db->update('savsoft_quiz',$userdata);
	 }else{
			$correct_i=array();
			 $incorrect_i=array();
 foreach($_POST['i_correct'] as $ck =>$cv){
$correct_i[]=$_POST['i_correct'][$ck];
$incorrect_i[]=$_POST['i_incorrect'][$ck];
}

	 $userdata=array(
		 'correct_score'=>implode(',',$correct_i),
		  'incorrect_score'=>implode(',',$incorrect_i)
		 
			);
	  $this->db->where('quid',$quid);
	  $this->db->update('savsoft_quiz',$userdata);


}
	return $quid;
	 
 }
 
 function get_questions($qids){
	 if($qids == ''){
		$qids=0; 
	 }else{
		 $qids=$qids;
	 }
/*
	 if($cid!='0'){
		 $this->db->where('savsoft_qbank.cid',$cid);
	 }
	 if($lid!='0'){
		 $this->db->where('savsoft_qbank.lid',$lid);
	 }
*/
	  
	 $query=$this->db->query("select * from savsoft_qbank join savsoft_category on savsoft_category.cid=savsoft_qbank.cid join savsoft_level on savsoft_level.lid=savsoft_qbank.lid 
	 where savsoft_qbank.qid in ($qids) order by FIELD(savsoft_qbank.qid,$qids) 
	 ");
	 return $query->result_array();
	 
	 
 }
 
 function get_options($qids){
	 
     log_message("debug", "get_options, qids:".$qids);
	 
	 $query=$this->db->query("select * from savsoft_options where qid in ($qids) order by FIELD(savsoft_options.qid,$qids)");
	 return $query->result_array();
	 
 }
 
 
 
 function up_question($quid,$qid){
  	$this->db->where('quid',$quid);
 	$query=$this->db->get('savsoft_quiz');
 	$result=$query->row_array();
 	$qids=$result['qids'];
 	if($qids==""){
 	$qids=array();
 	}else{
 	$qids=explode(",",$qids);
 	}
 	$qids_new=array();
 	foreach($qids as $k => $qval){
 	if($qval == $qid){

 	$qids_new[$k-1]=$qval;
	$qids_new[$k]=$qids[$k-1];
	
 	}else{
	$qids_new[$k]=$qval;
 	
	}
 	}
 	
 	$qids=array_filter(array_unique($qids_new));
 	$qids=implode(",",$qids);
 	$userdata=array(
 	'qids'=>$qids
 	);
 		$this->db->where('quid',$quid);
	$this->db->update('savsoft_quiz',$userdata);

}



function down_question($quid,$qid){
  	$this->db->where('quid',$quid);
 	$query=$this->db->get('savsoft_quiz');
 	$result=$query->row_array();
 	$qids=$result['qids'];
 	if($qids==""){
 	$qids=array();
 	}else{
 	$qids=explode(",",$qids);
 	}
 	$qids_new=array();
 	foreach($qids as $k => $qval){
 	if($qval == $qid){

 	$qids_new[$k]=$qids[$k+1];
$kk=$k+1;
	$kv=$qval;
 	}else{
	$qids_new[$k]=$qval;
 	
	}

 	}
 	$qids_new[$kk]=$kv;
	
 	$qids=array_filter(array_unique($qids_new));
 	$qids=implode(",",$qids);
 	$userdata=array(
 	'qids'=>$qids
 	);
 		$this->db->where('quid',$quid);
	$this->db->update('savsoft_quiz',$userdata);

}




function get_qcl($quid){
	
	 $this->db->where('quid',$quid);
	 $query=$this->db->get('savsoft_qcl');
	 return $query->result_array();
	
}

 function remove_qid($quid,$qid){
	 
	 $this->db->where('quid',$quid);
	 $query=$this->db->get('savsoft_quiz');
	 $quiz=$query->row_array();
	 $new_qid=array();
	 foreach(explode(',',$quiz['qids']) as $key => $oqid){
		 
		 if($oqid != $qid){
			$new_qid[]=$oqid; 
			 
		 }
		 
	 }
	 $noq=count($new_qid);
	 $userdata=array(
	 'qids'=>implode(',',$new_qid),
	 'noq'=>$noq
	 
	 );
	 $this->db->where('quid',$quid);
	 $this->db->update('savsoft_quiz',$userdata);
	 return true;
 }
 
  function add_qid($quid,$qid){
	 
	 $this->db->where('quid',$quid);
	 $query=$this->db->get('savsoft_quiz');
	 $quiz=$query->row_array();
	 $new_qid=array();
	 $new_qid[]=$qid;
	 //puanlar� al�yoruz
	 $correct_score=$quiz['correct_score'];
	 $incorrect_score=$quiz['incorrect_score'];

	 $parcali_correct_scr=explode(',',$quiz['correct_score']);
	 //puan say�s� 1 se zaten hi� soru yok demektir ilk soruyu eklerken dokunmuyoruz
	 if(count($parcali_correct_scr)!=1 || $quiz['noq']>0)
	   array_push($parcali_correct_scr,$parcali_correct_scr[0]);

	 $parcali_incorrect_scr=explode(',',$quiz['incorrect_score']);
	 //puan say�s� 1 se zaten hi� soru yok demektir ilk soruyu eklerken dokunmuyoruz
	 if(count($parcali_incorrect_scr)!=1 || $quiz['noq']>0)
	   array_push($parcali_incorrect_scr,$parcali_incorrect_scr[0]);
	 
	   log_message("debug", "yeni eklenen correct_score ile birlikte:".count($parcali_correct_scr)." incorrect:".count($parcali_incorrect_scr));
	 
	 
	 
	 foreach(explode(',',$quiz['qids']) as $key => $oqid){
		 
		 if($oqid != $qid){
			$new_qid[]=$oqid; 
			 
		 }
		 
	 }
	 $new_qid=array_filter(array_unique($new_qid));
	 $noq=count($new_qid);
	 $userdata=array(
	 'qids'=>implode(',',$new_qid),
	     'correct_score'=>implode(',',$parcali_correct_scr),
	     'incorrect_score'=>implode(',',$parcali_incorrect_scr),
	 'noq'=>$noq
	 );
	 $this->db->where('quid',$quid);
	 $this->db->update('savsoft_quiz',$userdata);
	 return true;
 }
 

 
 function get_quiz($quid){
	 $this->db->where('quid',$quid);
	 $query=$this->db->get('savsoft_quiz');
	 return $query->row_array();
	 
	 
 } 
 
 function remove_quiz($quid){
	 
	 $this->db->where('quid',$quid);
	 if($this->db->delete('savsoft_quiz')){
		 
		 return true;
	 }else{
		 
		 return false;
	 }
	 
	 
 }
 
  
 
 function count_result($quid,$uid){
	 
	 $this->db->where('quid',$quid);
	 $this->db->where('uid',$uid);
	$query=$this->db->get('savsoft_result');
	return $query->num_rows();
	 
 }
 
 
 function insert_result($quid,$uid){
	 
	 // get quiz info
	  $this->db->where('quid',$quid);
	 $query=$this->db->get('savsoft_quiz');
	$quiz=$query->row_array();
	 
	 if($quiz['question_selection']=='0'){
		 
	// get questions	
$noq=$quiz['noq'];	
	$qids=explode(',',$quiz['qids']);
	$categories=array();
	$category_range=array();

	$i=0;
	$wqids=implode(',',$qids);
	$noq=array();
	$query=$this->db->query("select * from savsoft_qbank join savsoft_category on savsoft_category.cid=savsoft_qbank.cid where qid in ($wqids) ORDER BY FIELD(qid,$wqids)  ");	
	$questions=$query->result_array();
	foreach($questions as $qk => $question){
	if(!in_array($question['category_name'],$categories)){
		if(count($categories)!=0){
			$i+=1;
		}
	$categories[]=$question['category_name'];
	$noq[$i]+=1;
	}else{
	$noq[$i]+=1;

	}
	}
	
	$categories=array();
	$category_range=array();

	$i=-1;
	foreach($questions as $qk => $question){
		if(!in_array($question['category_name'],$categories)){
		 $categories[]=$question['category_name'];
		$i+=1;	
		$category_range[]=$noq[$i];
		
		} 
	}
 
	
	}else{
	// randomaly select qids
	 $this->db->where('quid',$quid);
	 $query=$this->db->get('savsoft_qcl');
	 $qcl=$query->result_array();
	$qids=array();
	$categories=array();
	$category_range=array();
	
	foreach($qcl as $k => $val){
		$cid=$val['cid'];
		$lid=$val['lid'];
		$noq=$val['noq'];
		
		$i=0;
	$query=$this->db->query("select * from savsoft_qbank join savsoft_category on savsoft_category.cid=savsoft_qbank.cid where savsoft_qbank.cid='$cid' and lid='$lid' ORDER BY RAND() limit $noq ");	
	$questions=$query->result_array();
	foreach($questions as $qk => $question){
		$qids[]=$question['qid'];
		if(!in_array($question['category_name'],$categories)){
		$categories[]=$question['category_name'];
		$category_range[]=$i+$noq;
		}
	}
	}
	}
	$zeros=array();
	 foreach($qids as $qidval){
	 $zeros[]=0;
	 }
	 
	 
	 
	 $userdata=array(
	 'quid'=>$quid,
	 'uid'=>$uid,
	 'r_qids'=>implode(',',$qids),
	 'categories'=>implode('#',$categories),
	 'category_range'=>implode(',',$category_range),
	 'start_time'=>time(),
	 'individual_time'=>implode(',',$zeros),
	 'score_individual'=>implode(',',$zeros),
	 'attempted_ip'=>$_SERVER['REMOTE_ADDR'] 
	 );
	 
	 if($this->session->userdata('photoname')){
		 $photoname=$this->session->userdata('photoname');
		 $userdata['photo']=$photoname;
	 }
	 $this->db->insert('savsoft_result',$userdata);
	  $rid=$this->db->insert_id();
	return $rid;
 }
 
 
 
 function open_result($quid,$uid){
	 $result_open=$this->lang->line('open');
		$query=$this->db->query("select * from savsoft_result  where savsoft_result.result_status='$result_open'  and savsoft_result.uid='$uid'  "); 
	if($query->num_rows() >= '1'){
		$result=$query->row_array();
return $result['rid'];		
	}else{
		return '0';
	}
	
	 
 }
 
 function quiz_result($rid){
	 
	 
	$query=$this->db->query("select * from savsoft_result join savsoft_quiz on savsoft_result.quid=savsoft_quiz.quid where savsoft_result.rid='$rid' "); 
	return $query->row_array(); 
	 
 }
 
function saved_answers($rid){
	 
	 
	$query=$this->db->query("select * from savsoft_answers  where savsoft_answers.rid='$rid' "); 
	return $query->result_array(); 
	 
 }
 
 
 function assign_score($rid,$qno,$score){
	 $qp_score=$score;
	 $query=$this->db->query("select * from savsoft_result join savsoft_quiz on savsoft_result.quid=savsoft_quiz.quid where savsoft_result.rid='$rid' "); 
	$quiz=$query->row_array(); 
	$score_ind=explode(',',$quiz['score_individual']);
	$score_ind[$qno]=$score;
	$r_qids=explode(',',$quiz['r_qids']);
	$correct_score=$quiz['correct_score'];
	$incorrect_score=$quiz['incorrect_score'];
		$manual_valuation=0;
	foreach($score_ind as $mk => $score){
		
		if($score == 1){
			
			$marks+=$correct_score;
		}
		if($score == 2){
			
			$marks+=$incorrect_score;
		}
		if($score == 3){
			
			$manual_valuation=1;
		}
		
	}
	$percentage_obtained=($marks/$quiz['noq'])*100;
	if($percentage_obtained >= $quiz['pass_percentage']){
		$qr=$this->lang->line('pass');
	}else{
		$qr=$this->lang->line('fail');
		
	}
	 $userdata=array(
	  'score_individual'=>implode(',',$score_ind),
	  'score_obtained'=>$marks,
	 'percentage_obtained'=>$percentage_obtained,
	 'manual_valuation'=>$manual_valuation
	 );
	 if($manual_valuation == 1){
		 $userdata['result_status']=$this->lang->line('pending');
	}else{
		$userdata['result_status']=$qr;
	}
	 $this->db->where('rid',$rid);
	 $this->db->update('savsoft_result',$userdata);
	 
	 // question performance
	 $qp=$r_qids[$qno];
	 		 $crin="";
		if($$qp_score=='1'){
			$crin=", no_time_corrected=(no_time_corrected +1)"; 	 
		 }else if($$qp_score=='2'){
			$crin=", no_time_incorrected=(no_time_incorrected +1)"; 	 
		 }
		  $query_qp="update savsoft_qbank set  $crin  where qid='$qp'  ";
	 $this->db->query($query_qp);
 }
 
 
 
 function submit_result(){
	 if(!$this->session->userdata('logged_in')){
		$logged_in=$this->session->userdata('logged_in_raw');
	 }else{
	 $logged_in=$this->session->userdata('logged_in');
	 }
	 $email=$logged_in['email'];
	 $rid=$this->session->userdata('rid');
	$query=$this->db->query("select * from savsoft_result join savsoft_quiz on savsoft_result.quid=savsoft_quiz.quid where savsoft_result.rid='$rid' "); 
	$quiz=$query->row_array(); 
	$score_ind=explode(',',$quiz['score_individual']);
	$r_qids=explode(',',$quiz['r_qids']);
	$qids_perf=array();
	$marks=0;
	$correct_score=$quiz['correct_score'];
	$incorrect_score=$quiz['incorrect_score'];
	$total_time=array_sum(explode(',',$quiz['individual_time']));
	$manual_valuation=0;
	foreach($score_ind as $mk => $score){
		$qids_perf[$r_qids[$mk]]=$score;
		
		if($score == 1){
			
			$marks+=$correct_score;
			
		}
		if($score == 2){
			
			$marks+=$incorrect_score;
		}
		if($score == 3){
			
			$manual_valuation=1;
		}
		
	}
	$percentage_obtained=($marks/($quiz['noq']*$correct_score))*100;
	if($percentage_obtained >= $quiz['pass_percentage']){
		$qr=$this->lang->line('pass');
	}else{
		$qr=$this->lang->line('fail');
		
	}
	 $userdata=array(
	  'total_time'=>$total_time,
	   'end_time'=>time(),
	  'score_obtained'=>$marks,
	 'percentage_obtained'=>$percentage_obtained,
	 'manual_valuation'=>$manual_valuation
	 );
	 if($manual_valuation == 1){
		 $userdata['result_status']=$this->lang->line('pending');
	}else{
		$userdata['result_status']=$qr;
	}
	 $this->db->where('rid',$rid);
	 $this->db->update('savsoft_result',$userdata);
	 
	 
	 foreach($qids_perf as $qp => $qpval){
		 $crin="";
		 if($qpval=='0'){
			$crin=", no_time_unattempted=(no_time_unattempted +1) "; 
		 }else if($qpval=='1'){
			$crin=", no_time_corrected=(no_time_corrected +1)"; 	 
		 }else if($qpval=='2'){
			$crin=", no_time_incorrected=(no_time_incorrected +1)"; 	 
		 }
		  $query_qp="update savsoft_qbank set no_time_served=(no_time_served +1)  $crin  where qid='$qp'  ";
	 $this->db->query($query_qp);
		 
	 }
	 
if($this->config->item('allow_result_email')){
	$this->load->library('email');
	$query = $this -> db -> query("select savsoft_result.*,savsoft_users.*,savsoft_quiz.* from savsoft_result, savsoft_users, savsoft_quiz where savsoft_users.uid=savsoft_result.uid and savsoft_quiz.quid=savsoft_result.quid and savsoft_result.rid='$rid'");
	$qrr=$query->row_array();
  		if($this->config->item('protocol')=="smtp"){
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = $this->config->item('smtp_hostname');
			$config['smtp_user'] = $this->config->item('smtp_username');
			$config['smtp_pass'] = $this->config->item('smtp_password');
			$config['smtp_port'] = $this->config->item('smtp_port');
			$config['smtp_timeout'] = $this->config->item('smtp_timeout');
			$config['mailtype'] = $this->config->item('smtp_mailtype');
			$config['starttls']  = $this->config->item('starttls');
			$config['newline']  = $this->config->item('newline');

			$this->email->initialize($config);
		}
			$toemail=$qrr['email'];
			$fromemail=$this->config->item('fromemail');
			$fromname=$this->config->item('fromname');
			$subject=$this->config->item('result_subject');
			$message=$this->config->item('result_message');
			
			$subject=str_replace('[email]',$qrr['email'],$subject);
			$subject=str_replace('[first_name]',$qrr['first_name'],$subject);
			$subject=str_replace('[last_name]',$qrr['last_name'],$subject);
			$subject=str_replace('[quiz_name]',$qrr['quiz_name'],$subject);
			$subject=str_replace('[score_obtained]',$qrr['score_obtained'],$subject);
			$subject=str_replace('[percentage_obtained]',$qrr['percentage_obtained'],$subject);
			$subject=str_replace('[current_date]',date('Y-m-d H:i:s',time()),$subject);
			$subject=str_replace('[result_status]',$qrr['result_status'],$subject);
			
			$message=str_replace('[email]',$qrr['email'],$message);
			$message=str_replace('[first_name]',$qrr['first_name'],$message);
			$message=str_replace('[last_name]',$qrr['last_name'],$message);
			$message=str_replace('[quiz_name]',$qrr['quiz_name'],$message);
			$message=str_replace('[score_obtained]',$qrr['score_obtained'],$message);
			$message=str_replace('[percentage_obtained]',$qrr['percentage_obtained'],$message);
			$message=str_replace('[current_date]',date('Y-m-d H:i:s',time()),$message);
			$message=str_replace('[result_status]',$qrr['result_status'],$message);
			 
			
			$this->email->to($toemail);
			$this->email->from($fromemail, $fromname);
			$this->email->subject($subject);
			$this->email->message($message);
			if(!$this->email->send()){
			 //print_r($this->email->print_debugger());
			
			}
	}
	

	return true;
 }
 
 
 
 
 
 function insert_answer(){
	 $rid=$_POST['rid'];
	$srid=$this->session->userdata('rid');
	if(!$this->session->userdata('logged_in')){
		$logged_in=$this->session->userdata('logged_in_raw');
	}else{
		$logged_in=$this->session->userdata('logged_in');
	}
	$uid=$logged_in['uid'];
	if($srid != $rid){

	return "Something wrong";
	}
	$query=$this->db->query("select * from savsoft_result join savsoft_quiz on savsoft_result.quid=savsoft_quiz.quid where savsoft_result.rid='$rid' "); 
	$quiz=$query->row_array(); 
	$correct_score=$quiz['correct_score'];
	$incorrect_score=$quiz['incorrect_score'];
	$qids=explode(',',$quiz['r_qids']);
	$vqids=$quiz['r_qids'];
	$correct_incorrect=explode(',',$quiz['score_individual']);
	
	
	// remove existing answers
	$this->db->where('rid',$rid);
	$this->db->delete('savsoft_answers');
	
	 foreach($_POST['answer'] as $ak => $answer){
		 
		 // multiple choice single answer
		 if($_POST['question_type'][$ak] == '1' || $_POST['question_type'][$ak] == '2'){
			 
			 $qid=$qids[$ak];
			 $query=$this->db->query(" select * from savsoft_options where qid='$qid' ");
			 $options_data=$query->result_array();
			 $options=array();
			 foreach($options_data as $ok => $option){
				 $options[$option['oid']]=$option['score'];
			 }
			 $attempted=0;
			 $marks=0;
				foreach($answer as $sk => $ansval){
					if($options[$ansval] <= 0 ){
					$marks+=-1;	
					}else{
					$marks+=$options[$ansval];
					}
					$userdata=array(
					'rid'=>$rid,
					'qid'=>$qid,
					'uid'=>$uid,
					'q_option'=>$ansval,
					'score_u'=>$options[$ansval]
					);
					$this->db->insert('savsoft_answers',$userdata);
				$attempted=1;	
				}
				if($attempted==1){
					if($marks >= '0.99' ){
					$correct_incorrect[$ak]=1;	
					}else{
					$correct_incorrect[$ak]=2;							
					}
				}else{
					$correct_incorrect[$ak]=0;
				}
		 }
		 // short answer
		 if($_POST['question_type'][$ak] == '3'){
			 
			 $qid=$qids[$ak];
			 $query=$this->db->query(" select * from savsoft_options where qid='$qid' ");
			 $options_data=$query->row_array();
			 $options_data=explode(',',$options_data['q_option']);
			 $noptions=array();
			 foreach($options_data as $op){
				 $noptions[]=strtoupper(trim($op));
			 }
			 
			 $attempted=0;
			 $marks=0;
				foreach($answer as $sk => $ansval){
					if($ansval != ''){
					if(in_array(strtoupper(trim($ansval)),$noptions)){
					$marks=1;	
					}else{
					$marks=0;
					}
					
				$attempted=1;

					$userdata=array(
					'rid'=>$rid,
					'qid'=>$qid,
					'uid'=>$uid,
					'q_option'=>$ansval,
					'score_u'=>$marks
					);
					$this->db->insert('savsoft_answers',$userdata);

				}
				}
				if($attempted==1){
					if($marks==1){
					$correct_incorrect[$ak]=1;	
					}else{
					$correct_incorrect[$ak]=2;							
					}
				}else{
					$correct_incorrect[$ak]=0;
				}
		 }
		 
		 // long answer
		 if($_POST['question_type'][$ak] == '4'){
			  $attempted=0;
			 $marks=0;
			  $qid=$qids[$ak];
					foreach($answer as $sk => $ansval){
					if($ansval != ''){
					$userdata=array(
					'rid'=>$rid,
					'qid'=>$qid,
					'uid'=>$uid,
					'q_option'=>$ansval,
					'score_u'=>0
					);
					$this->db->insert('savsoft_answers',$userdata);
					$attempted=1;
					}
					}
				if($attempted==1){
					
					$correct_incorrect[$ak]=3;							
					
				}else{
					$correct_incorrect[$ak]=0;
				}
		 }
		 
		 // match
			 if($_POST['question_type'][$ak] == '5'){
				 			 $qid=$qids[$ak];
			 $query=$this->db->query(" select * from savsoft_options where qid='$qid' ");
			 $options_data=$query->result_array();
			$noptions=array();
			foreach($options_data as $op => $option){
				$noptions[]=$option['q_option'].'___'.$option['q_option_match'];				
			}
			 $marks=0;
			 $attempted=0;
					foreach($answer as $sk => $ansval){
						if($ansval != '0'){
						$mc=0;
						if(in_array($ansval,$noptions)){
							$marks+=1/count($options_data);
							$mc=1/count($options_data);
						}else{
							$marks+=0;
							$mc=0;
						}
					$userdata=array(
					'rid'=>$rid,
					'qid'=>$qid,
					'uid'=>$uid,
					'q_option'=>$ansval,
					'score_u'=>$mc
					);
					$this->db->insert('savsoft_answers',$userdata);
					$attempted=1;
					}
					}
					if($attempted==1){
					if($marks==1){
					$correct_incorrect[$ak]=1;	
					}else{
					$correct_incorrect[$ak]=2;							
					}
				}else{
					$correct_incorrect[$ak]=0;
				}
		 }
		 
		 
		 
		 
		 
		 
		 
		 
	 }
	 
	 $userdata=array(
	 'score_individual'=>implode(',',$correct_incorrect),
	 'individual_time'=>$_POST['individual_time'],
	 
	 );
	 $this->db->where('rid',$rid);
	 $this->db->update('savsoft_result',$userdata);
	 
	 return true;
	 
 }
 function insert_answer_for_calis(){
        log_message("debug", "insert_answer_for_calis" . $_POST);
        $logged_in = $this->session->userdata('logged_in');
        $uid = $logged_in['uid'];
        
        $userdata = array(
            'uid' => $uid,
            'soru_id' => $_POST['noq'],
            'opt_id' => $_POST['oid'],
            'dogru_mu' => $_POST['dogrumu']
        );
        return $this->db->insert('savsoft_result2', $userdata);
    }
    
 function insert_answer_for_otodeneme(){
        log_message("debug", "insert_answer_for_otodeneme" . $_POST);
        $logged_in = $this->session->userdata('logged_in');
        $uid = $logged_in['uid'];
        
        $this->db->where('uid',$uid);
        $this->db->where('soru_id',$_POST['noq']);
        $this->db->delete('savsoft_result_otodeneme');
        
        $userdata = array(
            'otodeneme_id' => $_POST['oto_deneme_id'],
            'uid' => $uid,
            'soru_id' => $_POST['noq'],
            'opt_id' => $_POST['oid'],
            'dogru_mu' => $_POST['dogrumu']
        );
        return $this->db->insert('savsoft_result_otodeneme', $userdata);
    }
    
    function get_otodeneme_sonuclari(int $uid,$oto_deneme_no){
        
        
        $sql ="          SELECT c.category_name,".
        "                 sum(r.dogru_mu) dogru,".
        "                 sum(if(r.dogru_mu = 0, 1, 0)) yanlis".
        "          FROM savsoft_result_otodeneme r,".
        "               savsoft_category c,".
        "               savsoft_category_kadro ck,".
        "               savsoft_users u,".
        "               savsoft_qbank qb".
        "          WHERE     c.cid = ck.kategori_id".
        "                AND u.uid = r.uid".
        "                AND qb.qid = r.soru_id".
        "                AND qb.cid = c.cid".
        "                AND u.kadro_id = ck.kadro_id".
        "                AND u.kurum_id = ck.kurum_id".
        "                AND r.uid = ?".
        "                AND r.otodeneme_id = ?".
        "          GROUP BY c.category_name".
        "          ORDER BY c.category_name";
        
        $params=array();
        $params[0]=$uid;
        $params[1]=$oto_deneme_no;
        $query = $this->db->query($sql,$params);
        
        return $query->result_array();
        
    }
    
    //insert sonras� autoincrement alan� d�ner.
    function get_otodeneme_id(){
        log_message("debug", "get_otodeneme_id");
        $logged_in = $this->session->userdata('logged_in');
        $uid = $logged_in['uid'];
        
        $userdata = array(
            'uid' => $uid
        );
        
        $this->db->insert('otomatik_deneme', $userdata);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }
    
    function get_sorular_otodeneme($otodeneme_id){
        log_message("debug", "get_qids_otodeneme, otodnme_id:".$otodeneme_id);
        
        $sql =
        " SELECT *".
        " FROM savsoft_result_otodeneme".
        " WHERE otodeneme_id = ?";
        
        $query = $this->db->query($sql,$otodeneme_id);
        
        return $query->result_array();
        
    }
    
    function otodeneme_sonuc_update($uid,$oto_deneme_no){
        log_message("debug", "otodeneme_sonuc_update");
        
        $sonuc = $this->get_otodeneme_sonuclari($uid,$oto_deneme_no);
        $dogru=0;
        $yanlis=0;
        foreach($sonuc as $key => $val){
            $dogru=$dogru+$val['dogru'];
            $yanlis=$yanlis+$val['yanlis'];
        }
        $yuzde=round(100*$dogru/($yanlis+$dogru), 2);
        
        $userdata=array(
            'basari_yuzdesi'=>$yuzde,
            'toplam_cozulen'=>$dogru+$yanlis
        );
        $this->db->where('kayit_id',$oto_deneme_no);
        $this->db->update('otomatik_deneme',$userdata);
        
        $sonucArray[0]=$sonuc;
        $sonucArray[1]=$dogru;
        $sonucArray[2]=$yanlis;
        return  $sonucArray;
    }
 
 
 function set_ind_time(){
	 	$rid=$this->session->userdata('rid');

	 $userdata=array(
	 'individual_time'=>$_POST['individual_time'],
	 
	 );
	 $this->db->where('rid',$rid);
	 $this->db->update('savsoft_result',$userdata);
	 
	 return true;
 }
 
 
 
 function get_questions_demo_kontrol(){
     $logged_in=$this->session->userdata('logged_in');
     $gid=$logged_in['gid'];
     $uid=$logged_in['uid'];
     //admin yada �zel �ye de�ilse demo soru �ekildi�ine dair kay�t at�yoruz.
     if($logged_in['su']=='0' && $gid!=3){
         //daha �nce soru �ekilmi� mi bak�yoruz
         $bugun_cozdu="bugun_cozdu";
         $query=$this->db->query("select DATE_FORMAT(date(max(tarih)), '%d.%m.%Y') tarih_formatted from savsoft_settings where uid=$uid and anahtar='$bugun_cozdu'");
         $sonTarih="";
         foreach ($query->result() as $row)
         {
             $sonTarih=$row->tarih_formatted;
         }
         
         if ($sonTarih==date('d.m.Y')) {
             return 1;
         } else {
             return 0;
         }
     }
    
 }
 
 
 function get_questions_ders_calis(){
     $logged_in=$this->session->userdata('logged_in');
     $gid=$logged_in['gid'];
     $uid=$logged_in['uid'];
     $soruAdet = $_POST['soruAdet'];
     if (empty($soruAdet))
         $soruAdet=1000;
     //admin yada �zel �ye de�ilse demo soru �ekildi�ine dair kay�t at�yoruz.
     if($logged_in['su']=='0' && $gid!=3){

              $userdata = array(
                  'uid' => $uid,
                  'anahtar' => "bugun_cozdu",
                  'value' => "1",
              );
              $this->db->insert('savsoft_settings', $userdata);
              //soru adedini s�n�rl�yoruz.
              $soruAdet=$this->config->item('demo_soru');
          }
     
     log_message("debug", "grup_id:".$gid);
     log_message("debug", "uid:".$uid);
     log_message("debug", "kategori_id:".$_POST['kategori_id']);
     log_message("debug", "soru adet:".$_POST['soruAdet']);
     $cat_id = $_POST['kategori_id'];
     if ($cat_id=="-1") {
         //e�er hi� bir kategori se�ilmemi�se
         //ilk sql daha �nce ��z�lmeyen sorulardan getiriyor
         $sql = " SELECT q.*, cat.category_name, lvl.level_name,".
         " (SELECT count(*) cnt FROM savsoft_result2 r WHERE r.soru_id = q.qid AND r.dogru_mu = 1) dogru_adet,".
         " (SELECT count(*) cnt FROM savsoft_result2 r WHERE r.soru_id = q.qid AND r.dogru_mu = 0) yanlis_adet".
         " FROM savsoft_qbank q, savsoft_category cat, savsoft_level lvl".
         " WHERE     q.cid = cat.cid".
         "       AND lvl.lid = q.lid".
         "       AND q.aktifmi = 1".
         "       and q.qid not in (select r.soru_id from savsoft_result2 r where r.uid=$uid)".
         " ORDER BY RAND()".
         " LIMIT $soruAdet";
         //t�m sorulardan getiriyor
         $sql2 = " SELECT q.*, cat.category_name, lvl.level_name,".
         " (SELECT count(*) cnt FROM savsoft_result2 r WHERE r.soru_id = q.qid AND r.dogru_mu = 1) dogru_adet,".
         " (SELECT count(*) cnt FROM savsoft_result2 r WHERE r.soru_id = q.qid AND r.dogru_mu = 0) yanlis_adet".
         " FROM savsoft_qbank q, savsoft_category cat, savsoft_level lvl".
         " WHERE     q.cid = cat.cid".
         "       AND lvl.lid = q.lid".
         "       AND q.aktifmi = 1".
         " ORDER BY RAND()".
         " LIMIT $soruAdet";
     } else {
         //e�er kategori se�ilmi�se
         //ilk sql daha �nce ��z�lmeyen sorulardan getiriyor
         $sql = " SELECT q.*, cat.category_name, lvl.level_name,".
         " (SELECT count(*) cnt FROM savsoft_result2 r WHERE r.soru_id = q.qid AND r.dogru_mu = 1) dogru_adet,".
         " (SELECT count(*) cnt FROM savsoft_result2 r WHERE r.soru_id = q.qid AND r.dogru_mu = 0) yanlis_adet".
         " FROM savsoft_qbank q, savsoft_category cat, savsoft_level lvl".
         " WHERE     q.cid = cat.cid".
         "       AND lvl.lid = q.lid".
         "       AND q.aktifmi = 1".
         "       AND q.cid=$cat_id".
         "       and q.qid not in (select r.soru_id from savsoft_result2 r where r.uid=$uid)".
         " ORDER BY RAND()".
         " LIMIT $soruAdet";
         //t�m sorulardan getiriyor
         $sql2 = " SELECT q.*, cat.category_name, lvl.level_name,".
             " (SELECT count(*) cnt FROM savsoft_result2 r WHERE r.soru_id = q.qid AND r.dogru_mu = 1) dogru_adet,".
             " (SELECT count(*) cnt FROM savsoft_result2 r WHERE r.soru_id = q.qid AND r.dogru_mu = 0) yanlis_adet".
         " FROM savsoft_qbank q, savsoft_category cat, savsoft_level lvl".
         " WHERE     q.cid = cat.cid".
         "       AND lvl.lid = q.lid".
         "       AND q.aktifmi = 1".
         "       AND q.cid=$cat_id".
         " ORDER BY RAND()".
         " LIMIT $soruAdet";
        }
         $query=$this->db->query($sql);
         //daha �nce t�m sorular ��z�lm�� m� diye bak�yoruz
         //��z�ld�yse rasgele ��zd��� sorulardan getiriyoruz.
         if ($query->num_rows()==0)
             $query=$this->db->query($sql2);
     return $query->result_array();
     
     
 }
 function get_questions_oto_deneme($otodeneme_id){
     $logged_in=$this->session->userdata('logged_in');
     $gid=$logged_in['gid'];
     $uid=$logged_in['uid'];
     $kadro_id=$logged_in['kadro_id'];
     $kadroSql="select * from savsoft_category_kadro ck where ck.kadro_id=$kadro_id";
     log_message("debug", "grup_id:".$gid);
     log_message("debug", "uid:".$uid);
     
     $query=$this->db->query($kadroSql);
     $kadro_soruArray=$query->result_array();
     
     $sql ="";

     foreach ($kadro_soruArray as $key => $value) {
         $catId=$value['kategori_id'];
         $soru_adet=$value['soru_adet'];
         $sql = $sql.
         " (SELECT q.*,".
         "        cat.category_name,".
         "        lvl.level_name".
         " FROM savsoft_qbank q, savsoft_category cat, savsoft_level lvl".
         " WHERE q.cid = cat.cid AND lvl.lid = q.lid AND q.aktifmi = 1 and cat.cid=$catId".
         " ORDER BY RAND()".
         " limit $soru_adet)";
         if ($key+1!=count($kadro_soruArray))
                $sql = $sql." UNION ALL ";
     }
     
  //  print_r($sql);
  //  exit();
     
         //kategorilere ait deneme s�nas� soru say�lar�na g�re sorular� �ekiyoruz.
             $query=$this->db->query($sql);
             $sonuc = $query->result_array();
             
    //soru say�s�n� update ediyoruz.
    
             $userdata=array(
                 'soru_adet'=>count($sonuc)
             );
             
             $this->db->where('kayit_id',$otodeneme_id);
             $this->db->update('otomatik_deneme',$userdata);
             
     return $sonuc;
     
 }
 
 function calisma_list(){
     
     $logged_in=$this->session->userdata('logged_in');
//      if($logged_in['su']=='0'){
//          $gid=$logged_in['gid'];
//          $where="FIND_IN_SET('".$gid."', gids)";
//          $this->db->where($where);
//      }
     
     
//      if($this->input->post('search') && $logged_in['su']=='1'){
//          $search=$this->input->post('search');
//          $this->db->or_where('quid',$search);
//          $this->db->or_like('quiz_name',$search);
//          $this->db->or_like('description',$search);
         
//      }
     $uid=$logged_in['uid'];
     if($logged_in['su']=='0'){
         $sql =
         " SELECT c.*, count(q.qid) soru_adet".
         " FROM savsoft_users u,".
         "      savsoft_category c,".
         "      savsoft_category_kadro ck,".
         "      savsoft_qbank q".
         " WHERE     u.uid = ?".
         "       AND u.kadro_id = ck.kadro_id".
         "       AND ck.kurum_id = u.kurum_id".
         "       AND c.cid = ck.kategori_id".
         "       AND q.cid = c.cid".
         " GROUP BY c.cid".
         " ORDER BY c.category_name ASC";
         $query=$this->db->query($sql,$uid);
     } else {
         $sql =
         " SELECT c.*, count(q.qid) soru_adet".
         " FROM savsoft_category c, savsoft_qbank q".
         " WHERE c.cid = q.cid".
         " GROUP BY c.cid".
         " ORDER BY category_name ASC";
         $query=$this->db->query($sql);
     }
//      log_message("debug", "calisma_list size:".count($query->result_array()));
     return $query->result_array();
     
     
 }
 function kaynak_list(){
     
     $logged_in=$this->session->userdata('logged_in');
//      if($logged_in['su']=='0'){
//          $gid=$logged_in['gid'];
//          $where="FIND_IN_SET('".$gid."', gids)";
//          $this->db->where($where);
//      }
     
     
//      if($this->input->post('search') && $logged_in['su']=='1'){
//          $search=$this->input->post('search');
//          $this->db->or_where('quid',$search);
//          $this->db->or_like('quiz_name',$search);
//          $this->db->or_like('description',$search);
         
//      }
     $uid=$logged_in['uid'];
     if($logged_in['su']=='0'){
     $query=$this->db->query("select c.* from savsoft_users u, savsoft_category_kaynak c, savsoft_category_kadro ck where u.uid=$uid and u.kadro_id=ck.kadro_id and c.kategori_id=ck.kategori_id and ck.kurum_id = c.kurum_id");
     } else {
         $query=$this->db->query("select * from savsoft_category_kaynak");
     }
//      log_message("debug", "calisma_list size:".count($query->result_array()));
     return $query->result_array();
     
     
 }
 
}
?>
