<?php

class Genel_model extends CI_Model
{

    function category_list($aktifler=1)
    {
        $this->db->order_by('category_name', 'asc');
        if ($aktifler==1) {
            $this->db->where('aktifmi',1);
        }
        $query = $this->db->get('savsoft_category');
        return $query->result_array();
    }
    
    function group_list(){
        $this->db->order_by('gid','asc');
        $query=$this->db->get('savsoft_group');
        return $query->result_array();
    }
    
    function kadro_list(){
        $this->db->order_by('kadro_adi','asc');
        $query=$this->db->get('savsoft_kadro');
        return $query->result_array();
    }
    
    function kadro_bilgileri($kadro_id){
        $this->db->where('kadro_id',$kadro_id);
        $query=$this->db->get('savsoft_kadro');
        return $query->result_array();
    }
    
    function kadro_list_by_kurum($kurum_id){
        $this->db->order_by('kadro_adi','asc');
        $this->db->where('bagli_kurum_id',intval($kurum_id));
        $this->db->where('aktifmi',1);
        $query=$this->db->get('savsoft_kadro');
        return $query->result_array();
    }
    
    function kurum_list($aktifler=0){
        $this->db->order_by('kurum_adi','asc');
        if ($aktifler==1) {
            $this->db->where('aktifmi',1);
        }
        $query=$this->db->get('savsoft_kurum');
        return $query->result_array();
    }
    
    function kategori_aktifpasif($cid,$yenidurum){
        $this->db->set('aktifmi', $yenidurum);
        $this->db->where('cid', $cid);
        $this->db->update('savsoft_category'); 
    }
    
    
    function kurum_aktifpasif($kurum_id,$yenidurum){
        $this->db->set('aktifmi', $yenidurum);
        $this->db->where('kurum_id', $kurum_id);
        $this->db->update('savsoft_kurum');
    }
    
    function kurum_sil($kurumId){
        $this->db->where('kurum_id', $kurumId);
        $this->db->delete('savsoft_kurum');
    }
    
    function kurum_ekle_guncelle($kurum_id,$kurumAdi){
        if ($kurum_id!="-1") {
            $this->db->set('kurum_adi', $kurumAdi);
            $this->db->where('kurum_id', $kurum_id);
            $this->db->update('savsoft_kurum');
        } else {
            $userdata = array(
                'kurum_adi' => $kurumAdi,
                'kac_sikli' => 5,
                'aktifmi' => 1,
            );
            
            if($this->db->insert('savsoft_kurum', $userdata)){
                return true;
            }else{
                return false;
            }
        }
            
    }
    function kadro_ekle_guncelle($kadro_id,$kadroAdi,$ucret,$bagliKurumId,$uyelikBitisTarihi){
        if ($kadro_id!="-1") {
            $this->db->set('kadro_adi', $kadroAdi);
            $this->db->set('uyelik_ucreti', $ucret);
            $this->db->set('uyelik_bitis', $uyelikBitisTarihi);
            if ($bagliKurumId>0)
                $this->db->set('bagli_kurum_id', $bagliKurumId);
            $this->db->where('kadro_id', $kadro_id);
            $this->db->update('savsoft_kadro');
        } else {
            $userdata = array(
                'kadro_adi' => $kadroAdi,
                'uyelik_ucreti' => $ucret,
                'aktifmi' => 1,
                'bagli_kurum_id'=>$bagliKurumId,
                'uyelik_bitis'=>$uyelikBitisTarihi
            );
            
            if($this->db->insert('savsoft_kadro', $userdata)){
                return true;
            }else{
                return false;
            }
        }
            
    }
    function kadro_aktifpasif($kadro_id,$yenidurum){
        $this->db->set('aktifmi', $yenidurum);
        $this->db->where('kadro_id', $kadro_id);
        $this->db->update('savsoft_kadro');
    }
    function kadro_sil($kadroId){
        $this->db->where('kadro_id', $kadroId);
        $this->db->delete('savsoft_kadro');
    }
    function is_kadro_kullanilmis($kadroId){
        
        $sql = "select count(*) adet FROM savsoft_users where kadro_id=?";
        $query = $this->db->query($sql,$kadroId);
        $ret = $query->row();
        return $ret->adet;
    }
    
