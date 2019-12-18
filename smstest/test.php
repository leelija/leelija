<?php
   
   $apikey = "Cel1HfkoUkOIJP7VlXPAPA";
   $apisender = "TESTIN";
   $msg ="YOUR MESSAGE HERE";
   $num = 9831697684;    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
 
   $ms = rawurlencode($msg);   //This for encode your message content                 		
 
$url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
                     
 //echo $url;
 $ch=curl_init($url);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 curl_setopt($ch,CURLOPT_POST,1);
 curl_setopt($ch,CURLOPT_POSTFIELDS,"");
 curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
 $data = curl_exec($ch);
 //echo '<br/><br/>';
 //print($data); /* result of API call*/

?>