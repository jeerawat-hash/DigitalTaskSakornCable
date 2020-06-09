<?php 


	   ini_set('mssql.charset', 'UTF-8'); 


      ////////////////////////// begin cut out //////////////////////////////
      $mysql = mysql_connect("172.168.0.24","sak0rn","sak0rncable");

      $connection = mssql_connect('mssqlcon', 'sa', 'Sakorn123');

      
      $getAllTele_str = mssql_query( " SELECT top 1 [ID]
      ,[Telephone]
      ,[IsOpenCard]
      ,[CreateDate]
      ,[IsSuccess]
      ,[IsReInit]
  FROM [LineSakorn].[dbo].[PreOpenCard] where IsReInit = 0 and IsSuccess = 1 and IsOpenCard = 0 order by ID " );



      while ($Telephone = mssql_fetch_array($getAllTele_str)) {
 
          
          $CardStr = mssql_query(" 
            declare @Telephone char(10)

            set @Telephone = '".$Telephone["Telephone"]."'
            
            select 'Bangchalong' as DB,a.CardID,b.CustomerID,b.Telephone,b.CustomerName,b.Soi from Bangchalong.dbo.customercabletype a
            join Bangchalong.dbo.Customer b on a.CustomerID = b.CustomerID
            where b.Telephone = @Telephone and CardID != '' and b.Suspend = 0
            
            union 
            
            select 'Flat' as DB,a.CardID,b.CustomerID,b.Telephone,b.CustomerName,b.Soi from Flat.dbo.customercabletype a
            join Flat.dbo.Customer b on a.CustomerID = b.CustomerID
            where b.Telephone = @Telephone and CardID != '' and b.Suspend = 0
            
            union 
            
            select 'CSCable' as DB,a.CardID,b.CustomerID,b.Telephone,b.CustomerName,b.Soi from CSCable.dbo.customercabletype a
            join CSCable.dbo.Customer b on a.CustomerID = b.CustomerID
            where b.Telephone = @Telephone and CardID != '' and b.Suspend = 0
            
            union 
            
            select 'Sahamit' as DB,a.CardID,b.CustomerID,b.Telephone,b.CustomerName,b.Soi from Sahamit.dbo.customercabletype a
            join Sahamit.dbo.Customer b on a.CustomerID = b.CustomerID
            where b.Telephone = @Telephone and CardID != '' and b.Suspend = 0
            
            union 
            
            select 'SakornCable' as DB,a.CardID,b.CustomerID,b.Telephone,b.CustomerName,b.Soi from SakornCable.dbo.customercabletype a
            join SakornCable.dbo.Customer b on a.CustomerID = b.CustomerID
            where b.Telephone = @Telephone and CardID != '' and b.Suspend = 0
            
            union 
            
            select 'SakornNetwork' as DB,a.CardID,b.CustomerID,b.Telephone,b.CustomerName,b.Soi from SakornNetwork.dbo.customercabletype a
            join SakornNetwork.dbo.Customer b on a.CustomerID = b.CustomerID
            where b.Telephone = @Telephone and CardID != '' and b.Suspend = 0
            
            union 
            
            select 'SakornNewBusiness' as DB,a.CardID,b.CustomerID,b.Telephone,b.CustomerName,b.Soi from SakornNewBusiness.dbo.customercabletype a
            join SakornNewBusiness.dbo.Customer b on a.CustomerID = b.CustomerID
            where b.Telephone = @Telephone and CardID != '' and b.Suspend = 0
            
            union 
            
            select 'Sakorp' as DB,a.CardID,b.CustomerID,b.Telephone,b.CustomerName,b.Soi from Sakorp.dbo.customercabletype a
            join Sakorp.dbo.Customer b on a.CustomerID = b.CustomerID
            where b.Telephone = @Telephone and CardID != '' and b.Suspend = 0
            
            union 
            
            select 'SRN' as DB,a.CardID,b.CustomerID,b.Telephone,b.CustomerName,b.Soi from SRN.dbo.customercabletype a
            join SRN.dbo.Customer b on a.CustomerID = b.CustomerID
            where b.Telephone = @Telephone and CardID != '' and b.Suspend = 0 ");

 


                  $Report = "";
                  $Report_Internet = "";


                  ################## Card Operate ######################
                  while ($Card = mssql_fetch_array($CardStr)) {

                     
                    
                      $CardSyncStr = mssql_query(" declare @sCardNo char(20)

                          set @sCardNo = '".$Card["CardID"]."'


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


                        if (mssql_num_rows($CardSyncStr) != 0 ) {




                          //$check_CardCycle = mssql_num_rows(mssql_query(" select * from [LineSakorn].[dbo].[OpenCard] where CardNo = '".$Card["CardID"]."' and month(CreateDate) = MONTH(GETDATE()) and IsSuccess = 1 "));
                          $check_CardCycle = mssql_num_rows(mssql_query(" select * from [LineSakorn].[dbo].[OpenCard] where CardNo = '".$Card["CardID"]."' and IsSuccess = 1 "));


                          /// begin
                          if ($check_CardCycle != 0) {

                            $string  = " perl /var/www/html/schedue/digital/opencard.pl ".$Card["CardID"]." ";

                            $exe =  shell_exec( $string );

                            
                            $Report .= $Card["DB"]." ".$Card["CardID"]." ".$Card["CustomerID"]."\n".$Card["CustomerName"]."\n".$Card["Telephone"]." ".$Card["Soi"]."\n";


                            mssql_query(" update [LineSakorn].[dbo].[OpenCard] set IsSuccess = 2 where CardNo = '".$Card["CardID"]."' and IsSuccess = 1 ");
        

                          }
                          //// end
                          

                          

                          sleep(2);

                        } 


                  }

                  ################## Card Operate ######################
 

 




                  ################### Internet Operate #################

                  $InternetQuery = mssql_query(" exec LineSakorn.dbo.InternetCheck '".$Telephone["Telephone"]."' ");

                  while ($InternetResult = mssql_fetch_array($InternetQuery)) {


                      if ($InternetResult["StopDate"] != "") {


                        if ($InternetResult["TypeNET"] == "INET") {
                          
                          $url = "https://bb.inet-th.net/index.php/api/update";
                          Operation($url,$InternetResult["INetID"],"active");

                        }else
                        if ($InternetResult["TypeNET"] == "Sakorn") {
                          
                          mysql_query(" update  radius.radreply set value = 'Online'  WHERE  username = '".$InternetResult["PPOE"]."'  ");

                        }


                      }else
                      if ($InternetResult["StopDate"] == "") {


                        if ($InternetResult["TypeNET"] == "INET") {
                          
                          $url = "https://bb.inet-th.net/index.php/api/update";
                          Operation($url,$InternetResult["INetID"],"suspend");

                        }else
                        if ($InternetResult["TypeNET"] == "Sakorn") {
                          
                          mysql_query(" update  radius.radreply set value = 'Expire'  WHERE  username = '".$InternetResult["PPOE"]."'  ");

                        }


                      }
                      

                      $Report_Internet .= "\n".$InternetResult["PPOE"];


                  }
 
                  ################### Internet Operate #################


  



              ############################ update log #############################


              mssql_query(" update [LineSakorn].[dbo].[PreOpenCard] set IsReInit = 1 where ID = '".$Telephone["ID"]."' ");
            
              $message = "ทำการ Sync ค่าเบอร์ ".$Telephone["Telephone"]." จากระบบต่อชั่วคราว\n".$Report."สำเร็จ";

              if ($Report != "") {
                
                //$token = "xwIy9YnB1ByZfiFz9dS4Pe82hLw9o5nRnQdmqnXlBBZ";
                $token = "X3Ns5J0u2UhKkoirOm20GIvRyFlNtA3R7LJEizfhGQN";
                notify($message,$token);

              } 

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

function Operation($url,$clientid,$status)
{
    
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS,
              "access_code=ZWaFcOV3yILx6DjmRWs029EzdYQgy0GdmoHA779tAK4vz8FqP55kOtivxounk11erUF7NsplanMKDivQVJL1pxIPwbkNEnBJSqCsfwXZcGZfXrSeTdezPt3CpUHYYR22fQjc6iGWwq8M&id=".$clientid."&status=".$status."&name=&surname=&mac_address&username&password&site_id=97&package_id=&type=");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($ch);

  curl_close ($ch);

  return $result;
}


 ?>