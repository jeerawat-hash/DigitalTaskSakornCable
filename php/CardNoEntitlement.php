<?php 
  ini_set('mssql.charset', 'UTF-8'); 

  require "vendor/autoload.php";


  use LINE\LINEBot;
  use LINE\LINEBot\HTTPClient;
  use LINE\LINEBot\HTTPClient\CurlHTTPClient;
  //use LINE\LINEBot\Event;
  //use LINE\LINEBot\Event\BaseEvent;
  //use LINE\LINEBot\Event\MessageEvent;
  use LINE\LINEBot\MessageBuilder;
  use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
  use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
  use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
  use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
  use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
  use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
  use LINE\LINEBot\ImagemapActionBuilder;
  use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
  use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder;
  use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
  use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
  use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
  use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
  use LINE\LINEBot\TemplateActionBuilder;
  use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
  use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
  use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
  use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
  use LINE\LINEBot\MessageBuilder\TemplateBuilder;
  use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
  use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
  use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
  use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
  use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
  use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder;
  use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder;


  $token = "3/eg6PG+jtDE679lsfZCbanCi1r2AphBbTW8oqkjqXqzgHepQkCMXYGAtYO0D8NzbY1++E52JZwqywM7XnKDUDbZ8SKAL8xTS+5CO+3WbeiCKEQGIu8jwCP7rjpuTy541Fu+RG8WE9HBwaTPokYTYwdB04t89/1O/w1cDnyilFU=";
  $channel = "6f59f1781c889646a225fdca62fd55a0";


  $httpClient = new CurlHTTPClient($token);
  $bot = new LINEBot($httpClient, ['channelSecret' => $channel]);
  



      ////////////////////////// begin cut out //////////////////////////////

      $a = mssql_connect('mssqlcon', 'sa', 'Sakorn123');
       

      $b = mssql_connect('mssqlconcas', 'check', 'Sakorn123');
  
        


      $Query =  mssql_query(" SELECT top 2 a.[ID]
      ,[CardNO]
      ,a.[Telephone]
      ,[IsSuccess]
    ,[SyncDate]
	,[LineID]
    FROM [LineSakorn].[dbo].[NoEntitlement] a left outer join LineSakorn.dbo.Customer b on a.Telephone = b.Telephone where a.IsSuccess = 0 and a.SyncDate = convert(date,getdate()) order by a.[ID] asc  ",$a);



      while ($Result = mssql_fetch_array($Query)) {
       

        $Check = mssql_num_rows(mssql_query(" SELECT * FROM [CAS].[dbo].[Card2Platform] where CardNO = '".trim($Result["CardNO"])."' ",$b));

        $status = "";

        if ($Check == "1") {
          

          echo $Result["CardNO"]." ".$Check."\n";


          #$Cut  = " perl /var/www/html/schedue/digital/cutcard.pl ".$Result["CardNO"]." ";

          #shell_exec( $Cut );
          mssql_query(" exec dbo.sp_Card_Stop '".$Result["CardNO"]."',null ",$b);
          

          sleep(5);


          #$Open  = " perl /var/www/html/schedue/digital/opencard.pl ".$Result["CardNO"]." ";

          #shell_exec( $Open );
          mssql_query(" exec dbo.sp_Card_Restart '".$Result["CardNO"]."',null ",$b);

          $status = "ย้ำสัญญาณการ์ดสำเร็จ";
 

        }else{



          $status = "ย้ำสัญญาณการ์ดไม่สำเร็จ";
 

        }
          


          mssql_query(" update [LineSakorn].[dbo].[NoEntitlement] set IsSuccess = 1 where ID = '".$Result["ID"]."' ",$a);

          notify("ย้ำสัญญาณการ์ด\n".$Result["CardNO"]."\nหมายเลขโทรศัพท์ ".$Result["Telephone"]."\n".$status,"X3Ns5J0u2UhKkoirOm20GIvRyFlNtA3R7LJEizfhGQN");
          
          $MSGT = "[ระบบ]\nย้ำสัญญาณการ์ดหมายเลข ".$Result["CardNO"]." สำเร็จแล้ว\nกรุณาทดสอบเปลี่ยนช่องใน 1-2 นาทีหากภาพไม่มาภายใน 30 นาทีกรุณาแจ้งงานบริการอีกครั้ง";

          botpush($token,$channel,"U9c4cfc5da6f9aedeafd692b67b37a59e",$MSGT);

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

function botpush($access_token,$channelSecret,$LineID,$Message){

  $httpClient = new CurlHTTPClient($access_token);
  $bot = new LINEBot($httpClient, ['channelSecret' => $channelSecret]);

  $SendMessage = new TextMessageBuilder($Message);

  $response = $bot->pushMessage($LineID, $SendMessage);

    $aa = $response->getHTTPStatus();
  if ($aa == "200") {
    return "200";
  }else{
    return "500";
  }

}


 ?>