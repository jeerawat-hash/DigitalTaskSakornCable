<?php 


	   ini_set('mssql.charset', 'UTF-8'); 


      ////////////////////////// begin cut out //////////////////////////////

      $connection = mssql_connect('mssqlcon', 'sa', 'Sakorn123');

      
      $getAllCard_str = mssql_query( " SELECT top 10 [ID]
            ,[CardNO]
            ,[Is_Init]
        FROM [WebSakorn].[dbo].[CardInit] where Is_Init = 0 order by ID " );


      $Report = "";




      while ($resultCard = mssql_fetch_array($getAllCard_str)) {
        

       

            $Card_str =  mssql_query(" declare @sCardNo char(20)

              set @sCardNo = '".$resultCard["CardNO"]."'


              SELECT * FROM
              (
              select DB='SakornCable',a.customerid,b.CardID ,a.stopdate from
              (select * from SakornCable.dbo.Customer where StopDate is null
                                        and CustomerID in (select CustomerID from SakornCable.dbo.customercabletype where CardID = @sCardNo   )
               ) a    Left outer join SakornCable.dbo.customercabletype b
              on a.customerid = b.customerid   AND b.CardID = @sCardNo

              UNION

              select DB='SakornNetwork',a.customerid,b.CardID ,a.stopdate from
              (select * from SakornNetwork.dbo.Customer where StopDate is   null
                                        and CustomerID in (select CustomerID from SakornNetwork.dbo.customercabletype where CardID = @sCardNo   )
               ) a    Left outer join SakornNetwork.dbo.customercabletype b
              on a.customerid = b.customerid   AND b.CardID = @sCardNo
              UNION
              select DB='Sakorp',a.customerid,b.CardID ,a.stopdate from
              (select * from Sakorp.dbo.Customer where StopDate is   null
                                        and CustomerID in (select CustomerID from Sakorp.dbo.customercabletype where CardID = @sCardNo   )
               ) a    Left outer join Sakorp.dbo.customercabletype b
              on a.customerid = b.customerid   AND b.CardID = @sCardNo

              UNION
              select DB='CSCable',a.customerid,b.CardID ,a.stopdate from
              (select * from CSCable.dbo.Customer where StopDate is   null
                                        and CustomerID in (select CustomerID from CSCable.dbo.customercabletype where CardID = @sCardNo   )
               ) a    Left outer join CSCable.dbo.customercabletype b
              on a.customerid = b.customerid   AND b.CardID = @sCardNo
              UNION
              select  DB='Sahamit',a.customerid,b.CardID ,a.stopdate from
              (select * from Sahamit.dbo.Customer where StopDate is   null
                                        and CustomerID in (select CustomerID from Sahamit.dbo.customercabletype where CardID = @sCardNo   )
               ) a    Left outer join Sahamit.dbo.customercabletype b
              on a.customerid = b.customerid   AND b.CardID = @sCardNo
              UNION

               
              select DB='Bangchalong',a.customerid,b.CardID ,a.stopdate from
              (select * from Bangchalong.dbo.Customer where StopDate is   null
                                        and CustomerID in (select CustomerID from Bangchalong.dbo.customercabletype where CardID = @sCardNo   )
               ) a    Left outer join Bangchalong.dbo.customercabletype b
              on a.customerid = b.customerid  AND b.CardID = @sCardNo  

              UNION

              select DB='Flat',a.customerid,b.CardID ,a.stopdate from
              (select * from Flat.dbo.Customer where StopDate is   null
                                        and CustomerID in (select CustomerID from Flat.dbo.customercabletype where CardID = @sCardNo   )
               ) a    Left outer join Flat.dbo.customercabletype b
              on a.customerid = b.customerid   AND b.CardID = @sCardNo

              UNION
              select DB='SRN',a.customerid,b.CardID ,a.stopdate from
              (select * from SRN.dbo.Customer where StopDate is   null
                                        and CustomerID in (select CustomerID from SRN.dbo.customercabletype where CardID = @sCardNo   )
               ) a    Left outer join SRN.dbo.customercabletype b
              on a.customerid = b.customerid   AND b.CardID = @sCardNo

              UNION
              select DB='SakornNewBusiness',a.customerid,b.CardID ,a.stopdate from
              (select * from SakornNewBusiness.dbo.Customer where StopDate is   null
                                        and CustomerID in (select CustomerID from SakornNewBusiness.dbo.customercabletype where CardID = @sCardNo   )
               ) a    Left outer join SakornNewBusiness.dbo.customercabletype b
              on a.customerid = b.customerid   AND b.CardID = @sCardNo

              ) SakornGroup ORDER BY StopDate desc

               
                "); 

            
            $CardStatus = mssql_num_rows($Card_str);
            $StatusRemrk = "";

            sleep(1);

            if ($CardStatus == 0) {
                ############ cut card number ##############

                $string  = " perl /var/www/html/schedue/digital/cutcard.pl ".$resultCard["CardNO"]." ";

                $exe =  shell_exec( $string );

                ############ cut card number ##############
                $StatusRemrk = "FreeCard";

                $Report .= "ตัด ".$resultCard["CardNO"]."\n";

            }else{



                $StatusRemrk = "NormalCard";
            }

  

            mssql_query("update [WebSakorn].[dbo].[CardInit] set [Is_Init] = 1 , Remark = '".$StatusRemrk."' where CardNo = '".$resultCard["CardNo"]."' ");

  
      }


      $ReportAll = "SyncCardStatus by CasServer....\n".$Report;



      notify($ReportAll,"Ahlxzwfwdnv7CjVPMC3s6fdNPtOEH49AeQkhF4CUfKI");
      
 




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