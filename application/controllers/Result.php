<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Result extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->helper('url');
	   $this->load->model("result_model");
	   $this->load->model("user_model");
	   $this->lang->load('basic', $this->config->item('language'));
		// redirect if not loggedin

	 }

	public function index($limit='0',$status='0')
	{
	    log_message("debug", "Result.php index() e geldi.");
		
	 	if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}
		
		//daha �nce biri giri� yapm��sa session u silip logine y�nlendiriyoruz
		log_message("debug", "tek_login_kontrol� yap�l�yor.");
		if(!$this->user_model->tek_login_kontrol($logged_in)){
		    log_message("debug", "tek_login_kontrol�nden ge�emedi.");
		    $this->session->unset_userdata('logged_in');
		    $this->session->set_flashdata('message', $this->lang->line('tek_login_mesaji'));
		    redirect('login');
		}
		log_message("debug", "tek_login_kontrol� yap�ld�.");
		
			
		$data['limit']=$limit;
		$data['status']=$status;
		$data['title']=$this->lang->line('resultlist');
		// fetching result list
		$data['result']=$this->result_model->result_list($limit,$status);
		// fetching quiz list
		$data['quiz_list']=$this->result_model->quiz_list();
//		log_message("debug", "deneme yazdı?.");
		// group list
		 $this->load->model("user_model");
		$data['group_list']=$this->user_model->group_list();
