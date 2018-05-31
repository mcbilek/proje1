<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mesajlar extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->helper('url');
	   $this->load->model("user_model");
// 	   log_message("debug", "mahana_messaging load ediliyor");
	   $this->load->library('mahana_messaging');
// 	   log_message("debug", "mahana_messaging load edildi");
	     $this->lang->load('basic', $this->config->item('language'));

	 }

	public function index($limit='0')
	{
	    log_message("debug", "ENVIRONMENT:".ENVIRONMENT);
		
	    $this->loginController();
	    $logged_in=$this->session->userdata('logged_in');
	    $mahana = new Mahana_messaging();
// 	    $msg="5 id li üyeye cevap";
// 	    $status = $mahana->send_new_message($logged_in['uid'], 5 ,"konu","5 id li üyeye yeni mesaj ğüişçöı ÜĞİŞÇÖ");
// 	    $status = $mahana->reply_to_message(3, 5,-1,"konular",$msg);
// 	    if ($status['err']==MSG_SUCCESS)
// 	        $basarili="";
// 	    print_r($logged_in['uid']);
// 	    echo "<br>";
// 	    print_r($status);
// 	    exit();
// 	    if($logged_in['su']!='1'){
// 	        exit($this->lang->line('permission_denied'));
// 	    }
        $mesajs=$mahana->get_all_threads_grouped($logged_in['uid'],true);
//       print "<pre>";
//       print_r($mesajs);
//       print "</pre>";
//        exit();

	    
		$data['title']=$this->lang->line('mesajlar_title');
		if ($mesajs['error']==MSG_SUCCESS)
		  $data['mesajlar']=$mesajs['retval'];
		// fetching quiz list
	//	$data['result']=$this->notification_model->notification_list($limit);
		$this->load->view('header',$data);
		$this->load->view('mesajlar',$data);
		$this->load->view('footer',$data);
	}
	
	
	
	public function cevap_gonder(){
	    if ($this->input->post('islem_tur')==2) {
	        $this->yeni_mesaj_gonder();
	    } else {
	        
	    log_message("debug", "ENVIRONMENT:".ENVIRONMENT);
	    log_message("debug", "cevap_gonder geldi:");
	    
	    $this->loginController();
	    $logged_in=$this->session->userdata('logged_in');
	    $mahana = new Mahana_messaging();
        
	    $mahana->reply_to_message($logged_in['uid'],-1,$this->input->post('thrd_id'),$this->input->post('mesaj'));
	    $mesajs=$mahana->get_all_threads_grouped($logged_in['uid'],true);
        
        $data['title']=$this->lang->line('mesajlar_title');
        if ($mesajs['error']==MSG_SUCCESS)
            $data['mesajlar']=$mesajs['retval'];
        
        $this->load->view('header',$data);
        $this->load->view('mesajlar',$data);
        $this->load->view('footer',$data);
	    }
	}
	
	function hataBildir(){
        log_message("debug", "hataBildir geliyor");
        log_message("debug", "hataBildir geldi");
        log_message("debug", $_POST['konu']);
        log_message("debug", $_POST['mesaj']);
        log_message("debug", $_POST['soru_no']);
        
        $this->loginController();
        $logged_in = $this->session->userdata('logged_in');
        $mahana = new Mahana_messaging();
        $aliciUserId = 42;
        $title = $this->input->post('konu').",soru no:".$this->input->post('soru_no');
        $mesaj = $this->input->post('soru_no')." id li soru için, hata bildirimi:".$this->input->post('mesaj');
        $mesaj = $mesaj.", soruyu düzenlemek için <a href='".site_url('qbank/edit_question_1/'.$this->input->post('soru_no'))."'>tıklayın</a>";
        //http://localhost/sinav/qbank/edit_question_1/36
        
        $mahana->send_new_message($logged_in['uid'], $aliciUserId, $title, $mesaj);
//        $this->session->set_flashdata('message', "<div class='alert alert-success alert-dismissible fade in' role='alert'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Mesajınız Başarıyla Gönderilmiştir. </div>");
    }
	
	
	public function yeni_mesaj_gonder(){
	    //print_r($_POST);
// 	    exit();
	    log_message("debug", "ENVIRONMENT:".ENVIRONMENT);
	    //exit();
	    
	    $this->loginController();
	    $logged_in=$this->session->userdata('logged_in');
	    $mahana = new Mahana_messaging();
	    $aliciUserId=$mahana->get_user_id($this->input->post('email'));
	    if($aliciUserId>0) {
            if (empty($this->input->post('konu')))
                $title = $this->input->post('title');
            else
                $title = $this->input->post('konu');
            if (empty($this->input->post('mesaj')))
                $mesaj = $this->input->post('message');
            else
                $mesaj = $this->input->post('mesaj');
	                    
            $mahana->send_new_message($logged_in['uid'],$aliciUserId,$title,$mesaj);
	        $this->session->set_flashdata('message', "<div class='alert alert-success alert-dismissible fade in' role='alert'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Mesajınız Başarıyla Gönderilmiştir. </div>");
	    } else {
	        $this->session->set_flashdata('message', "<div class='alert alert-danger alert-dismissible fade in'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Email Adresi Bulunamadı! </div>");
	    }
	    $mesajs=$mahana->get_all_threads_grouped($logged_in['uid'],true);
        
        $data['title']=$this->lang->line('mesajlar_title');
        if ($mesajs['error']==MSG_SUCCESS)
            $data['mesajlar']=$mesajs['retval'];
        
        $this->load->view('header',$data);
        $this->load->view('mesajlar',$data);
        $this->load->view('footer',$data);
	}
	
	
	
}
