<?php 

ob_start();

	//Link -> localhost/wehnc/Service/GetEmplData.php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("./phpHeader/getHeader.php");

header("Access-Control-Allow-Origin: *");
$headers = apache_request_headers();
$headers = $headers['token'];
require_once("./token/validateToken.php");


$dats = '';
$dats = @$_GET['term'];

require_once("../Controller/Class_Employees_Controller.php");
$controller = new EmployeesController();
header('Content-Type: application/json');
ob_clean();
echo $controller->getEmployeeSmartSearchJson($dats);



?>