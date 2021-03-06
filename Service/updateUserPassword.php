<?php
ob_start();
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "./phpHeader/getHeader.php";

$headers = apache_request_headers();
require_once "./token/validateToken.php";

$userId = @$_GET['id'];
$password =  @$_GET['password'];

require_once "../Controller/StaticDBCon.php";
$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
// Create connection

$responseArr = array();
if (!$conn) {
	$responseArr["result"] = false;
	$responseArr["reason"] =  mysqli_connect_error();
	die($responseArr["reason"]);
}

$sql = "UPDATE user SET password= ".$password." WHERE id=".$userId ;
ob_clean();
if (mysqli_query($conn, $sql)) {
	$responseArr["result"] = true;
	echo json_encode($responseArr);
} else {
	$responseArr["result"] = false;
	$responseArr["reason"] = mysqli_error($conn);
	echo json_encode($responseArr);
  //  echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
