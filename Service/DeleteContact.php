<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "./phpHeader/getHeader.php";

$headers = apache_request_headers();
require_once "./token/validateToken.php";

require_once "../Controller/StaticDBCon.php";
require_once "./mailChimp/unSubEmpl/unSubUser.php";

$emplId = @$_GET['id'];
$emplName = @$_GET['name'];
$emplEmail = @$_GET['email'];
$responseArr = array();

$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);

if($conn->connect_error) {
	$responseArr["result"] = false;
	$responseArr["reason"] = $conn->connect_error;
	exit(json_encode($responseArr));
}


$mailChimpApiKey="29d5edbfcd350d88255fbd6c3b961a8e-us14";
if(isset($emplId) && !empty($emplId)) {

// 	$unSubSql = "UPDATE `employee` set isSubscribed = 0 WHERE id=4";
// 	if(isset($emplEmail) && !empty($emplEmail)){
// 		$unSubUser = new unSubUser();
// 		$unSubResult = $unSubUser->unSubUserFun($emplEmail,$emplName,$mailChimpApiKey);
// 		// exit($unSubResult);
// // print_r($mailChimpApiKey);
// 		if ($unSubResult['status'] == true) {
// 			mysqli_query($conn, $unSubSql);
// 		} else{
// 			$responseArr["result"] = false;
// 			$responseArr["reason"] = $unSubResult['reason'];
// 			exit(json_encode($responseArr));
// 		}
// 	}


	$deleteSql = "UPDATE `employee` set isactive = 0 WHERE id=".$emplId.";";
	if(mysqli_query($conn, $deleteSql)){
		$responseArr["result"] = true;
		echo json_encode($responseArr);
	}
	else{
		$responseArr["result"] = false;
		$responseArr["reason"] =  mysqli_error($conn);
		echo json_encode($responseArr);
	}
}

else{
	$responseArr["result"] = false;
	$responseArr["reason"] = "Employee Id not found";
	echo json_encode($responseArr);
}

?>
