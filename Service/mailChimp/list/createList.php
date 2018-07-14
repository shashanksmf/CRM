<?php
    header("Access-Control-Allow-Origin: *");
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

class createList {

  public function list($mailChimpApiKey,$name,$mailChimpSubDomainInit,$contactDetails,$permission_reminder,$campaign_defaults,$email_type_option) {

    $data = array(
        'apikey'        => $mailChimpApiKey,
        'contact'  => $contactDetails,
        'name'=> $name,
        'email_type_option' => $email_type_option === 'true' ? true : false,
        'permission_reminder'=>$permission_reminder,
        'campaign_defaults'=>$campaign_defaults
        );

    $json_data = json_encode($data);

    $auth = base64_encode( 'user:'.$mailChimpApiKey);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/lists');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
        'Authorization: Basic '.$auth));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    // curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    $result = curl_exec($ch);
// $result = json_decode($result, true);
    return $result;
  }
}

?>
