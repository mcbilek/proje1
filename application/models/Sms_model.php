<?php
Class Sms_model extends CI_Model
{
    
    function send_sms($msg, $telno, $smskime="0", $header="8503051929")
    {
        log_message("debug", "smskime:".$smskime);
        $username= "8503051929";
        $pass= "123201";
        
        $startdate=date('dmYHi');
        $stopdate=date('dmYHi', strtotime('+1 day'));
        
        if ($smskime=="0") {
            //tekli sms gönderilecek..
            log_message("debug", "tekli sms gönderilecek.., smskime:".$smskime);
            $output = $this->sendSMS($msg, $telno, $header, $username, $pass, $startdate, $stopdate);
            $this->insert_sms($output,"");

            return $output;
        } else {
            //toplu sms gönderilecek..
            log_message("debug", "toplu sms gönderilecek.., smskime:".$smskime);
            $sonuclar = $this->getUsersForSMS($smskime);
            foreach($sonuclar as $key => $val){
                $output = $this->sendSMS($msg, str_replace(' ', '', $val['contact_no']), $header, $username, $pass, $startdate, $stopdate,$val['uid']);
                log_message("info", "send_sms log.. msj:".$msg." numara:".$telno." user_id:".$val['uid']." sonuç:".$output);
            }
            $this->insert_sms_toplu($msg,$smskime);
            return "00";
        }
    }
    /**
     * @param msg
     * @param telno
     * @param header
     * @param username
     * @param pass
     * @param startdate
     * @param stopdate
     */private function sendSMS($msg, $telno, $header, $username, $pass, $startdate, $stopdate,$uid="0")
    {
        $msg=urlencode($msg);
        $telno = str_replace(' ', '', $telno);
        $url="http://api.netgsm.com.tr/bulkhttppost.asp?usercode=$username&password=$pass&gsmno=$telno&message=$msg&msgheader=$header&startdate=$startdate&stopdate=$stopdate";
        //echo $url;
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        //  curl_setopt($ch,CURLOPT_HEADER, false);
        $output=curl_exec($ch);
        curl_close($ch);
        log_message("debug", "send_sms msj:".$msg." numara:".$telno." user_id:".$uid." sonuç:".$output);
        log_message("debug", $url);
        return $output;
    }

    
    function getUsersForSMS($group){
        log_message("debug", "getUsersForSMS, group:".$group);
        if ($group=="1" || $group=="3") {
            $query=$this->db->query("select uid,contact_no from savsoft_users where gid='$group' and contact_no is not null");
        } else {
            $query=$this->db->query("select uid,contact_no from savsoft_users where contact_no is not null");
        }
            $result=$query->result_array();
            return $result;
    }
    
    function insert_sms($result,$nval){
        $uid=$this->input->post('uid');
        if ($uid==NULL)
            $uid=-1;
        
        $userdata=array(
            'title'=>"sms",
            'message'=>$this->input->post('sms_text'),
            'click_action'=>"",
            'uid'=>$uid,
            'notification_to'=>$nval,
            'response'=>$result,
            'mesaj_turu'=>1,
            
        );
        $this->db->insert('savsoft_notification',$userdata);
    }
    function insert_sms_toplu($msg,$smskime){
        $userdata=array(
            'title'=>"sms",
            'message'=>$msg,
            'click_action'=>"",
            'uid'=>$smskime,
            'notification_to'=>"",
            'response'=>"",
            'mesaj_turu'=>1,
        );
        $this->db->insert('savsoft_notification',$userdata);
    }
 
 

}












?>