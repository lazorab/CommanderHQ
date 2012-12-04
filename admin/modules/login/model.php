<?php

/* * ******************************************************
Class to manage members
Copyright Be-Mobile

Created By   : Darren Hart
Created Date : 10 January 2012

Last Modified Date: 10 January 2012

*********************************************************/

class LoginModel extends Model
{
    function __construct()
    {

    }
	
    function Login($username,$password)
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
	$SQL='SELECT MD.GymId FROM MemberDetails MD JOIN Members M ON M.UserId = MD.MemberId
            WHERE M.UserName = "'.$username.'" AND M.PassWord = "'.$password.'"';
        $db->setQuery($SQL);
	$db->Query();
	if($db->getNumRows() > 0){	
            return $db->loadResult();
	}
	else{
            return false;
        }	
    }
}

