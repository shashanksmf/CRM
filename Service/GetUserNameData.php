<?php

	//http://localhost/wehnc/Service/GetUserData.php?id=1

ob_start();
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "./phpHeader/getHeader.php";

$headers = apache_request_headers();
require_once "./token/validateToken.php";

$dats = '';
$dats = @$_GET['id'];


require_once "../Controller/Class_User_Controller.php";
$controller = new UserController();
header('Content-Type: application/json');
ob_clean();
echo $controller->getUserNameJson($dats);

?>
