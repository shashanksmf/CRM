<?php

include_once('./../../vendor/autoload.php');

use ReallySimpleJWT\TokenValidator;
use ReallySimpleJWT\Token;
use Carbon\Carbon;
use ReallySimpleJWT\TokenBuilder;

$validator = new TokenValidator;
$secret =  'SecretSuperstar@99';
$token = $_POST['token'];
$responseArr = array();
$tokenExp = '';

// print_r($validator->splitToken($token));
// echo Carbon::now()->addMinutes(0)->toDateTimeString();
// print_r($getPayload = Token::getPayload($token));

$getPayload = Token::getPayload($token);

try {
  $result = Token::validate($token, $secret);
  $tokenExp = $validator->splitToken($token)->validateExpiration()->validateSignature($secret);
}
catch(Exception $e) {
   $responseArr['result'] = false;
   $responseArr["details"] = $e->getMessage();
   $responseArr['getPayload'] = json_decode($getPayload);
   exit(json_encode($responseArr));
}

$responseArr['getPayload'] = json_decode($getPayload);
$responseArr['exp'] = $tokenExp;
$responseArr['result'] = $result;
echo json_encode($responseArr);
