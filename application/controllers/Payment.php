<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->helper('url');
	   $this->load->model("user_model");
	   $this->load->model("sms_model");
	   $this->load->model("ozeluyelik_model");
	   $this->lang->load('basic', $this->config->item('language'));

	 }

	public function index($odemeTuru=1)
	{
		upgradeGroup($odemeTuru);
	}
	
function subscription_expired($uid){
				
		$data['uid']=$uid;
		$data['title']=$this->lang->line('subscription_expired');
		// fetching user info
		$data['user']=$this->user_model->get_user($uid);
		$this->load->view('header',$data);
		$this->load->view('subscription_expired',$data);
		$this->load->view('footer',$data);
	}
	
	function upgradeGroup($odemeTuru=1){
				
	    // redirect if not loggedin
	    if(!$this->session->userdata('logged_in')){
	        redirect('login');
	        
	    }
	    $logged_in=$this->session->userdata('logged_in');
	    if($logged_in['base_url'] != base_url()){
	        $this->session->unset_userdata('logged_in');
	        redirect('login');
	    }
	    
	    //daha önce biri giriş yapmışsa session u silip logine yönlendiriyoruz
	    log_message("debug", "tek_login_kontrolü yapılıyor.");
	    if(!$this->user_model->tek_login_kontrol($logged_in)){
	        log_message("debug", "tek_login_kontrolünden geçemedi.");
	        $this->session->unset_userdata('logged_in');
	        $this->session->set_flashdata('message', $this->lang->line('tek_login_mesaji'));
	        redirect('login');
	    }
	    log_message("debug", "tek_login_kontrolü yapıldı.");
	    
	    $logged_in=$this->session->userdata('logged_in');
	    if($logged_in['su']!='1'){
	        //exit($this->lang->line('permission_denied'));
	    }
	    
	    
	    $data['odemeTuru']=$odemeTuru;
	    $data['title']="Özel Üyelik";
	    // havale ile üyelik
	    //$data['odemeBildirimi']=$this->ozelUyelik_model->payment_list($limit);
	    $this->load->view('header',$data);
	    $this->load->view('odemeBildirimi',$data);
	    $this->load->view('footer',$data);
	}
	
	
	function odemeBildirimi($groupId=1,$odemeTuru=1){
	    $logged_in=$this->session->userdata('logged_in');
	    log_message('debug', '$groupId:'.$groupId);
	    log_message('debug', '$odemeTuru:'.$odemeTuru);
	    log_message('debug', 'user Base URL:'.$logged_in['base_url']);
	    log_message('debug', 'userID:'.$logged_in['uid']);
	    
	    // redirect if not loggedin
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
	        //exit($this->lang->line('permission_denied'));
	    }
	    
	    $anaSayfa=site_url('login');
	    if($this->ozeluyelik_model->insert_odemeBildirimi($groupId,$odemeTuru)){
	        $this->sms_model->send_sms($logged_in[first_name]." ".$logged_in[last_name]." yeni bir ödeme bildiri yaptı.",$this->config->item('telefon_no'));
	        $this->session->set_flashdata('message', "<div class='alert alert-success'>Ödeme bildiriminiz alınmıştır, onaylandıktan sonra özel üyelik avantajlarından faydalanabilirsiniz.<a href='".$anaSayfa."'>  Ana Sayfa</a> </div>");
	    }else{
	        $this->session->set_flashdata('message', "<div class='alert alert-danger'>Bir hata oluştu, lütfen site yönetimine başvurunuz. </div>");
	        
	    }
	    redirect('payment/upgradeGroup');
	    
	}
	
	function odemeOnay(){
	    $logged_in=$this->session->userdata('logged_in');
	    log_message('debug', '$odemeId:'.$this->input->post('payment_id'));
	    
	    // redirect if not loggedin
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
	    
	    $anaSayfa=site_url('login');
	    if($this->ozeluyelik_model->odemeyiOnayla()){
	        $this->session->set_flashdata('message', "<div class='alert alert-success'>Ödeme Onaylanmıştır</div>");
	    }else{
	        $this->session->set_flashdata('message', "<div class='alert alert-danger'>Bir hata oluştu, lütfen site yönetimine başvurunuz. </div>");
	        
	    }
	    redirect('payment_gateway');
	    
	}
	
function generate_report(){
		// redirect if not loggedin
		if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']!='1'){
			exit($this->lang->line('permission_denied'));
		}
			
		$this->load->helper('download');
		
		 $result=$this->payment_model->generate_report();
		$csvdata=$this->lang->line('transaction_id').",".$this->lang->line('email').",".$this->lang->line('first_name').",".$this->lang->line('last_name').",".$this->lang->line('payment_gateway').",".$this->lang->line('amount').",".$this->lang->line('paid_date').",".$this->lang->line('status')."\r\n";
		foreach($result as $rk => $val){
		$csvdata.=$val['transaction_id'].",".$val['email'].",".$val['first_name'].",".$val['last_name'].",".$val['payment_gateway'].",".$val['amount'].",".date('Y-m-d H:i:s',$val['paid_date']).",".$val['payment_status']."\r\n";
		}
		$filename=time().'.csv';
		force_download($filename, $csvdata);

	}
	
}
