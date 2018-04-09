<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("./phpHeader/getHeader.php");

$headers = apache_request_headers();
require_once("./token/validateToken.php");

require_once("../Controller/tests/mailchimptest/mailChimpUserTest.php");
require_once("mailChimpConfig.php");
require_once("mailChimpService.php");


$emplName = @$_POST['emplName'];
$emplEmail = @$_POST['emplEmail'];

echo ("$emplName" .$emplName);
echo ("$empl" .$emplEmail);

$mailChimpService = new MailChimpService();
$mailChimpSubDomainInit = MailChimpConfig::$mailChimpSubDomainInit;
$mailChimpApiKey = $mailChimpService->mailChimpApiKey = getenv("mailChimpApiKey");
$list_id = $mailChimpService->list_id = getenv('mailChimpListId');

$unSubUser = new MailChimpUserTest();
$result = $unSubUser->unSubscribeUser($emplEmail,$emplName,$mailChimpApiKey,$mailChimpSubDomainInit,$list_id);
echo $result;

	// $mailChimpUserTest = new MailChimpUserTest();
 //    $mailChimpSubDomainInit = MailChimpConfig::$mailChimpSubDomainInit;
 //    $mailChimpApiKey = $mailChimpUserTest->mailChimpApiKey = getenv("mailChimpApiKey");
 //    $list_id = $mailChimpUserTest->list_id = getenv('mailChimpListId');


 //    $unSubUserRes = $mailChimpUserTest->unSubscribeUser($emplEmail,$emplName,$mailChimpApiKey,$mailChimpSubDomainInit,$list_id);

 //    $unSubUserRes = $unSubUserRes === NULL ? "" : $unSubUserRes;

 //    print_r($unSubUserRes);

 //    echo ("result :" .json_encode($unSubUserRes));



?>