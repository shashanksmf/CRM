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
$apiKey = @$_GET['apiKey'];
$name = @$_GET['name'];
$type=@$_GET['type'];
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

  $mailChimpService = new MailChimpService();
  $mailChimpSubDomainInit = 'us19.';
  $mailChimpApiKey = $mailChimpService->mailChimpApiKey =$apiKey;
  $contactDetails=array('company'=>$company,'address1'=>$address1,'address2'=>$address2,'city'=>$city,
  'state'=>$state,'zip'=>$zip,'country'=>$country,'phone'=>$phone);
  $campaign_defaults=array('from_name'=>$from_name,
  'from_email'=>$from_email,'subject'=>$subject,'language'=>$language
  );

  $createList = new createList();
  $result = $createList->list($mailChimpApiKey,$name,$mailChimpSubDomainInit,$contactDetails,$permission_reminder,$campaign_defaults,$email_type_option);
  $result = json_decode($result,true);
  // print_r($result);
    if (!array_key_exists('id', $result)) {
        $resultArr['result'] = false;
        $resultArr['reason'] = "list is invalid";
        exit(json_encode($resultArr));
  }
   else{
        $listid = $result["id"];
	      // print_r($listid);
        $insertListDetails="INSERT INTO mailchimp_createlist_details (listid,userId,APIKEY,listname,type,date_created,company,address1,address2,city,state,zip,country,phone,permission_reminder,from_name,from_email,subject,language,email_type_option,isActive)VALUES('".$listid."','".$userId."','".$mailChimpApiKey."','".$name."','".$type."','".$date."','".$company."','".$address1."','".$address2."','".$city."','".$state."','".$zip."','".$country."','".$phone."','".$permission_reminder."','".$from_name."','".$from_email."','".$subject."','".$language."','".$email_type_option."',1)";
        if(mysqli_query($conn, $insertListDetails))
       {
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
      }

 mysqli_close($conn);

?>
