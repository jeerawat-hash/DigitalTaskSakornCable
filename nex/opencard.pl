  # Create a user agent object
  use LWP::UserAgent;
  
  $ua = new LWP::UserAgent;
  $ua->agent("AgentName/0.1 " . $ua->agent);

  my ($AccountID) = @ARGV;

  # Create a request
  my $req = new HTTP::Request POST => 'http://agent.cdnisp.com/bill/customer/edit/id/'.$AccountID.'.html';
  
  $req->header('Cookie' => 'PHPSESSID=f6e3jp56h51lnopkmqbn88oke6');
  
  $req->content_type('application/x-www-form-urlencoded');
  $req->content('address=CDN%20Plus%20535/35%20%E0%B8%9B%E0%B8%A3%E0%B8%B0%E0%B8%8A%E0%B8%B2%E0%B8%A3%E0%B8%B2%E0%B8%A9%E0%B8%8E%E0%B8%A3%E0%B9%8C%E0%B8%9A%E0%B8%B3%E0%B9%80%E0%B8%9E%E0%B9%87%E0%B8%8D%2015%20%E0%B9%81%E0%B8%A2%E0%B8%81%203%20%20%E0%B8%AB%E0%B9%89%E0%B8%A7%E0%B8%A2%E0%B8%82%E0%B8%A7%E0%B8%B2%E0%B8%87%20%E0%B8%81%E0%B8%A3%E0%B8%B8%E0%B8%87%E0%B9%80%E0%B8%97%E0%B8%9E%E0%B8%A1%E0%B8%AB%E0%B8%B2%E0%B8%99%E0%B8%84%E0%B8%A3%2010310&aid=&email=&imei=&import_mac=304EC30F5C92&is_enable=1&live_password=&mac=304EC30F5C92&model=&nick_name=CAT%20IPTV%20Series9&phone=022047555&remark=&sex=male&sn=170601001439&status=1&user_name=34348992141&user_pass=483242');

  # Pass request to the user agent and get a response back
  my $res = $ua->request($req);
  # Check the outcome of the response
  if ($res->is_success) {
 

      print $res->content;


  } else {
      print "Bad luck this time\n";
  }
  

# perl /var/www/html/schedue/nex/opencard.pl 9980003000000773