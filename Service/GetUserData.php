<?php 
ob_start();
	//http://localhost/wehnc/Service/GetUserData.php?id=1
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("./phpHeader/getHeader.php");

header("Access-Control-Allow-Origin: *");
$headers = apache_request_headers();
// $headers = $headers['token'];
// require_once("./token/validateToken.php");

$dats = '';
$dats = @$_GET['id'];
header("Access-Control-Allow-Origin: *");

require_once("../Controller/Class_User_Controller.php");
$controller = new UserController();
header('Content-Type: application/json');
ob_clean();
echo $controller->getUserJson($dats);

?>