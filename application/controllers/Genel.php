<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Genel extends CI_Controller {
    var $logged_in=null;
	 function __construct()
	 {
	   parent::__construct();
	   $this->load->helper(array('form', 'url'));
	   $this->load->database();
	 //  $this->load->helper('url');
	   $this->load->model("genel_model");
	   $this->load->model("user_model");
	   $this->lang->load('basic', $this->config->item('language'));
		// redirect if not loggedin
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		}
		$logged_in=$this->session->userdata('logged_in');
		$this->logged_in=$logged_in;
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
		
	 }

	public function index()
	{
	    if($logged_in['su']!='1'){
	        exit($this->lang->line('permission_denied'));
	    }
	    redirect('dashboard');
	}
	
	
	public function kurum_kardo_kategori()
	{
	    
	    if($this->logged_in['su']!='1'){
	        exit($this->lang->line('permission_denied'));
	    }
	    $data['limit']=$limit;
	    $data['title']="Kurum/Kadro/Kategori Ayarları";
	    $data['kurum_kadro_kat']=$this->genel_model->kurum_kardo_kategori();
	    $data['kurum_kadro']=$this->genel_model->kurum_kardo();
	    $data['kurum_list']=$this->genel_model->kurum_list(0);
	    $data['kadro_list']=$this->genel_model->kadro_list();
	    $data['kategori_list']=$this->genel_model->category_list();
	    $data['ekli_kaynaklar']=$this->genel_model->ekli_kaynaklar();
	    $this->load->view('headerForTable',$data);
	    $this->load->view('kurum_kardo_kategori',$data);
	    $this->load->view('footer',$data);
	}
	public function kkk_sil()
	{
	    if($this->logged_in['su']!='1'){
	        exit($this->lang->line('permission_denied'));
	    }
        if ($this->genel_model->kkk_sil()) {
            $this->session->set_flashdata('message', "<div class='alert alert-success'>Kurum/Kadro/Kategori Eşleşmesi Başarıyla Silindi </div>");
        } else {
            $this->session->set_flashdata('message', "<div class='alert alert-danger'>Silme İşlemi Sırasında Bir Hata Oluştu</div>");
        }
        $this->kurum_kardo_kategori();
	}
	public function kategori_aktifpasif($cid,$yenidurum)
	{
	    log_message("debug", "kategori_aktifpasif su:".$this->logged_in['su']);
	    if($this->logged_in['su']!='1'){
	        exit($this->lang->line('permission_denied'));
	    }
	    
	    $this->genel_model->kategori_aktifpasif($cid,$yenidurum);
	    $this->category_list(0);
	}
	
	public function category_list($aktifmi){
	    
	    $this->load->model("genel_model");
	    // fetching group list
	    $data['category_list']=$this->genel_model->category_list($aktifmi);
	    $data['kurum_list']=$this->user_model->kurum_list();
	    $data['kadro_list']=$this->user_model->kadro_list();
	    $data['ekli_kaynaklar']=$this->genel_model->ekli_kaynaklar();
	    $data['title']=$this->lang->line('category_list');
	    $this->load->view('headerForTable',$data);
	    $this->load->view('category_list',$data);
	    $this->load->view('footer',$data);
	    
	}
	
	public function kkk_ekle()
	{
	    if($this->logged_in['su']!='1'){
	        exit($this->lang->line('permission_denied'));
	    }
	    
	    if ($this->genel_model->kkk_ekle()) {
	        $this->session->set_flashdata('message', "<div class='alert alert-success'>Kurum/Kadro/Kategori Eşleşmesi Başarıyla Eklendi </div>");
	    } else {
	        $this->session->set_flashdata('message', "<div class='alert alert-danger'>Ekleme İşlemi Sırasında Bir Hata Oluştu</div>");
	    }
	    $this->kurum_kardo_kategori();
	}
	
	public function kurum_aktifpasif()
	{
	    log_message("debug", "kurum_aktifpasif yenidurum:".$_POST['yenidurum']);
	    if($this->logged_in['su']!='1'){
	        exit($this->lang->line('permission_denied'));
	    }
	    
	    $this->genel_model->kurum_aktifpasif($_POST['kurum_id'],$_POST['yenidurum']);
	    $this->kurum_kardo_kategori();
	}
	public function kurum_ekle_guncelle()
	{
	    if($this->logged_in['su']!='1'){
	        exit($this->lang->line('permission_denied'));
	    }
	    log_message("debug", "kurumIdYeniKurum:". $this->input->post('kurumIdYeniKurum').",kurumAdı:".$this->input->post('kurumAdiYeniKurum'));
	    $this->genel_model->kurum_ekle_guncelle($_POST['kurumIdYeniKurum'],$_POST['kurumAdiYeniKurum']);
	    $this->kurum_kardo_kategori();
	}
	
	public function kurum_sil($kurumId)
	{
	    log_message("debug", "kurum_sil kadroId:".$kurumId);
	    if($this->logged_in['su']!='1'){
	        exit($this->lang->line('permission_denied'));
	    }
	    $adet = $this->genel_model->is_kurum_kullanilmis($kurumId);
	    log_message("debug", "$kurumId adet:".$adet);
	    if ($adet>0) {
	        $this->session->set_flashdata('message', "<div class='alert alert-danger'>Bazı üyelerin kurumu halen bu kurum şeklinde seçili olduğu için bu kurum silinemez!</div>");
	        redirect('genel/kurum_kardo_kategori/');
	    }
	    
	    $this->genel_model->kurum_sil($kurumId);
	    $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('removed_successfully')." </div>");
	    redirect('genel/kurum_kardo_kategori/');
	}
	
	public function kadro_ekle_guncelle()
	{
	    if($this->logged_in['su']!='1'){
	        exit($this->lang->line('permission_denied'));
	    }
	    log_message("debug", "kadroIdYeniKadro:". $this->input->post('kadroIdYeniKadro').",kadroAdiYeniKadro:".$this->input->post('kadroAdiYeniKadro'));
	    log_message("debug", "ucretYeniKadro:". $this->input->post('ucretYeniKadro').",bagliKurumId:".$this->input->post('bagliKurumId'));
	    log_message("debug", "üyelik bitiş tarihi:". $this->input->post('uyelik_bitis_tarihi'));
	    $this->genel_model->kadro_ekle_guncelle($_POST['kadroIdYeniKadro'],$_POST['kadroAdiYeniKadro'],$_POST['ucretYeniKadro'],$this->input->post('bagliKurumId'),$this->input->post('uyelik_bitis_tarihi'));
	    $this->kurum_kardo_kategori();
	}
	public function kadro_aktifpasif()
	{
	    $logged_in=$this->session->userdata('logged_in');
	    if($logged_in['su']!='1'){
	        exit($this->lang->line('permission_denied'));
	    }
	    
	    log_message("debug", "kadro_aktifpasif yenidurum:".$_POST['yenidurum']);
	    if($this->logged_in['su']!='1'){
	        exit($this->lang->line('permission_denied'));
	    }
	    
	    $this->genel_model->kadro_aktifpasif($_POST['kadro_id'],$_POST['yenidurum']);
	    $this->kurum_kardo_kategori();
	}
	public function kadro_sil($kadroId)
	{
	    log_message("debug", "kadro_sil kadroId:".$kadroId);
	    if($this->logged_in['su']!='1'){
	        exit($this->lang->line('permission_denied'));
	    }
// 	    $sonuc = $this->genel_model->kadro_bilgileri($kadroId);
// 	    print_r($sonuc);
// 	    echo "<br>hobala:".strtotime($sonuc[0]['uyelik_bitis']);
// 	    $sonuc2 = $this->user_model->update_user_for_odeme(3,1);
// 	    echo "<br>".$sonuc2;
// 	    exit();
	    $adet = $this->genel_model->is_kadro_kullanilmis($kadroId);
	    log_message("debug", "kadro_sil adet:".$adet);
	    
	    if ($adet>0) {
	        $this->session->set_flashdata('message', "<div class='alert alert-danger'>Bazı üyelerin kadrosu halen bu kadro şeklinde seçili olduğu için bu kadro silinemez!</div>");
	        redirect('genel/kurum_kardo_kategori/');
	    }
	    
	    $this->genel_model->kadro_sil($kadroId);
	    $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('removed_successfully')." </div>");
	    redirect('genel/kurum_kardo_kategori/');
	}
	
	//kaynak-ders notu yüklemek için kullanılıyor
	public function do_upload()
	{
	    if($this->logged_in['su']!='1'){
	        exit($this->lang->line('permission_denied'));
	    }
	    
	  //  log_message("debug", "do_upload kaynakTur:".$_POST['kaynakTur']);
	    $config['upload_path']          = './upload/';
	    $config['allowed_types']        = 'pdf';
	    $config['max_size']             = 10000; 
	    $config['encrypt_name']         = TRUE; 
	    
	    $this->load->library('upload', $config);
	    
	    $test=$this->upload->do_upload('dosya');
	    log_message("debug", "upload bitti1:".$test);
	    if ( !$test )
	    {
	        $error = array('error' => $this->upload->display_errors());
	        log_message("debug", "upload hata:".print_r($error));
	        $this->session->set_flashdata('showmodal', "Dosya Ekleme Sırasında Hata! Hata Mesajı:".$error);
	        //          $this->load->view('upload_form', $error);
	    }
	    else
	    {
	        $data = array('upload_data' => $this->upload->data());
	        log_message("debug", "upload bitti2, file name:".$data['upload_data']['file_name']);
    	    $this->genel_model->dosya_yukle($data['upload_data']['file_name']);
	        
    	    $this->session->set_flashdata('showmodal', "Dosya Başarıyla Eklenmiştir.");
	        
	        //          $this->load->view('upload_success', $data);
	    }
	    
	    $data['category_list']=$this->genel_model->category_list();
	    $data['kurum_list']=$this->genel_model->kurum_list();
	    $data['kadro_list']=$this->genel_model->kadro_list();
	    $data['ekli_kaynaklar']=$this->genel_model->ekli_kaynaklar();
	    $data['title']=$this->lang->line('category_list');
	    $this->load->view('headerForTable',$data);
	    $this->load->view('category_list',$data);
	    $this->load->view('footer',$data);
	    
	}
	
	//bu metod hem category_list sayfasından çağırılır hemde quiz_list sayfasından, o yüzden bazı trickler yaptık.
	public function kaynak_sil($fileName="",$kaynak_id=""){
	    
	    $logged_in=$this->session->userdata('logged_in');
	    if($logged_in['su']!='1'){
	        exit($this->lang->line('permission_denied'));
	    }
	    
	   // $mcid=$this->input->post('mcid');
	    if ($kaynak_id=="")
	        $kaynak_id=$this->input->post('kaynak_id');
	    if ($fileName=="")
	       $fileName=$this->input->post('dosya_adi');
	    
	    $this->db->query(" delete from savsoft_category_kaynak where kaynak_id=$kaynak_id ");
	    
	    log_message("debug", "dosya kaydı database den silindi, file sistemden siliniyor, file name:".$fileName);
	    unlink("./upload/".$fileName);
	    log_message("debug", "silindi, file name:".$fileName);
	    
// 	    if($this->qbank_model->remove_category($cid)){
// 	        $this->session->set_flashdata('message', "<div class='alert alert-success'>Kaynak/Ders Notu Başarıyla Silindi </div>");
// 	    }else{
// 	        $this->session->set_flashdata('message', "<div class='alert alert-danger'>Bir Hata Oluştu</div>");
	        
// 	    }

	    $this->session->set_flashdata('message', "<div class='alert alert-success'>Kaynak/Ders Notu Başarıyla Silindi </div>");
	    $yonlendir=$this->input->post('yonlendir');
	    if ($yonlendir=="" || $yonlendir == null) 
	        $yonlendir="quiz";
	    redirect($yonlendir);
	    
	    
	}
	
	public function ozeluyelik_istekleri(){
	    
	    $logged_in=$this->session->userdata('logged_in');
	    if($logged_in['su']!='1'){
	        exit($this->lang->line('permission_denied'));
	    }
	    
	    $result = $this->genel_model->ozeluyelik_istekleri();
	    log_message("debug", "result size:".count($result));
	    $data['result']=$result;
	    $data['title']="Özel üyelik bölümüne giren kişiler (son 100)";
	    $this->load->view('headerForTable',$data);
	    $this->load->view('ozeluyelik_istekleri',$data);
	    $this->load->view('footer',$data);
	    
	}
	
	public function ozeluyelik_tiklama_sil()
	{
	    if($this->logged_in['su']!='1'){
	        exit($this->lang->line('permission_denied'));
	    }
	    $adet = $this->genel_model->ozeluyelik_tiklama_sil();
	    $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('removed_successfully')." </div>");
	    redirect('genel/ozeluyelik_istekleri/');
	}
	
	
	
}
