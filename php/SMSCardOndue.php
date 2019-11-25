<?php 


	ini_set('mssql.charset', 'UTF-8');
    $connection = mssql_connect('mssqlcon', 'sa', 'Sakorn123');

   

  	$query = mssql_query("

  	SELECT TOP 5 [ID],DB
      ,[CardNO]
      ,[CustomerID]
      ,[PayCode]
      ,WriteDate
      ,[Status_Send]
  	FROM [LineBot].[dbo].[SMS_Digital_Ondue]
  	where len([CardNO]) > 10 and WriteDate = CONVERT(date,GETDATE()) and Status_Send = 0

 	");

  	while ( $result = mssql_fetch_array($query) ) {
  		
  		$message = "แจ้งเตือนบิลครบกำหนดกรุณาชำระค่าบริการขออภัยหากชำระแล้ว";

  		
  		shell_exec(" perl /var/www/html/schedue/digital/notifycard.pl ".$result["CardNO"]." ".$message." ".$result["WriteDate"]." 08:50:00 ");

  		sleep(5);

  		#shell_exec(" perl /var/www/html/schedue/digital/notifycard.pl ".$result["CardNO"]." ".$message." ".$result["WriteDate"]." 10:50:00 ");

  		sleep(5);

  		#shell_exec(" perl /var/www/html/schedue/digital/notifycard.pl ".$result["CardNO"]." ".$message." ".$result["WriteDate"]." 12:00:00 ");

  		sleep(5);

  		#shell_exec(" perl /var/www/html/schedue/digital/notifycard.pl ".$result["CardNO"]." ".$message." ".$result["WriteDate"]." 15:00:00 ");

  		sleep(5);

  		#shell_exec(" perl /var/www/html/schedue/digital/notifycard.pl ".$result["CardNO"]." ".$message." ".$result["WriteDate"]." 17:00:00 ");

  		sleep(5);

  		shell_exec(" perl /var/www/html/schedue/digital/notifycard.pl ".$result["CardNO"]." ".$message." ".$result["WriteDate"]." 19:30:00 ");

  		sleep(5);

  		#shell_exec(" perl /var/www/html/schedue/digital/notifycard.pl ".$result["CardNO"]." ".$message." ".$result["WriteDate"]." 21:00:00 ");
 

  		mssql_query(" update [LineBot].[dbo].[SMS_Digital_Ondue] set Status_Send = 1 where  [ID] = '".$result["ID"]."' ");
		

		//print_r($result);
  	}
  

		 



 ?>