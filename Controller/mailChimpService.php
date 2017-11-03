
<?php

//$email = 'shankie1990@gmail.com';
//$first_name = 'shashankGmail';
//$last_name = 'Jaiswal';
 
$mailChimpApiKey = getenv("mailChimpApiKey"); // YOUR API KEY
 
// server name followed by a dot. 
// We use us13 because us13 is present in API KEY
$mailChimpSubDomainInit = 'us14.'; 
 
$list_id = getenv("mailChimpListId"); 

function subscribeUser($email,$first_name,$mailChimpApiKey,$mailChimpSubDomainInit,$list_id) {
   
  $auth = base64_encode( 'user:'.$mailChimpApiKey);
      
  $data = array(
      'apikey'        => $mailChimpApiKey,
      'email_address' => $email,
      'status'        => 'subscribed',
      'merge_fields'  => array(
          'FNAME' => $first_name
          )    
      );
  $json_data = json_encode($data);
   
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/lists/'.$list_id.'/members/'.md5(strtolower($email)));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
      'Authorization: Basic '.$auth));
  curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_POST, true);    
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");  
  curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
   
  $result = curl_exec($ch);
  return $result;
} 

//$subUser = subscribeUser($email,$first_name,$mailChimpApiKey,$mailChimpSubDomainInit,$list_id);
//echo $subUser;

//echo "<div>There is agap </div><br/>";


function unSubscribeUser(){
  //lowercase and md5 of email address is compulsory
//  strtolower md5
}

function readList($mailChimpSubDomainInit,$mailChimpApiKey,$list_id){

  $auth = base64_encode( 'user:'.$mailChimpApiKey);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/lists/'.$list_id.'/members/');
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
      'Authorization: Basic '.$auth));
  curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");    
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   
  $result = curl_exec($ch);
  return $result;
}

//$rl = readList($mailChimpSubDomainInit,$mailChimpApiKey,$list_id);
//echo "GAppy</br>".$rl;

function getMemberInfo($mailChimpSubDomainInit,$mailChimpApiKey,$email,$list_id){
//  echo $mailChimpSubDomainInit.$mailChimpApiKey.$email.$list_id;
  $auth = base64_encode( 'user:'.$mailChimpApiKey);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/lists/'.$list_id.'/members/'.md5(strtolower($email)));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',  
    'Authorization: Basic '.$auth));
  curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
  //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");    
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   
  $result = curl_exec($ch);
}

//$memberInfo = getMemberInfo($mailChimpSubDomainInit,$mailChimpApiKey,$email,$list_id);
//echo "member Info".$memberInfo;
//echo "<br/>".md5($email);
//$result_obj = json_decode($result);
 
function createSegment($groupName,$mailChimpSubDomainInit,$emailArr,$list_id,$mailChimpApiKey) {

  $auth = base64_encode( 'user:'.$mailChimpApiKey);
  $data = array(
    'name'        => $groupName,
    'static_segment' => $emailArr    
    );

  $json_data = json_encode($data);
  //echo $json_data;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/lists/'.$list_id.'/segments');
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',  
    'Authorization: Basic '.$auth));
  curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
  //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
  $result = curl_exec($ch); 
}

//$emailArr = array('shankie1990@gmail.com');
//$groupName = "USA-GDP";
//$createSeg = createSegment($groupName,$mailChimpSubDomainInit,$emailArr,$list_id,$mailChimpApiKey);
//echo "createsergment".$createSeg;

function getAllSegments($mailChimpSubDomainInit,$list_id,$mailChimpApiKey) {

  $auth = base64_encode( 'user:'.$mailChimpApiKey);
  
  //$json_data = json_encode($data);
  //echo $json_data;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/lists/'.$list_id.'/segments');
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',  
    'Authorization: Basic '.$auth));
  curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
  //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");    
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//  curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
  $result = curl_exec($ch); 
}

//$getSegments = getAllSegments($mailChimpSubDomainInit,$list_id,$mailChimpApiKey);
//echo "segments: ".$getSegments;

