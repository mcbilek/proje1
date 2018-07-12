<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->helper('url');
	   $this->load->model("user_model");
	   $this->load->model("qbank_model");
	   $this->load->model("quiz_model");
	   $this->load->model("result_model");
	   $this->load->library('onlineusers');
	   $this->lang->load('basic', $this->config->item('language'));
		// redirect if not loggedin
		if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
				$this->session->unset_userdata('logged_in');		
			redirect('login');
		}
		//daha önce biri giriþ yapmýþsa session u silip logine yönlendiriyoruz
		log_message("debug", "tek_login_kontrolü yapýlýyor.");
		if(!$this->user_model->tek_login_kontrol($logged_in)){
		    log_message("debug", "tek_login_kontrolünden geçemedi.");
		    $this->session->unset_userdata('logged_in');
		    $this->session->set_flashdata('message', $this->lang->line('tek_login_mesaji'));
		    redirect('login');
		}
		log_message("debug", "tek_login_kontrolü yapýldý.");
		
	 }

	public function index()
	{
		$data['title']=$this->lang->line('dashboard');
		
		$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']=='1'){
				
		$data['result']=$this->user_model->user_list(30);
		$data['active_users']=$this->user_model->status_users('Active');
		//$data['inactive_users']=$this->user_model->status_users('Inactive');
		$data['payments']=$this->user_model->recent_payments(12);
		$data['revenue_months']=$this->user_model->revenue_months();
				
				
		$data['num_users']=$this->user_model->num_users();
		$data['num_qbank']=$this->qbank_model->num_qbank();
		$data['num_quiz']=$this->quiz_model->num_quiz();
		$data['onlineusers']=$this->onlineusers->total_mems();
		
			}
			

		
	 
	 
		$this->load->view('header',$data);
		$this->load->view('dashboard',$data);
		$this->load->view('footer',$data);
	}
	
	
		public function config(){
		
		$logged_in=$this->session->userdata('logged_in');

			if($logged_in['su']!='1'){
			exit($this->lang->line('permission_denied'));
			}
			if($this->config->item('frontend_write_admin') > $logged_in['su']){
			exit($this->lang->line('permission_denied'));
			}			
			
		if($this->input->post('config_val')){
		if($this->input->post('force_write')){
		if(chmod("./application/config/config.php",0777)){ } 	
		}
		
		$file="./application/config/config.php";
		$content=$this->input->post('config_val');
		 file_put_contents($file,$content);
		if($this->input->post('force_write')){
		if(chmod("./application/config/config.php",0644)){ } 	
		}

		 	 redirect('dashboard/config');
		} 
		 
		$data['result']=file_get_contents('./application/config/config.php');
		$data['title']=$this->lang->line('config');
		$this->load->view('header',$data);
		$this->load->view('config',$data);
		$this->load->view('footer',$data);

		}



		public function css(){
		
		$logged_in=$this->session->userdata('logged_in');

			if($logged_in['su']!='1'){
			exit($this->lang->line('permission_denied'));
			}
			
			
		if($this->input->post('config_val')){
		if($this->input->post('force_write')){
		if(chmod("./css/style.css",0777)){ } 	
		}

		$file="./css/style.css";
		$content=$this->input->post('config_val');
		 file_put_contents($file,$content);
		if($this->input->post('force_write')){
		if(chmod("./css/style.css",0644)){ } 	
		}

		 redirect('dashboard/css');
		} 
		 
		$data['result']=file_get_contents('./css/style.css');
		$data['title']=$this->lang->line('config');
		$this->load->view('header',$data);
		$this->load->view('css',$data);
		$this->load->view('footer',$data);

		}		
		
		
		
	
}
