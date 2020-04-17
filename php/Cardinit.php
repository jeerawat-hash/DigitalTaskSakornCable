<?php 


	   ini_set('mssql.charset', 'UTF-8');
    $connection = mssql_connect('mssqlconcas', 'check', 'sakorn123');

   
 


    if ($connection) {
      echo "Connected";
    }else{
      echo "Disconnected";
    }




















function notify($message,$token){

          $lineapi = $token; 
        $mms =  trim($message); 
        date_default_timezone_set("Asia/Bangkok");
        $con = curl_init();
        curl_setopt( $con, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
        // SSL USE 
        curl_setopt( $con, CURLOPT_SSL_VERIFYHOST, 0); 
        curl_setopt( $con, CURLOPT_SSL_VERIFYPEER, 0); 
        //POST 
        curl_setopt( $con, CURLOPT_POST, 1); 
        curl_setopt( $con, CURLOPT_POSTFIELDS, "message=$mms"); 
        $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$lineapi.'', );
          curl_setopt($con, CURLOPT_HTTPHEADER, $headers); 
        curl_setopt( $con, CURLOPT_RETURNTRANSFER, 1); 
        $result = curl_exec( $con ); 

}


 ?>