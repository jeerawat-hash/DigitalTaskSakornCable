<?php 

	ini_set('mssql.charset', 'UTF-8');
    $a = mssql_connect('mssqlcon', 'sa', 'Sakorn123');
    $b = mssql_connect('mssqlconcas', 'check', 'Sakorn123');

 
	$token = "";
 	
	$CasCheck = mssql_fetch_array(mssql_query(" SELECT  [Cas_IsNormal]
  FROM [WebSakorn].[dbo].[SystemSakorn] ",$a));

	if ($CasCheck["Cas_IsNormal"] == "0") {
		
		notify('ระบบหยุดการทำงาน...เนื่องจากระบบล้มเหลว...',$token);

		exit();
	}
	 

	//$query_str = mssql_query(" select top 3 'SakornCable' as DB,UserID,RowOrder,CardNO,IsOpenCard,IsUpdateCASAlready from SakornCable.dbo.CustomerCardLog where IsUpdateCASAlready = 0 order by RowOrder asc ",$a);
	$query_str = mssql_query(" select  top 10 'SakornCable' as DB,UserID,RowOrder,CardNO,( select top 1 MACAddress from SakornCable.dbo.CustomerCableType where CardID = CardNO and Suspend = 0) as Macaddress
	,IsOpenCard,IsUpdateCASAlready from SakornCable.dbo.CustomerCardLog where IsUpdateCASAlready = 0 order by RowOrder asc	 ",$a);

	$message_notify = "[ระบบประมวลการ์ด]\nกุญแจ SakornCable \n";


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
		FROM [WebSakorn].[dbo].[CardCompenStateDetail] where Is_Success = 0 and Is_Notify = 1 and CardID = '".$result["CardNO"]."' ",$a) );


			$ComPen = ( isset($CustomerCom["ID"]) ) ? $CustomerCom["DB"]." ".$CustomerCom["CustomerID"]." ได้รับการชดเชยแล้ว" : "";

			if(isset($CustomerCom["ID"])){

				mssql_query(" update [WebSakorn].[dbo].[CardCompenStateDetail] set Is_Success = 1  where Is_Success = 0 and ID = '".$CustomerCom["ID"]."' ",$a);
 
			}

			if(strlen($result["CardNO"]) == 7){


				$string  = " perl /var/www/html/schedue/nex/opencard.pl ".$result["CardNO"]." ".$result["Macaddress"]." ";
				$exe =  shell_exec( $string );
				$status_auto = "NEX ต่อสัญญาณ (ไม่สามารถดำเนินการได้)\n".$ComPen;
				//$token = "xwIy9YnB1ByZfiFz9dS4Pe82hLw9o5nRnQdmqnXlBBZ";
  

			}else{


				mssql_query(" exec dbo.sp_Card_Restart '".$result["CardNO"]."',null ",$b);
				//mssql_query(" delete from [CAS].[dbo].[OSDsBackup] where FilterData = '".$result["CardNO"]."' ",$b);
				#$string  = " perl /var/www/html/schedue/digital/opencard.pl ".$result["CardNO"]." ";
				#$exe =  shell_exec( $string );
				$status_auto = "การ์ดสาคร ต่อสัญญาณ\n".$ComPen;
				//$token = "xwIy9YnB1ByZfiFz9dS4Pe82hLw9o5nRnQdmqnXlBBZ";


			}
			 


            $token = "X3Ns5J0u2UhKkoirOm20GIvRyFlNtA3R7LJEizfhGQN";
 

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
  FROM [WebSakorn].[dbo].[CardCompenStateDetail] where Is_Success = 0 and Is_Notify = 0 and CardID = '".$result["CardNO"]."' ",$a) );

		
		$today = time();
    	$intervalday = date('Y-m-d', strtotime('+'.$CustomerCom["DateInterval"].' day', $today)); 

    	$inday = date('d-m-Y', strtotime('+'.$CustomerCom["DateInterval"].' day', $today));


    	$ComPen = ( isset($CustomerCom["ID"]) ) ? $CustomerCom["DB"]." ".$CustomerCom["CustomerID"]." ได้รับการชดเชยเลื่อนไปตัดวันที่ ".$inday : "";
    	
    	///////// 
    	/// Notify
    	/////////
		if(isset($CustomerCom["ID"])){

			mssql_query(" update [WebSakorn].[dbo].[CardCompenStateDetail] set Is_Notify = 1 , CutDate = '".$intervalday."'  where Is_Success = 0 and Is_Notify = 0 and ID = '".$CustomerCom["ID"]."' ",$a);
			
		}
		

			 
			if ($ComPen == "") {
				
 
				if(strlen($result["CardNO"]) == 7){
 
					$nex  = " perl /var/www/html/schedue/nex/cutcard.pl ".$result["CardNO"]." ".$result["Macaddress"]." ";
					shell_exec( $nex );
					$status_auto = "NEX ตัดสัญญาณ (ไม่สามารถดำเนินการได้)\n".$ComPen;
 
				}else{

					//$string  = " perl /var/www/html/schedue/digital/cutcard.pl ".$result["CardNO"]." ";
					mssql_query(" exec dbo.sp_Card_Stop '".$result["CardNO"]."',null ",$b);
					mssql_query(" exec [dbo].[sp_Service_OSD]  0,'".$result["CardNO"]."',0,60,'yGJu6u5seTLn6ox2p7UwDApMxtTBbOMiuA9GFXnJt+I3K2hBPx6mS4Takp3lYXbPwiaEhCA7u94EyLUokJ4aoQQVRU+vEXIP','".date("Y-m-d")." 18:25:00',null ",$b);
					$status_auto = "การ์ดสาคร ตัดสัญญาณ\n".$ComPen;

				}
 
			}else{

				$dayp = date('Y-m-d', strtotime('+1 day', $today));
				$message = "ได้รับการชดเชยเลื่อนตัดสัญญาณเป็นวันที่".$inday;
				$string  = " perl /var/www/html/schedue/digital/notifycard.pl ".$result["CardNO"]." ".$message." ".$dayp." 08:50:00";

			}
 
  
			$exe =  shell_exec( $string ); 
 			$token = "Ahlxzwfwdnv7CjVPMC3s6fdNPtOEH49AeQkhF4CUfKI";

 

			/*
			$string  = " perl /var/www/html/schedue/digital/cutcard.pl ".$result["CardNO"]." ";

			$exe =  shell_exec( $string );
 			
 			$status_auto = "ตัด";
 			$token = "Ahlxzwfwdnv7CjVPMC3s6fdNPtOEH49AeQkhF4CUfKI";
			*/

 
 

		}
 

		mssql_query(" update SakornCable.dbo.CustomerCardLog set IsUpdateCASAlready = 1 where CardNO = '".$result["CardNO"]."' ",$a);

		$message_notify .= $result["CardNO"]." \nผู้ดำเนินการ ".$result["UserID"]." ".$status_auto."\n";

		sleep(2);
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
