<?php 



	//Link -> localhost/wehnc/Service/GetEmplData.php
header("Access-Control-Allow-Origin: *");
ob_start();
$headers = apache_request_headers();
$headers = $headers['token'];
require_once("./token/validateToken.php");

$dats = '';
$dats = @$_GET['id'];


require_once("../Controller/Class_Template_Controller.php");
$controller = new TemplateController();
header('Content-Type: application/json');

ob_clean();
echo (json_encode($controller->getTemplateJson($dats)));



?>