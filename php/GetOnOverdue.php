<?php 

	ini_set('mssql.charset', 'UTF-8');
    $connection = mssql_connect('mssqlcon', 'sa', 'Sakorn123');


    $queryOndue =  mssql_query(" select *  from LineBot.dbo.Ondue 
where CustomerID not in ( select CustomerID from [LineBot].[dbo].[SMS_Digital_Ondue] ) 
and CONVERT(date,InvoiceDate) not in ( select WriteDate from [LineBot].[dbo].[SMS_Digital_Ondue] )
  ");

    while ( $resultdue = mssql_fetch_array($queryOndue) ) {
  	


    	$cardno = mssql_fetch_array(mssql_query(" 
select top 1   a.cardno,b.CustomerID ,c.CustomerName ,  MAX(b.startdate) as startdate 
from ".$resultdue["DB"].".dbo.customercardlog  a  left outer join ".$resultdue["DB"].".dbo.CustomerCableType b on a.CardNO = b.CardID 
LEFT OUTER JOIN ".$resultdue["DB"].".dbo.Customer c ON b.CustomerID = c.CustomerID 
where b.CustomerID = '".$resultdue["CustomerID"]."'
GROUP BY  a.cardno,b.CustomerID ,c.CustomerName
 ORDER BY  startdate  desc "));

  		mssql_query(" 
  		INSERT INTO [LineBot].[dbo].[SMS_Digital_Ondue]
           ([CardNO]
           ,[DB]
           ,[CustomerID]
           ,[PayCode]
           ,[WriteDate]
           ,[Status_Send])
     VALUES
           ('".$cardno["cardno"]."'
           ,'".$resultdue["DB"]."'
           ,'".$resultdue["CustomerID"]."'
           ,'".$resultdue["PayCode"]."'
           ,'".date("Y-m-d")."'
           ,'0')
            ");  	
 
    }





    $queryOverdue =  mssql_query(" select *  from LineBot.dbo.Overdue 
where CustomerID not in ( select CustomerID from [LineBot].[dbo].[SMS_Digital_Overdue] ) 
and CONVERT(date,InvoiceDate) not in ( select WriteDate from [LineBot].[dbo].[SMS_Digital_Overdue] )
  ");

    while ( $resultOverdue = mssql_fetch_array($queryOverdue) ) {
  	

    	$cardno = mssql_fetch_array(mssql_query(" 
select top 1   a.cardno,b.CustomerID ,c.CustomerName ,  MAX(b.startdate) as startdate 
from ".$resultOverdue["DB"].".dbo.customercardlog  a  left outer join ".$resultOverdue["DB"].".dbo.CustomerCableType b on a.CardNO = b.CardID 
LEFT OUTER JOIN ".$resultOverdue["DB"].".dbo.Customer c ON b.CustomerID = c.CustomerID 
where b.CustomerID = '".$resultOverdue["CustomerID"]."'
GROUP BY  a.cardno,b.CustomerID ,c.CustomerName
 ORDER BY  startdate  desc "));

  		mssql_query(" INSERT INTO [LineBot].[dbo].[SMS_Digital_Overdue]
           ([DB]
           ,[CardNO]
           ,[CustomerID]
           ,[PayCode]
           ,[WriteDate]
           ,[Status_Send])
     VALUES
           ('".$cardno["cardno"]."'
           ,'".$resultOverdue["DB"]."'
           ,'".$resultOverdue["CustomerID"]."'
           ,'".$resultOverdue["PayCode"]."'
           ,'".date("Y-m-d")."' 
           ,'0') ");  	
 
    }



 ?>