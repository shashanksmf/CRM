<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: Authorization');
header('Access-Control-Max-Age: 1');  //1728000
header("Content-Length: 0");
header("Content-Type: text/plain charset=UTF-8");

error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once('../vendor/autoload.php');

session_start();

$client = new Google_Client();
$client->setAuthConfigFile('../credentials.json');
$client->addScope(Google_Service_Plus::PLUS_ME);
$httpClient = $client->authorize();
// $client->setRedirectUri('https://upsailgroup.herokuapp.com');
$client->setRedirectUri('https://' . $_SERVER['HTTP_HOST']);
$client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
if (! isset($_GET['code'])) {
  echo $_GET['code'];
  $auth_url = $client->createAuthUrl();
  echo $auth_url;
  header('Location:' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  echo $_SESSION['access_token'];
  // $redirect_uri = 'https://upsailgroup.herokuapp.com';
  $redirect_uri = 'https://' . $_SERVER['HTTP_HOST'];
  header('Location:' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
$response = $httpClient->get('https://www.googleapis.com/plus/v1/people/me');
echo $response;

// require_once("../Controller/Class_User_Login_Controller.php");
// $controller = new UserLoginController();
// header('Content-Type: application/json');
// echo $controller->checkUserEmail($email);

?>