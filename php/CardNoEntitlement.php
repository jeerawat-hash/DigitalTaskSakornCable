<?php 


	   ini_set('mssql.charset', 'UTF-8'); 


      ////////////////////////// begin cut out //////////////////////////////

      $a = mssql_connect('mssqlcon', 'sa', 'Sakorn123');
       

      $b = mssql_connect('mssqlconcas', 'check', 'Sakorn123');
  
        


      $Query =  mssql_query(" SELECT top 2 [ID]
      ,[CardNO]
      ,[Telephone]
      ,[IsSuccess]
    ,[SyncDate]
    FROM [LineSakorn].[dbo].[NoEntitlement] where IsSuccess = 0 and SyncDate = convert(date,getdate()) order by [ID] asc ",$a);



      while ($Result = mssql_fetch_array($Query)) {
       

        $Check = mssql_num_rows(mssql_query(" SELECT * FROM [CAS].[dbo].[Card2Platform] where CardNO = '".trim($Result["CardNO"])."' and CUCount = 1 ",$b));




        echo $Result["CardNO"]." ".$Check."\n"









      }

















      if ($b) {
        echo "Btrue\n";
        $bb = mssql_fetch_array(mssql_query(" SELECT * FROM [CAS].[dbo].[Card2Platform] ",$b));
        print_r($bb);

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