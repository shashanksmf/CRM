<?php
	
	header("Access-Control-Allow-Origin: *");
	require_once("../Controller/StaticDBCon.php");

	$empId = @$_GET['id'];
	$responseArr = array();

	$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
	
	if($conn->connect_error) {
		$responseArr["result"] = false;
		$responseArr["details"] = $conn->connect_error;
		exit(json_encode($responseArr));
	}


	if(isset($empId) && !empty($empId)){

		$deleteSql = "UPDATE `employee` set isactive = 0 WHERE id=".$empId.";";
		if(mysqli_query($conn, $deleteSql)){
			$responseArr["result"] = true;
			echo json_encode($responseArr);
		}
		else{
			$responseArr["result"] = false;
			$responseArr["details"] =  mysqli_error($conn);
			echo json_encode($responseArr);
		}
	}

	else{
		$responseArr["result"] = false;
		$responseArr["details"] = "Employee Id not found";
		echo json_encode($responseArr);
	}

?>
