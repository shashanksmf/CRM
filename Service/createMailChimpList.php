<?php
header("Access-Control-Allow-Origin: *");
error_reporting(E_ALL);
ini_set('display_errors', 1);
// $headers = apache_request_headers();
// $headers = $headers['token'];
// require_once("./token/validateToken.php");

// $userId = @$_GET['userId'];
// $apiKey = @$_GET['apiKey'];
// $listId = @$_GET['listId'];
// $listName = @$_GET['listName'];

// require_once("./mailChimp/list/createList.php");
// require_once(".../../../Controller/mailChimpConfig.php");
require_once(".../../../Controller/mailChimpService.php");

$mailChimpService = new MailChimpService();
// $mailChimpSubDomainInit = MailChimpConfig::$mailChimpSubDomainInit;
$mailChimpApiKey = $mailChimpService->mailChimpApiKey = getenv("mailChimpApiKey");
echo "key".$mailChimpApiKey;
// $list_id = $mailChimpService->list_id = getenv('mailChimpListId');

// $createList = new createList();
// $result = $createList->list($mailChimpApiKey,$mailChimpSubDomainInit);
// // echo $result;

// $result = json_decode($result, true);
// $responseArr = array();
// $responseArr = $result;
// // echo $result['status'];
// // echo $responseArr['status'];
// // echo $responseArr['unsubscribe_reason'];

// if ($responseArr['status'] == "unsubscribed") {
//     $responseArr['result'] = true;
//     // return $responseArr;
// } 
// else {
//     $responseArr['result'] = false;
//     $responseArr['reason'] = $result['unsubscribe_reason'];
//     // return $responseArr;
// }

// require_once("../Controller/StaticDBCon.php");
// $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
// // Create connection

// $responseArr = array();
// if (!$conn) {
// //echo "not conn";
//     $responseArr["result"] = false;
//     $responseArr["details"] =  mysqli_connect_error();
//     die($responseArr);
// }
// mysqli_set_charset($conn,"utf8");
// $sql = "INSERT INTO .mailchimpdetails (userId,apiKey,listId,listName)
// VALUES ('".$userId."','".$apiKey."','".$listId."','".$listName."')";

// if (mysqli_query($conn, $sql)) {
// //echo "if";
//     $responseArr["result"] = true;
//     $last_id = mysqli_insert_id($conn);
//     $responseArr["lastId"] = $last_id;

//     echo json_encode($responseArr);
// } else {
// //echo "else".mysqli_error($conn);
//     $responseArr["result"] = false;
//     $responseArr["details"] = mysqli_error($conn);
//     echo json_encode($responseArr);
//    // echo "Error updating record: " . mysqli_error($conn);
// }

// mysqli_close($conn);

?>