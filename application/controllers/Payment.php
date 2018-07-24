<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Iyzipay\Model\CheckoutForm;
class Payment extends CI_Controller {
    
    var $iller = array('','Adana', 'Adıyaman', 'Afyon', 'Ağrı', 'Amasya', 'Ankara', 'Antalya', 'Artvin',
        'Aydın', 'Balıkesir', 'Bilecik', 'Bingöl', 'Bitlis', 'Bolu', 'Burdur', 'Bursa', 'Çanakkale',
        'Çankırı', 'Çorum', 'Denizli', 'Diyarbakır', 'Edirne', 'Elazığ', 'Erzincan', 'Erzurum', 'Eskişehir',
        'Gaziantep', 'Giresun', 'Gümüşhane', 'Hakkari', 'Hatay', 'Isparta', 'Mersin', 'İstanbul', 'İzmir',
        'Kars', 'Kastamonu', 'Kayseri', 'Kırklareli', 'Kırşehir', 'Kocaeli', 'Konya', 'Kütahya', 'Malatya',
        'Manisa', 'Kahramanmaraş', 'Mardin', 'Muğla', 'Muş', 'Nevşehir', 'Niğde', 'Ordu', 'Rize', 'Sakarya',
        'Samsun', 'Siirt', 'Sinop', 'Sivas', 'Tekirdağ', 'Tokat', 'Trabzon', 'Tunceli', 'Şanlıurfa', 'Uşak',
        'Van', 'Yozgat', 'Zonguldak', 'Aksaray', 'Bayburt', 'Karaman', 'Kırıkkale', 'Batman', 'Şırnak',
        'Bartın', 'Ardahan', 'Iğdır', 'Yalova', 'Karabük', 'Kilis', 'Osmaniye', 'Düzce');

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
	    
