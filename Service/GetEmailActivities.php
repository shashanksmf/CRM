<?php 


ob_start();
	//Link -> localhost/wehnc/Service/GetEmplData.php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("./phpHeader/getHeader.php");

$headers = apache_request_headers();
require_once("./token/validateToken.php");

	//$id = @$_POST['id'];

$campaignId = $_GET['id'];

require_once("../Controller/EmailMgr.php");
$controller = new EmailMgr();
$controller->apiKey = getenv("mailChimpApiKey");
header('Content-Type: application/json');

ob_clean(); 
echo $controller->getActivityList($campaignId);


?>