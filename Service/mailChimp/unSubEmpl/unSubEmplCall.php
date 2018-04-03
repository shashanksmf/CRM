<?php
    header("Access-Control-Allow-Origin: *");
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once("unSubEmpl.php");
    require_once(".../../../Controller/mailChimpConfig.php");
    require_once(".../../../Controller/mailChimpService.php");

	class unSubEmplCall {

        public function unSubUser($emplEmail,$emplName) {

            $mailChimpService = new MailChimpService();
            $mailChimpSubDomainInit = MailChimpConfig::$mailChimpSubDomainInit;
            $mailChimpApiKey = $mailChimpService->mailChimpApiKey = getenv("mailChimpApiKey");
            $list_id = $mailChimpService->list_id = getenv('mailChimpListId');

            $unSubEmpl = new unSubEmpl();
            $result = $unSubEmpl->unSubscribeUser($emplEmail,$emplName,$mailChimpApiKey,$mailChimpSubDomainInit,$list_id);
            return $result;

        }

    }

    


?>