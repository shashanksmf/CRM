<?php



	//Link -> localhost/wehnc/Service/GetEmplData.php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "./phpHeader/getHeader.php";

$headers = apache_request_headers();
require_once "./token/validateToken.php";

$dats = '';
$dats = @$_GET['id'];


require_once "../Controller/Class_Template_Controller.php";
$controller = new TemplateController();
header('Content-Type: application/json');

echo (json_encode($controller->getTemplateJson($dats)));



?>
