<?php
use Iyzipay\Model\CheckoutForm;
use Iyzipay\Model\CheckoutFormInitialize;

Class Ozeluyelik_model extends CI_Model
{
    
    
    function insert_odemeBildirimi($group_id,$odemeTuru,$amount=0,$cardFamily="",$paymentStatus="",$paymentId=""){
        $logged_in=$this->session->userdata('logged_in');
//         switch ($group_id){
//             case 3:
//                 $amount=100;
//                 break;
//             case 1:
//                 $amount=0;
//                 break;
//             default:
//                 $amount=0;
//         }
        log_message('debug', 'payment_gateway:'.$odemeTuru);
        log_message('debug', 'bankaAdi:'.$this->input->post('bankaAdi'));
        log_message('debug', 'amount:'.$amount);
        log_message('debug', 'uid:'.$logged_in['uid']);
        log_message('debug', 'gid:'.$group_id);
        if ($odemeTuru==1)  {
        $odemeDetay=array(
            'uid'=>$logged_in['uid'],
            'gid'=>$group_id,
            'amount'=>$amount,
            'bankaAdi'=>$this->input->post('bankaAdi'),
            'gonderen'=>$this->input->post('gonderen'),
            'payment_gateway'=>$odemeTuru,
            'payment_status'=>0,
            'transaction_id'=>-1,
            'other_data'=>$this->input->post('aciklama')
        );
        } else if ($odemeTuru==2) {
            $odemeDetay=array(
                'uid'=>$logged_in['uid'],
                'gid'=>$group_id,
                'amount'=>$amount,
                'bankaAdi'=>$cardFamily,
                'payment_gateway'=>$odemeTuru,
                'payment_status'=>1,
                'transaction_id'=>$paymentId,
                'other_data'=>"Kredi Kart� �demesi"
            );
        }
        
        if($this->db->insert('savsoft_payment',$odemeDetay)){
            return true;
        }else{
            
            return false;
        }
    }
    function insert_krediKartiOdeme(CheckoutForm $odemeSonuc,$group_id){
        $logged_in=$this->session->userdata('logged_in');
//         log_message('debug', 'payment_gateway:'.$odemeTuru);
//         log_message('debug', 'bankaAdi:'.$this->input->post('bankaAdi'));
//         log_message('debug', 'amount:'.$amount);
        log_message('debug', 'uid:'.$logged_in['uid']);
        log_message('debug', 'gid:'.$group_id);
        log_message('debug', 'ucret:'.$odemeSonuc->getPaidPrice());
        log_message('debug', 'token:'.$odemeSonuc->getToken());
        
        $odemeDetay=array(
            'user_id'=>$logged_in['uid'],
            'status'=>$odemeSonuc->getStatus(),
            'paymentId'=>$odemeSonuc->getPaymentId(),
            'grup_id'=>$group_id,
            'token'=>$odemeSonuc->getToken(),
            'price'=>$odemeSonuc->getPaidPrice(),
            'raw_result'=>$odemeSonuc->getRawResult()
        );

        if($this->db->insert('kredi_karti_islemleri',$odemeDetay))
            return true;
        else
            return false;
    }
    
  
    function update_krediKartiOdeme(CheckoutForm $odemeSonuc){
        log_message('debug', 'update_krediKartiOdeme, token:'.$odemeSonuc->getToken());
        log_message('debug', 'update_krediKartiOdeme, status:'.$odemeSonuc->getStatus());
        log_message('debug', 'update_krediKartiOdeme, CardFamily:'.$odemeSonuc->getCardFamily());
        log_message('debug', 'update_krediKartiOdeme, CardType:'.$odemeSonuc->getCardType());
        log_message('debug', 'update_krediKartiOdeme, RawResult:'.$odemeSonuc->getRawResult());
        $userdata=array(
            'status'=>$odemeSonuc->getStatus(),
            'paymentId'=>$odemeSonuc->getPaymentId()
        );
        $this->db->where('token',$odemeSonuc->getToken());
        $this->db->update('kredi_karti_islemleri',$userdata);
        
        if ($odemeSonuc->getStatus()=="success") {
            $this->insert_odemeBildirimi(3, 2,$odemeSonuc->getPaidPrice(), $odemeSonuc->getCardFamily(),$odemeSonuc->getPaymentStatus(),$odemeSonuc->getPaymentId());            
            return true;
        }
        else 
            return false;
    }
    function odemeyiOnayla(){
        log_message('debug', '$payment_id:'. $this->input->post('payment_id'));
        $pid=$this->input->post('payment_id');
        if ($this->input->post('islem') == 1) {
            $userdata = array(
                'payment_status' => 1
            );
            $sure = strtotime('+2 month');
            if($this->db->simple_query("update savsoft_users u set u.gid=3, u.subscription_expired=$sure  where u.uid=(select p.uid FROM savsoft_payment p where p.pid=$pid)"))
                log_message("debug", "update ba�ar�l�,pid:".$pid);
            else 
                log_message("debug", "update ba�ar�s�z,pid:".$pid);
            
        } else {
            $userdata = array(
                'payment_status'=>0
            );
            $sure = strtotime('+10 year');
            if($this->db->simple_query("update savsoft_users u set u.gid=1, u.subscription_expired=$sure where u.uid=(select p.uid FROM savsoft_payment p where p.pid=$pid)"))
                log_message("debug", "update ba�ar�l�,pid:".$pid);
            else
                log_message("debug", "update ba�ar�s�z,pid:".$pid);
        }
        $this->db->where('pid',$this->input->post('payment_id'));
        if($this->db->update('savsoft_payment',$userdata)){
            
            return true;
        }else{
            
            return false;
        }
    }
 
    function indirim_kodu_dogrula(){
        $kod=$this->input->post('indirimKodu');
        $this->db->where('kod',$kod);
        $query=$this->db->get('indirim_kodu');
        if ($query->num_rows()>0) {
            
            return $query->result_array();
        } else {
            $this->session->set_flashdata('message', "<div class='alert alert-danger'>Girdiğiniz indirim kodu hatalıdır, lütfen kontrol ediniz.</div>");
            redirect('payment/upgradeGroup');
        }
    }

}












?>