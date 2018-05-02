<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');
header('Access-Control-Allow-Methods: GET');


error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();
// added in v4.0.0
require_once 'autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
// init app with app id and secret
FacebookSession::setDefaultApplication( '1827896904180275','e0407be9cc41abcb26207d8d46328118' );
// login helper with redirect_uri
// $redirect_url = "https://upsailgroup.herokuapp.com/";
$redirect_url = 'https://' . $_SERVER['HTTP_HOST'];
$helper = new FacebookRedirectLoginHelper($redirect_url);
try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
  echo "<br> FaceExpexption => " . $ex;
} catch( Exception $ex ) {
  // When validation fails or other local issues
  echo "<br> Expexption => " . $ex;
}
$responseArr = array();
// see if we have a session
if ( isset( $session ) ) {
  // graph api request for user data
  $request = new FacebookRequest( $session, 'GET', '/me' );
  $response = $request->execute();
  // get response
  $graphObject = $response->getGraphObject();
      $fbid = $graphObject->getProperty('id');              // To Get Facebook ID
      $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
      $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
     /* ---- Session Variables -----*/
     $_SESSION['FBID'] = $fbid;           
     $_SESSION['FULLNAME'] = $fbfullname;
     $_SESSION['EMAIL'] =  $femail;
     
     $responseArr['fbid'] = $fbid;
     $responseArr['fbfullname'] = $fbfullname;
     $responseArr["femail"] = $femail;
     /* ---- header location after session ----*/
     echo json_encode($responseArr);
     exit;
     header("Location: ".'https://' . $_SERVER['HTTP_HOST']);
   } else {
    $loginUrl = $helper->getLoginUrl();
    echo "$loginUrl".$loginUrl;
    exit;
    header("Location: ".$loginUrl);
  }
?>