<?php 
	//http://localhost/wehnc/Service/GetUserData.php?id=1
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("./phpHeader/getHeader.php");

header("Access-Control-Allow-Origin: *");
$headers = apache_request_headers();
// $headers = $headers['token'];
// require_once("./token/validateToken.php");

require_once("../Controller/StaticDBCon.php");

$dats = '';
$emplId = @$_GET['emplId'];
$fileId = @$_GET['fileId'];	
$responseArr = array();

$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
if($conn->connect_error) {
	$responseArr["result"] = false;
	$responseArr["details"] = $conn->connect_error;
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
		$responseArr["details"] =  mysqli_error($conn);
		echo json_encode($responseArr);		
	}
}

else{
	$responseArr["result"] = false;
	$responseArr["details"] = "file Id of employee Id not found";
	echo json_encode($responseArr);
}

?>

