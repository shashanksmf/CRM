<?php
    header("Access-Control-Allow-Origin: *");
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once "unSubAPI.php";
    require_once ".../../../Controller/mailChimpConfig.php";
    require_once ".../../../Controller/mailChimpService.php";

	class unSubUser {

        public function unSubUserFun($emplEmail,$emplName) {
            $mailChimpService = new MailChimpService();
            $mailChimpSubDomainInit = MailChimpConfig::$mailChimpSubDomainInit;
            $mailChimpApiKey = $mailChimpService->mailChimpApiKey = getenv("mailChimpApiKey");
            $list_id = $mailChimpService->list_id = getenv('mailChimpListId');

            $unSubAPI = new unSubAPI();
            $result = $unSubAPI->unSubscribeUser($emplEmail,$emplName,$mailChimpApiKey,$mailChimpSubDomainInit,$list_id);
            // echo $result;

            $result = json_decode($result, true);
            $responseArr = array();
            $responseArr = $result;
            // print_r($result);
            // echo $responseArr['status'];
            // echo $responseArr['detail'];

            if ($responseArr['status'] == "unsubscribed") {
                $responseArr['status'] = true;
                return $responseArr;
            }
            else {
                $responseArr['status'] = false;
                $responseArr['reason'] = $responseArr['detail'];
                return $responseArr;
            }

        }

    }



// {
//   "id": "3b2c6602895ae53a5f677fe4835ca92f",
//   "email_address": "newName@gmail.com",
//   "unique_email_id": "0cd40eb407",
//   "email_type": "html",
//   "status": "unsubscribed",
//   "unsubscribe_reason": "N/A (Unsubscribed by admin)",
//   "merge_fields": {
//     "FNAME": "Jitu",
//     "LNAME": ""
//   },
//   "stats": {
//     "avg_open_rate": 0,
//     "avg_click_rate": 0
//   },
//   "ip_signup": "",
//   "timestamp_signup": "",
//   "ip_opt": "54.224.11.144",
//   "timestamp_opt": "2018-01-29T05:26:40+00:00",
//   "member_rating": 2,
//   "last_changed": "2018-04-03T12:22:07+00:00",
//   "language": "",
//   "vip": false,
//   "email_client": "",
//   "location": {
//     "latitude": 0,
//     "longitude": 0,
//     "gmtoff": 0,
//     "dstoff": 0,
//     "country_code": "",
//     "timezone": ""
//   },
//   "list_id": "91a2bc4140",
//   "_links": [
//     {
//       "rel": "self",
//       "href": "https://us14.api.mailchimp.com/3.0/lists/91a2bc4140/members/3b2c6602895ae53a5f677fe4835ca92f",
//       "method": "GET",
//       "targetSchema": "https://us14.api.mailchimp.com/schema/3.0/Definitions/Lists/Members/Response.json"
//     },
//     {
//       "rel": "parent",
//       "href": "https://us14.api.mailchimp.com/3.0/lists/91a2bc4140/members",
//       "method": "GET",
//       "targetSchema": "https://us14.api.mailchimp.com/schema/3.0/Definitions/Lists/Members/CollectionResponse.json",
//       "schema": "https://us14.api.mailchimp.com/schema/3.0/CollectionLinks/Lists/Members.json"
//     },
//     {
//       "rel": "update",
//       "href": "https://us14.api.mailchimp.com/3.0/lists/91a2bc4140/members/3b2c6602895ae53a5f677fe4835ca92f",
//       "method": "PATCH",
//       "targetSchema": "https://us14.api.mailchimp.com/schema/3.0/Definitions/Lists/Members/Response.json",
//       "schema": "https://us14.api.mailchimp.com/schema/3.0/Definitions/Lists/Members/PATCH.json"
//     },
//     {
//       "rel": "upsert",
//       "href": "https://us14.api.mailchimp.com/3.0/lists/91a2bc4140/members/3b2c6602895ae53a5f677fe4835ca92f",
//       "method": "PUT",
//       "targetSchema": "https://us14.api.mailchimp.com/schema/3.0/Definitions/Lists/Members/Response.json",
//       "schema": "https://us14.api.mailchimp.com/schema/3.0/Definitions/Lists/Members/PUT.json"
//     },
//     {
//       "rel": "delete",
//       "href": "https://us14.api.mailchimp.com/3.0/lists/91a2bc4140/members/3b2c6602895ae53a5f677fe4835ca92f",
//       "method": "DELETE"
//     },
//     {
//       "rel": "activity",
//       "href": "https://us14.api.mailchimp.com/3.0/lists/91a2bc4140/members/3b2c6602895ae53a5f677fe4835ca92f/activity",
//       "method": "GET",
//       "targetSchema": "https://us14.api.mailchimp.com/schema/3.0/Definitions/Lists/Members/Activity/Response.json"
//     },
//     {
//       "rel": "goals",
//       "href": "https://us14.api.mailchimp.com/3.0/lists/91a2bc4140/members/3b2c6602895ae53a5f677fe4835ca92f/goals",
//       "method": "GET",
//       "targetSchema": "https://us14.api.mailchimp.com/schema/3.0/Definitions/Lists/Members/Goals/Response.json"
//     },
//     {
//       "rel": "notes",
//       "href": "https://us14.api.mailchimp.com/3.0/lists/91a2bc4140/members/3b2c6602895ae53a5f677fe4835ca92f/notes",
//       "method": "GET",
//       "targetSchema": "https://us14.api.mailchimp.com/schema/3.0/Definitions/Lists/Members/Notes/CollectionResponse.json"
//     }
//   ]
// }


?>
