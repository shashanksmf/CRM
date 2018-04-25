<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');
// Required if your environment does not handle autoloading
include_once('../../vendor/autoload.php');

// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;

// Your Account SID and Auth Token from twilio.com/console
$account_sid = 'ACd6174cef3f620aee42f1c89fc9d6a7fe';
$auth_token = '213c7b2c415da489eac89130e4d180b8';
$client = new Client($account_sid, $auth_token);

// Use the client to do fun stuff like send text messages!
$client->messages->create(
    // the number you'd like to send the message to
    '+919511762987', '+919822097124'
    array(
        // A Twilio phone number you purchased at twilio.com/console
        'from' => '+15128588607',
        // the body of the text message you'd like to send
        'body' => 'Hey! Good luck!'
    )
);

?>