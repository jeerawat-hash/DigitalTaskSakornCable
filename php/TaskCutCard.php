<?php 


	   ini_set('mssql.charset', 'UTF-8'); 
 
      $a = mssql_connect('mssqlcon', 'sa', 'Sakorn123');
      $b = mssql_connect('mssqlconcas', 'check', 'Sakorn123');
      
      $staCardquert = mssql_query( " SELECT top 50 [ID]
      ,[CustomerID]
      ,[CardID]
      ,[IsCut]  FROM [WebSakorn].[dbo].[TempCutCard] where IsCut = 0 order by ID asc
      
       ",$a);

      while ($ResultCard = mssql_fetch_array($staCardquert)) {
  
        mssql_query(" exec dbo.sp_Card_Stop '".$ResultCard["CardID"]."',null ",$b);

        ############################ update log ############################# 
        mssql_query(" update [WebSakorn].[dbo].[TempCutCard] set IsCut = 1 where ID = '".$ResultCard["ID"]."' ",$a);
        ############################ update log #############################
        
        sleep(1);        

      }
 
       
 ?>