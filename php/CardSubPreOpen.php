<?php 


	   ini_set('mssql.charset', 'UTF-8'); 


      ////////////////////////// begin cut out //////////////////////////////
       
      $a = mssql_connect('mssqlcon', 'sa', 'Sakorn123');
      $b = mssql_connect('mssqlconcas', 'check', 'Sakorn123');
      
      $query = mssql_query( " SELECT top 1  a.ID,b.EmployeeName,[CardNo],[EmployeeID],Is_Open,Is_Success,( select top 1 MACAddress from SakornNewBusiness.dbo.CustomerCableType where CardID = [CardNo] and Suspend = 0) as Macaddress
    FROM [WebSakorn].[dbo].[SubPreOpenCard] a 
    join [WebSakorn].[dbo].[Employee] b on a.EmployeeID = b.ID  where Is_Success = 0 and Is_Open = 0 " ,$a );
  

      while ($result = mssql_fetch_array($query)) {
         
      sleep(3);
      #$string  = " perl /var/www/html/schedue/digital/opencard.pl ".$result["CardNo"]." ";
      #$exe =  shell_exec( $string );
	      

  $typeServices = "";

	if(strlen($result["CardNo"]) != 7){
		
		mssql_query(" exec dbo.sp_Card_Restart '".$result["CardNo"]."',null ",$b);
		$typeServices = "กล่องสาคร";

	}else{
		
	     $string  = " perl /var/www/html/schedue/nex/opencard.pl ".$result["CardNo"]." ".$result["Macaddress"]." ";
	     $exe =  shell_exec( $string );
  		$typeServices = "กล่อง NEX\nMAC : ".$result["Macaddress"];

		
	}
	       
      $message = "\nคุณ ".$result["EmployeeName"]." เปิดสัญญาณชั่วคราวการ์ด\n".$typeServices."\nหมายเลข : ".$result["CardNo"];

      notify($message,"xwIy9YnB1ByZfiFz9dS4Pe82hLw9o5nRnQdmqnXlBBZ");

      mssql_query( " update [WebSakorn].[dbo].[SubPreOpenCard] set Is_Open = 1 where ID = '".$result["ID"]."' " ,$a);

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
