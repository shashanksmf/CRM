<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');

class transactionTable {

	public function insert($conn, $userId)
	{
		$responseArr = array();
		if($conn->connect_error) {
			$responseArr["result"] = false;
			$responseArr["reason"] = $conn->connect_error;
			exit(json_encode($responseArr["reason"]));
		}

		mysqli_set_charset($conn,"utf8");
		$insertInTTable = "INSERT INTO transactiontable(userId) VALUES ('".$userId."')";
// print_r($insertInTable);
		if (mysqli_query($conn, $insertInTTable)) {
			// $responseArr["result"] = true;
			$responseArr["last_id"] = mysqli_insert_id($conn);
			// echo json_encode($responseArr);
			return $responseArr;
		} else {
			$responseArr["result"] = false;
			$responseArr["reason"] = mysqli_error($conn);
			return $responseArr;
		}
	}

	public function update($conn, $tId, $userId, $status, $totalrecords, $totalinserted, $totalfailed)
	{
		$responseArr = array();
		if($conn->connect_error) {
			$responseArr["result"] = false;
			$responseArr["reason"] = $conn->connect_error;
			exit(json_encode($responseArr["reason"]));
		}

		mysqli_set_charset($conn,"utf8");
		$insertInTTable = 'UPDATE transactiontable SET insertDateTime = "'.date("Y-m-d H:i:s").'", status = "'.$status.'" , totalrecords = "'.$totalrecords.'" , totalinserted = "'.$totalinserted.'" ,totalfailed = "'.$totalfailed.'" WHERE userId = "'.$userId.'" AND id = "'.$tId.'"';

		if (mysqli_query($conn, $insertInTTable)) {
			$responseArr["result"] = true;
			// echo json_encode($responseArr);
			return $responseArr;
		} else {
			// $last_id = mysqli_insert_id($conn);
			$responseArr["result"] = false;
			$responseArr["reason"] = mysqli_error($conn);
			return $responseArr;
		}
	}
}
?>
