<?php 
	
	
	
	//Link -> localhost/wehnc/Service/GetEmplData.php
	
	
	
	$email = @$_GET['userName'];
	$password= @$_GET['password'];
	

	require_once("../Controller/Class_User_Login_Controller.php");
	$controller = new UserLoginController();
	header('Content-Type: application/json');
	echo $controller->getUserJson($email,$password);

	

?>