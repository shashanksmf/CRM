<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

$to = "judy@techinvento.com";
$subject = "My subject";
$txt = "Hello world!";
$headers .= "From: shashank@techinvento.com" . "\r\n";

if(mail($to,$subject,$txt,$headers)) {
	echo "send successfully";
}
else {
	echo "failed";
}
?>