<?php 
	
	
	
	//Link -> localhost/wehnc/Service/GetEmplData.php
	
	
	
	$dats = '';
	$dats = @$_GET['id'];
	

	require_once("../Controller/Class_Employee_Controller.php");
	$controller = new EmployeeController();
	header('Content-Type: application/json');
	echo $controller->getEmployeeJson($dats);

	

?>