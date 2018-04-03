<?php
    header("Access-Control-Allow-Origin: *");
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once("unSubAPI.php");
    require_once(".../../../Controller/mailChimpConfig.php");
    require_once(".../../../Controller/mailChimpService.php");

	class unSubUser {

        public function unSubUserFun($emplEmail,$emplName) {

            $mailChimpService = new MailChimpService();
            $mailChimpSubDomainInit = MailChimpConfig::$mailChimpSubDomainInit;
            $mailChimpApiKey = $mailChimpService->mailChimpApiKey = getenv("mailChimpApiKey");
            $list_id = $mailChimpService->list_id = getenv('mailChimpListId');

            $unSubAPI = new unSubAPI();
            $result = $unSubAPI->unSubscribeUser($emplEmail,$emplName,$mailChimpApiKey,$mailChimpSubDomainInit,$list_id);
            echo $result;
            
            $result = json_decode($result, true);
            $responseArr = array();
            $responseArr = json_decode($result, true);
            // echo $result['status'];
            echo $responseArr['status'];
            echo $responseArr['reason'];
            
            if ($responseArr['status'] == "unsubscribed") {
                $responseArr['status'] = true;
                return $responseArr;
            } 
            else {
                $responseArr['status'] = false;
                $responseArr['reason'] = $result['status'];
                return $responseArr;
            }

        }

    }

    


?>