function addBulkMembersToSegment($membersArr,$segmentId,$list_id,$mailChimpApiKey,$mailChimpSubDomainInit) {
  //echo json_encode($membersArr)."/".$segmentId."/".$list_id."/".$mailChimpApiKey.$mailChimpSubDomainInit;
  $auth = base64_encode( 'user:'.$mailChimpApiKey);
  $data = array(
      'members_to_add' => $membersArr  
    );
  $json_data = json_encode($data);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/lists/'.$list_id.'/segments/'.$segmentId);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',  
    'Authorization: Basic '.$auth));
  curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
  //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
  $result = curl_exec($ch);

}

//$membersArr = array('shankie1990','shashanksmf@outlook.com');
//$bulkMembersAddReq = addBulkMembersToSegment($membersArr,'29009',$list_id,$mailChimpApiKey,$mailChimpSubDomainInit);
//echo $bulkMembersAddReq;

function removeBulkMembersFromSegment($removeMemArr,$segmentId,$list_id,$mailChimpApiKey,$mailChimpSubDomainInit){
  $auth = base64_encode( 'user:'.$mailChimpApiKey);
  $data = array(
      'members_to_remove' => $removeMemArr
    );
  $json_data = json_encode($data);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/lists/'.$list_id.'/segments/'.$segmentId);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',  
    'Authorization: Basic '.$auth));
  curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
  //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
  $result = curl_exec($ch);
}

//$removeMemArr = array('shankie1990@gmail.com');
//$bulkMembersRemoveReq = removeBulkMembersFromSegment($removeMemArr,'29009',$list_id,$mailChimpApiKey,$mailChimpSubDomainInit);
//echo $bulkMembersRemoveReq;

