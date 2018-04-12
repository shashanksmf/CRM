<?php
$to = "judy@techinvento.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: shashank@techinvento.com" . "\r\n" .
"";

mail($to,$subject,$txt,$headers);
?>