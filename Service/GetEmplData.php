<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
ob_start();
if( !function_exists('apache_request_headers') ) {
///
function apache_request_headers() {
  $arh = array();
  $rx_http = '/\AHTTP_/';
  foreach($_SERVER as $key => $val) {
    if( preg_match($rx_http, $key) ) {
      $arh_key = preg_replace($rx_http, '', $key);
      $rx_matches = array();
      // do some nasty string manipulations to restore the original letter case
      // this should work in most cases
      $rx_matches = explode('_', $arh_key);
      if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
        foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
        $arh_key = implode('-', $rx_matches);
      }
      $arh[$arh_key] = $val;
    }
  }
  return( $arh );
}
///
}
	//Link -> localhost/wehnc/Service/GetEmplData.php
header("Access-Control-Allow-Origin: *");
$headers = apache_request_headers();
print_r($headers);
$headers = $headers['token'];
require_once("./token/validateToken.php");


$dats = '';
$dats = @$_GET['id'];


require_once("../Controller/Class_Employees_Controller.php");
$controller = new EmployeesController();
header('Content-Type: application/json');
	// ob_clean();
echo $controller->getEmployeeJson($dats);


?>
