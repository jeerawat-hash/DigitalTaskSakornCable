<?php 


	   ini_set('mssql.charset', 'UTF-8'); 


      ////////////////////////// begin cut out //////////////////////////////
      $mysql = mysql_connect("172.168.0.22","sak0rn","sak0rncable");

      $connection = mssql_connect('mssqlcon', 'sa', 'Sakorn123');

      
      $query = mssql_query( "
      select SeqNo,CustomerID,PPOE,INetID,SakornID,SakornIPID,
(case when substring(PPOE,1,12)='sakorn_cable' then 'S'
	  when substring(PPOE,1,13)='sakorn_public' then 'SP' else 'I' end)  as TypeNET
from sakorncable.dbo.CustomerCableType where PPOE is not null and (SakornID is null and INetID is null and SakornIPID is null) and len(PPOE) > 12
order by TypeNET asc 
     " );



      while ($result = mssql_fetch_array($query)) {

        /*if($result["TypeNET"] == "S"){

            $resultA = mysql_fetch_array(mysql_query(" SELECT ID FROM radcheck where username = '".$result["PPOE"]."' "));

            mssql_query("update sakorncable.dbo.CustomerCableType set SakornID = '".$resultA["ID"]."'  where SeqNo = '".$result["SeqNo"]."' and CustomerID = '".$result["CustomerID"]."' ");

        }else*/
        if($result["TypeNET"] == "SP"){

            $resultA = mysql_fetch_array(mysql_query(" SELECT ID FROM radcheck where username = '".$result["PPOE"]."' "));

            mssql_query("update sakorncable.dbo.CustomerCableType set SakornIPID = '".$resultA["ID"]."' where SeqNo = '".$result["SeqNo"]."' and CustomerID = '".$result["CustomerID"]."' ");

        }
        /*
        if($result["TypeNET"] == "I"){






            mssql_query(" update sakorncable.dbo.CustomerCableType set INetID = '' where SeqNo = '".$result["SeqNo"]."' and CustomerID = '".$result["CustomerID"]."' ");
            
        }*/

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