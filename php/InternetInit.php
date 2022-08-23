<?php 


	   ini_set('mssql.charset', 'UTF-8'); 


      ////////////////////////// begin cut out //////////////////////////////
      $mysql = mysql_connect("172.168.0.24","sak0rn","sak0rncable");

      $connection = mssql_connect('mssqlcon', 'sa', 'Sakorn123');

      mssql_query("delete from [InternetSakorn].[dbo].[InternetCheckLog] where is_Check = 1");
      
      $query_inet = mssql_query( " 
        INSERT INTO [InternetSakorn].[dbo].[InternetCheckLog]
           ([PPPOE] 
           ,[INetID] ) 
   select PPOE,INetID from (
   select PPOE,INetID from Bangchalong.dbo.CustomerCableType where INetID is not null   
   union
   select PPOE,INetID from Flat.dbo.CustomerCableType where INetID is not null
   union
   select PPOE,INetID from CSCable.dbo.CustomerCableType where INetID is not null  
   union
   select PPOE,INetID from Sahamit.dbo.CustomerCableType where INetID is not null  
   union 
   select PPOE,INetID from SakornCable.dbo.CustomerCableType where INetID is not null  
   union 
   select PPOE,INetID from SakornNetwork.dbo.CustomerCableType where INetID is not null  
    union 
   select PPOE,INetID from SakornNewBusiness.dbo.CustomerCableType where INetID is not null  
   union 
   select PPOE,INetID from Sakorp.dbo.CustomerCableType where INetID is not null  
   union  
   select PPOE,INetID from SRN.dbo.CustomerCableType where INetID is not null  
   )a where INetID not in (select INetID from InternetSakorn.dbo.view_InternetNormal where InetID is not null)
 " );


  
      $query_sakorn = mssql_query( "
      INSERT INTO [InternetSakorn].[dbo].[InternetCheckLog]
           ([PPPOE] 
           ,[SakornID] )  
           select PPOE,SakornID from (
   select PPOE,SakornID from Bangchalong.dbo.CustomerCableType where SakornID is not null   
   union
   select PPOE,SakornID from Flat.dbo.CustomerCableType where SakornID is not null
   union
   select PPOE,SakornID from CSCable.dbo.CustomerCableType where SakornID is not null  
   union
   select PPOE,SakornID from Sahamit.dbo.CustomerCableType where SakornID is not null  
   union 
   select PPOE,SakornID from SakornCable.dbo.CustomerCableType where SakornID is not null  
   union 
   select PPOE,SakornID from SakornNetwork.dbo.CustomerCableType where SakornID is not null  
    union 
   select PPOE,SakornID from SakornNewBusiness.dbo.CustomerCableType where SakornID is not null  
   union 
   select PPOE,SakornID from Sakorp.dbo.CustomerCableType where SakornID is not null  
   union  
   select PPOE,SakornID from SRN.dbo.CustomerCableType where SakornID is not null  
   )a where SakornID not in (select SakornID from InternetSakorn.dbo.view_InternetNormal where SakornID is not null)
 " );

 
 

 

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

      // SSL USE 
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_POST, 1);
      // SSL USE 
      
  $result = curl_exec($ch);

  curl_close ($ch);

  return $result;
}


 ?>