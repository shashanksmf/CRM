<?php
ob_start();
$headers = apache_request_headers();
$headers = $headers['token'];
require_once("./token/validateToken.php");

$userId = @$_GET['userId'];
$apiKey = @$_GET['apiKey'];
$listId = @$_GET['listId'];
$listName = @$_GET['listName'];

require_once("../Controller/StaticDBCon.php");
$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
// Create connection

$responseArr = array();
if (!$conn) {
//echo "not conn";
	$responseArr["result"] = false;
	$responseArr["details"] =  mysqli_connect_error();
	die($responseArr);
}
mysqli_set_charset($conn,"utf8");
$sql = "INSERT INTO .mailchimpdetails (userId,apiKey,listId,listName)
VALUES ('".$userId."','".$apiKey."','".$listId."','".$listName."')";

if (mysqli_query($conn, $sql)) {
//echo "if";
	$responseArr["result"] = true;
	$last_id = mysqli_insert_id($conn);
	$responseArr["lastId"] = $last_id;

	echo json_encode($responseArr);
} else {
//echo "else".mysqli_error($conn);
	$responseArr["result"] = false;
	$responseArr["details"] = mysqli_error($conn);
	echo json_encode($responseArr);
   // echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>