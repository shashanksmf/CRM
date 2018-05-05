<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');
header('Access-Control-Allow-Methods: POST, GET');

error_reporting(E_ALL);
ini_set('display_errors', '1');
error_reporting(E_ERROR | E_PARSE);

include_once('../vendor/autoload.php');


session_start();

$responseArr = array();
$client_id = '106745707537-lqdq3l9g6l6gkim9fgqn2hqbktpslatf.apps.googleusercontent.com';
$client_secret = 'oUv4b6yzrPaz_YG2nx9Toy0J';
// $redirect_uri = 'https://' . $_SERVER['HTTP_HOST'];
$redirect_uri = 'https://' . $_SERVER['HTTP_HOST'] .'/Service/googleLogIn.php';
$simple_api_key = 'AIzaSyCCBX6FQPBwCCqarnFKHWV9Ls1LzI2AMIU';

//Create Client Request to access Google API
$client = new Google_Client();
$client->setApplicationName("CRM.git");
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->setDeveloperKey($simple_api_key);
$client->addScope("https://www.googleapis.com/auth/userinfo.email");

//Send Client Request
$objOAuthService = new Google_Service_Oauth2($client);

//Logout
if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
  $client->revokeToken();
  // header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL)); 
  $responseArr["url"] = filter_var($redirect_uri, FILTER_SANITIZE_URL);
}

//Authenticate code from Google OAuth Flow
//Add Access Token to Session
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  // header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  $responseArr["url"] = filter_var($redirect_uri, FILTER_SANITIZE_URL);
}

//Set Access Token to make Request
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
}

//Get User Data from Google Plus
//If New, Insert to Database
if ($client->getAccessToken()) {
  $userData = $objOAuthService->userinfo->get();
  $responseArr['userData'] = $userData;
  $responseArr['userEmail'] = $userData['email'];
  
  $_SESSION['access_token'] = $client->getAccessToken();
  $access_token = $_SESSION['access_token'];
  $responseArr['accessToken'] = $access_token;
  $responseArr['idToken'] = $access_token['id_token'];
  
  //redirect to server
  $responseArr["url"] = 'https://' . $_SERVER['HTTP_HOST'];

  require_once("../Controller/Class_User_Login_Controller.php");
  $controller = new UserLoginController();
  header('Content-Type: application/json');
  $checkUserEmail = $controller->checkUserEmail($userData['email']);
  // $checkUserEmail = $controller->checkUserEmail('shashanksmf@gmail.com');
  $checkUserEmail =  json_decode(json_encode($checkUserEmail),true);
  print_r($checkUserEmail);
  $checkUserEmailArr = array();
  $checkUserEmailArr = $checkUserEmail;
  $message = $checkUserEmailArr['message'];
  echo "message".$message;
    // $responseArr['userDetails'] = $checkUserEmail;
  $email = "shashanksmf@gmail.com";
  $checkUserEmail = $controller->checkUserEmail($email);
  $checkUserEmail =  json_decode(json_encode($checkUserEmail),true);
  print_r($checkUserEmail);
  $checkUserEmailArr = array();
  $checkUserEmailArr = $checkUserEmail;
  $message = $checkUserEmailArr['message'];
  echo "message".$message;
    
  // if($checkUserEmail['isSignedIn'] == TRUE){
  //    $responseArr['userDetails'] = $checkUserEmail;
  // } else {
  //   //Create User Store Data
  //   $isSocial = 'True';
  //   $socialType = 'Google';
  //   $addSocialUser = $controller->addSocialUser($userData['givenName'], $userData['email'],$userData['picture'], $isSocial, $socialType);
  //   $responseArr['userDetails'] = $addSocialUser;
  // }
} else {
  $auth_url = $client->createAuthUrl();
  $responseArr["result"] = TRUE;
  $responseArr["url"] = filter_var($auth_url, FILTER_SANITIZE_URL);
}
exit(json_encode($responseArr,true));


?>