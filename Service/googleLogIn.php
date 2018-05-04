<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');
header('Access-Control-Allow-Methods: POST, GET');

error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once('../vendor/autoload.php');


session_start();

$responseArr = array();
$client = new Google_Client();
$client->setAuthConfigFile('../credentials.json');
$client->addScope(Google_Service_Plus::PLUS_ME);
$httpClient = $client->authorize();
// $client->setRedirectUri('https://upsailgroup.herokuapp.com');
$client->setRedirectUri('https://' . $_SERVER['HTTP_HOST']);
$client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  $_SESSION['access_token'] = $client->getAccessToken();
  // echo '<script type="text/javascript">top.location.href = "'.filter_var($auth_url, FILTER_SANITIZE_URL).'";</script>';
  $responseArr['result'] = True;
  $responseArr['access_token'] = $_SESSION['access_token'];
  $responseArr["url"] = filter_var($auth_url, FILTER_SANITIZE_URL);
  echo json_encode($responseArr);
  // header('Location:' . filter_var($auth_url, FILTER_SANITIZE_URL));
  
} else {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  echo "access_token".$_SESSION['access_token'];
  $redirect_uri = 'https://' . $_SERVER['HTTP_HOST'];
  // echo '<script type="text/javascript">top.location.href = "'.filter_var($redirect_uri, FILTER_SANITIZE_URL).'";</script>';
  $responseArr['result'] = False;
  $responseArr['access_token'] = $_SESSION['access_token'];
  $responseArr["url"] = filter_var($redirect_uri, FILTER_SANITIZE_URL);
  $response = $httpClient->get('https://www.googleapis.com/plus/v1/people/me');
  print_r($response);
  echo json_encode($responseArr);
  // header('Location:' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  
}
// $responseArr['email'] = json_encode($response);
// echo json_encode($responseArr);


// require_once("../Controller/Class_User_Login_Controller.php");
// $controller = new UserLoginController();
// header('Content-Type: application/json');
// echo $controller->checkUserEmail($email);


// $responseArr = array();
//  $client_id = 'oUv4b6yzrPaz_YG2nx9Toy0J';
//  $client_secret = '106745707537-lqdq3l9g6l6gkim9fgqn2hqbktpslatf.apps.googleusercontent.com';
//  $redirect_uri = 'https://' . $_SERVER['HTTP_HOST'];
//  $simple_api_key = 'AIzaSyCCBX6FQPBwCCqarnFKHWV9Ls1LzI2AMIU';
 
// //Create Client Request to access Google API
// $client = new Google_Client();
// $client->setApplicationName("CRM.git");
// $client->setClientId($client_id);
// $client->setClientSecret($client_secret);
// $client->setRedirectUri($redirect_uri);
// $client->setDeveloperKey($simple_api_key);
// $client->addScope("https://www.googleapis.com/auth/userinfo.email");

// //Send Client Request
// $objOAuthService = new Google_Service_Oauth2($client);

// //Logout
// if (isset($_REQUEST['logout'])) {
//   unset($_SESSION['access_token']);
//   $client->revokeToken();
//   header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL)); //redirect user back to page
//   // $responseArr["url"] = filter_var($redirect_uri, FILTER_SANITIZE_URL);
// //   echo json_encode($responseArr);
// }

// //Authenticate code from Google OAuth Flow
// //Add Access Token to Session
// if (isset($_GET['code'])) {
//   $client->authenticate($_GET['code']);
//   $_SESSION['access_token'] = $client->getAccessToken();
//   header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
//   // $responseArr["url"] = filter_var($redirect_uri, FILTER_SANITIZE_URL);
// //   echo json_encode($responseArr);
// }

// //Set Access Token to make Request
// if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
//   $client->setAccessToken($_SESSION['access_token']);
// }

// //Get User Data from Google Plus
// //If New, Insert to Database
// if ($client->getAccessToken()) {
//   $userData = $objOAuthService->userinfo->get();
//   if(!empty($userData)) {
//   $objDBController = new DBController();
//   $existing_member = $objDBController->getUserByOAuthId($userData->id);
//   if(empty($existing_member)) {
//     $objDBController->insertOAuthUser($userData);
//   }
//   }
//   $_SESSION['access_token'] = $client->getAccessToken();
// } else {
//   $authUrl = $client->createAuthUrl();
// }

?>