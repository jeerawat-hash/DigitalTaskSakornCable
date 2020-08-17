  # Create a user agent object
  use LWP::UserAgent;

  $ua = new LWP::UserAgent;
  $ua->agent("AgentName/0.1 " . $ua->agent);
  # Create a request
  my $req = new HTTP::Request POST => 'http://172.168.2.2:8081/sms2_4/ca/camessageedit.do';

  my ($card,$message,$date,$time) = @ARGV;
  #$name = '9980003200006591';

  $req->header('Cookie' => 'JSESSIONID=EB7E78BF5A6409C2B72253A9ADA7F29D');

  $req->content_type('application/x-www-form-urlencoded');
  #$req->content('accreditType=CARDOSD&duration=60&id=&message=ทดสอบระบบ&operate=insert&remark=test&scCode=9980003200006591&sendCount=1&sendInterval=60&sendTime=2019-11-19%2017:10:00&subAreaId=&subTypeId=&title=');

  my $content  = 'accreditType=CARDOSD&duration=60&id=&message='.$message.'&operate=insert&remark=test&scCode='.$card.'&sendCount=1&sendInterval=60&sendTime='.$date.'%20'.$time.'&subAreaId=&subTypeId=&title=';
  $req->content( $content );

  # Pass request to the user agent and get a response back
  my $res = $ua->request($req);
  # Check the outcome of the response
  if ($res->is_success) {
      print $res->content;
  } else {
      print "Bad luck this time\n";
  }
  


# perl /var/www/html/schedue/digital/notifycard.pl 9980003000000773 ทดสอบระบบส่งข้อความหาพี่พิทัก 2019-11-19 12:50:00

#9980003200006591
#9980003000000773