ob_start();
?>
<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Simple Transactional Email</title>
    <style>
      /* -------------------------------------
          GLOBAL RESETS
      ------------------------------------- */
      img {
        border: none;
        -ms-interpolation-mode: bicubic;
        max-width: 100%; }

      body {
        background-color: #f6f6f6;
        font-family: sans-serif;
        -webkit-font-smoothing: antialiased;
        font-size: 14px;
        line-height: 1.4;
        margin: 0;
        padding: 0; 
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%; }

      table {
        border-collapse: separate;
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
        width: 100%; }
        table td {
          font-family: sans-serif;
          font-size: 14px;
          vertical-align: top; }

      /* -------------------------------------
          BODY & CONTAINER
      ------------------------------------- */

      .body {
        background-color: #f6f6f6;
        width: 100%; }

      /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
      .container {
        display: block;
        Margin: 0 auto !important;
        /* makes it centered */
        max-width: 580px;
        padding: 10px;
        width: 580px; }

      /* This should also be a block element, so that it will fill 100% of the .container */
      .content {
        box-sizing: border-box;
        display: block;
        Margin: 0 auto;
        max-width: 580px;
        padding: 10px; }

      /* -------------------------------------
          HEADER, FOOTER, MAIN
      ------------------------------------- */
      .main {
        background: #fff;
        border-radius: 3px;
        width: 100%; }

      .wrapper {
        box-sizing: border-box;
        padding: 20px; }

      .footer {
        clear: both;
        padding-top: 10px;
        text-align: center;
        width: 100%; }
        .footer td,
        .footer p,
        .footer span,
        .footer a {
          color: #999999;
          font-size: 12px;
          text-align: center; }

      /* -------------------------------------
          TYPOGRAPHY
      ------------------------------------- */
      h1,
      h2,
      h3,
      h4 {
        color: #000000;
        font-family: sans-serif;
        font-weight: 400;
        line-height: 1.4;
        margin: 0;
        Margin-bottom: 30px; }

      h1 {
        font-size: 35px;
        font-weight: 300;
        text-align: center;
        text-transform: capitalize; }

      p,
      ul,
      ol {
        font-family: sans-serif;
        font-size: 14px;
        font-weight: normal;
        margin: 0;
        Margin-bottom: 15px; }
        p li,
        ul li,
        ol li {
          list-style-position: inside;
          margin-left: 5px; }

      a {
        color: #3498db;
        text-decoration: underline; }

      /* -------------------------------------
          BUTTONS
      ------------------------------------- */
      .btn {
        box-sizing: border-box;
        width: 100%; }
        .btn > tbody > tr > td {
          padding-bottom: 15px; }
        .btn table {
          width: auto; }
        .btn table td {
          background-color: #ffffff;
          border-radius: 5px;
          text-align: center; }
        .btn a {
          background-color: #ffffff;
          border: solid 1px #3498db;
          border-radius: 5px;
          box-sizing: border-box;
          color: #3498db;
          cursor: pointer;
          display: inline-block;
          font-size: 14px;
          font-weight: bold;
          margin: 0;
          padding: 12px 25px;
          text-decoration: none;
          text-transform: capitalize; }

      .btn-primary table td {
        background-color: #3498db; }

      .btn-primary a {
        background-color: #3498db;
        border-color: #3498db;
        color: #ffffff; }

      /* -------------------------------------
          OTHER STYLES THAT MIGHT BE USEFUL
      ------------------------------------- */
      .last {
        margin-bottom: 0; }

      .first {
        margin-top: 0; }

      .align-center {
        text-align: center; }

      .align-right {
        text-align: right; }

      .align-left {
        text-align: left; }

      .clear {
        clear: both; }

      .mt0 {
        margin-top: 0; }

      .mb0 {
        margin-bottom: 0; }

      .preheader {
        color: transparent;
        display: none;
        height: 0;
        max-height: 0;
        max-width: 0;
        opacity: 0;
        overflow: hidden;
        mso-hide: all;
        visibility: hidden;
        width: 0; }

      .powered-by a {
        text-decoration: none; }

      hr {
        border: 0;
        border-bottom: 1px solid #f6f6f6;
        Margin: 20px 0; }

      /* -------------------------------------
          RESPONSIVE AND MOBILE FRIENDLY STYLES
      ------------------------------------- */
      @media only screen and (max-width: 620px) {
        table[class=body] h1 {
          font-size: 28px !important;
          margin-bottom: 10px !important; }
        table[class=body] p,
        table[class=body] ul,
        table[class=body] ol,
        table[class=body] td,
        table[class=body] span,
        table[class=body] a {
          font-size: 16px !important; }
        table[class=body] .wrapper,
        table[class=body] .article {
          padding: 10px !important; }
        table[class=body] .content {
          padding: 0 !important; }
        table[class=body] .container {
          padding: 0 !important;
          width: 100% !important; }
        table[class=body] .main {
          border-left-width: 0 !important;
          border-radius: 0 !important;
          border-right-width: 0 !important; }
        table[class=body] .btn table {
          width: 100% !important; }
        table[class=body] .btn a {
          width: 100% !important; }
        table[class=body] .img-responsive {
          height: auto !important;
          max-width: 100% !important;
          width: auto !important; }}

      /* -------------------------------------
          PRESERVE THESE STYLES IN THE HEAD
      ------------------------------------- */
      @media all {
        .ExternalClass {
          width: 100%; }
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
          line-height: 100%; }
        .apple-link a {
          color: inherit !important;
          font-family: inherit !important;
          font-size: inherit !important;
          font-weight: inherit !important;
          line-height: inherit !important;
          text-decoration: none !important; } 
        .btn-primary table td:hover {
          background-color: #34495e !important; }
        .btn-primary a:hover {
          background-color: #34495e !important;
          border-color: #34495e !important; } }

    </style>
  </head>
  <body class="">
    <table border="0" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <td>&nbsp;</td>
        <td class="container">
          <div class="content">

            <!-- START CENTERED WHITE CONTAINER -->
            <span class="preheader">This is preheader text. Some clients will show this text as a preview.</span>
            <table class="main">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper">
                  <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td>
                        <p>*|FNAME|*,</p>
                        <p>Sometimes you just want to send a simple HTML email with a simple design and clear call to action. This is it.</p>
            <p>*|MC_PREVIEW_TEXT|*</p>
                        <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                          <tbody>
                            <tr>
                              <td align="left">
                                <table border="0" cellpadding="0" cellspacing="0">
                                  <tbody>
                                    <tr>
                                      <td> <a href="http://htmlemail.io" target="_blank">Call To Action</a> </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <p>ADDBODYHERE</p>
                        <p>Good luck! Hope it works.</p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>

              <!-- END MAIN CONTENT AREA -->
              </table>

            <!-- START FOOTER -->
            <div class="footer">
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="content-block">
                    <span class="apple-link">Company Inc, 3 Abbey Road, San Francisco CA 94102</span>
                    <br> Dont like these emails? <a href="http://i.imgur.com/CScmqnj.gif">Unsubscribe</a>.
                  </td>
                </tr>
                <tr>
                  <td class="content-block powered-by">
                    Powered by <a href="http://htmlemail.io">HTMLemail</a>.
                  </td>
                </tr>
              </table>
            </div>

            <!-- END FOOTER -->
            
<!-- END CENTERED WHITE CONTAINER --></div>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </body>
</html>
<?php
$htmlStr = ob_get_clean();
//echo $htmlStr;
 ob_flush();

function createTemplate($htmlStr,$mailChimpSubDomainInit,$mailChimpApiKey){

  $auth = base64_encode( 'user:'.$mailChimpApiKey);
  $data = array(
      'name' => 'basic-template',
      'html' => $htmlStr
    );

  $json_data = json_encode($data);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/templates');
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',  
    'Authorization: Basic '.$auth));
  curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
  //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
  $result = curl_exec($ch);
}

//$createTemReq = createTemplate($htmlStr,$mailChimpSubDomainInit,$mailChimpApiKey);
//echo $createTemReq;

function createCampaign($mailChimpSubDomainInit,$mailChimpApiKey,$list_id,$segmentId) { 

  $auth = base64_encode( 'user:'.$mailChimpApiKey);
  $data = array(
      'type' => 'plaintext',
      'recipients' => array( 
        'list_id' => $list_id,
        'segment_opts' => array(
            'saved_segment_id' => $segmentId
          )
       ),
      'settings' => array(
          'subject_line' => 'Sample Subject Line',
          'preview_text'=>'this is the Preview Text',
          'title' => 'Sample Title',
          'from_name' => 'Admin Raffia',
          'reply_to' => 'info@raffia.co',
          'to_name' => 'User',
          'template_id' => 104033
        )
    );

  $json_data = json_encode($data);
  //echo $json_data;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/campaigns');
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',  
    'Authorization: Basic '.$auth));
  curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
  //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
  $result = curl_exec($ch);

}

