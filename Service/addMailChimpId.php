<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');


require_once("./phpHeader/getHeader.php");

$headers = apache_request_headers();
require_once("./token/validateToken.php");


$userId = @$_GET['userId'];
$apiKey = @$_GET['apiKey'];

require_once("./mailChimp/list/checkAPIKey.php");
require_once(".../../../Controller/mailChimpConfig.php");
require_once(".../../../Controller/mailChimpService.php");

$mailChimpSubDomainInit = MailChimpConfig::$mailChimpSubDomainInit;

$checkAPIKey = new checkAPIKey();
$result = $checkAPIKey->key($apiKey,$mailChimpSubDomainInit);
echo "echoResult".$result;

$result = json_decode($result, true);
echo "res".$result;
$resultArr = array();
$resultArr = $result;
echo $resultArr;

if ($resultArr['account_id']) {
    // $resultArr['result'] = true;
    // exit $resultArr;
} 
else {
    $resultArr['result'] = false;
    $resultArr['errorType'] = "apiKey";
    exit $resultArr;
}

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
// $sql = "INSERT INTO .mailchimpdetails (userId,apiKey,listId,listName,isvalid)
// VALUES ('".$userId."','".$apiKey."','','',0)";

// if (mysqli_query($conn, $sql)) {

// } else {
// //echo "else".mysqli_error($conn);
//     $responseArr["result"] = false;
//     $responseArr["details"] = mysqli_error($conn);
//     echo json_encode($responseArr);
//    // echo "Error updating record: " . mysqli_error($conn);
// }

// mysqli_set_charset($conn,"utf8");
// $sql = "INSERT INTO .mailchimpapikeydetails (userId,apiKey,account_id,login_id,account_name,email,first_name,last_name,username,avatar_url,role,member_since,pricing_plan_type,first_payment,account_timezone,account_industry,last_login,total_subscribers,industry_stats)
// VALUES ('".$userId."','".$apiKey."','".$resultArr['account_id']."','".$resultArr['login_id']."','".$resultArr['account_name']."','".$resultArr['email']."','".$resultArr['first_name']."','".$resultArr['last_name']."','".$resultArr['username']."','".$resultArr['avatar_url']."','".$resultArr['role']."','".$resultArr['member_since']."','".$resultArr['pricing_plan_type']."','".$resultArr['first_payment']."','".$resultArr['account_timezone']."','".$resultArr['account_industry']."','".$resultArr['last_login']."','".$resultArr['total_subscribers']."','".$resultArr['industry_stats']."')";

// if (mysqli_query($conn, $sql)) {

// } else {
// //echo "else".mysqli_error($conn);
//     $responseArr["result"] = false;
//     $responseArr["details"] = mysqli_error($conn);
//     echo json_encode($responseArr);
//    // echo "Error updating record: " . mysqli_error($conn);
// }

// $contactArr = array();
// $contactArr = $resultArr['contact'];
// mysqli_set_charset($conn,"utf8");
// $sql = "INSERT INTO .mailchimp_apikey_contact_details(id, userId, apiKey, account_id, company, addr1, addr2, city, state, zip, country) VALUES ('".$userId."','".$apiKey."','".$resultArr['account_id']."','".$contactArr['company']."','".$contactArr['addr1']."','".$contactArr['addr2']."','".$contactArr['city']."','".$contactArr['state']."','".$contactArr['zip']."','".$contactArr['country']."')";

// if (mysqli_query($conn, $sql)) {
//     $responseArr["result"] = true;
//     // $last_id = mysqli_insert_id($conn);
//     // $responseArr["lastId"] = $last_id;
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