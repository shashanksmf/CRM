<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');
header('Access-Control-Allow-Methods: GET');


error_reporting(E_ALL);
ini_set('display_errors', '1');

if(!session_id()){
    session_start();
}

// Include the autoloader provided in the SDK
require_once 'autoload.php';

// Include required libraries
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

/*
 * Configuration and setup Facebook SDK
 */
$appId         = '1827896904180275'; //Facebook App ID
$appSecret     = 'e0407be9cc41abcb26207d8d46328118'; //Facebook App Secret
$redirectURL   = 'https://' . $_SERVER['HTTP_HOST'] .'/Service/fbAuth/fbconfig.php'; //Callback URL
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
        $profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,locale,cover,picture');
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
    $user = new User();
    
    // Insert or update user data to the database
    $fbUserData = array(
        'oauth_provider'=> 'facebook',
        'oauth_uid'     => $fbUserProfile['id'],
        'first_name'    => $fbUserProfile['first_name'],
        'last_name'     => $fbUserProfile['last_name'],
        'email'         => $fbUserProfile['email'],
        'gender'        => $fbUserProfile['gender'],
        'locale'        => $fbUserProfile['locale'],
        'cover'         => $fbUserProfile['cover']['source'],
        'picture'       => $fbUserProfile['picture']['url'],
        'link'          => $fbUserProfile['link']
    );
    $userData = $user->checkUser($fbUserData);
    
    // Put user data into session
    $_SESSION['userData'] = $userData;
    $responseArr['userData'] = $userData;
    
    // Get logout url
    // $logoutURL = $helper->getLogoutUrl($accessToken, $redirectURL.'logout.php');
    
    
    
}else {
      // $loginUrl = $helper->getLoginUrl();
      $loginUrl = $helper->getLoginUrl($redirectURL, $fbPermissions);
      $responseArr['result'] = True;
      $responseArr["url"] = $loginUrl;
      // header("Location: ".$loginUrl);
      // echo '<script type="text/javascript">top.location.href = "'.$loginUrl.'";</script>';
      // echo '<meta http-equiv="refresh" content="0; url="'.$loginUrl.'">';
      // echo '<script language="javascript">window.location ="'.$loginUrl.'"</script>';
    }
      exit(json_encode($responseArr,true));

// session_start();
// require_once 'autoload.php';
// use Facebook\FacebookSession;
// use Facebook\FacebookRedirectLoginHelper;
// use Facebook\FacebookRequest;
// use Facebook\FacebookResponse;
// use Facebook\FacebookSDKException;
// use Facebook\FacebookRequestException;
// use Facebook\FacebookAuthorizationException;
// use Facebook\GraphObject;
// use Facebook\Entities\AccessToken;
// use Facebook\HttpClients\FacebookCurlHttpClient;
// use Facebook\HttpClients\FacebookHttpable;
// // init app with app id and secret
// FacebookSession::setDefaultApplication( '1827896904180275','e0407be9cc41abcb26207d8d46328118' );
// // login helper with redirect_uri
// // $redirect_url = "https://upsailgroup.herokuapp.com/";
// $redirect_url = 'https://' . $_SERVER['HTTP_HOST'] .'/fbAuth/fbconfig.php/';
// $helper = new FacebookRedirectLoginHelper($redirect_url);

// try {
//   $session = $helper->getSessionFromRedirect();
// } catch( FacebookRequestException $ex ) {
//   // When Facebook returns an error
//   echo "<br> FaceExpexption => " . $ex;
// } catch( Exception $ex ) {
//   // When validation fails or other local issues
//   echo "<br> Expexption => " . $ex;
// }
// $responseArr = array();
// // see if we have a session
// if ( isset( $session ) ) {
//   // graph api request for user data
//   $request = new FacebookRequest( $session, 'GET', '/me' );
//   $response = $request->execute();
//   // get response
//   $graphObject = $response->getGraphObject();
//       $fbid = $graphObject->getProperty('id');              // To Get Facebook ID
//       $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
//       $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
//       /* ---- Session Variables -----*/
//       $_SESSION['FBID'] = $fbid;           
//       $_SESSION['FULLNAME'] = $fbfullname;
//       $_SESSION['EMAIL'] =  $femail;

//       $responseArr['result'] = False;
//       $responseArr['fbid'] = $fbid;
//       $responseArr['fbfullname'] = $fbfullname;
//       $responseArr["femail"] = $femail;
//       $responseArr["url"] = 'https://' . $_SERVER['HTTP_HOST'] .'/Service/fbAuth/index.php';
//       /* ---- header location after session ----*/
//       echo json_encode($responseArr);
//       // header("Location: ".'https://' . $_SERVER['HTTP_HOST']);
//       exit;
//     } else {
//       $loginUrl = $helper->getLoginUrl();
//       // echo "$loginUrl".$loginUrl;
//       $responseArr['result'] = True;
//       $responseArr["url"] = $loginUrl;
//       /* ---- header location after session ----*/
//       echo json_encode($responseArr);
//       // header("Location: ".$loginUrl);
//       // echo '<script type="text/javascript">top.location.href = "'.$loginUrl.'";</script>';
//       // echo '<meta http-equiv="refresh" content="0; url="'.$loginUrl.'">';
//       // echo '<script language="javascript">window.location ="'.$loginUrl.'"</script>';
//       exit;
//     }
?>