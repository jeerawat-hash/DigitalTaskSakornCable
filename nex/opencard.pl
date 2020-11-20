  # Create a user agent object
  use LWP::UserAgent;
  
  $ua = new LWP::UserAgent;
  $ua->agent("AgentName/0.1 " . $ua->agent);

  my ($AccountID,$MacAddress) = @ARGV;

  # Create a request
  my $req = new HTTP::Request POST => 'http://agent.cdnisp.com/bill/customer/edit/id/'.$AccountID.'.html';
  
  $req->header('Cookie' => 'PHPSESSID=f6e3jp56h51lnopkmqbn88oke6');
  
  $req->content_type('application/x-www-form-urlencoded');
  $req->content('import_mac='.$MacAddress.'&is_enable=1');

  # Pass request to the user agent and get a response back
  my $res = $ua->request($req);
  # Check the outcome of the response
  if ($res->is_success) {
 

      #print $res->content;


  } else {
      print "Bad luck this time\n";
  }
  

# perl /var/www/html/schedue/nex/opencard.pl 9980003000000773