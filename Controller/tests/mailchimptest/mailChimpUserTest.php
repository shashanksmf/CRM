<?php
header("Access-Control-Allow-Origin: *");
error_reporting(E_ALL);
ini_set('display_errors', 1);
// require_once("./../../mailChimpConfig.php");
// require_once("./../../mailChimpService.php");

// $mailChimpServiceBlah = new MailChimpService();
// $mailChimpSubDomainInit = MailChimpConfig::$mailChimpSubDomainInit;
// $mailChimpApiKey = $mailChimpService->mailChimpApiKey = getenv("mailChimpApiKey");
// $list_id = $mailChimpService->list_id = getenv('mailChimpListId');

// echo $mailChimpSubDomainInit."hello".$mailChimpApiKey."hello".$list_id."<br/>";

class MailChimpUserTest {

	public function subscribeUser($email,$first_name,$mailChimpApiKey,$mailChimpSubDomainInit,$list_id) {

    $auth = base64_encode( 'user:'.$mailChimpApiKey);

    $data = array(
        'apikey'        => $mailChimpApiKey,
        'email_address' => $email,
        'status'        => 'subscribed',
        'merge_fields'  => array(
            'FNAME' => $first_name
            )
        );

    $json_data = json_encode($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/lists/'.$list_id.'/members/'.md5(strtolower($email)));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
        'Authorization: Basic '.$auth));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

    $result = curl_exec($ch);
    return $result;
  }

  public function unSubscribeUser($email,$first_name,$mailChimpApiKey,$mailChimpSubDomainInit,$list_id) {

    $auth = base64_encode( 'user:'.$mailChimpApiKey);

    $data = array(
        'apikey'        => $mailChimpApiKey,
        'email_address' => $email,
        'status'        => 'unsubscribed',
        'merge_fields'  => array(
            'FNAME' => $first_name
            )
        );

    $json_data = json_encode($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/lists/'.$list_id.'/members/'.md5(strtolower($email)));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
        'Authorization: Basic '.$auth));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

    $result = curl_exec($ch);
    return $result;
  }
}


// $subUser = new MailChimpUserTest();
// $result = $subUser->subscribeUser("shashanksmf@outlook.com","shashank",$mailChimpApiKey,$mailChimpSubDomainInit,$list_id);
// echo $result;
// echo "<br/>";

// $unSubUser = new MailChimpUserTest();
// $result = $subUser->unSubscribeUser("shashanksmf@outlook.com","shashank",$mailChimpApiKey,$mailChimpSubDomainInit,$list_id);
// echo $result;
// echo "<br/>";
?>
