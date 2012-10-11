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
	mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
	@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
    }
	
    function Login($username,$password)
    {
	$sql='SELECT MD.GymId FROM MemberDetails MD
              JOIN Members M ON M.UserId = MD.MemberId
              WHERE M.UserName = "'.$username.'" AND M.PassWord = "'.$password.'"';
	$result = mysql_query($sql);
	if(mysql_num_rows($result) > 0){
            $row = mysql_fetch_assoc($result);	
            return $row['GymId'];
	}
	else{
            return false;
        }	
    }
    
    function checkUser($uid, $oauth_provider, $username) 
    {
        $query = mysql_query("SELECT * FROM `Members` WHERE oauth_uid = '$uid' and oauth_provider = '$oauth_provider'") or die(mysql_error());
        $result = mysql_fetch_array($query);
        if (!empty($result)) {
            # User is already present
        } else {
            #user not present. Insert a new Record
            $query = mysql_query("INSERT INTO `Members` (oauth_provider, oauth_uid, username) VALUES ('$oauth_provider', $uid, '$username')") or die(mysql_error());
            $query = mysql_query("SELECT * FROM `Members` WHERE oauth_uid = '$uid' and oauth_provider = '$oauth_provider'");
            $result = mysql_fetch_array($query);
            return $result;
        }
        return $result;
    }
}

