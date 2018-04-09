<?php
ob_start();
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("./phpHeader/getHeader.php");

$headers = apache_request_headers();
require_once("./token/validateToken.php");

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
$sql = "INSERT INTO .mailchimpdetails (userId,apiKey,listId,listName)
VALUES ('".$userId."','".$apiKey."','".$listId."','".$listName."')";

if (mysqli_query($conn, $sql)) {

} else {
//echo "else".mysqli_error($conn);
    $responseArr["result"] = false;
    $responseArr["details"] = mysqli_error($conn);
    echo json_encode($responseArr);
   // echo "Error updating record: " . mysqli_error($conn);
}

mysqli_set_charset($conn,"utf8");
$sql = "INSERT INTO .mailchimp_list_id_details(id, userId, apiKey, listId, web_id, name, date_created, subscribe_url_long) VALUES ('".$userId."','".$apiKey."','".$resultArr['id']."','".$resultArr['web_id']."','".$resultArr['name']."','".$resultArr['date_created']."','".$resultArr['subscribe_url_long']."')";

if (mysqli_query($conn, $sql)) {
    $responseArr["result"] = true;
    echo json_encode($responseArr);
} else {
    $responseArr["result"] = false;
    $responseArr["details"] = mysqli_error($conn);
    echo json_encode($responseArr);
}

mysqli_close($conn);

?>