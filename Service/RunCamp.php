<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("./phpHeader/getHeader.php");

header("Access-Control-Allow-Origin: *");
$headers = apache_request_headers();
$headers = $headers['token'];
require_once("./token/validateToken.php");

require('../libs/mandril/Mandrill.php');
require('../Controller/Class_Group_Controller.php');
require('../Controller/Class_Campaign_Controller.php');
require ('../Controller/Class_Template_Controller.php');
require ('../Controller/EmailMgr.php');



$runCampaigns = "";

$campId = $_GET['campId'];

$emlMgr = new EmailMgr();

$emlMgr->apiKey = getenv("mailChimpApiKey");





$emlMgr->runCampaign($campId);


       // print_r($resAr);
$jsonStr = '{"responce":true;"campaignId":"'
. $campId
. '"}';
header('Content-Type: application/json');
echo $jsonStr;

?>
