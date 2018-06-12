<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');

class transactionDetails {

	public function insert($conn, $tId, $email, $companyId, $companyName, $insertStatus, $operationPerform, $reason, $compReason)
	{
		$reason = str_replace("'", "", $reason);
		$responseArr = array();
		if($conn->connect_error) {
			$responseArr["result"] = false;
			$responseArr["details"] = $conn->connect_error;
			exit(json_encode($responseArr["details"]));
		}

		mysqli_set_charset($conn,"utf8");
		$insertInTDetails = "INSERT INTO transactiondetails(tId, email, companyId, companyName, insertStatus, operationPerform, reason, compReason) VALUES ('".$tId."','".$email."','".$companyId."','".$companyName."','".$insertStatus."','".$operationPerform."','".$reason."','".$compReason."')";


		if (mysqli_query($conn, $insertInTDetails)) {
			$responseArr["result"] = true;
			// echo json_encode($responseArr);
			// return $responseArr;
		} else {
			// $last_id = mysqli_insert_id($conn);
			$responseArr["result"] = false;
			$responseArr["details"] = mysqli_error($conn);
         // print_r("Response in Tr",$responseArr);
			return $responseArr;

		}

	}


}
?>
