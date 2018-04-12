<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Headers: Origin, token, Host');

    require_once("../.././phpHeader/getHeader.php");

class checkAPIKey {

  public function key($mailChimpApiKey,$mailChimpSubDomainInit) {

    $auth = base64_encode( 'user:'.$mailChimpApiKey);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/');
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