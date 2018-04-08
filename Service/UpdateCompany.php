<?php 
	
	
	
	//Link -> localhost/wehnc/Service/GetEmplData.php
	ob_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	require_once("./phpHeader/getHeader.php");

	header("Access-Control-Allow-Origin: *");
	$headers = apache_request_headers();
	$headers = $headers['token'];
	require_once("./token/validateToken.php");
	
	$id = @$_GET['id'];
	$name = @$_GET['name'];
	$areaOfWork = @$_GET['areaOfWork'];
	$establised = @$_GET['establised'];
	$employees = @$_GET['employees'];
	$revenue = @$_GET['revenue'];
	$ofcAddress = @$_GET['ofcAddress'];
	$email = @$_GET['email'];
	$phone = @$_GET['phone'];
	$fb = @$_GET['fb'];
	$tw = @$_GET['twitter'];
	$ln = @$_GET['ln'];
	$extra = @$_GET['extra'];
	
	
	

	require_once("../Controller/Class_Company_Controller.php");
	$controller = new CompanyController();
	header('Content-Type: application/json');
	ob_clean();
	echo $controller->updateCompanyJson($id, $name, $areaOfWork, $establised, $employees, $revenue, $ofcAddress, $email, $phone,$fb,$tw,$ln,$extra);

?>