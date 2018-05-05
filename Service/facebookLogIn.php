<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');
header('Access-Control-Allow-Methods: POST, GET');

error_reporting(E_ALL);
ini_set('display_errors', '1');
// error_reporting(E_ERROR | E_PARSE);

if(!session_id()){
    session_start();
}

//composer require facebook/graph-sdk

// Include the autoloader provided in the SDK
include_once('../vendor/autoload.php');
include_once('./token/getNewtoken.php');

// Include required libraries
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

/*
 * Configuration and setup Facebook SDK
 */
$appId         = '1827896904180275'; //Facebook App ID
$appSecret     = 'e0407be9cc41abcb26207d8d46328118'; //Facebook App Secret
$redirect_url   = 'https://' . $_SERVER['HTTP_HOST'] .'/Service/facebookLogIn.php'; //Callback URL
$fbPermissions = array('email');  //Optional permissions

$fb = new Facebook(array(
    'app_id' => $appId,
    'app_secret' => $appSecret,
    'default_graph_version' => 'v2.10',
));

// Get redirect login helper
$helper = $fb->getRedirectLoginHelper();

// Try to get access token
try {
    if(isset($_SESSION['facebook_access_token'])){
        $accessToken = $_SESSION['facebook_access_token'];
    }else{
          $accessToken = $helper->getAccessToken();
    }
} catch(FacebookResponseException $e) {
     echo 'Graph returned an error: ' . $e->getMessage();
      exit;
} catch(FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
}

if(isset($accessToken)){
    if(isset($_SESSION['facebook_access_token'])){
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }else{
        // Put short-lived access token in session
        $_SESSION['facebook_access_token'] = (string) $accessToken;
        
          // OAuth 2.0 client handler helps to manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();
        
        // Exchanges a short-lived access token for a long-lived one
        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
        $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
        
        // Set default access token to be used in script
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }
    
    // Redirect the user back to the same page if url has "code" parameter in query string
    if(isset($_GET['code'])){
        // header('Location: ./');
        $responseArr["url"] = filter_var($redirect_url, FILTER_SANITIZE_URL);
    }
    
    // Getting user facebook profile info
    try {
        $profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,locale,cover,picture', $accessToken);
        $fbUserProfile = $profileRequest->getGraphNode()->asArray();
    } catch(FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        session_destroy();
        // Redirect user back to app login page
        // header("Location: ./");
        exit;
    } catch(FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }
    
    // Initialize User class
    // $user = $profileRequest->getGraphUser();
    // $user = new User();
    
    // Insert or update user data to the database
    $fbUserData = array(
        'oauth_provider'=> 'facebook',
        'oauth_uid'     => $fbUserProfile['id'],
        'name'          => $fbUserProfile['first_name'] . ' ' . $fbUserProfile['last_name'],
        'email'         => $fbUserProfile['email'],
        'gender'        => $fbUserProfile['gender'],
        'locale'        => $fbUserProfile['locale'],
        'cover'         => $fbUserProfile['cover']['source'],
        'picture'       => $fbUserProfile['picture']['url'],
        'link'          => $fbUserProfile['link']
    );
    $responseArr['fbUserData'] = $fbUserData;
    $responseArr['fbUserProfile'] = $fbUserProfile;


        echo $fbUserProfile['id'],
        echo $fbUserProfile['first_name'] . ' ' . $fbUserProfile['last_name'],
        echo $fbUserProfile['email'],
        echo $fbUserProfile['gender'],
        echo $fbUserProfile['locale'],
        echo $fbUserProfile['cover']['source'],
        echo $fbUserProfile['picture']['url'],
        echo $fbUserProfile['link']

  require_once("../Controller/Class_User_Login_Controller.php");
  $controller = new UserLoginController();
  header('Content-Type: application/json');
  $checkUserEmail = $controller->checkUserEmail($fbUserProfile['email']);
  $checkUserEmail = json_decode($checkUserEmail, true);
  // echo "result".$checkUserEmail['result'];
  
  //For get new token  
  $getNewtoken = new getNewtoken();

  if($checkUserEmail['result'] == true){
    // $responseArr['userDetails'] = $checkUserEmail;
    $userDetailsArr = array();
    $userDetailsArr = $checkUserEmail['details'];
    // echo $userDetailsArr['name'];
    $responseArr['userId'] = $userDetailsArr['id'];
    $responseArr['userName'] = $userDetailsArr['name'];
    $responseArr['userEmail'] = $userDetailsArr['email'];
    $token = $getNewtoken->getToken($userDetailsArr['id']);
    $responseArr['token'] = $token['token'];
  } 
  else {
    //Create User Store Data
    // $responseArr['userId'] = $userData['id'];
    $fbUName = $fbUserProfile['first_name'] . ' ' . $fbUserProfile['last_name'];
    $responseArr['userName'] = $fbUName;
    $responseArr['userEmail'] = $fbUserProfile['email'];
    $isSocial = 'True';
    $socialType = 'Facebook';
    $addSocialUser = $controller->addSocialUser($fbUName, $fbUserProfile['gender'], $fbUserProfile['email'],$fbUserProfile['picture']['url'], $isSocial, $socialType);
    $addSocialUser = json_decode($addSocialUser, true);
    // $responseArr['userDetails'] = $addSocialUser;
    $responseArr['userId'] = $addSocialUser['lastId'];
    $token = $getNewtoken->getToken($addSocialUser['lastId']);
    $responseArr['token'] = $token['token'];
  }
    
}else {
      // $loginUrl = $helper->getLoginUrl();
  $loginUrl = $helper->getLoginUrl($redirect_url, $fbPermissions);
      $responseArr['result'] = True;
      $responseArr["url"] = $loginUrl;
      // header("Location: ".$loginUrl);
      // echo '<script type="text/javascript">top.location.href = "'.$loginUrl.'";</script>';
      // echo '<meta http-equiv="refresh" content="0; url="'.$loginUrl.'">';
      // echo '<script language="javascript">window.location ="'.$loginUrl.'"</script>';
    }
      exit(json_encode($responseArr,true));
?>