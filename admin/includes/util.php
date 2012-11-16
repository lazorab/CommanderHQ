<?php

$Request = new BRequest();	

define('IMAGE_RENDER_PATH',''.THIS_ADDRESS.'images/');
//TRACKS THE REFERRALS FROM SMS LINKS
if(isset($request->get['r']))
{
    $referralID = $request->get['r'];
    $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    $SQL = 'UPDATE MemberReferral SET ClickDate = NOW() WHERE MemberReferralID = '.$referralID.'';
    $db->setQuery($SQL);
    $db->Query();
}
?>
