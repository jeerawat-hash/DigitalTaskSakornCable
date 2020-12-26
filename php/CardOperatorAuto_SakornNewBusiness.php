<?php 

	ini_set('mssql.charset', 'UTF-8');
    $connection = mssql_connect('mssqlcon', 'sa', 'Sakorn123');


	$token = "xwIy9YnB1ByZfiFz9dS4Pe82hLw9o5nRnQdmqnXlBBZ";
 

	$CasCheck = mssql_fetch_array(mssql_query(" SELECT  [Cas_IsNormal]
  FROM [WebSakorn].[dbo].[SystemSakorn] "));

	if ($CasCheck["Cas_IsNormal"] == "0") {
		
		notify('ระบบหยุดการทำงาน...เนื่องจากระบบล้มเหลว...',$token);

		exit();
	}
	 

	$query_str = mssql_query(" 
 select top 3 'SakornNewBusiness' as DB,UserID,RowOrder,CardNO,(select MACAddress from SakornNewBusiness.dbo.CustomerCableType where CardID = CardNO) as MacAddress
 ,IsOpenCard,IsUpdateCASAlready from SakornNewBusiness.dbo.CustomerCardLog where IsUpdateCASAlready = 0 order by RowOrder asc ");



	$message_notify = "ดำเนินการการ์ด กุญแจ SakornNewBusiness \n";


	while ( $result = mssql_fetch_array($query_str) ) {
		
		$status_auto = "";
		
		if ( $result["IsOpenCard"] == "1" ) {









				$CustomerCom = mssql_fetch_array( mssql_query(" SELECT [ID]
      ,[DB]
      ,[HomeNameID]
      ,[CardID]
      ,[CustomerID]
      ,[DateInterval]
      ,[Is_Notify]
      ,[CutDate]
      ,[Is_Success]
  FROM [WebSakorn].[dbo].[CardCompenStateDetail] where Is_Success = 0 and Is_Notify = 1 and CardID = '".$result["CardNO"]."' ") );


		$ComPen = ( isset($CustomerCom["ID"]) ) ? $CustomerCom["DB"]." ".$CustomerCom["CustomerID"]." ได้รับการชดเชยแล้ว" : "";

		mssql_query(" update [WebSakorn].[dbo].[CardCompenStateDetail] set Is_Success = 1  where Is_Success = 0 and ID = '".$CustomerCom["ID"]."' ");












			

			$string  = " perl /var/www/html/schedue/nex/opencard.pl ".$result["CardNO"]." ".$result["MacAddress"]." ";

			$exe =  shell_exec( $string );

			$status_auto = "ต่อ\n".$ComPen;
            //$token = "xwIy9YnB1ByZfiFz9dS4Pe82hLw9o5nRnQdmqnXlBBZ";
            $token = "Ahlxzwfwdnv7CjVPMC3s6fdNPtOEH49AeQkhF4CUfKI";






















		}else
		if ( $result["IsOpenCard"] == "0" ) {


















			
		$CustomerCom = mssql_fetch_array( mssql_query(" SELECT [ID]
      ,[DB]
      ,[HomeNameID]
      ,[CardID]
      ,[CustomerID]
      ,[DateInterval]
      ,[Is_Notify]
      ,[CutDate]
      ,[Is_Success]
  FROM [WebSakorn].[dbo].[CardCompenStateDetail] where Is_Success = 0 and Is_Notify = 0 and CardID = '".$result["CardNO"]."' ") );

		
		$today = time();
    	$intervalday = date('Y-m-d', strtotime('+'.$CustomerCom["DateInterval"].' day', $today)); 

    	$inday = date('d-m-Y', strtotime('+'.$CustomerCom["DateInterval"].' day', $today));


    	$ComPen = ( isset($CustomerCom["ID"]) ) ? $CustomerCom["DB"]." ".$CustomerCom["CustomerID"]." ได้รับการชดเชยเลื่อนไปตัดวันที่ ".$inday : "";
    	
    	///////// 
    	/// Notify
    	/////////

		mssql_query(" update [WebSakorn].[dbo].[CardCompenStateDetail] set Is_Notify = 1 and CutDate = '".$intervalday."'  where Is_Success = 0 and Is_Notify = 0 and ID = '".$CustomerCom["ID"]."' ");


			$dayp = date('d-m-Y', strtotime('+1 day', $today));
			$message = "ได้รับการชดเชยเลื่อนตัดสัญญาณวันที่ ".$dayp;
			

			$string = ( isset($CustomerCom["ID"]) ) ? "perl /var/www/html/schedue/digital/notifycard.pl ".$result["CardNO"]." ".$message." ".$intervalday." 08:50:00" : " perl /var/www/html/schedue/digital/cutcard.pl ".$result["CardNO"]." " ;		 
			
			//$string  = " perl /var/www/html/schedue/digital/cutcard.pl ".$result["CardNO"]." ";
  
			$exe =  shell_exec( $string );
 			 
 			$status_auto = "ตัด\n".$ComPen;
 			$token = "Ahlxzwfwdnv7CjVPMC3s6fdNPtOEH49AeQkhF4CUfKI";












			/*
		
			$string  = " perl /var/www/html/schedue/nex/cutcard.pl ".$result["CardNO"]." ".$result["MacAddress"]." ";


			$exe =  shell_exec( $string );
 			
 			$status_auto = "ตัด";
 			$token = "Ahlxzwfwdnv7CjVPMC3s6fdNPtOEH49AeQkhF4CUfKI";
		*/


























		}
 

		mssql_query(" update SakornNewBusiness.dbo.CustomerCardLog set IsUpdateCASAlready = 1 where CardNO = '".$result["CardNO"]."' ");

		$message_notify .= $result["CardNO"]." ".$result["UserID"]." ".$status_auto."\n";

		sleep(10);

	}
 

	#$message = $Status."การ์ด \n หมายเลข : 9980003200006591 \n สถานะ : สำเร็จ";

	if ( mssql_num_rows($query_str) != 0 ) {
		
		notify($message_notify,$token);

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