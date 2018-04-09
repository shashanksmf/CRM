<?php 

	//http://localhost/wehnc/Service/GetUserData.php?id=1

ob_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("./phpHeader/getHeader.php");

header("Access-Control-Allow-Origin: *");
$headers = apache_request_headers();
// $headers = $headers['token'];
// require_once("./token/validateToken.php");

$responseArr = array();
$dats = '';
$userId = @$_POST['id'];
require_once("../Controller/StaticDBCon.php");
$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);

if($conn->connect_error) {
	$responseArr["result"] = false;
	$responseArr["details"] = $conn->connect_error;
	exit(json_encode($responseArr));
}


ob_clean();
if(isset($_FILES['image'])){
	$extt = $_FILES['image']['name'];
	$errors= array();
	$path_info = pathinfo($_FILES['image']['name']);
	  //echo $path_info['extension'];
	$file_name = $_FILES['image']['name'];
	
	$file_size =$_FILES['image']['size'];
	$file_tmp = $_FILES['image']['tmp_name'];
	$file_type= $_FILES['image']['type'];
      //$file_ext=strtolower(end(explode('.',$extt)));
   //   $expensions= array("jpeg","jpg","png");
	
       //exit("outside empty");
	if(!empty($file_name)){
		
		$uploadDirPath = "../uploads/";
		$proPicFolder = "../uploads/profilepic";
		
		if (!file_exists($proPicFolder)) {
			mkdir($proPicFolder);
		}
		
		$userFolder = $proPicFolder."/user";
		
		if (!file_exists($userFolder)) {
			mkdir($userFolder);
		}
		
		$userIdFolder = $userFolder."/".$userId;
		if (!file_exists($userIdFolder)) {
			mkdir($userIdFolder, 0777, true);
		}
		$userIdFolderPath = "uploads/profilepic/user/".$userId."/";
		$fileUrl = $userIdFolderPath;
		
		
		$updateUserProfilePicSql = "UPDATE user SET profilePic = '".$fileUrl.$file_name."' WHERE id=".$userId;
		//exit($updateEmplProfilePicSql);
	//exit();  
		if (mysqli_query($conn, $updateUserProfilePicSql)) { 
		//exit("hello");		
			move_uploaded_file($file_tmp,$userIdFolder."/".$file_name);
			
			$responseArr["result"] = true;
			$responseArr["details"] = array();
			$responseArr["details"]["domainName"] = $_SERVER['SERVER_NAME'];
			$responseArr["details"]["imageUrl"] =  $userIdFolderPath.$file_name;
			echo json_encode($responseArr); 
			
		}
		else{
			$responseArr["result"] = false;
			$responseArr["details"] = mysqli_error($conn);
			echo json_encode($responseArr); 
		}
	}
	else{
		$responseArr["result"] = false;	
		$responseArr["details"] = "file Name empty";
		echo json_encode($responseArr);
		
	}
	
}
else{
	$responseArr["result"] = false;
	$responseArr["details"] = "server is down";
	echo json_encode($responseArr);
}

?>