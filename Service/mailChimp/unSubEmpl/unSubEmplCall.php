<?php
    header("Access-Control-Allow-Origin: *");
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once("unSubAPI.php");
    require_once(".../../../Controller/mailChimpConfig.php");
    require_once(".../../../Controller/mailChimpService.php");

	class unSubEmplCall {

        public function unSubUser($emplEmail,$emplName) {

            $mailChimpService = new MailChimpService();
            $mailChimpSubDomainInit = MailChimpConfig::$mailChimpSubDomainInit;
            $mailChimpApiKey = $mailChimpService->mailChimpApiKey = getenv("mailChimpApiKey");
            $list_id = $mailChimpService->list_id = getenv('mailChimpListId');

            $unSubAPI = new unSubAPI();
            $result = $unSubAPI->unSubscribeUser($emplEmail,$emplName,$mailChimpApiKey,$mailChimpSubDomainInit,$list_id);

            $resultArr = array();
            $resultArr = json_decode($result);
            echo $resultArr;
            echo $resultArr["status"];

            return true;

            // if ($resultArr["status"] == "unsubscribed") {
            //     return true;
            // } else{
            //     return false;
            // }

        }

    }

    


?>