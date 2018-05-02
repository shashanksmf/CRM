<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');
header('Access-Control-Allow-Methods: POST, GET');

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
  $auth_url = $client->createAuthUrl();
  // echo "auth_url".$auth_url;
  header('Location:' . filter_var($auth_url, FILTER_SANITIZE_URL), 'Access-Control-Allow-Methods: POST, GET');
} else {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  echo "access_token".$_SESSION['access_token'];
  // $redirect_uri = 'https://upsailgroup.herokuapp.com';
  $redirect_uri = 'https://' . $_SERVER['HTTP_HOST'];
  // echo "$redirect_uri".$redirect_uri;
  header('Location:' . filter_var($redirect_uri, FILTER_SANITIZE_URL), 'Access-Control-Allow-Methods: POST, GET');
}
$response = $httpClient->get('https://www.googleapis.com/plus/v1/people/me');
print_r($response);

// require_once("../Controller/Class_User_Login_Controller.php");
// $controller = new UserLoginController();
// header('Content-Type: application/json');
// echo $controller->checkUserEmail($email);

?>