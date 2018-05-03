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
  exit;
} else {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  echo "access_token".$_SESSION['access_token'];
  $redirect_uri = 'https://' . $_SERVER['HTTP_HOST'];
  // echo '<script type="text/javascript">top.location.href = "'.filter_var($redirect_uri, FILTER_SANITIZE_URL).'";</script>';
  $responseArr['result'] = False;
  $responseArr['access_token'] = $_SESSION['access_token'];
  $responseArr["url"] = filter_var($redirect_uri, FILTER_SANITIZE_URL);
  echo json_encode($responseArr);
  // header('Location:' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  exit;
}
// $response = $httpClient->get('https://www.googleapis.com/plus/v1/people/me');
// print_r($response);
// $responseArr['email'] = json_encode($response);
// echo json_encode($responseArr);


// require_once("../Controller/Class_User_Login_Controller.php");
// $controller = new UserLoginController();
// header('Content-Type: application/json');
// echo $controller->checkUserEmail($email);

?>