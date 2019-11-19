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
		
		echo "message";

	}else
	if ( isset($_POST["cutcard"]) ) {
		
		echo "cutcard";

	}else	
	if ( isset($_POST["connectcard"]) ) {
		
		echo "connectcard";

	}else{



	}
 

 ?>