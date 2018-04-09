<?php 

ob_start();	
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("./phpHeader/getHeader.php");

header("Access-Control-Allow-Origin: *");
$headers = apache_request_headers();
// $headers = $headers['token'];
// require_once("./token/validateToken.php");

	//$id = @$_POST['id'];
$name = $_POST['name'];
$createdBy = $_POST['createdBy'];
$emails = $_POST['emails'];
$subject = $_POST['subject'];
$body = $_POST['body'];
	//$recievedBy = $_POST['recievedBy'];
$dates = $_POST['dates'];
$templateId = $_POST['templateId'];
$groupId = $_POST['groupId'];
$segId = $_POST['segId'];

require_once("../Controller/Class_Campaign_Controller.php");
$controller = new CampaignController();
header('Content-Type: application/json');
ob_clean();
echo $controller->addNewCampaignJson($name, $createdBy, $emails, $subject, $body, "", $dates, $templateId,$groupId,$segId);


?>