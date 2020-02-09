<?php 
	ini_set('mssql.charset', 'UTF-8');
    $connection = mssql_connect('mssqlcon', 'sa', 'Sakorn123');

		
error_reporting(0);

	$token = "xwIy9YnB1ByZfiFz9dS4Pe82hLw9o5nRnQdmqnXlBBZ";
	$token2 = "eWEGn8hijvdIqDQCdBRUffGcMUQ3UIp7yuyQjde1g3f";
	

	/// 9980003000000039 
	///// Controller
    $pull = file_get_contents("php://input");
    ///// Controller

    ///// Model
	$data = json_decode($pull,true);

	//print_r($data);
	//echo $data["CardNo"]."\n".$data["Status"]."\n";

	$Status_Card = "";

	if ( $data["Status"] == "Cut" ) {
		
		$string  = " perl /var/www/html/schedue/digital/cutcard.pl ".$data["CardNo"]." ";

		$exe =  shell_exec( $string );

		if ($exe) {
			echo "CUT ".$data["CardNo"];
			$Status_Card = "CUT";
			$message_notify = "ตัดสัญญาณทันที ".$data["CardNo"]." ดำเนินการโดย ".$data["BY"]." กรุณารอ 3-5 นาที ระบบกำลังดำเนินการ....";

			mssql_query("INSERT INTO [WebSakorn].[dbo].[CardOperator]
           ([EmployeeID]
           ,[CardNo]
           ,[Status])
     VALUES
           ('".$data["EmpID"]."'
           ,'".$data["CardNo"]."'
           ,'".$data["Status"]."') ");

			notify($message_notify,$token);
			notify($message_notify,$token2);

		}

	}else	
	if ( $data["Status"] == "Open" ) {
			

		$stringa  = " perl /var/www/html/schedue/digital/cutcard.pl ".$data["CardNo"]." ";

		$exea =  shell_exec( $string );

		sleep(2);

		$string  = " perl /var/www/html/schedue/digital/opencard.pl ".$data["CardNo"]." ";

		$exe =  shell_exec( $string );

		if ($exe) {
			echo "Open ".$data["CardNo"];

			$message_notify = "ต่อสัญญาณทันที ".$data["CardNo"]." ดำเนินการโดย ".$data["BY"]." กรุณารอ 3-5 นาที ระบบกำลังดำเนินการ....";
			$Status_Card = "Open";

			mssql_query("INSERT INTO [WebSakorn].[dbo].[CardOperator]
           ([EmployeeID]
           ,[CardNo]
           ,[Status])
     VALUES
           ('".$data["EmpID"]."'
           ,'".$data["CardNo"]."'
           ,'".$data["Status"]."') ");
			
			notify($message_notify,$token);
			notify($message_notify,$token2);

		}

	}

	$status_back = array('CardNo' => $data["CardNo"] , 'Status' => $Status_Card );

	print_r($status_back);

	echo json_encode($status_back);


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