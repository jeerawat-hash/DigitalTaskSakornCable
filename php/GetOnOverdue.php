<?php 

	ini_set('mssql.charset', 'UTF-8');
    $connection = mssql_connect('mssqlcon', 'sa', 'Sakorn123');


    $queryOndue =  mssql_query(" select *  from LineBot.dbo.Ondue 
where CustomerID not in ( select CustomerID from [LineBot].[dbo].[SMS_Digital_Ondue] ) 
and CONVERT(date,InvoiceDate) not in ( select WriteDate from [LineBot].[dbo].[SMS_Digital_Ondue] )
  ");

    while ( $resultdue = mssql_fetch_array($queryOndue) ) {
    	



    	print_r($resultdue);

/*
	
	
INSERT INTO [LineBot].[dbo].[SMS_Digital_Ondue]
           ([CardNO]
           ,[DB]
           ,[CustomerID]
           ,[PayCode]
           ,[WriteDate]
           ,[Status_Send])
     VALUES
           ('".."'
           ,'".."'
           ,'".."'
           ,'".."'
           ,'".."'
           ,'0')

*/


    }



 ?>