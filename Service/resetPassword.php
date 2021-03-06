<?php
ob_start();
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "./phpHeader/getHeader.php";

$headers = apache_request_headers();
require_once "./token/validateToken.php";

$email =  @$_GET['email'];

require_once "../Controller/StaticDBCon.php";
$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
// Create connection

$responseArr = array();
if (!$conn) {
	$responseArr["result"] = false;
	$responseArr["reason"] =  mysqli_connect_error();
	die($responseArr["reason"]);
}

if(!isset($email) || empty($email)) {
	$responseArr["result"] = false;
	$responseArr["reason"] =  "Please enter Email Id";
	die($responseArr["reason"]);
}

// code for random alpha numeric string generator
$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
$code = '';
$max = strlen($characters) - 1;
for ($i = 0; $i < $random_string_length; $i++) {
	$code .= $characters[mt_rand(0, $max)];
}
// code for random alpha numeric string generator

// insert random string into database
ob_clean();
$sql = "UPDATE user SET forgetpasscode= ".$code." WHERE email=".$email;
if (mysqli_query($conn, $sql)) {

	$to = $email;
	$subject = "Re: Reset Password";

	$message = "<div><div>Please Click on Below Link to reset your password.</div>";
	$message .= "<div><a href='".$_SERVER['SERVER_NAME']."/views/resetPassword/".$code."'/></div></div>";

	$header = "From:support@jaiswal.com \r\n";
	$header .= "MIME-Version: 1.0\r\n";
	$header .= "Content-type: text/html\r\n";

	$retval = mail ($to,$subject,$message,$header);

	if( $retval == true ) {
		$responseArr["result"] = true;
		$responseArr["reason"] = "Please check your Inbox or Spam to reset your Password";
		echo json_encode($responseArr);
	}else {
		$responseArr["result"] = false;
		$responseArr["reason"] = "mail Function failed";
		echo json_encode($responseArr);
	}



} else {
	$responseArr["result"] = false;
	$responseArr["reason"] = mysqli_error($conn);
	echo json_encode($responseArr);
  //  echo "Error updating record: " . mysqli_error($conn);
}
//



mysqli_close($conn);
?>
