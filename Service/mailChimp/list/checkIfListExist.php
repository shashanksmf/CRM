<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

require_once "./phpHeader/getHeader.php";
require_once "../Controller/StaticDBCon.php";

$headers = apache_request_headers();
require_once "./token/validateToken.php";
class checkIfListExists{
  public function checkExist($list_id){
    $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
    // Create connection
    if (!$conn) {
      //echo "not conn";
      $responseArr["result"] = false;
      $responseArr["reason"] =  mysqli_connect_error();
      die($responseArr);
    }
    $sql = "SELECT * from mailchimpdetails  WHERE listId='".$list_id."' AND isactive = 1;";
    $result = mysqli_query($conn, $sql);
    $responseArr = array();
    if (@mysqli_num_rows($result) > 0) {
        // output data of each row
           // print_r($result);
    	$responseArr["result"] = false;
    	$responseArr["reason"] ="List already present" ;
      exit(json_encode($responseArr));
}
  }
}
?>
