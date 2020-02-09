<?php 

		
error_reporting(0);

	/// 9980003000000039 
	///// Controller
    $pull = file_get_contents("php://input");
    ///// Controller

    ///// Model
	$data = json_decode($pull,true);

	print_r($data);

	echo "<br>";

	echo $data["CardNo"]."<br>".$data["Status"]."<br>";

	/*
	if ( isset($_POST["cutcard"]) ) {
		
		$string  = " perl /var/www/html/schedue/digital/cutcard.pl ".$_POST["card"]." ";

		$exe =  shell_exec( $string );

		if ($exe) {
			echo "CUT ".$_POST["card"];
		}

	}else	
	if ( isset($_POST["connectcard"]) ) {
		
		$string  = " perl /var/www/html/schedue/digital/opencard.pl ".$_POST["card"]." ";

		$exe =  shell_exec( $string );

		if ($exe) {
			echo "Connect ".$_POST["card"];
		}

	}else{



	}*/




 ?>