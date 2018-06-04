<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "./phpHeader/getHeader.php";

$headers = apache_request_headers();
require_once "./token/validateToken.php";

require_once "../Controller/EmailMgr.php";
$c2 = new EmailMgr();
$c2->apiKey = getenv("mailChimpApiKey");
$email = "shankie1990@gmail.com";
$name = "shashank";
$c2->addMebmberToList($email,'d0a4dda674',$name,'','');
echo json_encode($c2);
?>
