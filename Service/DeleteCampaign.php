<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "./phpHeader/getHeader.php";

$headers = apache_request_headers();
require_once "./token/validateToken.php";

require_once "../Controller/StaticDBCon.php";

$campaignId = @$_GET['id'];
$responseArr = array();

$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);

if($conn->connect_error) {
	$responseArr["result"] = false;
	$responseArr["reason"] = $conn->connect_error;
	exit(json_encode($responseArr));
}


if(isset($campaignId) && !empty($campaignId)){

	$deleteSql = "UPDATE `campaign` set isactive = 0 WHERE id=".$campaignId.";";
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
	$responseArr["reason"] = "Campaign Id not found";
	echo json_encode($responseArr);
}

?>