    function is_kurum_kullanilmis($kurumId){
        
        $sql = "select count(*) adet FROM savsoft_users where kurum_id=?";
        $query = $this->db->query($sql,$kurumId);
        $ret = $query->row();
        return $ret->adet;
    }
    
    //Kurum/Kadro/Kategorileri çeken metod.
    function kurum_kardo_kategori(){
        
        $sql =
        " SELECT ck.*,".
        "        krm.kurum_adi,".
        "        kdr.kadro_adi,".
        "        c.category_name".
        " FROM savsoft_category_kadro ck,".
        "      savsoft_category c,".
        "      savsoft_kurum krm,".
        "      savsoft_kadro kdr".
        " WHERE     ck.kurum_id = krm.kurum_id".
        "       AND ck.kadro_id = kdr.kadro_id".
        "       AND ck.kategori_id = c.cid".
        "       AND krm.aktifmi=1".
        " ORDER BY krm.kurum_adi, kdr.kadro_adi, c.category_name";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    //Kuruma bağlı Kadrolaro çeken metod.
    function kurum_kardo(){
        
        $sql =
        " SELECT krm.kurum_id, krm.kurum_adi, kdr.*".
        " FROM savsoft_kurum krm, savsoft_kadro kdr".
        " WHERE krm.kurum_id = kdr.bagli_kurum_id".
        " ORDER BY krm.kurum_adi, kdr.kadro_adi";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    
    //Kurum/Kadro/Kategori eşleşmesi silme metodu
    function kkk_sil(){
        
        $kat_kadro_id=$this->input->post('kat_kadro_id');
        $this->db->where('kat_kadro_id',$kat_kadro_id);
        if($this->db->delete('savsoft_category_kadro')){
            return true;
        }else{
            return false;
        }
    }
    
    //Kurum/Kadro/Kategori eşleşmesi ekleme metodu
    function kkk_ekle(){
        
        
        $userdata = array(
            'kurum_id' => $this->input->post('kurum_id'),
            'kadro_id' => $this->input->post('kadro_id'),
            'kategori_id' => $this->input->post('kategori_id'),
            'soru_adet' => $this->input->post('soru_sayisi')
        );
        
        if($this->db->insert('savsoft_category_kadro', $userdata)){
            return true;
        }else{
            return false;
        }
    }

    
    function get_questions_demo_kontrol()
    {
        $logged_in = $this->session->userdata('logged_in');
        $gid = $logged_in['gid'];
        $uid = $logged_in['uid'];
        // admin yada �zel �ye de�ilse demo soru �ekildi�ine dair kay�t at�yoruz.
        if ($logged_in['su'] == '0' && $gid != 3) {
            // daha �nce soru �ekilmi� mi bak�yoruz
            $bugun_cozdu = "bugun_cozdu";
            $query = $this->db->query("select * from savsoft_settings where uid=$uid and anahtar='$bugun_cozdu'");
            if ($query->num_rows() > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    function get_questions_ders_calis()
    {
        $logged_in = $this->session->userdata('logged_in');
        $gid = $logged_in['gid'];
        $uid = $logged_in['uid'];
        $soruAdet = $_POST['soruAdet'];
        // admin yada �zel �ye de�ilse demo soru �ekildi�ine dair kay�t at�yoruz.
        if ($logged_in['su'] == '0' && $gid != 3) {
            
            $userdata = array(
                'uid' => $uid,
                'anahtar' => "bugun_cozdu",
                'value' => "1"
            );
            $this->db->insert('savsoft_settings', $userdata);
            // soru adedini s�n�rl�yoruz.
            $soruAdet = $this->config->item('demo_soru');
        }
        
        log_message("debug", "grup_id:" . $gid);
        log_message("debug", "uid:" . $uid);
        log_message("debug", "kategori_id:" . $_POST['kategori_id']);
        log_message("debug", "soru adet:" . $_POST['soruAdet']);
        $cat_id = $_POST['kategori_id'];
        if ($cat_id == "-1")
            $query = $this->db->query("select q.*,cat.category_name,lvl.level_name from savsoft_qbank q, savsoft_category cat, savsoft_level lvl 
                            where q.cid=cat.cid and lvl.lid=q.lid and q.aktifmi=1 ORDER BY RAND() limit $soruAdet");
        else
            $query = $this->db->query("select q.*,cat.category_name,lvl.level_name from savsoft_qbank q, savsoft_category cat, savsoft_level lvl
                            where q.cid=cat.cid and lvl.lid=q.lid and q.aktifmi=1 and q.cid=$cat_id ORDER BY RAND() limit $soruAdet");
        return $query->result_array();
    }

    function calisma_list()
    {
        $logged_in = $this->session->userdata('logged_in');
        // if($logged_in['su']=='0'){
        // $gid=$logged_in['gid'];
        // $where="FIND_IN_SET('".$gid."', gids)";
        // $this->db->where($where);
        // }
        
        // if($this->input->post('search') && $logged_in['su']=='1'){
        // $search=$this->input->post('search');
        // $this->db->or_where('quid',$search);
        // $this->db->or_like('quiz_name',$search);
        // $this->db->or_like('description',$search);
        
        // }
        $uid = $logged_in['uid'];
        if ($logged_in['su'] == '0') {
            $query = $this->db->query("select c.* from savsoft_users u, savsoft_category c, savsoft_category_kadro ck where u.uid=$uid 
                              and u.kadro_id=ck.kadro_id and c.cid=ck.kategori_id order by c.category_name asc");
        } else {
            $query = $this->db->query("select * from savsoft_category order by category_name asc");
        }
        // log_message("debug", "calisma_list size:".count($query->result_array()));
        return $query->result_array();
    }

    function kaynak_list()
    {
        $logged_in = $this->session->userdata('logged_in');
        // if($logged_in['su']=='0'){
        // $gid=$logged_in['gid'];
        // $where="FIND_IN_SET('".$gid."', gids)";
        // $this->db->where($where);
        // }
        
        // if($this->input->post('search') && $logged_in['su']=='1'){
        // $search=$this->input->post('search');
        // $this->db->or_where('quid',$search);
        // $this->db->or_like('quiz_name',$search);
        // $this->db->or_like('description',$search);
        
        // }
        $uid = $logged_in['uid'];
        if ($logged_in['su'] == '0') {
            $query = $this->db->query("select c.* from savsoft_users u, savsoft_category_kaynak c, savsoft_category_kadro ck where u.uid=$uid and u.kadro_id=ck.kadro_id and c.kategori_id=ck.kategori_id");
        } else {
            $query = $this->db->query("select * from savsoft_category_kaynak");
        }
        // log_message("debug", "calisma_list size:".count($query->result_array()));
        return $query->result_array();
    }
    function ekli_kaynaklar()
    {
        $logged_in = $this->session->userdata('logged_in');
        // if($logged_in['su']=='0'){
        // $gid=$logged_in['gid'];
        // $where="FIND_IN_SET('".$gid."', gids)";
        // $this->db->where($where);
        // }
        
        // if($this->input->post('search') && $logged_in['su']=='1'){
        // $search=$this->input->post('search');
        // $this->db->or_where('quid',$search);
        // $this->db->or_like('quiz_name',$search);
        // $this->db->or_like('description',$search);
        
        // }
        $uid = $logged_in['uid'];
        $sql =
        " SELECT kynk.*,".
        "        c.category_name,".
        "        krm.kurum_adi,".
        "        kdr.kadro_adi".
        " FROM savsoft_category_kaynak kynk,".
        "      savsoft_category c,".
        "      savsoft_kadro kdr,".
        "      savsoft_kurum krm".
        " WHERE     kynk.kadro_id = kdr.kadro_id".
        "       AND kynk.kurum_id = krm.kurum_id".
        "       AND c.cid = kynk.kategori_id";
        $query = $this->db->query($sql);
        // log_message("debug", "calisma_list size:".count($query->result_array()));
        return $query->result_array();
    }

    function dosya_yukle($dosya_adi)
    {
        log_message("debug", "dosya_yukle" . $_POST);
        $logged_in = $this->session->userdata('logged_in');
        $uid = $logged_in['uid'];
        
        $userdata = array(
            'kategori_id' => $_POST['kategori_id'],
            'kaynak_tur' => $_POST['kaynak_tur'],
            'kurum_id' => $_POST['kurum_id'],
            'kadro_id' => $_POST['kadro_id'],
            'dosya_adi' => $dosya_adi,
            'dosya_aciklama' => $_POST['dosya_aciklama']
        );
        return $this->db->insert('savsoft_category_kaynak', $userdata);
    }
}
?>
