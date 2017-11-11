<?php
header("Access-Control-Allow-Origin: *");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StaticDBCon
 *
 
 * @author SEARCH
 */
class MailChimpConfig {
    
    public $mailChimpApiKey = getenv("mailChimpApiKey");
    public static $mailChimpSubDomainInit = 'us14.';
    public static $list_id = getenv('mailChimpListId');

    public static $emailFromName = "Admin Raffia";
    public static $emailReplyTo = "info@raffia.co";
    public static $emailToName = "";
    public static $emailTemplateId = "105465";

}
