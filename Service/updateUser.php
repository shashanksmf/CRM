<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "./phpHeader/getHeader.php";

$headers = apache_request_headers();
require_once "./token/validateToken.php";

$userId = @$_GET['id'];
$name = @$_GET['name'];
$department = @$_GET['department'];
$dob = @$_GET['dob'];
$gender = @$_GET['gender'];
$homeAddress = @$_GET['homeAddress'];
$email = @$_GET['email'];
$phone = @$_GET['phone'];
$hireDate = @$_GET['hireDate'];

require_once "../Controller/StaticDBCon.php";
$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
// Create connection

$responseArr = array();
if (!$conn) {
//echo "not conn";
	$responseArr["result"] = false;
	$responseArr["reason"] =  mysqli_connect_error();
	die($responseArr);
}
mysqli_set_charset($conn,"utf8");
$sql = "UPDATE user SET name= '".$name."' ,department='".$department."' ,dob='".$dob."',gender = '".$gender."', email='".$email."',phone='".$phone."',homeAddress='".$homeAddress."' ,hireDate ='".$hireDate."'  WHERE id=".$userId ;
//echo $sql;
if (mysqli_query($conn, $sql)) {
//echo "if";
	$responseArr["result"] = true;
	echo json_encode($responseArr);
} else {
//echo "else".mysqli_error($conn);
	$responseArr["result"] = false;
	$responseArr["reason"] = mysqli_error($conn);
	echo json_encode($responseArr);
   // echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
