<?php 

	ini_set('mssql.charset', 'UTF-8');
  $connection = mssql_connect('mssqlcon', 'sa', 'Sakorn123');


  mssql_query("  exec linesakorn.dbo.initsms ");


  //// ส่งข้อความเตือนก่อน 3วัน ของเมื่อวาน
  $date3 = mssql_fetch_array(mssql_query(" SELECT count(*) as SMS3D, DATEADD (day, -1,  '".date("Y-m-d")."' ) as OverDate FROM 
  [LineSakorn].[dbo].[SMSLog] where isOndue = 1 and smsDate = DATEADD (day, -1,  '".date("Y-m-d")."' )  "));
 

  //// ส่งข้อความเตือนบิลเกิน ของเมื่อวาน
  $dateOver = mssql_fetch_array(mssql_query(" SELECT count(*) as SMSOver, DATEADD (day, -1,  '".date("Y-m-d")."' ) as OverDate FROM 
  [LineSakorn].[dbo].[SMSLog] where IsOverDue = 1 and OverDueDate = DATEADD (day, -1,  '".date("Y-m-d")."' ) "));



 ?>