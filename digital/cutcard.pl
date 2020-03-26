  # Create a user agent object
  use LWP::UserAgent;
  $ua = new LWP::UserAgent;
  $ua->agent("AgentName/0.1 " . $ua->agent);
  # Create a request
  my $req = new HTTP::Request POST => 'http://172.168.2.2:8081/sms2_4/ca/avitcaaccredit.do';

  my ($card,$message) = @ARGV;

  $req->header('Cookie' => 'JSESSIONID=D657AE6B4AAD5BE08A0C7748D37AB946');

  $req->content_type('application/x-www-form-urlencoded');
  $req->content('accreditType=BUYPRO_1&duration=&message=&operate=accredit&position=0&productIds=81&scCode='.$card.'&title=');

  # Pass request to the user agent and get a response back
  my $res = $ua->request($req);
  # Check the outcome of the response
  if ($res->is_success) {
      print $res->content;
  } else {
      print "Bad luck this time\n";
  }



# perl /var/www/html/schedue/digital/cutcard.pl 9980003000000773
