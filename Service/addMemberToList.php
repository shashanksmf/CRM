<?php

header('Access-Control-Allow-Origin: *');
$headers = apache_request_headers();
$headers = $headers['token'];
require_once("./token/validateToken.php");

require_once("../Controller/EmailMgr.php");
$c2 = new EmailMgr();
$c2->apiKey = getenv("mailChimpApiKey");
$email = "shankie1990@gmail.com";
$name = "shashank";
$c2->addMebmberToList($email,'d0a4dda674',$name,'','');
echo json_encode($c2);
?>