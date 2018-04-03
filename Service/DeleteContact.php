<?php
	
	header("Access-Control-Allow-Origin: *");
	require_once("../Controller/StaticDBCon.php");
	require_once("./mailChimp/unSubEmpl/unSubEmplCall.php");

	$emplId = @$_GET['id'];
	$emplName = @$_GET['name'];
	$emplEmail = @$_GET['email'];
	$responseArr = array();

	$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
	
	if($conn->connect_error) {
		$responseArr["result"] = false;
		$responseArr["details"] = $conn->connect_error;
		exit(json_encode($responseArr));
	}


	if(isset($emplId) && !empty($emplId)) {

		if(isset($emplEmail) && !empty($emplEmail)){
			echo "inside";
			$unSubEmplCall = new unSubEmplCall();
        	$result = $unSubEmplCall->unSubUser($emplEmail,$emplName);
        	echo $result;
        }

		
		$deleteSql = "UPDATE `employee` set isactive = 0 WHERE id=".$emplId.";";
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
