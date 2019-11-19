  # Create a user agent object
  use LWP::UserAgent;
  $ua = new LWP::UserAgent;
  $ua->agent("AgentName/0.1 " . $ua->agent);
  # Create a request
  my $req = new HTTP::Request POST => 'http://172.168.2.2:8081/sms2_4/ca/avitcaaccredit.do';

  $req->header('Cookie' => 'JSESSIONID=FD43E88157EE150E0C7270025AFCF18D');

  $req->content_type('application/x-www-form-urlencoded');
  $req->content('accreditType=BUYPRO_0&duration=&message=&operate=accredit&position=0&productIds=81&scCode=9980003200006591&title=');

  # Pass request to the user agent and get a response back
  my $res = $ua->request($req);
  # Check the outcome of the response
  if ($res->is_success) {
      print $res->content;
  } else {
      print "Bad luck this time\n";
  }



