<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "./phpHeader/getHeader.php";
$headers = apache_request_headers();
require_once "./token/validateToken.php";

$responseArr = array();
$dats = '';
$id = @$_POST['id'];
$userFileName = @$_POST['fileName'];
require_once "../Controller/StaticDBCon.php";

$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
if($conn->connect_error) {
	$responseArr["result"] = false;
	$responseArr["reason"] = $conn->connect_error;
	exit(json_encode($responseArr));
}

if(isset($_FILES['image'])) {
	$extt = $_FILES['image']['name'];
	$errors= array();
	$path_info = pathinfo($_FILES['image']['name']);
	  //echo $path_info['extension'];
	if(isset($userFileName) && !empty($userFileName) && (strlen($userFileName) > 0)) {
		$file_name = $userFileName.".".$path_info['extension'];
	}
	else{
		$file_name = $_FILES['image']['name'];
	}

	$file_size =$_FILES['image']['size'];
	$file_tmp = $_FILES['image']['tmp_name'];
	$file_type= $_FILES['image']['type'];

	if(!empty($file_name)){

		$uploadDirPath = "../uploads/";
		$emplFolder = "../uploads/empl";
		if (!file_exists($emplFolder)) {
			mkdir($emplFolder, 0777, true);
		}

		$userIdFolder = $emplFolder."/".$id;
		if (!file_exists($userIdFolder)) {
			mkdir($userIdFolder, 0777, true);
		}
		$userIdFolderPath = "uploads/empl/".$id."/";
		$fileUrl = $userIdFolderPath;


		$insertUserFileSql = "INSERT into emplFiles (emplid,url,name,filesize,isactive,date) VALUES('".$id."','".$userIdFolderPath."','".$file_name."','".$file_size."','1','".date("d-m-Y")."')";
		//echo $insertUserFileSql;
	//exit();
		if (mysqli_query($conn, $insertUserFileSql)) {
		//exit("hello");
			move_uploaded_file($file_tmp,$userIdFolder."/".$file_name);

			$responseArr["result"] = true;
			$responseArr["details"] = array();
			$responseArr["details"]["fileName"] = $file_name;
			$responseArr["details"]["id"] =  mysqli_insert_id($conn);
			$responseArr["details"]["filesize"] =  $file_size;
			$responseArr["details"]["date"] =  date("d-m-Y");
			echo json_encode($responseArr);

		}
	}
	else{
		$responseArr["result"] = false;
		$responseArr["reason"] = "error occured";
		echo json_encode($responseArr);

	}

}
else{
	$responseArr["result"] = false;
	$responseArr["reason"] = "server is down";
	echo json_encode($responseArr);
}

?>
