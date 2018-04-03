<?php
    header("Access-Control-Allow-Origin: *");
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once("mailChimpSubUserList.php");
    require_once("../../../Controller/mailChimpConfig.php");
    require_once("../../../Controller/mailChimpService.php");

	// class subUserList {

 //        public function subUserListFun() {

            $mailChimpService = new MailChimpService();
            $mailChimpSubDomainInit = MailChimpConfig::$mailChimpSubDomainInit;
            $mailChimpApiKey = $mailChimpService->mailChimpApiKey = getenv("mailChimpApiKey");
            $list_id = $mailChimpService->list_id = getenv('mailChimpListId');

            $mailChimpSubUserList = new mailChimpSubUserList();
            $result = $mailChimpSubUserList->userList($mailChimpApiKey,$mailChimpSubDomainInit,$list_id);
            // $result = json_decode($result, true);
            echo $result;
                    
    //     }

    // }





?>


