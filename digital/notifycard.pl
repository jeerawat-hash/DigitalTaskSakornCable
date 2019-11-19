  # Create a user agent object
  use LWP::UserAgent;

  $ua = new LWP::UserAgent;
  $ua->agent("AgentName/0.1 " . $ua->agent);
  # Create a request
  my $req = new HTTP::Request POST => 'http://172.168.2.2:8081/sms2_4/ca/camessageedit.do';

  #my ($name) = @ARGV;
  $name = '9980003200006591';

  $req->header('Cookie' => 'JSESSIONID=FD43E88157EE150E0C7270025AFCF18D');

  $req->content_type('application/x-www-form-urlencoded');
  #$req->content('accreditType=CARDOSD&duration=60&id=&message=ทดสอบระบบ&operate=insert&remark=test&scCode=9980003200006591&sendCount=1&sendInterval=60&sendTime=2019-11-19%2017:10:00&subAreaId=&subTypeId=&title=');

  my $string  = 'accreditType=CARDOSD&duration=60&id=&message=${name}&operate=insert&remark=test&scCode=9980003200006591&sendCount=1&sendInterval=60&sendTime=2019-11-19%2017:10:00&subAreaId=&subTypeId=&title=';
  $req->content( $string );

  # Pass request to the user agent and get a response back
  my $res = $ua->request($req);
  # Check the outcome of the response
  if ($res->is_success) {
      print $res->content;
  } else {
      print "Bad luck this time\n";
  }
  


