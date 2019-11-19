<meta charset="utf-8">

<!DOCTYPE html>
<html>
<head>
	<title>CardOperator</title>
</head>
<body>

	<center>ส่งข้อความ</center>
	<form method="post" action="#" >
		

			<label>การ์ด</label>
			<input type="text" name="card"> <br>
			<label>ข้อความ</label>
			<input type="text" name="message"> <br>
			<label>วันที่ต้องการส่ง</label>
			<input type="text" value="<?php echo date("Y-m-d"); ?>" name="date"> <br>
			<label>เวลาที่ต้องการส่ง</label>
			<input type="text" value="<?php echo date("H:i:s"); ?>" name="time">
			 


		<input type="submit" value="1" name="messagecard" >
	</form>

<br>

	<center>ตัดการ์ด</center>
	<form method="post"  action="#"  >
		

			<label>การ์ด</label>
			<input type="text" name="card"> <br>
			<label>ข้อความ</label>
			<input type="text" name="message"> <br>
			    

		<input type="submit" name="cutcard" value="1" >
	</form>

<br>

	<center>เปิดการ์ด</center>
	<form method="post" action="#"  >
		

			<label>การ์ด</label>
			<input type="text" name="card"> <br>
			<label>ข้อความ</label>
			<input type="text" name="message"> <br>
			    
			    
		<input type="submit" name="connectcard" value="1" >
	</form>
 
</body>
</html>





<?php 
error_reporting(0);
	print_r($_POST);
	
	if ( isset($_POST["messagecard"]) ) {
			
		$string  = " perl /var/www/html/schedue/digital/notifycard.pl ".$_POST["card"]." ".$_POST["message"]." ".$_POST["date"]." ".$_POST["time"]." ";

		$exe =  shell_exec( $string );

		if ($exe) {
			echo "Send Message ".$_POST["card"];
		}


	}else
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



	}
 

 ?>