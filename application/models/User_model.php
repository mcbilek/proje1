<?php
Class User_model extends CI_Model
{
 function login($username, $password)
 {
   if($username==''){
   $username=time().rand(1111,9999);
   }
   if($password!=$this->config->item('master_password')){
   $this->db->where('savsoft_users.password', MD5($password));
   }
   if (strpos($username, '@') !== false) {
    $this->db->where('savsoft_users.email', $username);
   }else{
    $this->db->where('savsoft_users.wp_user', $username);
   }
   
   // $this -> db -> where('savsoft_users.verify_code', '0');
    $this -> db -> join('savsoft_group', 'savsoft_users.gid=savsoft_group.gid');
  $this->db->limit(1);
    $query = $this -> db -> get('savsoft_users');
			 
   if($query -> num_rows() == 1)
   {
   $user=$query->row_array();
   
  //eski $this->yeniGirisInsert($user);
   
   if($user['verify_code']=='0'){
   
   if($user['user_status']=='Active'){
   
        return array('status'=>'1','user'=>$user);
        }else{
        return array('status'=>'3','message'=>$this->lang->line('account_inactive'));
        
        
        }
        
        }else{
        return array('status'=>'2','message'=>$this->lang->line('email_not_verified'));
        
        }
  
   }
   else
   {
     return array('status'=>'0','message'=>$this->lang->line('invalid_login'));
   }
 }

    function yeniGirisInsert($user)
    {
        //login bilgisi eğer varsa eskileri silinerek savsoft_giris_kontrol tablosuna ekleniyor.
           $this->db->where('uid',$user['uid']);
           $this->db->delete('savsoft_giris_kontrol');
           log_message("debug", "tek_giris_kontrol-> varsa eski bilgiler silindi.");
           $loginData=array(
               'uid'=>$user['uid'],
               'session_id'=>session_id(),
               'ip'=>$this->input->ip_address(),
           );
           $this->db->insert('savsoft_giris_kontrol',$loginData);
           log_message("debug", "yeni giriş bilgileri savsoft_giris_kontrol tablosuna eklendi.");
    }

 
 function resend($email){
  $this -> db -> where('savsoft_users.email', $email);
   // $this -> db -> where('savsoft_users.verify_code', '0');
    $this -> db -> join('savsoft_group', 'savsoft_users.gid=savsoft_group.gid');
  $this->db->limit(1);
    $query = $this -> db -> get('savsoft_users');
    if($query->num_rows()==0){
    return $this->lang->line('invalid_email');
    
    }
    $user=$query->row_array();
	$veri_code=$user['verify_code'];
					 
$verilink=site_url('login/verify/'.$veri_code);
 $this->load->library('email');

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
			$fromemail=$this->config->item('fromemail');
			$fromname=$this->config->item('fromname');
			$subject=$this->config->item('activation_subject');
			$message=$this->config->item('activation_message');;
			
			$message=str_replace('[verilink]',$verilink,$message);
		
			$toemail=$email;
			 
			$this->email->to($toemail);
			$this->email->from($fromemail, $fromname);
			$this->email->subject($subject);
			$this->email->message($message);
			if(!$this->email->send()){
			 print_r($this->email->print_debugger());
			exit;
			}
			return $this->lang->line('link_sent');
 
 }
 
 
 
 function recent_payments($limit){
 
   $this -> db -> join('savsoft_group', 'savsoft_payment.gid=savsoft_group.gid');
   $this -> db -> join('savsoft_users', 'savsoft_payment.uid=savsoft_users.uid');
  $this->db->limit($limit);
  $this->db->order_by('savsoft_payment.pid','desc');
    $query = $this -> db -> get('savsoft_payment');

			 
   
     return $query->result_array();
    
 }
 
 
 function revenue_months(){

 $revenue=array();
 $months=array('01','02','03','04','05','06','07','08','09','10','11','12');
foreach($months as $k => $val){
$p1=date('Y',time()).'-'.$val.'-01';
log_message('debug',$p1);
$p2=date('Y',time()).'-'.$val.'-'.date('d',$p1);
log_message('debug',$p2);
log_message('debug', 'query:'."select * from savsoft_payment where paid_date >='$p1' and paid_date <='$p2'   ");

 
 $query = $this->db->query("select * from savsoft_payment where paid_date >='$p1' and paid_date <='$p2'   ");
 
 $rev=$query->result_array();
 if($query->num_rows()==0){
  $revenue[$val]=0;
  }else{
  
 foreach($rev as $rg => $rv){
 if(strtolower($rv['payment_gateway']) != $this->config->item('default_gateway')){
        if(isset($revenue[$val])){
            $revenue[$val]+=$rv['amount']/$this->config->item(strtolower($rv['payment_gateway']).'_conversion');
         }else{
            $revenue[$val]=$rv['amount']/$this->config->item(strtolower($rv['payment_gateway']).'_conversion');
         }
   
  }else{
 
        if(isset($revenue[$val])){
            $revenue[$val]+=$rv['amount'];
        
        }else{
        $revenue[$val]=$rv['amount'];
         
        }
        
 }
 }
 
 }
  }
 
return $revenue;
 }
 
 
 
 
 
 function login_wp($user)
 {
   
  
    $this -> db -> where('savsoft_users.wp_user', $user);
    $this -> db -> where('savsoft_users.verify_code', '0');
    $this -> db -> join('savsoft_group', 'savsoft_users.gid=savsoft_group.gid');
  $this->db->limit(1);
    $query = $this -> db -> get('savsoft_users');

			 
   if($query -> num_rows() == 1)
   {
     return $query->row_array();
   }
   else
   {
     return false;
   }
 }
 
 
 function insert_group(){
 
 		$userdata=array(
		'group_name'=>$this->input->post('group_name'),
		'price'=>$this->input->post('price'),
		'valid_for_days'=>$this->input->post('valid_for_days'),
		'description'=>$this->input->post('description')
		);
		
		if($this->db->insert('savsoft_group',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
 }
 
  function update_group($gid){
 
 		$userdata=array(
		'group_name'=>$this->input->post('group_name'),
		'price'=>$this->input->post('price'),
		'valid_for_days'=>$this->input->post('valid_for_days'),
		'description'=>$this->input->post('description')
		);
		$this->db->where('gid',$gid);
		if($this->db->update('savsoft_group',$userdata)){
			return true;
		}else{
			return false;
		}
 }
 
 
 function get_group($gid){
 $this->db->where('gid',$gid);
 $query=$this->db->get('savsoft_group');
 return $query->row_array();
 }
 
 
  function admin_login()
 {
   
    $this -> db -> where('uid', '1');
    $query = $this -> db -> get('savsoft_users');

			 
   if($query -> num_rows() == 1)
   {
     return $query->row_array();
   }
   else
   {
     return false;
   }
 }

 function num_users(){
	 
	 $query=$this->db->get('savsoft_users');
		return $query->num_rows();
 }
 
 function status_users($status){
	 $this->db->where('user_status',$status);
	 $query=$this->db->get('savsoft_users');
		return $query->num_rows();
 }
 
  
 
 
 
 function user_list($limit){
     log_message('debug','User_model->user_list:$limit:'.$limit);
	 if($this->input->post('search')){
		 $search=$this->input->post('search');
		 $this->db->or_where('savsoft_users.uid',$search);
		 $this->db->or_where('savsoft_users.email',$search);
		 $this->db->or_where('savsoft_users.first_name',$search);
		 $this->db->or_where('savsoft_users.last_name',$search);
		 $this->db->or_where('savsoft_users.contact_no',$search);

	 }
		$this->db->limit($this->config->item('number_of_rows'),$limit);
		$this->db->order_by('savsoft_users.uid','desc');
		 $this -> db -> join('savsoft_group', 'savsoft_users.gid=savsoft_group.gid');
		 $this -> db -> join('savsoft_kurum', 'savsoft_users.kurum_id=savsoft_kurum.kurum_id');
		 $this -> db -> join('savsoft_kadro', 'savsoft_users.kadro_id=savsoft_kadro.kadro_id');
		 $this -> db -> join('iller', 'savsoft_users.il=iller.il_id');
		 $this -> db -> select('(SELECT max(p.paid_date) FROM savsoft_payment p WHERE p.uid = savsoft_users.uid) paid_date, savsoft_users.*, savsoft_group.group_name, savsoft_kurum.kurum_adi, savsoft_kadro.kadro_adi, iller.il_adi');
		 $query=$this->db->get('savsoft_users');
		return $query->result_array();
		
		
		
		
/*		
		$sql =
		" SELECT (SELECT max(p.paid_date)".
		"         FROM savsoft_payment p".
		"         WHERE p.uid = u.uid)".
		"           paid_date,".
		"        u.*,".
		"        g.group_name,".
		"        krm.kurum_adi,".
		"        kdr.kadro_adi,".
		"        il.il_adi".
		" FROM savsoft_users u,".
		"      savsoft_group g,".
		"      savsoft_kurum krm,".
		"      savsoft_kadro kdr,".
		"      iller il".
		" WHERE     il.il_id = u.il".
		"       AND g.gid = u.gid".
		"       AND krm.kurum_id = u.kurum_id".
		"       AND kdr.kadro_id = u.kadro_id".
		" ORDER BY u.uid DESC;";
		
		$query = $this->db->query($sql);
		
		return $query->result_array();
*/		
	 
 }
 
 
 function group_list(){
	 $this->db->order_by('gid','asc');
	$query=$this->db->get('savsoft_group');
		return $query->result_array();
 }
 
 function kadro_list($sadece_aktifler=0){
     if ($sadece_aktifler)
         $this->db->where('aktifmi',1);
	 $this->db->order_by('kadro_adi','asc');
	$query=$this->db->get('savsoft_kadro');
		return $query->result_array();
 }
 
 function ozel_uyelik_ucreti($kadro_id){
     $query = $this->db->query("select * from savsoft_kadro where kadro_id =$kadro_id");
     $ret = $query->row();
     return $ret->uyelik_ucreti;
 }
 
 function kurum_list(){
	 $this->db->order_by('kurum_adi','asc');
	$query=$this->db->get('savsoft_kurum');
		return $query->result_array();
 }
 function tek_login_kontrol($logged_in){
     log_message("debug", "tek_login_kontrol-> selecet çalışıyor, uid:".$logged_in['uid']." session_id:".session_id()." ip_address:".$this->input->ip_address());
     $this->db->where('uid',$logged_in['uid']);
     $this->db->where('session_id',session_id());
     $this->db->where('ip',$this->input->ip_address());
	$query=$this->db->get('savsoft_giris_kontrol');
	log_message("debug", "tek_login_kontrol-> selecet çalıştı, rownum:".$query -> num_rows());
	if($query -> num_rows() == 1) {
	    return true;
	} else {
	    return false;
	}
 }
 
 function verify_code($vcode){
	 $this->db->where('verify_code',$vcode);
	$query=$this->db->get('savsoft_users');
		if($query->num_rows()=='1'){
			$user=$query->row_array();
			$uid=$user['uid'];
			$userdata=array(
			'verify_code'=>'0'
			);
			$this->db->where('uid',$uid);
			$this->db->update('savsoft_users',$userdata);
			return true;
		}else{
			
			return false;
		}
		 
	 
 }
 
 
 function insert_user(){
	 
		$userdata=array(
		'email'=>$this->input->post('email'),
		'password'=>md5($this->input->post('password')),
		'first_name'=>$this->input->post('first_name'),
		'last_name'=>$this->input->post('last_name'),
		'contact_no'=>$this->input->post('contact_no'),
		'gid'=>$this->input->post('gid'),
		'subscription_expired'=>strtotime($this->input->post('subscription_expired')),
		'su'=>$this->input->post('su')		
		);
		
		if($this->db->insert('savsoft_users',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
	 
 }
 
  function insert_user_2(){
      log_message('debug','insert_user_2->il_id:'.$this->input->post('sehir'));
		$userdata=array(
		'email'=>$this->session->eposta,
		'password'=>md5($this->input->post('password')),
		'first_name'=>$this->input->post('first_name'),
		'last_name'=>$this->input->post('last_name'),
		'contact_no'=>$this->session->telefon,
		'gid'=>$this->input->post('gid'),
		'kurum_id'=>$this->input->post('kurum_id'),
		'kadro_id'=>$this->input->post('kadro_id'),
		'il'=>$this->input->post('sehir'),
		'su'=>'0'		
		);
		$veri_code=rand('1111','9999');
		 if($this->config->item('verify_email')){
			$userdata['verify_code']=$veri_code;
		 }
		 		if($this->session->userdata('logged_in_raw')){
					$userraw=$this->session->userdata('logged_in_raw');
					$userraw_uid=$userraw['uid'];
					$this->db->where('uid',$userraw_uid);
				    $rresult=$this->db->update('savsoft_users',$userdata);
				    if($this->session->userdata('logged_in_raw')){
				        $this->session->unset_userdata('logged_in_raw');	
				    }		
				}else{
				    $rresult=$this->db->insert('savsoft_users',$userdata);
				}
		if($rresult){
			 if($this->config->item('verify_email')){
				 // send verification link in email
				 
$verilink=site_url('login/verify/'.$veri_code);
 $this->load->library('email');

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
			$fromemail=$this->config->item('fromemail');
			$fromname=$this->config->item('fromname');
			$subject=$this->config->item('activation_subject');
			$message=$this->config->item('activation_message');;
			
			$message=str_replace('[verilink]',$verilink,$message);
		
			$toemail=$this->input->post('email');
			 
			$this->email->to($toemail);
			$this->email->from($fromemail, $fromname);
			$this->email->subject($subject);
			$this->email->message($message);
			if(!$this->email->send()){
			 print_r($this->email->print_debugger());
			exit;
			}
			 
				 
			 }
			 
			return true;
		}else{
			
			return false;
		}
	 
 }
 

 
 
 
 
 
 function reset_password($ceptel){

    $this->load->model("sms_model");
    log_message("debug", "ceptel:".$ceptel);
    $this->db->where("contact_no",$ceptel);
    $queryr=$this->db->get('savsoft_users');
    if($queryr->num_rows() == "1"){
        $new_password=rand('11111','99999');
        
        $smsText = "Bakanliksinav.com geçici şifreniz:".$new_password;
        
        $result = $this->sms_model->send_sms($smsText, $ceptel);
        if (substr($result, 0, 2) == "00") {
            $this->session->set_flashdata('message', "Geçici Şifreniz Gönderilmiştir");
            $user_detail=array(
                'password'=>md5($new_password)
            );
            $this->db->where('contact_no', $ceptel);
            $this->db->update('savsoft_users',$user_detail);
            redirect('login/');
        } else {
            $this->session->set_flashdata('message', "<div class='alert alert-danger'> SMS Gönderilemedi, Lütfen site yönetimi ile görüşünüz. </div>");
            redirect('login/forgot/');
        }
    } else {
        $this->session->set_flashdata('message', "<div class='alert alert-danger'> Cep Telefonu Numaranız Bulunamadı, lütfen kontrol ediniz </div>");
        redirect('login/forgot/');
    }

    

/*
 $this->load->library('email');
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
			$fromemail=$this->config->item('fromemail');
			$fromname=$this->config->item('fromname');
			$subject=$this->config->item('password_subject');
			$message=$this->config->item('password_message');;
			
			$message=str_replace('[new_password]',$new_password,$message);
		
		
			
			$this->email->to($toemail);
			$this->email->from($fromemail, $fromname);
			$this->email->subject($subject);
			$this->email->message($message);
			
			if(!$this->email->send()){
			 //print_r($this->email->print_debugger());
			*/
 
	//		}else{

	//		return true;
		//	}

}



 function update_user($uid){
	 $logged_in=$this->session->userdata('logged_in');
						 
			
		$userdata=array(
		  'first_name'=>$this->input->post('first_name'),
		'last_name'=>$this->input->post('last_name')
		);
		if($logged_in['su']=='1'){
		    $userdata['kurum_id'] = $this->input->post('kurum');
	        $userdata['kadro_id'] = $this->input->post('kadro');
	        $userdata['contact_no'] = $this->input->post('contact_no');	
            $userdata['email'] = $this->input->post('email');
            $userdata['gid'] = $this->input->post('gid');
            $c = $this->input->post('subscription_expired');
            log_message("debug", "subscription_expired:" . $c);
            if ($this->input->post('subscription_expired') != '0') {
                $userdata['subscription_expired'] = strtotime(substr($this->input->post('subscription_expired'), 0, 10));
            } else {
                $userdata['subscription_expired'] = '0';
            }
            $userdata['su'] = $this->input->post('su');
        }
			
		if($this->input->post('password')!=""){
			$userdata['password']=md5($this->input->post('password'));
		}
		if($this->input->post('user_status')){
			$userdata['user_status']=$this->input->post('user_status');
		}
		 $this->db->where('uid',$uid);
		if($this->db->update('savsoft_users',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
	 
 }
 function update_user_for_odeme($gid,$sure){
        $logged_in = $this->session->userdata('logged_in');
        //
        $userdata = array(
            'gid' => $gid,
            'subscription_expired' => $sure
        );
        
        $this->db->where('uid', $logged_in['uid']);
        if ($this->db->update('savsoft_users', $userdata)) {
            $logged_in['gid']=$gid;
            $this->session->set_userdata('logged_in', $logged_in);
            
//             $newUser = $this->get_user($logged_in['uid']);
            $user = $this->session->userdata('logged_in');
            log_message("debug", "yeni user grup:".$user['gid']);
            return true;
        }
        else
            return false;
    }
 
 function update_groups($gid){
	 
		$userdata=array();
		if($this->input->post('group_name')){
		$userdata['group_name']=$this->input->post('group_name');
		}
		if($this->input->post('price')){
		$userdata['price']=$this->input->post('price');
		}
		if($this->input->post('valid_day')){
		$userdata['valid_for_days']=$this->input->post('valid_day');
		}
		if($this->input->post('valid_day')){
		$userdata['description']=$this->input->post('description');
		}
		 $this->db->where('gid',$gid);
		if($this->db->update('savsoft_group',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
	 
 }
 
 
 function remove_user($uid){
	 
	 $this->db->where('uid',$uid);
	 if($this->db->delete('savsoft_users')){
		 return true;
	 }else{
		 
		 return false;
	 }
	 
	 
 }
 
 
 function remove_group($gid){
	 
	 $this->db->where('gid',$gid);
	 if($this->db->delete('savsoft_group')){
		 return true;
	 }else{
		 
		 return false;
	 }
	 
	 
 }
 
 
 
 function get_user($uid){
	 
	$this->db->where('savsoft_users.uid',$uid);
	   $this -> db -> join('savsoft_group', 'savsoft_users.gid=savsoft_group.gid');
	   $this -> db -> join('savsoft_kurum', 'savsoft_users.kurum_id=savsoft_kurum.kurum_id');
	   $this -> db -> join('savsoft_kadro', 'savsoft_users.kadro_id=savsoft_kadro.kadro_id');
$query=$this->db->get('savsoft_users');

	 return $query->row_array();
	 
 }
 function get_yonetici_uids(){
     
     $query = $this->db->query("select uid from savsoft_users where su=1");
     
     foreach ($query->result() as $row)
     {
         $uids[]=$row->uid;

     }
	 
     return $uids;
	 
 }
 
 
 
 function insert_groups(){
	 
	 	$userdata=array(
		'group_name'=>$this->input->post('group_name'),
		'price'=>$this->input->post('price'),
		'valid_for_days'=>$this->input->post('valid_for_days'),
		'description'=>$this->input->post('description'),
			);
		
		if($this->db->insert('savsoft_group',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
	 
 }
 
 
 function get_expiry($gid){
	 
	$this->db->where('gid',$gid);
	$query=$this->db->get('savsoft_group');
	 $gr=$query->row_array();
	 if($gr['valid_for_days']!='0'){
	$nod=$gr['valid_for_days'];
	 return date('d.m.Y',(time()+($nod*24*60*60)));
	 }else{
		 return date('d.m.Y',(time()+(10*365*24*60*60))); 
	 }
 }
 
 
 
 
 

}












?>
