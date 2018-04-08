<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("./phpHeader/getHeader.php");

ob_start();
	//Link -> localhost/wehnc/Service/GetEmplData.php
header("Access-Control-Allow-Origin: *");
$headers = apache_request_headers();
print_r($headers);
$headers = $headers['TOKEN'];
require_once("./token/validateToken.php");


$dats = '';
$dats = @$_GET['id'];


require_once("../Controller/Class_Employees_Controller.php");
$controller = new EmployeesController();
header('Content-Type: application/json');
	// ob_clean();
echo $controller->getEmployeeJson($dats);


?>
