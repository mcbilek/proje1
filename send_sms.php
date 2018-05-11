<?php

function sendsms($msg, $telno, $header="8503051929")
{
  $username= "8503051929";
  $pass= "123201";
  
  $startdate=date('dmYHi');
  $stopdate=date('dmYHi', strtotime('+1 day'));


  
	$url="http://api.netgsm.com.tr/bulkhttppost.asp?usercode=$username&password=$pass&gsmno=$telno&message=$msg&msgheader=$header&startdate=$startdate&stopdate=$stopdate";
	//echo $url;
	
    $ch = curl_init(); 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//  curl_setopt($ch,CURLOPT_HEADER, false);
    $output=curl_exec($ch);
    curl_close($ch);
    return $output;
	
}

$mesaj='Mesaj Metni selamun kanka';
$tel='905323523823'; 
$baslik='8503051929';


$mesaj = html_entity_decode($mesaj, ENT_COMPAT, "UTF-8"); 
$mesaj = rawurlencode($mesaj); 


$baslik = html_entity_decode($baslik, ENT_COMPAT, "UTF-8"); 
$baslik = rawurlencode($baslik); 

	
echo sendsms($mesaj,$tel,$baslik);

?>