	   // print_r($logged_in);
	   // exit();
	    if($logged_in['gid']=='3'){
	        $this->session->set_flashdata('message', "<div class='alert alert-danger'>Zaten Özel Üyelik Grubundasınız! </div>");
	        redirect('quiz');
	        //exit($this->lang->line('permission_denied'));
	    }
	    
	    
	    $data['odemeTuru']=$odemeTuru;
	    $data['ucret']=$this->user_model->ozel_uyelik_ucreti($logged_in['kadro_id']);
	    $data['title']="Özel Üyelik";
	    // havale ile üyelik
	    //$data['odemeBildirimi']=$this->ozelUyelik_model->payment_list($limit);
	    $this->load->view('header',$data);
	    $this->load->view('odemeBildirimi',$data);
	    $this->load->view('footer',$data);
	}
	
	function indirimKodu(){
				
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
	    
	    $data['odemeTuru']=1;
	    $indirimMiktari=$this->ozeluyelik_model->indirim_kodu_dogrula();
	    $netindirim=$indirimMiktari[0]['miktar'];
	    $ucret=$this->user_model->ozel_uyelik_ucreti($logged_in['kadro_id']);
	    $data['ucret']=$ucret-$netindirim;
	    $this->session->set_userdata('kodindirimi', $netindirim);
	    $data['indirim_miktari']=$indirimMiktari[0]['miktar'];
	    $data['title']="Özel Üyelik";
	    $this->session->set_flashdata('message', "<div class='alert alert-info'>$netindirim TL indidim uygulanmıştır.</div>");
	    
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
	    $ucret = $this->user_model->ozel_uyelik_ucreti($logged_in['kadro_id']);
	    if($this->ozeluyelik_model->insert_odemeBildirimi($groupId,$odemeTuru,$ucret)){
	        $this->sms_model->send_sms($logged_in[first_name]." ".$logged_in[last_name]." yeni bir ödeme bildiri yaptı.",$this->config->item('telefon_no'));
	        $this->session->set_flashdata('message', "<div class='alert alert-success'>Ödeme bildiriminiz alınmıştır, onaylandıktan sonra özel üyelik avantajlarından faydalanabilirsiniz.<a href='".$anaSayfa."'>  Ana Sayfa</a> </div>");
	    }else{
	        $this->session->set_flashdata('message', "<div class='alert alert-danger'>Bir hata oluştu, lütfen site yönetimine başvurunuz. </div>");
	        
	    }
	    redirect('payment/upgradeGroup');
	    
	}
	
	function krediKarti(){
	    $logged_in=$this->session->userdata('logged_in');
// 	    log_message('debug', '$groupId:'.$groupId);
// 	    log_message('debug', '$odemeTuru:'.$odemeTuru);
// 	    log_message('debug', 'user Base URL:'.$logged_in['base_url']);
// 	    log_message('debug', 'userID:'.$logged_in['uid']);
	    
	    // redirect if not loggedin
	    if(!$this->session->userdata('logged_in')){
	        redirect('login');
	        
	    }
	    if($logged_in['base_url'] != base_url()){
	        $this->session->unset_userdata('logged_in');
	        redirect('login');
	    }
	    
	    $anaSayfa=site_url('login');
	    //eğer adres alanı gelmişse, ödeme hazırlıyoruz demektir.
	    if ($this->input->post('adres')!="") {
	    log_message("debug", "adres:".$this->input->post('adres'));
	    $ucret = $this->user_model->ozel_uyelik_ucreti($logged_in['kadro_id']);
	    log_message("debug", "indirim kodu net indirim:".$this->session->kodindirimi);
	    if($this->session->kodindirimi>0) {
	        $ucret=$ucret-$this->session->kodindirimi;
	    }
	    require_once('config_iyzico.php');
	    
	    # create request class
	    $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
	    $request->setLocale(\Iyzipay\Model\Locale::TR);
	    //$request->setConversationId("123456789");
	    $request->setPrice($ucret);
	    $request->setPaidPrice($ucret);
	    $request->setCurrency(\Iyzipay\Model\Currency::TL);
	    $request->setBasketId("1");
	    $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::SUBSCRIPTION);
	    $request->setCallbackUrl("https://www.bakanliksinav.com/sinav/payment/krediKartiReturn");
// 	    $request->setCallbackUrl("http://localhost/sinav/payment/krediKartiReturn");
	    $request->setEnabledInstallments(array(2, 3, 6, 9));
	    
	    $buyer = new \Iyzipay\Model\Buyer();
	    $buyer->setId($logged_in['uid']);
	    $buyer->setName($logged_in['first_name']);
	    $buyer->setSurname($logged_in['last_name']);
	    $buyer->setGsmNumber($logged_in['contact_no']);
	    $buyer->setEmail($logged_in['email']);
	    $buyer->setIdentityNumber($logged_in['uid']."0000");
	   // $buyer->setLastLoginDate("2015-10-05 12:43:35");
	    $buyer->setRegistrationDate($logged_in['registered_date']);
	    $buyer->setRegistrationAddress($this->input->post('adres'));
	    $buyer->setIp($this->input->ip_address());
	    $buyer->setCity($this->iller[$logged_in['il']]);
	    $buyer->setCountry("Turkey");
	  //  $buyer->setZipCode("34732");
	    $request->setBuyer($buyer);
	    
	    $shippingAddress = new \Iyzipay\Model\Address();
	    $shippingAddress->setContactName($logged_in['first_name']." ".$logged_in['last_name']);
	    $shippingAddress->setCity($this->iller[$logged_in['il']]);
	    $shippingAddress->setCountry("Turkey");
	    $shippingAddress->setAddress($this->input->post('adres'));
	  //  $shippingAddress->setZipCode("34742");
	    $request->setShippingAddress($shippingAddress);
	    $request->setBillingAddress($shippingAddress);
	    
	    $secondBasketItem = new \Iyzipay\Model\BasketItem();
	    $secondBasketItem->setId("1");
	    $secondBasketItem->setName("Özel Üyelik");
	    $secondBasketItem->setCategory1("Özel Üyelik");
	    $secondBasketItem->setCategory2("Ücretli Üyelik");
	    $secondBasketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
	    $secondBasketItem->setPrice($ucret);
	    $basketItems[0] = $secondBasketItem;
	    
	    $request->setBasketItems($basketItems);
	    
	    # make request
	    $checkoutFormInitialize = Iyzipay\Model\CheckoutFormInitialize::create($request, Config::options());
	    //print_r($checkoutFormInitialize);
	    if ($checkoutFormInitialize->getStatus()=="success") {
// 	        $this->ozeluyelik_model->insert_krediKartiOdeme($checkoutFormInitialize,3,$ucret);
            $data['islemHazir']="1";
            $data['OdemeFormuScripti'] = $checkoutFormInitialize->getCheckoutFormContent();
            $this->session->set_flashdata('iyzico', '<div id="iyzipay-checkout-form"  class="responsive"></div>');
            } else {
//                 print "<pre>";
//                 print_r($checkoutFormInitialize);
//                 print "</pre>";
//                 exit();
                $this->session->set_flashdata('message', "<div class='alert alert-danger'>Bir hata oluştu, lütfen site yönetimine başvurunuz. Hata Mesajı: " . $checkoutFormInitialize->getErrorMessage() . "</div>");
            }
	    }
	    $this->load->view('header',$data);
	    $this->load->view('odemeBildirimi',$data);
	    $this->load->view('footer',$data);
	    
	    
	    
