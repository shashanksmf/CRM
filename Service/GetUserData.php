<?php 
ob_start();
	//http://localhost/wehnc/Service/GetUserData.php?id=1
header("Access-Control-Allow-Origin: *");
$headers = apache_request_headers();
$headers = $headers['token'];
require_once("./token/validateToken.php");

$dats = '';
$dats = @$_GET['id'];
header("Access-Control-Allow-Origin: *");

require_once("../Controller/Class_User_Controller.php");
$controller = new UserController();
header('Content-Type: application/json');
ob_clean();
echo $controller->getUserJson($dats);

?>