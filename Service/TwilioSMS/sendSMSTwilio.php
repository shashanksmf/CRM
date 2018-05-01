<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once('../../vendor/autoload.php');

use Twilio\Rest\Client;

$to = @$_GET['to'];
$to = "+".$to;
$text = @$_GET['text'];

$account_sid = 'ACd6174cef3f620aee42f1c89fc9d6a7fe';
$auth_token = '213c7b2c415da489eac89130e4d180b8';

// $account_sid = 'AC971d7637dc5a0596d6f1617861d9d921';
// $auth_token = 'cacfde23096e6d8beadf02e63c1592e0';
$client = new Client($account_sid, $auth_token);
$result = $client->messages->create($to,
	    array(
	        // 'from' => $from,
	        'from' => '+15128588607',
	        // 'from' => '+14014097255',
	        'body' => $text
	    )
	);
// $result=json_encode($result[0]);
// print_r($result);
echo "Result=".$result['content'];
?>


<!-- $client->messages->create(
    '+15558675310',
    array(
        'from' => '+15017122661',
        'body' => "McAvoy or Stewart? These timelines can get so confusing.",
        'statusCallback' => "http://requestb.in/1234abcd"
    )
); -->