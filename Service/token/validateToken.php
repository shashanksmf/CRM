<?php

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
			   $responseArr['errorType'] = 'token';
			   $responseArr["details"] = $e->getMessage();
			   $responseArr['getPayload'] = json_decode($getPayload);
			   // exit(json_encode($responseArr));
			   return $responseArr;
			}

			// $responseArr['result'] = $result;
			// $responseArr['exp'] = $tokenExp;
			// $responseArr['getPayload'] = json_decode($getPayload);
			// echo json_encode($responseArr);
		}
}


	$validateToken = new validateToken();
    $result = $validateToken->validate($headers);
    // echo json_encode($result);
 	if (strlen($result['details']) > 0 && $result['result'] == false) {
    	 exit(json_encode($result));
    }

?>
