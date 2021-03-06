<?php
ob_start();
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, token, Host');

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "./phpHeader/getHeader.php";

$headers = apache_request_headers();
require_once "./token/validateToken.php";

require('../libs/mandril/Mandrill.php');
require('../Controller/Class_Group_Controller.php');
require('../Controller/Class_Campaign_Controller.php');
require ('../Controller/Class_Template_Controller.php');
require ('../Controller/EmailMgr.php');


$listAdd = "";
$userAdd = "";
$templAdd = "";
$campaignAdd = "";
$runCampaigns = "";

$listId = "";
$campainsId = "";

$body = $_POST['body'];
$fromName = $_POST['fromName'];
$fromEmail = $_POST['fromEmail'];
$subject = $_POST['subject'];
$templateId = $_POST['templateId'];
$groupId = $_POST['groupId'];

$emlMgr = new EmailMgr();
$emlMgr->apiKey = getenv("mailChimpApiKey");
$resAr = array();
$camps = new CampaignController();

$template = "";
$templateC = new TemplateController();
$template = $templateC->getTemplateList($templateId)[0]->html;


$grp = new GroupController();
$list = $grp->getGroupList($groupId);



$empls = $grp->getUserList($list[0]->getMembers());



$template = str_replace("CHANGETHISNAME", "*|FNAME|*", $template);
$template = str_replace("ADDBODYHERE", $body, $template);


     //  $listAdd = $emlMgr->addList($list[0]->getName());

$jsonRespListAdds = json_decode($listAdd);

$listId = 'd0a4dda674';
      // echo "List Id ; ".$listId;


$coutEmp = count($empls);
foreach($empls as $empl) {
          // echo 'Email '.$empl->getEmail();

  $emlMgr->addMebmberToList($empl->getEmail(), $listId, $empl->getName(),$empl->getName());
       //$emlMgr->addMebmberToList($empl->getEmail(), $listId, $empl->getName(),$empl->getName());
  $coutEmp --;
}




$campaignAdd = $emlMgr->addCampaign($fromEmail, $listId, $fromName, $subject);
$campaignId = json_decode($campaignAdd)->id;
$templAdd = $emlMgr->updateHtmlToCampaign($campaignId, $template);



     //   echo "Campaign Id ; ".$campaignId;

       // print_r($resAr);
$jsonStr = '{"responce":true;"campaignId":"'
. $campaignId
. '","listId":"'
. $listId
. '"}';
header('Content-Type: application/json');
ob_clean();
echo $jsonStr;

?>
