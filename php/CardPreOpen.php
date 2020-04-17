<?php 


	   ini_set('mssql.charset', 'UTF-8'); 


      ////////////////////////// begin cut out //////////////////////////////

      $connection = mssql_connect('mssqlcon', 'sa', 'Sakorn123');

      
      $getAllTele_str = mssql_query( " SELECT top 1 * FROM [LineSakorn].[dbo].[PreOpenCard] where IsSuccess = 0  order by ID asc " );

      while ($Telephone = mssql_fetch_array($getAllTele_str)) {

        //set @Telephone = '".$Telephone["Telephone"]."'
          
          $CardStr = mssql_query(" 
            declare @Telephone char(10)

             set @Telephone = '0996162847'
            
            select 'Bangchalong' as DB,a.CardID,b.CustomerID,b.Telephone,b.CustomerName,b.Soi from Bangchalong.dbo.customercabletype a
            join Bangchalong.dbo.Customer b on a.CustomerID = b.CustomerID
            where b.Telephone = @Telephone and CardID != ''
            
            union 
            
            select 'Flat' as DB,a.CardID,b.CustomerID,b.Telephone,b.CustomerName,b.Soi from Flat.dbo.customercabletype a
            join Flat.dbo.Customer b on a.CustomerID = b.CustomerID
            where b.Telephone = @Telephone and CardID != ''
            
            union 
            
            select 'CSCable' as DB,a.CardID,b.CustomerID,b.Telephone,b.CustomerName,b.Soi from CSCable.dbo.customercabletype a
            join CSCable.dbo.Customer b on a.CustomerID = b.CustomerID
            where b.Telephone = @Telephone and CardID != ''
            
            union 
            
            select 'Sahamit' as DB,a.CardID,b.CustomerID,b.Telephone,b.CustomerName,b.Soi from Sahamit.dbo.customercabletype a
            join Sahamit.dbo.Customer b on a.CustomerID = b.CustomerID
            where b.Telephone = @Telephone and CardID != ''
            
            union 
            
            select 'SakornCable' as DB,a.CardID,b.CustomerID,b.Telephone,b.CustomerName,b.Soi from SakornCable.dbo.customercabletype a
            join SakornCable.dbo.Customer b on a.CustomerID = b.CustomerID
            where b.Telephone = @Telephone and CardID != ''
            
            union 
            
            select 'SakornNetwork' as DB,a.CardID,b.CustomerID,b.Telephone,b.CustomerName,b.Soi from SakornNetwork.dbo.customercabletype a
            join SakornNetwork.dbo.Customer b on a.CustomerID = b.CustomerID
            where b.Telephone = @Telephone and CardID != ''
            
            union 
            
            select 'SakornNewBusiness' as DB,a.CardID,b.CustomerID,b.Telephone,b.CustomerName,b.Soi from SakornNewBusiness.dbo.customercabletype a
            join SakornNewBusiness.dbo.Customer b on a.CustomerID = b.CustomerID
            where b.Telephone = @Telephone and CardID != ''
            
            union 
            
            select 'Sakorp' as DB,a.CardID,b.CustomerID,b.Telephone,b.CustomerName,b.Soi from Sakorp.dbo.customercabletype a
            join Sakorp.dbo.Customer b on a.CustomerID = b.CustomerID
            where b.Telephone = @Telephone and CardID != ''
            
            union 
            
            select 'SRN' as DB,a.CardID,b.CustomerID,b.Telephone,b.CustomerName,b.Soi from SRN.dbo.customercabletype a
            join SRN.dbo.Customer b on a.CustomerID = b.CustomerID
            where b.Telephone = @Telephone and CardID != '' ");

 


                  $Report = "";

                  ################## Card Operate ######################
                  while ($Card = mssql_fetch_array($CardStr)) {
                    
 
                    //$string  = " perl /var/www/html/schedue/digital/opencard.pl ".$Card["CardID"];." ";

                    //$exe =  shell_exec( $string );

                    
                    $Report .= $Card["DB"]." ".$Card["CardID"]." ".$Card["CustomerID"]."\n".$Card["CustomerName"]."\n".$Card["Telephone"]." ".$Card["Soi"]."\n";
                     

                    sleep(2);

                  }

                  ################## Card Operate ######################
 





              ############################ update log #############################


              mssql_query(" update [LineSakorn].[dbo].[PreOpenCard] set IsOpenCard = 1 , IsSuccess = 1 where ID = '".$Telephone["ID"]."' ");
            

              $message = "ดำเนินการ ต่อการ์ดชั่วคราว\n".$Report;


              $token = "xwIy9YnB1ByZfiFz9dS4Pe82hLw9o5nRnQdmqnXlBBZ";
              notify($message,$token);
              ############################ update log #############################
          


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