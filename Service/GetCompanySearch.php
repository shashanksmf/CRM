<?php 

ob_start();

	//Link -> http://localhost/wehnc/Service/GetCompanyData.php?id=1
header("Access-Control-Allow-Origin: *");
$headers = apache_request_headers();
$headers = $headers['token'];
require_once("./token/validateToken.php");


$dats = 'na';
$dats = @$_GET['name'];

require_once("../Controller/Class_Company_Controller.php");
$controller = new CompanyController();
header('Content-Type: application/json');
ob_clean(); 
echo $controller->getCompanyJson($dats);

?>