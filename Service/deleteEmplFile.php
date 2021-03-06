<?php
	//http://localhost/wehnc/Service/GetUserData.php?id=1
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "./phpHeader/getHeader.php";

$headers = apache_request_headers();
require_once "./token/validateToken.php";

require_once "../Controller/StaticDBCon.php";

$dats = '';
$emplId = @$_GET['emplId'];
$fileId = @$_GET['fileId'];
$responseArr = array();

$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
if($conn->connect_error) {
	$responseArr["result"] = false;
	$responseArr["reason"] = $conn->connect_error;
	exit(json_encode($responseArr));
}


if(isset($emplId) && !empty($emplId) && isset($fileId) && !empty($fileId)){

	$getAllFileSql = "UPDATE emplFiles set isactive = 0 WHERE emplid=".$emplId." AND id=".$fileId;
	if(mysqli_query($conn, $getAllFileSql)){
		$responseArr["result"] = true;
		echo json_encode($responseArr);
	}
	else{
		$responseArr["result"] = false;
		$responseArr["reason"] =  mysqli_error($conn);
		echo json_encode($responseArr);
	}
}

else{
	$responseArr["result"] = false;
	$responseArr["reason"] = "file Id of employee Id not found";
	echo json_encode($responseArr);
}

?>
