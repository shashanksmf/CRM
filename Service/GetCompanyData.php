<?php 


ob_start();
	//Link -> http://localhost/wehnc/Service/GetCompanyData.php?id=1

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("./phpHeader/getHeader.php");

header("Access-Control-Allow-Origin: *");
$headers = apache_request_headers();
// $headers = $headers['token'];
// require_once("./token/validateToken.php");

$dats = '';
$dats = @$_GET['id'];

$headers = apache_request_headers();
// $headers = $headers['token'];
// require_once("./token/validateToken.php");

require_once("../Controller/Class_Company_Controller.php");
$controller = new CompanyController();
header('Content-Type: application/json');
ob_clean();
echo $controller->getCompanyJson($dats);

?>