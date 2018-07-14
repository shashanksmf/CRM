<?php
ob_start();
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "./phpHeader/getHeader.php";

$headers = apache_request_headers();
require_once "./token/validateToken.php";

// $id = @$_GET['id'];
// $userId = @$_GET['userId'];
// $apiKey = @$_GET['apiKey'];
$listId = @$_GET['listId'];
// exit($listId);
// $listName = @$_GET['listName'];


require_once "../Controller/StaticDBCon.php";
$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
// Create connection

$responseArr = array();
if (!$conn) {
//echo "not conn";
	$responseArr["result"] = false;
	$responseArr["reason"] =  mysqli_connect_error();
	die($responseArr);
}

mysqli_set_charset($conn,"utf8");
$sql = "UPDATE mailchimp_createlist_details SET isactive = 0 WHERE listid='".$listId."';";
if (mysqli_query($conn, $sql)) {
//echo "if";
	$responseArr["result"] = true;
	$last_id = mysqli_insert_id($conn);
	$responseArr["lastId"] = $last_id;

	echo json_encode($responseArr);
} else {
//echo "else".mysqli_error($conn);
	$responseArr["result"] = false;
	$responseArr["reason"] = mysqli_error($conn);
	echo json_encode($responseArr);
   // echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
