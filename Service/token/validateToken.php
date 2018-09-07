<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

include_once('.../../../vendor/autoload.php');

use ReallySimpleJWT\TokenValidator;
use ReallySimpleJWT\Token;
use Carbon\Carbon;
use ReallySimpleJWT\TokenBuilder;

class validateToken {

	public function validate($token) {
		$validator = new TokenValidator;
		$secret =  'SecretSuperstar@99';
			// $token = $_POST['token'];
		$responseArr = array();
		$getPayloadArr = array();
		$tokenExp = '';

			// print_r($validator->splitToken($token));
			// echo Carbon::now()->addMinutes(0)->toDateTimeString();
			// print_r($getPayload = Token::getPayload($token));

		$getPayload = Token::getPayload($token);
		$getPayloadArr = json_decode($getPayload, TRUE);
		$userId = $getPayloadArr['userId'];
		try {
			$result = Token::validate($token, $secret);
			$tokenExp = $validator->splitToken($token)->validateExpiration()->validateSignature($secret);
		}
		catch(Exception $e) {
			$responseArr['result'] = false;
			$responseArr['errorType'] = 'token';
			$responseArr["reason"] = $e->getMessage();
			$responseArr['getPayload'] = json_decode($getPayload);
			$responseArr['userId'] = $userId;
			   // exit(json_encode($responseArr));
			return $responseArr;
		}

			$responseArr['result'] = $result;
			$responseArr['reason'] = '';
			$responseArr['exp'] = $tokenExp;
			$responseArr['getPayload'] = json_decode($getPayload);
			$responseArr['userId'] = $userId;
			// echo json_encode($responseArr);
			return $responseArr;
	}
}

if(isset($headers['token']) && !empty($headers['token']) && $headers['token'] != 'null'){
	$validateToken = new validateToken();
	$result = $validateToken->validate($headers['token']);
	$tokenUserId = $result['userId'];
	// echo json_encode($result);
	if (strlen($result['reason']) > 0 && $result['result'] == false) {
		exit(json_encode($result));
	}
}
else {
	$result['result'] = false;
	$result['errorType'] = 'token';
	$result['reason'] = 'This token has expired!';
	exit(json_encode($result));
}

?>
