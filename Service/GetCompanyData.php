<?php 
	
	
	
	//Link -> http://localhost/wehnc/Service/GetCompanyData.php?id=1
	
	
	
	$dats = 'na';
	$dats = @$_GET['id'];
	
	require_once("../Controller/Class_Company_Controller.php");
	$controller = new CompanyController();
	header('Content-Type: application/json');
	echo $controller->getCompanyJson($dats);

?>