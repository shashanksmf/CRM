<?php
	header("Access-Control-Allow-Origin: *");
  header('Access-Control-Allow-Headers: Origin, token, Host');
	ob_start();
	$email = @$_GET['userName'];
	$password= @$_GET['password'];
	require_once("../Controller/Class_User_Login_Controller.php");
	$controller = new UserLoginController();
	header('Content-Type: application/json');
	ob_clean();
	echo $controller->getUserJson($email,$password);

?>
