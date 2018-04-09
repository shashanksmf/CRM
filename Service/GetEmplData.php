<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("./phpHeader/getHeader.php");

$headers = apache_request_headers();
require_once("./token/validateToken.php");
// print_r($headers);
// $headers = $headers['token'];
// echo $headers['TOKEN'];
//Link -> localhost/wehnc/Service/GetEmplData.php


$dats = '';
$dats = @$_GET['id'];


require_once("../Controller/Class_Employees_Controller.php");
$controller = new EmployeesController();
header('Content-Type: application/json');
	// ob_clean();
echo $controller->getEmployeeJson($dats);


?>
