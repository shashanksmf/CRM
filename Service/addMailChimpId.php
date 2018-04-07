<?php
header("Access-Control-Allow-Origin: *");
error_reporting(E_ALL);
ini_set('display_errors', 1);
$headers = apache_request_headers();
$headers = $headers['token'];
require_once("./token/validateToken.php");

$userId = @$_GET['userId'];
$apiKey = @$_GET['apiKey'];

require_once("./mailChimp/list/checkAPIKey.php");
require_once(".../../../Controller/mailChimpConfig.php");
require_once(".../../../Controller/mailChimpService.php");

$mailChimpSubDomainInit = MailChimpConfig::$mailChimpSubDomainInit;

$checkAPIKey = new checkAPIKey();
$result = $checkAPIKey->key($mailChimpApiKey,$mailChimpSubDomainInit);
// echo $result;

$result = json_decode($result, true);
$responseArr = array();
$responseArr = $result;

if ($responseArr['account_id'] != "") {
    $responseArr['result'] = true;
    // echo $responseArr;
} 
else {
    $responseArr['result'] = false;
    exit $responseArr['result'];
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