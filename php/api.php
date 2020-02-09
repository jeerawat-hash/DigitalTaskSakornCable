<?php 

		
		///// Controller
    $pull = file_get_contents("php://input");
    ///// Controller

    ///// Model
	$data = json_decode($pull,true);

	print_r($data);


 ?>