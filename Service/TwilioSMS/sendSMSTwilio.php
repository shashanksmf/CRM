<?php
// Required if your environment does not handle autoloading
include_once('../../vendor/autoload.php');

// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;

// Your Account SID and Auth Token from twilio.com/console
$account_sid = 'ACd8c4a4ec09d8a4198292669ba559f661';
$auth_token = 'fbdfb06b92862c22145ba03b68ce5298';
$client = new Client($account_sid, $auth_token);

// Use the client to do fun stuff like send text messages!
$client->messages->create(
    // the number you'd like to send the message to
    '+919511762987',
    array(
        // A Twilio phone number you purchased at twilio.com/console
        'from' => '+15128588607',
        // the body of the text message you'd like to send
        'body' => 'Hey Jenny! Good luck on the bar exam!'
    )
);

?>