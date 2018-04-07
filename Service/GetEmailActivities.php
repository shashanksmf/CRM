<?php 
	
	
	 ob_start();
	//Link -> localhost/wehnc/Service/GetEmplData.php
	
	header("Access-Control-Allow-Origin: *");
	$headers = apache_request_headers();
	$headers = $headers['token'];
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