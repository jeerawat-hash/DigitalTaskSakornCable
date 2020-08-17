  # Create a user agent object
  use LWP::UserAgent;
  $ua = new LWP::UserAgent;
  $ua->agent("AgentName/0.1 " . $ua->agent);
  # Create a request
  my $req = new HTTP::Request POST => 'http://172.168.2.2:8081/sms2_4/ca/searchcamessage.do';

  $req->header('Cookie' => 'JSESSIONID=EB7E78BF5A6409C2B72253A9ADA7F29D');

  $req->content_type('application/x-www-form-urlencoded');
  $req->content('accreditType=&endDate=&operate=info_search&page=&scCode=&startDate=&subAreaId=&subTypeId=');

  # Pass request to the user agent and get a response back
  my $res = $ua->request($req);
  # Check the outcome of the response
  if ($res->is_success) {
      print $res->content;
  } else {
      print "Bad luck this time\n";
  }
