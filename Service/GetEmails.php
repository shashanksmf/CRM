<?php 

ob_start();

	//Link -> localhost/wehnc/Service/GetEmplData.php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("./phpHeader/getHeader.php");

header("Access-Control-Allow-Origin: *");
$headers = apache_request_headers();
// $headers = $headers['token'];
// require_once("./token/validateToken.php");


$dats = '';
$dats = @$_GET['id'];


require_once("../Controller/Class_Email_Controller.php");
$controller = new EmailController();
header('Content-Type: application/json');
ob_clean();
echo $controller->getEmailJson($dats);



?>