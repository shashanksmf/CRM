<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "./phpHeader/getHeader.php";

$headers = apache_request_headers();
require_once "./token/validateToken.php";
// require_once "./mailChimp/list/createList.php";
// require_once ".../../../Controller/mailChimpConfig.php";
// require_once ".../../../Controller/mailChimpService.php";
require_once "../Controller/StaticDBCon.php";

$userId= @$_GET['userId'];
$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
if($conn->connect_error) {
	$responseArr["result"] = false;
	$responseArr["reason"] = $conn->connect_error;
	exit(json_encode($responseArr));
}

$transactionDetails="SELECT * FROM transactiontable WHERE userId='".$userId."';";

@mysqli_set_charset($conn,"utf8");
$result = mysqli_query($conn, $transactionDetails);
if (@mysqli_num_rows($result) > 0) {
    // output data of each row
       // print_r($result);
	$responseArr["result"] = true;
	$responseArr["details"] = array();
	while($row = mysqli_fetch_assoc($result)) {
//	print_r($row);
		array_push($responseArr["details"] , $row);
	}
	exit(json_encode($responseArr));
} else {
	$responseArr["result"] = false;
	$responseArr["reason"] = "No Records found";
	exit(json_encode($responseArr));
}
mysqli_close($conn);

?>
