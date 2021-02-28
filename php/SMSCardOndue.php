<?php 


	ini_set('mssql.charset', 'UTF-8');
    $a = mssql_connect('mssqlcon', 'sa', 'Sakorn123');
    $b = mssql_connect('mssqlconcas', 'check', 'Sakorn123');
   

  	$query = mssql_query("

  	
      SELECT top 2 [ID]
      ,[CardNO]
      ,[IsOnDue]
      ,[IsOverDue]
      ,[SMSDate]
      ,[OverDueDate]
  FROM [LineSakorn].[dbo].[SMSLog] where isOndue = 0 and smsDate = '".date("Y-m-d")."' order by id asc



 	",$a);

  	while ( $result = mssql_fetch_array($query) ) {
  		
  		 
  		#shell_exec(" perl /var/www/html/schedue/digital/notifycard.pl ".$result["CardNO"]." ".$message." ".date("Y-m-d")." 08:50:00 ");
      

      mssql_query("  exec [dbo].[sp_Service_OSD]  0,'".$result["CardNO"]."',0,60,'Y/Z+hq2T9tcXz1C+CmUCD5bT9HqRsaVljtDGlbq1REe5PxbyhxC1Da+xOrggdBOqOJW3pLbupmNB8dzgvfGR0g==','2021-12-30 00:00:00',null ",$b);



  		mssql_query(" update [LineSakorn].[dbo].[SMSLog] set isOndue = 1 where [ID] = '".$result["ID"]."' ",$a);
		

		//print_r($result);
  	}
  

		 



 ?>