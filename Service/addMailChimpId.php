<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');


require_once "./phpHeader/getHeader.php";

$headers = apache_request_headers();
require_once "./token/validateToken.php";

$userId = $tokenUserId;
$apiKey = @$_GET['apiKey'];

require_once "./mailChimp/list/checkAPIKey.php";
require_once ".../../../Controller/mailChimpConfig.php";
require_once ".../../../Controller/mailChimpService.php";

$mailChimpSubDomainInit = 'us19.';

$checkAPIKey = new checkAPIKey();
$result = $checkAPIKey->key($apiKey,$mailChimpSubDomainInit);
// echo "echoResult".$result;

$result = json_decode($result, true);
$resultArr = array();
$resultArr = $result;
// print_r($resultArr);

if (array_key_exists('account_id', $resultArr)) {
    // $resultArr['result'] = true;
    // echo json_encode($resultArr,true);
}
else {
    $resultArr['result'] = false;
    $resultArr['errorType'] = "apiKey";
    exit(json_encode($resultArr,true));
}

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
$sql = "INSERT INTO .mailchimpdetails (userId,apiKey,listId,listName,isvalid)
VALUES ('".$userId."','".$apiKey."','','',0)";

if (mysqli_query($conn, $sql)) {

} else {
//echo "else".mysqli_error($conn);
    $responseArr["result"] = false;
    $responseArr["reason"] = mysqli_error($conn);
    echo json_encode($responseArr);
   // echo "Error updating record: " . mysqli_error($conn);
}

$account_id = $resultArr['account_id'];
$login_id = $resultArr['login_id'];
$account_name = $resultArr['account_name'];
$email = $resultArr['email'];
$first_name = $resultArr['first_name'];
$last_name = $resultArr['last_name'];
$username = $resultArr['username'];
$avatar_url = $resultArr['avatar_url'];
$role = $resultArr['role'];
$member_since = $resultArr['member_since'];
$pricing_plan_type = $resultArr['pricing_plan_type'];
$first_payment = $resultArr['first_payment'];
$account_timezone = $resultArr['account_timezone'];
$account_industry = $resultArr['account_industry'];
$last_login = $resultArr['last_login'];
$total_subscribers = $resultArr['total_subscribers'];
$industry_stats = json_encode($resultArr['industry_stats']);
// echo $industry_stats;

mysqli_set_charset($conn,"utf8");
$sql = "INSERT INTO .mailchimpapikeydetails (userId,apiKey,account_id,login_id,account_name,email,first_name,last_name,username,avatar_url,role,member_since,pricing_plan_type,first_payment,account_timezone,account_industry,last_login,total_subscribers,industry_stats)
VALUES ('".$userId."','".$apiKey."','".$account_id."','".$login_id."','".$account_name."','".$email."','".$first_name."','".$last_name."','".$username."','".$avatar_url."','".$role."','".$member_since."','".$pricing_plan_type."','".$first_payment."','".$account_timezone."','".$account_industry."','".$last_login."','".$total_subscribers."','".$industry_stats."')";

if (mysqli_query($conn, $sql)) {

} else {
//echo "else".mysqli_error($conn);
    $responseArr["result"] = false;
    $responseArr["reason"] = mysqli_error($conn);
    echo json_encode($responseArr);
   // echo "Error updating record: " . mysqli_error($conn);
}

$contactArr = array();
$contactArr = $resultArr['contact'];

$company = $contactArr['company'];
$addr1 = $contactArr['addr1'];
$addr2 = $contactArr['addr2'];
$city = $contactArr['city'];
$state = $contactArr['state'];
$zip = $contactArr['zip'];
$country = $contactArr['country'];


mysqli_set_charset($conn,"utf8");
$sql = "INSERT INTO .mailchimp_apikey_contact_details(userId, apiKey, account_id, company, addr1, addr2, city, state, zip, country) VALUES ('".$userId."','".$apiKey."','".$account_id."','".$company."','".$addr1."','".$addr2."','".$city."','".$state."','".$zip."','".$country."')";

if (mysqli_query($conn, $sql)) {
    $responseArr["result"] = true;
    // $last_id = mysqli_insert_id($conn);
    // $responseArr["lastId"] = $last_id;
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
