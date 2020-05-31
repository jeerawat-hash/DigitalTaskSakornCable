<?php 


	   ini_set('mssql.charset', 'UTF-8'); 


      ////////////////////////// begin cut out //////////////////////////////

      $connection = mssql_connect('mssqlcon', 'sa', 'Sakorn123');
 

      $Query =  mssql_query(" SELECT top 2 [ID]
      ,[CardNO]
      ,[Telephone]
      ,[IsSuccess]
    ,[SyncDate]
    FROM [LineSakorn].[dbo].[NoEntitlement] where IsSuccess = 0 and SyncDate = convert(date,getdate()) order by [ID] asc ");

      
      while ($Result = mssql_fetch_array($Query)) {
        


        $Cut  = " perl /var/www/html/schedue/digital/cutcard.pl ".$Result["CardNO"]." ";

        shell_exec( $Cut );
        

        sleep(10);


        $Open  = " perl /var/www/html/schedue/digital/opencard.pl ".$Result["CardNO"]." ";

        shell_exec( $Open );
  

        mssql_query(" update [LineSakorn].[dbo].[NoEntitlement] set IsSuccess = 1 where CardNO = '".$Result["CardNO"]."' ");


        notify("ย้ำสัญญาณ\n".$Result["CardNO"]."\nหมายเลข ".$Result["Telephone"],"X3Ns5J0u2UhKkoirOm20GIvRyFlNtA3R7LJEizfhGQN");

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