<?php
header("Access-Control-Allow-Origin: *");


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
?>