<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("./phpHeader/getHeader.php");

header("Access-Control-Allow-Origin: *");
$headers = apache_request_headers();
// $headers = $headers['token'];
// require_once("./token/validateToken.php");
$id = @$_GET['id'];
$userId = @$_GET['userId'];
$apiKey = @$_GET['apiKey'];
$listId = @$_GET['listId'];
$listName = @$_GET['listName'];

require_once("./mailChimp/list/checkListId.php");
require_once(".../../../Controller/mailChimpConfig.php");
require_once(".../../../Controller/mailChimpService.php");

$mailChimpSubDomainInit = MailChimpConfig::$mailChimpSubDomainInit;

$checkListId = new checkListId();
$result = $checkListId->checkList($apiKey,$mailChimpSubDomainInit,$listId);
// echo "checkListId",$result;

$result = json_decode($result, true);
$resultArr = array();
$resultArr = $result;

if ($resultArr['id'] != "") {
    $resultArr['result'] = true;
    // echo $resultArr;
} 
else {
    $resultArr['result'] = false;
    $resultArr['errorType'] = "listId";
    exit $resultArr;
}

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
$sql = "UPDATE mailchimpdetails SET userId='".$userId."',apiKey='".$apiKey."',listId='".$listId."',listName='".$listName."' WHERE id=".$id;

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