//$segmentId = 29009;
//$createCamReq = createCampaign($mailChimpSubDomainInit,$mailChimpApiKey,$list_id,$segmentId);
//echo $createCamReq;

function getAllCampaigns($mailChimpSubDomainInit,$mailChimpApiKey) {
  $auth = base64_encode( 'user:'.$mailChimpApiKey);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/campaigns');
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',  
    'Authorization: Basic '.$auth));
  curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
  //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");    
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//  curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
  $result = curl_exec($ch);

}

//$getAllCampaignReq = getAllCampaigns($mailChimpSubDomainInit,$mailChimpApiKey);
//echo $getAllCampaignReq;

function runCampaign($mailChimpSubDomainInit,$mailChimpApiKey,$campaignId){
  //echo $mailChimpSubDomainInit."/".$mailChimpApiKey."/".$campaignId;
  $auth = base64_encode( 'user:'.$mailChimpApiKey);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/campaigns/'.$campaignId.'/actions/send');
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',  
    'Authorization: Basic '.$auth));
  curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
  //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//  curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
  $result = curl_exec($ch);

}

//$campaignId = '08c993f8cb';
//$runCampaignReq = runCampaign($mailChimpSubDomainInit,$mailChimpApiKey,$campaignId);
//echo $runCampaignReq;

?>

