<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "./phpHeader/getHeader.php";

$headers = apache_request_headers();
require_once "./token/validateToken.php";

require_once "./../Controller/StaticDBCon.php";

$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
if($conn->connect_error) {
	$responseArr["result"] = false;
	$responseArr["reason"] = $conn->connect_error;
	exit(json_encode($responseArr));
}

$smsdata = file_get_contents('php://input');
$responseArr = array();
$smsArr = json_decode($smsdata,true);
$groupid = isset($smsArr["groupid"]) ? $smsArr["groupid"] : "";
$name = isset($smsArr["name"]) ? $smsArr["name"] : "";
	//echo ($groupid);

if(sizeof($smsArr > 0)  && array_key_exists("data", $smsArr))	 {

	$sql = "INSERT INTO `smscampaign` (name, groupid, infobipresponse) VALUES ('".$name."', '".$groupid."' , '".$smsdata."')";

	if (mysqli_query($conn, $sql)) {
		$responseArr["result"] = true;
	} else {
		$responseArr["result"] = false;
		$responseArr["reason"] = mysqli_error($conn);
	}

	echo json_encode($responseArr);

}
else {
	$responseArr["result"] = false;
	$responseArr["reason"] = "Empty data";
	echo json_encode($responseArr);
}

?>
