<?php
	
	header("Access-Control-Allow-Origin: *");
	require_once("../Controller/StaticDBCon.php");

	$companyId = @$_GET['id'];
	$responseArr = array();

	$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
	
	if($conn->connect_error) {
		$responseArr["result"] = false;
		$responseArr["details"] = $conn->connect_error;
		exit(json_encode($responseArr));
	}


	if(isset($companyId) && !empty($companyId)){

		$deleteSql = "UPDATE `company` set isactive = 0 WHERE id=".$companyId.";";
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
		$responseArr["details"] = "Company Id not found";
		echo json_encode($responseArr);
	}

?>