//		echo "deneme";
		$this->load->view('headerForTable',$data);
		$this->load->view('result_list',$data);
		$this->load->view('footer',$data);
	}
	
	public function kadro_list($kurum_id)
	{
	    log_message("debug", "kadro_list($kurum_id) geldi");
	    log_message("debug", "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa");
	    $this->load->model("genel_model");
	    // fetching group list
	    $kadro_list=$this->genel_model->kadro_list_by_kurum($_POST['kurum_id']);
	//    echo count($kadro_list);
	//    echo "<option value='5'>Deneme</option>";
	    foreach ($kadro_list as $key => $val) {
	        echo $val['kadro_id'];
                echo "<option value=".$val['kadro_id'].">";
                echo $val['kadro_adi']."</option>";
                    }
	}
	
	public function otodeneme_sonuclari($limit='0',$status='0')
	{
	    
	    if(!$this->session->userdata('logged_in')){
	        redirect('login');
	        
	    }
	    $logged_in=$this->session->userdata('logged_in');
	    if($logged_in['base_url'] != base_url()){
	        $this->session->unset_userdata('logged_in');
	        redirect('login');
	    }
	    
	    //daha �nce biri giri� yapm��sa session u silip logine y�nlendiriyoruz
	    log_message("debug", "tek_login_kontrol� yap�l�yor.");
	    if(!$this->user_model->tek_login_kontrol($logged_in)){
	        log_message("debug", "tek_login_kontrol�nden ge�emedi.");
	        $this->session->unset_userdata('logged_in');
	        $this->session->set_flashdata('message', $this->lang->line('tek_login_mesaji'));
	        redirect('login');
	    }
	    log_message("debug", "otodeneme_sonuclari->tek_login_kontrol� yap�ld�.");
	    
	    
	    $data['limit']=$limit;
	    $data['status']=$status;
	    $data['title']="Otomatik Deneme Sonuçlarınız";
	    // fetching result list
	    $data['result']=$this->result_model->otodeneme_sonuc_list($logged_in['uid']);
	    // group list
	   // $this->load->model("user_model");
	   // $data['group_list']=$this->user_model->group_list();
	    
	    $this->load->view('headerForTable',$data);
	    $this->load->view('result_list_otodeneme',$data);
	    $this->load->view('footer',$data);
	}
	


	
	public function remove_result($rid){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}
			$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']!='1'){
				exit($this->lang->line('permission_denied'));
			} 
			
			if($this->result_model->remove_result($rid)){
                        $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('removed_successfully')." </div>");
					}else{
						    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_remove')." </div>");
						
					}
					redirect('result');
                     
			
		}
	

	
	function generate_report(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}
		
		$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']!='1'){
				exit($this->lang->line('permission_denied'));
			} 
			
		$this->load->helper('download');
		
		$quid=$this->input->post('quid');
		$gid=$this->input->post('gid');
		$result=$this->result_model->generate_report($quid,$gid);
		$csvdata=$this->lang->line('result_id').",".$this->lang->line('email').",".$this->lang->line('first_name').",".$this->lang->line('last_name').",".$this->lang->line('group_name').",".$this->lang->line('quiz_name').",".$this->lang->line('score_obtained').",".$this->lang->line('percentage_obtained').",".$this->lang->line('status')."\r\n";
		foreach($result as $rk => $val){
		$csvdata.=$val['rid'].",".$val['email'].",".$val['first_name'].",".$val['last_name'].",".$val['group_name'].",".$val['quiz_name'].",".$val['score_obtained'].",".$val['percentage_obtained'].",".$val['result_status']."\r\n";
		}
		$filename=time().'.csv';
		force_download($filename, $csvdata);

	}
	
	
	function view_result($rid){
		
		if(!$this->session->userdata('logged_in')){
		if(!$this->session->userdata('logged_in_raw')){
			redirect('login');
		}	
		}
		if(!$this->session->userdata('logged_in')){
		$logged_in=$this->session->userdata('logged_in_raw');	
		}else{
		$logged_in=$this->session->userdata('logged_in');
		}
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}
		
		
		 	
		$data['result']=$this->result_model->get_result($rid);
		$data['attempt']=$this->result_model->no_attempt($data['result']['quid'],$data['result']['uid']);
		$data['title']=$this->lang->line('result_id').' '.$data['result']['rid'];
		if($data['result']['view_answer']=='1' || $logged_in['su']=='1'){
		 $this->load->model("quiz_model");
		$data['saved_answers']=$this->quiz_model->saved_answers($rid);
		$data['questions']=$this->quiz_model->get_questions($data['result']['r_qids']);
		$data['options']=$this->quiz_model->get_options($data['result']['r_qids']);
// 		print_r($data['options']);
// 		exit();
		}
		$last_results = $this->result_model->get_siralama($data['result']['quid']);
		$data['last_results']=$last_results;
	$value=array();
     $value[]=array('Quiz Name','Percentage (%)');
     $i=0;
		// top 10 results of selected quiz
     foreach($last_results as $val){
         $i++;
     $value[]=array($val['email'].' ('.$val['first_name']." ".$val['last_name'].')',intval($val['percentage_obtained']));
     if ($i==10)
         break;
     }
     $data['value']=json_encode($value);
	 
	// time spent on individual questions
	$correct_incorrect=explode(',',$data['result']['score_individual']);
	 $qtime[]=array($this->lang->line('question_no'),$this->lang->line('time_in_sec'));
    foreach(explode(",",$data['result']['individual_time']) as $key => $val){
	if($val=='0'){
		$val=1;
	}
	 if($correct_incorrect[$key]=="1"){
	 $qtime[]=array($this->lang->line('q')." ".($key+1).") - ".$this->lang->line('correct')." ",intval($val));
	 }else if($correct_incorrect[$key]=='2' ){
	  $qtime[]=array($this->lang->line('q')." ".($key+1).") - ".$this->lang->line('incorrect')."",intval($val));
	 }else if($correct_incorrect[$key]=='0' ){
	  $qtime[]=array($this->lang->line('q')." ".($key+1).") -".$this->lang->line('unattempted')." ",intval($val));
	 }else if($correct_incorrect[$key]=='3' ){
	  $qtime[]=array($this->lang->line('q')." ".($key+1).") - ".$this->lang->line('pending_evaluation')." ",intval($val));
	 }
	}
	 $data['qtime']=json_encode($qtime);
	 $data['percentile'] = $this->result_model->get_percentile($data['result']['quid'], $data['result']['uid'], $data['result']['score_obtained']);

	  
	  $uid=$data['result']['uid'];
	  $quid=$data['result']['quid'];
	  $score=$data['result']['score_obtained'];
	  $query=$this->db->query(" select * from savsoft_result where score_obtained > '$score' and quid ='$quid'  ");
	  $data['rank']=$query->num_rows() + 1;
	  $query=$this->db->query(" select * from savsoft_result where quid ='$quid'  ");
	  $data['last_rank']=$query->num_rows();
	  $query=$this->db->query(" select * from savsoft_result where quid ='$quid'  order by score_obtained desc limit 3 ");
	  $data['toppers']=$query->result_array();
	  $query=$this->db->query(" select * from savsoft_result where quid ='$quid'  order by score_obtained asc limit 1 ");
	  $data['looser']=$query->row_array();
	
		$this->load->view('header',$data);
		if($this->session->userdata('logged_in')){
		$this->load->view('view_result',$data);
		}else{
		$this->load->view('view_result_without_login',$data);
			
		}
		$this->load->view('footer',$data);	
		
		
	}
	
	function view_result_otodnm($otodeneme_id){
	    
	    if(!$this->session->userdata('logged_in')){
	        if(!$this->session->userdata('logged_in_raw')){
	            redirect('login');
	        }
	    }
	    if(!$this->session->userdata('logged_in')){
	        $logged_in=$this->session->userdata('logged_in_raw');
	    }else{
	        $logged_in=$this->session->userdata('logged_in');
	    }
	    if($logged_in['base_url'] != base_url()){
	        $this->session->unset_userdata('logged_in');
	        redirect('login');
	    }
	    
	    $sorular=$this->quiz_model->get_sorular_otodeneme($otodeneme_id);

	    $qids=implode(',',$sorular['soru_id']); 
	    log_message("debug", "quids:".$qids);
        
	    $data['questions']=$this->quiz_model->get_questions($qids);
	    $data['options']=$this->quiz_model->get_options($qids);
	    
	   // $data['result']=$this->result_model->get_result($rid);
	  //  $data['attempt']=$this->result_model->no_attempt($data['result']['quid'],$data['result']['uid']);
	  //  $data['title']=$this->lang->line('result_id').' '.$data['result']['rid'];
// 	    if($data['result']['view_answer']=='1' || $logged_in['su']=='1'){
// 	        $this->load->model("quiz_model");
// 	        $data['saved_answers']=$this->quiz_model->saved_answers($rid);
// 	        // 		print_r($data['options']);
// 	        // 		exit();
// 	    }
	    
	    
	    
// 	    $uid=$data['result']['uid'];
// 	    $quid=$data['result']['quid'];
// 	    $score=$data['result']['score_obtained'];
// 	    $query=$this->db->query(" select * from savsoft_result where score_obtained > '$score' and quid ='$quid' group by score_obtained ");
// 	    $data['rank']=$query->num_rows() + 1;
// 	    $query=$this->db->query(" select * from savsoft_result where quid ='$quid'  group by score_obtained  ");
// 	    $data['last_rank']=$query->num_rows();
// 	    $query=$this->db->query(" select * from savsoft_result where quid ='$quid'  group by score_obtained  order by score_obtained desc limit 3 ");
// 	    $data['toppers']=$query->result_array();
// 	    $query=$this->db->query(" select * from savsoft_result where quid ='$quid'  group by score_obtained  order by score_obtained asc limit 1 ");
// 	    $data['looser']=$query->row_array();
	    
	    $this->load->view('header',$data);
	    $this->load->view('otodeneme_sonuclar',$data);
	    $this->load->view('footer',$data);
	    
	    
	}
	
	
	
	function generate_certificate($rid){
				if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}
		if(!$this->config->item('dompdf')){
		exit('DOMPDF library disabled in config.php file');
		
		}
	$data['result']=$this->result_model->get_result($rid);
	if($data['result']['gen_certificate']=='0'){
		exit();
	}
		// save qr 
	$enu=urlencode(site_url('login/verify_result/'.$rid));

	$qrname="./upload/".time().'.jpg';
	$durl="https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=".$enu."&choe=UTF-8";
	copy($durl,$qrname);
	 
	
	$certificate_text=$data['result']['certificate_text'];
	$certificate_text=str_replace('{qr_code}',"<img src='".$qrname."'>",$certificate_text);
	$certificate_text=str_replace('{email}',$data['result']['email'],$certificate_text);
	$certificate_text=str_replace('{first_name}',$data['result']['first_name'],$certificate_text);
	$certificate_text=str_replace('{last_name}',$data['result']['last_name'],$certificate_text);
	$certificate_text=str_replace('{percentage_obtained}',$data['result']['percentage_obtained'],$certificate_text);
	$certificate_text=str_replace('{score_obtained}',$data['result']['score_obtained'],$certificate_text);
	$certificate_text=str_replace('{quiz_name}',$data['result']['quiz_name'],$certificate_text);
	$certificate_text=str_replace('{status}',$data['result']['result_status'],$certificate_text);
	$certificate_text=str_replace('{result_id}',$data['result']['rid'],$certificate_text);
	$certificate_text=str_replace('{generated_date}',date('Y-m-d H:i:s',$data['result']['end_time']),$certificate_text);
	
	$data['certificate_text']=$certificate_text;
	// $this->load->view('view_certificate',$data);
	$this->load->library('pdf');
	$this->pdf->load_view('view_certificate',$data);
	$this->pdf->render();
	$filename=date('Y-M-d_H:i:s',time()).".pdf";
	$this->pdf->stream($filename);

	
	}
	
	
	function preview_certificate($quid){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}

		$this->load->model("quiz_model");
	  
	$data['result']=$this->quiz_model->get_quiz($quid);
	if($data['result']['gen_certificate']=='0'){
		exit();
	}
		// save qr 
	$enu=urlencode(site_url('login/verify_result/0'));
$tm=time();
	$qrname="./upload/".$tm.'.jpg';
	$durl="https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=".$enu."&choe=UTF-8";
	copy($durl,$qrname);
	 $qrname2=base_url('/upload/'.$tm.'.jpg');
	
	
	$certificate_text=$data['result']['certificate_text'];
	$certificate_text=str_replace('{qr_code}',"<img src='".$qrname2."'>",$certificate_text);
	$certificate_text=str_replace('{result_id}','1023',$certificate_text);
	$certificate_text=str_replace('{generated_date}',date('Y-m-d H:i:s',time()),$certificate_text);
	
	$data['certificate_text']=$certificate_text;
	  $this->load->view('view_certificate_2',$data);
	 
	
	}
	
}
