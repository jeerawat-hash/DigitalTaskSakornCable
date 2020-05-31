<?php 


	ini_set('mssql.charset', 'UTF-8');
    $connection = mssql_connect('mssqlcon', 'sa', 'Sakorn123');

   

  	$query = mssql_query("

  	  SELECT top 2 [ID]
      ,[CardNO]
      ,[IsOnDue]
      ,[IsOverDue]
      ,[SMSDate]
      ,[OverDueDate]
  FROM [LineSakorn].[dbo].[SMSLog] where IsOverDue = 0 and OverDueDate = '".date("Y-m-d")."' order by id asc


 	");

  	while ( $result = mssql_fetch_array($query) ) {
  		
  		$message = "แจ้งเตือนบิลเกินกำหนดกรุณาชำระค่าบริการขออภัยหากชำระแล้ว";


  		shell_exec(" perl /var/www/html/schedue/digital/notifycard.pl ".$result["CardNO"]." ".$message." ".date("Y-m-d")." 08:50:00 ");

  		#sleep(5);

  		#shell_exec(" perl /var/www/html/schedue/digital/notifycard.pl ".$result["CardNO"]." ".$message." ".$result["WriteDate"]." 10:50:00 ");

  		#sleep(5);

  		#shell_exec(" perl /var/www/html/schedue/digital/notifycard.pl ".$result["CardNO"]." ".$message." ".$result["WriteDate"]." 12:00:00 ");

  		#sleep(5);

  		#shell_exec(" perl /var/www/html/schedue/digital/notifycard.pl ".$result["CardNO"]." ".$message." ".$result["WriteDate"]." 15:00:00 ");

  		#sleep(5);

  		#shell_exec(" perl /var/www/html/schedue/digital/notifycard.pl ".$result["CardNO"]." ".$message." ".$result["WriteDate"]." 17:00:00 ");

  		#sleep(5);

  		#shell_exec(" perl /var/www/html/schedue/digital/notifycard.pl ".$result["CardNO"]." ".$message." ".$result["WriteDate"]." 20:00:00 ");

  		sleep(10);

  		#shell_exec(" perl /var/www/html/schedue/digital/notifycard.pl ".$result["CardNO"]." ".$message." ".$result["WriteDate"]." 21:00:00 ");
 

  		mssql_query(" update [LineSakorn].[dbo].[SMSLog] set IsOverDue = 1 where  [ID] = '".$result["ID"]."' ");

  	}
  

		 



 ?>