<?php
$userId = @$_GET['id'];
$name = @$_GET['name'];
$department = @$_GET['department'];
$dob = @$_GET['dob'];
$gender = @$_GET['gender'];
$homeAddress = @$_GET['homeAddress'];
$email = @$_GET['email'];
$phone = @$_GET['phone'];

require_once("../Controller/StaticDBCon.php");
$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
// Create connection

$responseArr = array();
if (!$conn) {
	$responseArr["result"] = false;
	$responseArr["details"] =  mysqli_connect_error();
    die($responseArr["details"]);
}

$sql = "UPDATE user SET name= ".$name." ,department=".$department." ,dob=".$dob.",gender = ".$gender.", email=".$email."  WHERE id=".$userId ;

if (mysqli_query($conn, $sql)) {
    $responseArr["result"] = true;
	echo json_encode($responseArr);
} else {
    $responseArr["result"] = false;
	$responseArr["details"] = mysqli_error($conn);
	echo json_encode($responseArr);
    echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>