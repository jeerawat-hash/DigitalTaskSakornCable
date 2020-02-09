<?php 

		
error_reporting(0);

	/// 9980003000000039 
	///// Controller
    $pull = file_get_contents("php://input");
    ///// Controller

    ///// Model
	$data = json_decode($pull,true);

	print_r($data);
 

	echo $data["CardNo"]."\n".$data["Status"]."\n";

	
	if ( $_POST["Status"] == "Cut" ) {
		
		$string  = " perl /var/www/html/schedue/digital/cutcard.pl ".$_POST["CardNo"]." ";

		$exe =  shell_exec( $string );

		if ($exe) {
			echo "CUT ".$_POST["CardNo"];
		}

	}else	
	if ( $_POST["Status"] == "Open" ) {
		
		$string  = " perl /var/www/html/schedue/digital/opencard.pl ".$_POST["CardNo"]." ";

		$exe =  shell_exec( $string );

		if ($exe) {
			echo "Open ".$_POST["CardNo"];
		}

	}




 ?>