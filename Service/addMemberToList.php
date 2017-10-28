<?php

header('Access-Control-Allow-Origin: *'); 
require_once("../Controller/EmailMgr.php");
$c2 = new EmailMgr();
$email = "shankie1990@gmail.com";
$name = "shashank";
$c2->addMebmberToList($email,'d0a4dda674',$name,'','');
echo json_encode($c2);
?>