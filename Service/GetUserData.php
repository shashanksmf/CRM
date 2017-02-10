<?php 
	
	//http://localhost/wehnc/Service/GetUserData.php?id=1
	
	
	$dats = '';
	$dats = @$_GET['id'];
	

	require_once("../Controller/Class_User_Controller.php");
	$controller = new UserController();
	header('Content-Type: application/json');
	echo $controller->getUserJson($dats);

?>