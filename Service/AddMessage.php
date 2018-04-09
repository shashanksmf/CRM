<?php 
ob_start();


	//Link -> localhost/wehnc/Service/GetEmplData.php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("./phpHeader/getHeader.php");

$headers = apache_request_headers();
require_once("./token/validateToken.php");

$from = @$_GET['from'];
$msg = @$_GET['msg'];
$to = @$_GET['to'];


require_once("../Controller/Class_Chat_Controller.php");
$controller = new MessageController();
header('Content-Type: application/json');

ob_clean();
echo $controller->addMessageJson($msg, $from,$to);



?>