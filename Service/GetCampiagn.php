<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("./phpHeader/getHeader.php");

header("Access-Control-Allow-Origin: *");
$headers = apache_request_headers();
// $headers = $headers['token'];
// require_once("./token/validateToken.php");


$dats = '';
$dats = @$_GET['id'];


require_once("../Controller/Class_Campaign_Controller.php");
$controller = new CampaignController();
$controller->apiKey = getenv("mailChimpApiKey");
header('Content-Type: application/json');
echo $controller->getCampaignJson($dats);



?>