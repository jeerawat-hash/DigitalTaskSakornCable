<?php 


	   ini_set('mssql.charset', 'UTF-8'); 


      ////////////////////////// begin cut out //////////////////////////////
      $mysql = mysql_connect("172.168.0.24","sak0rn","sak0rncable");

      $connection = mssql_connect('mssqlcon', 'sa', 'Sakorn123');

      
      $query = mssql_query( " 
       SELECT TOP 10 [ID]
      ,[PPPOE]
      ,[InetID]
      ,[SakornID]
      ,[is_Check]
  FROM [InternetSakorn].[dbo].[InternetCheckLog] where is_Check = 0 and InetID is not null

     " );



      while ($result = mssql_fetch_array($query)) {

        sleep(1);

        $TYPE = ($result["InetID"] != "") ? "INET" : "Sakorn" ;
        //echo $result["PPPOE"]." ".$TYPE."<br>";

        if ($TYPE == "INET") {
          
            $url = "https://bb.inet-th.net/index.php/api/update";
            echo  Operation($url,$result["InetID"],"suspend");

        }else{

            mysql_query(" update  radius.radreply set value = 'Expire'  WHERE  username = '".$result["PPPOE"]."'  ");


        }

        mssql_query("update [InternetSakorn].[dbo].[InternetCheckLog] set [is_Check] = 1 where ID = '".$result["ID"]."' ");


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

function Operation($url,$clientid,$status)
{
    
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS,
              "access_code=ZWaFcOV3yILx6DjmRWs029EzdYQgy0GdmoHA779tAK4vz8FqP55kOtivxounk11erUF7NsplanMKDivQVJL1pxIPwbkNEnBJSqCsfwXZcGZfXrSeTdezPt3CpUHYYR22fQjc6iGWwq8M&id=".$clientid."&status=".$status."&name=&surname=&mac_address&username&password&site_id=97&package_id=&type=");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($ch);

  curl_close ($ch);

  return $result;
}


 ?>