<?php
/********************************************************
File to call any utility functions that need to be called 
per request
Copyright Be-Mobile

Created By   : Brett Spence
Created Date : 9 July 2008

Last Modified Date: 9 July 2008

*********************************************************/
//TODO: Add session mamagement here
//      Needs to happen before the clickstream casue we need to know who he is

//Member Management
//$member = new member($_COOKIE['BeMobileUserId_'.SITE_ID]);

//CREATE THE REQUEST
$request = new BRequest();	

//TRACKS THE REFERRALS FROM SMS LINKS
if(isset($request->get['r']))
{
	$db = new BData(array('host'=>DB_SERVER,'user'=>DB_USERNAME,'password'=>DB_PASSWORD,'database'=>DB_DATABASE));
	$db->Query( 'CALL Proc_MemberReferralLogClick("'.$request->get['r'].'")' );
}
?>
