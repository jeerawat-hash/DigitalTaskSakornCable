  use strict;
  # Create a user agent object
  use LWP::UserAgent;

  $ua = new LWP::UserAgent;
  $ua->agent("AgentName/0.1 " . $ua->agent);
  # Create a request
  my $req = new HTTP::Request POST => 'http://172.168.2.2:8081/sms2_4/ca/camessageedit.do';

  my ($card,$message,$date,$time) = @ARGV;

  $req->header('Cookie' => 'JSESSIONID=FD43E88157EE150E0C7270025AFCF18D');

  $req->content_type('application/x-www-form-urlencoded');
  $req->content('accreditType=CARDOSD&duration=60&id=&message=$message&operate=insert&remark=test&scCode=$card&sendCount=1&sendInterval=60&sendTime=$date%20$time&subAreaId=&subTypeId=&title=');

  # Pass request to the user agent and get a response back
  my $res = $ua->request($req);
  # Check the outcome of the response
  if ($res->is_success) {
      print $res->content;
  } else {
      print "Bad luck this time\n";
  }



