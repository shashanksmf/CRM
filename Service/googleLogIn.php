<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');
header('Access-Control-Allow-Methods: POST, GET');

error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once('../vendor/autoload.php');


session_start();

$responseArr = array();
// $userDataArr = array();
// $accessTokenArr = array();
$client_id = '106745707537-lqdq3l9g6l6gkim9fgqn2hqbktpslatf.apps.googleusercontent.com';
$client_secret = 'oUv4b6yzrPaz_YG2nx9Toy0J';
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
// $client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
// $client->addScope(Google_Service_Plus::PLUS_ME);
// $response = $httpClient->get('https://www.googleapis.com/plus/v1/people/me');
// print_r($response);

//Send Client Request
$objOAuthService = new Google_Service_Oauth2($client);

//Logout
if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
  $client->revokeToken();
  // header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL)); //redirect user back to page
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
  //userData
  // $userDataArr = json_decode($userData, TRUE);
  // $responseArr['user_email'] = $userDataArr['email'];
  // $responseArr['user_id'] = $userDataArr['id'];
  // $responseArr['user_picture'] = $userDataArr['picture'];
  // $responseArr['user_verifiedEmail'] = $userDataArr['verifiedEmail'];
  // $responseArr['user_token'] = $userDataArr['token'];
  $_SESSION['access_token'] = $client->getAccessToken();
  $responseArr['access_token'] = $_SESSION['access_token'];
  // access_token data
  // $accessTokenArr = json_decode($_SESSION['access_token'], TRUE);
  // $responseArr['access_token'] = $accessTokenArr['access_token'];
  // $responseArr['token_type'] = $accessTokenArr['token_type'];
  // $responseArr['expires_in'] = $accessTokenArr['expires_in'];
  // $responseArr['id_token'] = $accessTokenArr['id_token'];
  // $responseArr['token_created'] = $accessTokenArr['created'];
  //redirect to server
  $responseArr["url"] = 'https://' . $_SERVER['HTTP_HOST'];
} else {
  $auth_url = $client->createAuthUrl();
  $responseArr["url"] = filter_var($auth_url, FILTER_SANITIZE_URL);
}
echo json_encode($responseArr);


  // $responseArr = array();
// $client = new Google_Client();
// $client->setAuthConfigFile('../credentials.json');
// $client->addScope(Google_Service_Plus::PLUS_ME);
// $httpClient = $client->authorize();
// $client->setRedirectUri('https://' . $_SERVER['HTTP_HOST']);
// $client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
// if (! isset($_GET['code'])) {
//   $auth_url = $client->createAuthUrl();
//   $_SESSION['access_token'] = $client->getAccessToken();
//   $responseArr['result'] = True;
//   $responseArr['access_token'] = $_SESSION['access_token'];
//   $responseArr["url"] = filter_var($auth_url, FILTER_SANITIZE_URL);
//   echo json_encode($responseArr);
//   // header('Location:' . filter_var($auth_url, FILTER_SANITIZE_URL));

// } else {
//   $client->authenticate($_GET['code']);
//   $_SESSION['access_token'] = $client->getAccessToken();
//   echo "access_token".$_SESSION['access_token'];
//   $redirect_uri = 'https://' . $_SERVER['HTTP_HOST'];
//   $responseArr['result'] = False;
//   $responseArr['access_token'] = $_SESSION['access_token'];
//   $responseArr["url"] = filter_var($redirect_uri, FILTER_SANITIZE_URL);
//   echo json_encode($responseArr);
//   // header('Location:' . filter_var($redirect_uri, FILTER_SANITIZE_URL));

// }
// $response = $httpClient->get('https://www.googleapis.com/plus/v1/people/me');
// print_r($response);
// $responseArr['email'] = json_encode($response);
// echo json_encode($responseArr);


// require_once("../Controller/Class_User_Login_Controller.php");
// $controller = new UserLoginController();
// header('Content-Type: application/json');
// echo $controller->checkUserEmail($email);

?>