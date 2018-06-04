<?php

ob_start();
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "./phpHeader/getHeader.php";

$headers = apache_request_headers();
require_once "./token/validateToken.php";

$fIds = '';
$fIds = @$_GET['from'];
$tIds = '';
$tIds = @$_GET['to'];
$id = '';
$id = @$_GET['id'];


require_once "../Controller/Class_Chat_Controller.php";
$controller = new MessageController();
header('Content-Type: application/json');
ob_clean();
echo $controller->getMsgJson($id, $fIds,$tIds);

?>
