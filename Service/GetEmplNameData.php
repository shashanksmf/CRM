<?php 
	
	
	
	//Link -> localhost/wehnc/Service/GetEmplData.php
	
	ob_start();
	$headers = apache_request_headers();
	$headers = $headers['token'];
	require_once("./token/validateToken.php");
	
	$dats = '';
	$dats = @$_GET['id'];

	$headers = apache_request_headers();
	$headers = $headers['token'];
	require_once("./token/validateToken.php");
	

	require_once("../Controller/Class_Employees_Controller.php");
	$controller = new EmployeesController();
	header('Content-Type: application/json');
	ob_clean();
	echo $controller->getEmployeeNameJson($dats);

	

?>