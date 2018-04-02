<?php

require_once("../Controller/mailchimptest/mailChimpUserTest.php");
require_once("mailChimpConfig.php");

	$mailChimpUserTest = new MailChimpUserTest();
    $mailChimpSubDomainInit = MailChimpConfig::$mailChimpSubDomainInit;
    $mailChimpApiKey = $mailChimpUserTest->mailChimpApiKey = getenv("mailChimpApiKey");
    $list_id = $mailChimpUserTest->list_id = getenv('mailChimpListId');


    $subUserRes = $mailChimpUserTest->subscribeUser("shashanksmf@outlook.com", "Campaign test",$mailChimpApiKey,$mailChimpSubDomainInit,$list_id);

    $subUserRes = $subUserRes === NULL ? "" : $subUserRes;

    echo ("result :" .json_decode($subUserRes));



?>