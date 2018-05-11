<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SendSMS extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->helper('url');
	   $this->load->model("sms_model");
	   $this->load->model("user_model");
	   $this->lang->load('basic', $this->config->item('language'));

	 }

	public function index($limit='0')
	{
	       log_message("debug", "ENVIRONMENT:".ENVIRONMENT);
		
        $this->loginController();

	    $data['limit']=$limit;
		$data['title']=$this->lang->line('smstitle');
		// fetching quiz list
		$data['result']=$this->notification_model->notification_list($limit);
		$this->load->view('header',$data);
		$this->load->view('notification_list',$data);
		$this->load->view('footer',$data);
	}
	
	
	
	public function register_token($device,$uid){
	 if($device=='web'){
	 $userdata=array(
	 'web_token'=>$_POST['currentToken']	 
	 );
	 }else{
	  $userdata=array(
	 'android_token'=>$_POST['currentToken']	 
	 );
	 }
	$this->db->where('uid',$uid);
	$this->db->update('savsoft_users',$userdata);
	
	}
	
	
	
	public function send_sms($user_id='0'){
	
        $this->loginController();
    		
    	$data['title']=$this->lang->line('send_notification');
    	$data['user_id']=$user_id;
	    $this->load->view('header',$data);
		$this->load->view('new_sms',$data);
		$this->load->view('footer',$data);
	}
	
	
	public function send_newsms(){
	
	
	$this->loginController();
		
	$logged_in=$this->session->userdata('logged_in');
	if($logged_in['su']!='1'){
	    exit($this->lang->line('permission_denied'));
	}
	
	
	$result = $this->sms_model->send_sms($this->input->post('sms_text'),$this->input->post('tel_no'),$this->input->post('smskime'));
	if (substr($result, 0,2)=="00") {
	   $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('notification_sent')." </div>");
	} else {
	    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('sms_error').", Hata Mesajı:".$result."</div>");
	}
		redirect('notification/index');
	
	}

 
	
}
