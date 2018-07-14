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
$listId = @$_GET['listId'];
// exit($listId);
$company=@$_GET['company'];
$address1=@$_GET['address1'];
$address2=@$_GET['address2'];
$city=@$_GET['city'];
$state=@$_GET['state'];
$zip=@$_GET['zip'];
$country=@$_GET['country'];
$phone=@$_GET['phone'];
$permission_reminder=@$_GET['permission_reminder'];
$from_name=@$_GET['from_name'];
$from_email=@$_GET['from_email'];
$subject=@$_GET['subject'];
$language=@$_GET['language'];
$email_type_option=@$_GET['email_type_option'];
$date=date("Y-m-d");


// exit($company);
$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
if($conn->connect_error) {
	$responseArr["result"] = false;
	$responseArr["reason"] = $conn->connect_error;
	exit(json_encode($responseArr));
}

$updateListDetails="UPDATE `mailchimp_createlist_details` SET `company` = '".$company."',`address1`='".$address1."',`address2`='".$address2."',`city`='".$city."',`state`='".$state."',`zip`='".$zip."',`country`='".$country."',`phone`='".$phone."',`permission_reminder`='".$permission_reminder."',`from_name`='".$from_name."',`from_email`='".$from_email."',`subject`='".$subject."',`language`='".$language."'  WHERE listid='".$listId."';";

if ($conn->query($updateListDetails) === TRUE) {
	$responseArr["result"] = true;

	exit(json_encode($responseArr));
} else {
	$responseArr["result"] = false;
	$responseArr["reason"] = "Something went wrong";
	exit(json_encode($responseArr));
}
mysqli_close($conn);

?>
