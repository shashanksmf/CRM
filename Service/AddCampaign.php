<?php 
	
	 ob_start();
	
	//Link -> localhost/wehnc/Service/GetEmplData.php
	
	header("Access-Control-Allow-Origin: *");
	
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
	
//echo "name: ".$_POST['name']."-"."Emails: ". $_POST['emails']."-"."body:". $_POST['body']."-"."date: ". $_POST['dates']."-"."templateID: ". $_POST['templateId']."-". "groupId".$_POST['groupId'];
//exit("adasd");
	require_once("../Controller/Class_Campaign_Controller.php");
	$controller = new CampaignController();
	header('Content-Type: application/json');
	ob_clean();
	echo $controller->addNewCampaignJson($name, $createdBy, $emails, $subject, $body, "", $dates, $templateId,$groupId)
	

?>