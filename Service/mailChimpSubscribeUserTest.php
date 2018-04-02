<?php

require_once("../Controller/mailchimptest/mailChimpUserTest.php");
require_once("mailChimpConfig.php");


	$emplName = @$_GET['emplName'];
	$emplEmail = @$_GET['emplEmail'];

	echo ("$emplName" .$emplName);
	echo ("$empl" .$emplEmail);


	$mailChimpUserTest = new MailChimpUserTest();
    $mailChimpSubDomainInit = MailChimpConfig::$mailChimpSubDomainInit;
    $mailChimpApiKey = $mailChimpUserTest->mailChimpApiKey = getenv("mailChimpApiKey");
    $list_id = $mailChimpUserTest->list_id = getenv('mailChimpListId');


    $subUserRes = $mailChimpUserTest->subscribeUser($emplEmail,$emplName,$mailChimpApiKey,$mailChimpSubDomainInit,$list_id);

    $subUserRes = $subUserRes === NULL ? "" : $subUserRes;

    print_r($subUserRes);

    echo ("result :" .json_encode($subUserRes));



?>