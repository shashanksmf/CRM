<?php 

ob_start();

	//Link -> localhost/wehnc/Service/GetEmplData.php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Request-Headers");
$headers = apache_request_headers();
$headers = $headers['token'];
require_once("./token/validateToken.php");


$dats = '';
$dats = @$_GET['id'];


require_once("../Controller/Class_Employees_Controller.php");
$controller = new EmployeesController();
header('Content-Type: application/json');
	// ob_clean();
echo $controller->getEmployeeJson($dats);


?>