// 	    if($this->ozeluyelik_model->insert_odemeBildirimi($groupId,$odemeTuru)){
// 	        $this->sms_model->send_sms($logged_in[first_name]." ".$logged_in[last_name]." yeni bir ödeme bildiri yaptı.",$this->config->item('telefon_no'));
// 	        $this->session->set_flashdata('message', "<div class='alert alert-success'>Ödeme bildiriminiz alınmıştır, onaylandıktan sonra özel üyelik avantajlarından faydalanabilirsiniz.<a href='".$anaSayfa."'>  Ana Sayfa</a> </div>");
// 	    }else{
// 	        $this->session->set_flashdata('message', "<div class='alert alert-danger'>Bir hata oluştu, lütfen site yönetimine başvurunuz. </div>");
	        
// 	    }
// 	    redirect('payment/upgradeGroup');
	    
	}
	function krediKartiReturn(){
	    $logged_in=$this->session->userdata('logged_in');
	    $token= $_POST['token'];
	    //token geldiyse ödeme gerçekleşti demektir.
	    if ($token!="") {
	        require_once('config_iyzico.php');
	        # create request class
	        $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
	        $request->setLocale(\Iyzipay\Model\Locale::TR);
	       // $request->setConversationId("123456789");
	        $request->setToken($token);
	        # make request
	        $odemeSonuc = \Iyzipay\Model\CheckoutForm::retrieve($request, Config::options());
	        # print result
	        //print_r($odemeSonuc);
	        //exit();
	        //ödeme başarılı olsun olmasın kayıt atıyoruz.
	        $this->ozeluyelik_model->insert_krediKartiOdeme($odemeSonuc,3);
	        if ($odemeSonuc->getStatus()=='success' && $odemeSonuc->getPaymentStatus()=='SUCCESS') {
	            $gid = 3;
	            $odemeTuru=2;
	            $this->ozeluyelik_model->insert_odemeBildirimi($gid,$odemeTuru,$odemeSonuc->getPaidPrice());
	            $sure = strtotime('+2 month');
	            $this->user_model->update_user_for_odeme($gid, $sure);
	            $this->session->set_flashdata('message', "<div class='alert alert-success'>Ödemeniz Başarıyla Gerçekleştirilmiştir. Özel Üyelik Avantajlarından Faydalanabilirsiniz. </div>");
	        } else {
	            $this->session->set_flashdata('message', "<div class='alert alert-danger'>Bir hata oluştu, lütfen site yönetimine başvurunuz, alınan hata:".$odemeSonuc->getErrorMessage()."</div>");
	        }
            redirect('quiz');
        } else {
            $this->session->set_flashdata('message', "<div class='alert alert-danger'>Bir hata oluştu, lütfen site yönetimine başvurunuz, alınan hata:".$odemeSonuc->getErrorMessage()."</div>");
            redirect('quiz');
	    }
// 	    echo "<pre>";
	    //print_r($_POST);
	    //echo ("token:".$_POST['token']);
// 	    echo "</pre>";
// 	    log_message('debug', '$groupId:'.$groupId);
// 	    log_message('debug', '$odemeTuru:'.$odemeTuru);
// 	    log_message('debug', 'user Base URL:'.$logged_in['base_url']);
// 	    log_message('debug', 'userID:'.$logged_in['uid']);
	    
	    // redirect if not loggedin
// 	    if(!$this->session->userdata('logged_in')){
// 	        redirect('login');
	        
// 	    }
// 	    if($logged_in['base_url'] != base_url()){
// 	        $this->session->unset_userdata('logged_in');
// 	        redirect('login');
// 	    }
	    
// 	    $anaSayfa=site_url('login');
	    
// 	    if($this->ozeluyelik_model->insert_odemeBildirimi($groupId,$odemeTuru)){
// 	        $this->sms_model->send_sms($logged_in[first_name]." ".$logged_in[last_name]." yeni bir ödeme bildiri yaptı.",$this->config->item('telefon_no'));
// 	        $this->session->set_flashdata('message', "<div class='alert alert-success'>Ödeme bildiriminiz alınmıştır, onaylandıktan sonra özel üyelik avantajlarından faydalanabilirsiniz.<a href='".$anaSayfa."'>  Ana Sayfa</a> </div>");
// 	    }else{
// 	        $this->session->set_flashdata('message', "<div class='alert alert-danger'>Bir hata oluştu, lütfen site yönetimine başvurunuz. </div>");
	        
// 	    }
// 	    redirect('payment/upgradeGroup');
	    
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
	        $this->session->set_flashdata('message', "<div class='alert alert-success'>İşlem Tamamlanmıştır.</div>");
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
