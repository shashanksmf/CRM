<?php
    header("Access-Control-Allow-Origin: *");
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

class checkListId {

  public function checkList($mailChimpApiKey,$mailChimpSubDomainInit,$list_id) {

    $auth = base64_encode( 'user:'.$mailChimpApiKey);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/lists/'.$list_id);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
        'Authorization: Basic '.$auth));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    // curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

    $result = curl_exec($ch);
    return $result;
  }
}

?>
