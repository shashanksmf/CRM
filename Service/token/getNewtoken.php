<?php
  header("Access-Control-Allow-Origin: *");
  include_once('.../../../vendor/autoload.php');
  use ReallySimpleJWT\Token;
  use Carbon\Carbon;
  use ReallySimpleJWT\TokenValidator;
  use ReallySimpleJWT\TokenBuilder;


 class getNewtoken {

        public function getToken() {
          $dateTime = Carbon::now()->addHours(1)->toDateTimeString(); // + 60 seconds for testing
          $secretKey = 'SecretSuperstar@99';
          // $token = Token::getToken('shankie1990@gmail.com', $secretKey, $nowDate, 'www.raffia.co');

          $builder = new TokenBuilder();
          $token = $builder->setIssuer('http://localhost')
                   ->setSecret($secretKey)
                   ->setExpiration($dateTime)
                   ->addPayload(['key' => 'user_id', 'value' => 22])
                   ->build();

          $responseArr = array();
          $responseArr['token'] = $token;
          $responseArr["result"] = true;
          // echo json_encode($responseArr);
          return $responseArr;

        }

    }
  // echo json_encode($responseArr);
?>
