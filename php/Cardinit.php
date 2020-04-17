<?php 


	   ini_set('mssql.charset', 'UTF-8');
/*    $connection = mssql_connect('mssqlconcas', 'check', 'sakorn123');
 

    $cas_str = mssql_query(" SELECT  [CardNO]
      ,[PlatformID]
      ,[CUCount]
  FROM [CAS].[dbo].[Card2Platform] where CUcount = 1 and CardNo not in
  
        (
        
      '9980008100003504',
      '9980008100003068',
      '9980008100001366',
      '9980008100001212',
      '9980003300009752',
      '9980003300009172',
      '9980003300009071',
      '9980003300009046',
      '9980003300009045',
      '9980003300008446',
      '9980003300008416',
      '9980003300007954',
      '9980003300007936',
      '9980003300007513',
      '9980003300007495',
      '9980003300007316',
      '9980003300007037',
      '9980003300006970',
      '9980003300006514',
      '9980003300006505',
      '9980003300006364',
      '9980003200017254',
      '9980003200017013',
      '9980003200016746',
      '9980003200016521',
      '9980003200016233',
      '9980003200016230',
      '9980003200015991',
      '9980003200015465',
      '9980003200013968',
      '9980003200013427',
      '9980003200012753',
      '9980003200012439',
      '9980003200012167',
      '9980003200011659',
      '9980003200011088',
      '9980003200010474',
      '9980003200009627',
      '9980003200009031',
      '9980003200008258',
      '9980003200008154',
      '9980003200007302',
      '9980003200006733',
      '9980003200005902',
      '9980003200005306',
      '9980003200004590',
      '9980003200004530',
      '9980003200003864',
      '9980003200003621',
      '9980003200003588',
      '9980003200003506',
      '9980003200003491',
      '9980003200003365',
      '9980003200003226',
      '9980003200003167',
      '9980003200002745',
      '9980003200002695',
      '9980003200002620',
      '9980003200002014',
      '9980003200001636',
      '9980003200000846',
      '9980003200000689',
      '9980003200000276',
      '9980003000004887',
      '9980003000003759',
      '9980003000003455',
      '9980003000002934',
      '9980003000002250',
      '9980003000002010',
      '9980003000001906',
      '9980003000001001',
      '9980003000000693',
      '9980003000000332'
       
        
        ) ");


    $all = "";

      while ($result = mssql_fetch_array( $cas_str )) {
    
 

        $all .=  "INSERT INTO [WebSakorn].[dbo].[CardInit]
             ([CardNO]) VALUES ('".$result["CardNO"]."')\n";



      }

 
      echo $all;*/

      ////////////////////////// begin cut out //////////////////////////////

      $connection = mssql_connect('mssqlcon', 'sa', 'Sakorn123');

      
      $getAllCard_str = " SELECT top 10 [ID]
            ,[CardNO]
            ,[Is_Init]
        FROM [WebSakorn].[dbo].[CardInit] where Is_Init = 0 order by ID ";


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

                $Report .= "ตัด ".$resultCard["CardNO"]."\n"

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