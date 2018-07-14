<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "./phpHeader/getHeader.php";

$headers = apache_request_headers();
require_once "./token/validateToken.php";
require_once "./mailChimp/list/createList.php";
require_once ".../../../Controller/mailChimpConfig.php";
require_once ".../../../Controller/mailChimpService.php";
require_once "../Controller/StaticDBCon.php";
$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
$responseArr = array();
if($conn->connect_error) {
	$responseArr["result"] = false;
	$responseArr["reason"] = $conn->connect_error;
	exit(json_encode($responseArr));
}
$userId=@$_GET['userId'];
$name = @$_GET['name'];
$type=@$_GET['type'];
$date=date("Y-m-d");
	$insertListDetails="INSERT INTO mailchimp_createlist_details (userId,listname,type,date_created,isActive)VALUES('".$userId."','".$name."','".$type."','".$date."',1)";
$result = array('listname'=>$name,'type'=>$type,'date'=>$date);
	if(mysqli_query($conn, $insertListDetails))
	{
    $updateListDetails="UPDATE `mailchimp_createlist_details` SET listid=srno WHERE type='CustomList'" ;
// exit($updateListDetails);
    if ($conn->query($updateListDetails) === TRUE) {
    	$responseArr["result"] = true;
      $resultArr['details']=$result;
    	exit(json_encode($responseArr));
    } else {
    	$responseArr["result"] = false;
    	$responseArr["reason"] = "Something went wrong";
    	exit(json_encode($responseArr));
    }
		 $resultArr['result']=true;
		 $resultArr['details']=$result;
		 exit(json_encode($resultArr));
	}
	 else
	 {
		 $resultArr['result']=false;
		 $resultArr['reason']="cannot insert";
		 exit(json_encode($resultArr));
		}
?>
