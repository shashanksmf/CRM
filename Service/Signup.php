<?php 
	
	
	
	//Link -> localhost/wehnc/Service/GetEmplData.php
	
	
	
	$name = @$_GET['name'];
	$department= @$_GET['departmen'];
	$hireDate= @$_GET['hireDate'];
	$dob= @$_GET['dob'];
	$gender= @$_GET['gender'];
	$homeAddress= @$_GET['homeAddres'];
	$email= @$_GET['email'];
	$phone= @$_GET['phone'];
	$profilePic= @$_GET['profilePic'];
	$password= @$_GET['password'];
	

	require_once("../Controller/Class_User_Login_Controller.php");
	$controller = new UserLoginController();
	header('Content-Type: application/json');
	echo $controller->addUserJson($name, $department, $hireDate, $dob, $gender, $homeAddress, $email, $phone, $profilePic, $password);

	

?>