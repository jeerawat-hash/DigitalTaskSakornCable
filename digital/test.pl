

my ($name, $number,$other) = @ARGV;
 
if (not defined $name) {
  die "Need name\n";
}
 
if (defined $number) {
  print "Save '$name' and '$number' and '$other'\n";
  # save name/number in database
  exit;
}
 
print "Fetch '$name'\n";
# look up the name in the database and print it out


#document.cookie = "JSESSIONID=8E912732F6CC82033F4628E49C99FE55";q