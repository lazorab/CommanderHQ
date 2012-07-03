<?php

require 'dbconfig.php';

class User {
    
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
	}
    
    function checkUser($user, $oauth_provider) 
	{
        $explodedName = explode(' ', $user->name);
        $FirstName = $explodedName[0];
        $LastName= $explodedName[1];
        $query = mysql_query("SELECT *, 'memberhome' AS redirect FROM `Members` WHERE oauth_uid = '$user->id' and oauth_provider = '$oauth_provider'") or die(mysql_error());
        $result = mysql_fetch_array($query);
        if (!empty($result)) {
            # User is already present
        } else {
            #user not present. Insert a new Record
            $query = mysql_query("INSERT INTO `Members` (oauth_provider, oauth_uid, FirstName, LastName, UserName) VALUES ('$oauth_provider', $user->id, '$FirstName', '$LastName','$user->screen_name')") or die(mysql_error());
            $newUser = mysql_insert_id();
            $query = mysql_query("INSERT INTO `MemberDetails` (MemberId) VALUES ('$newUser')") or die(mysql_error());
            $query = mysql_query("SELECT *, 'edit' AS redirect FROM `Members` WHERE oauth_uid = '$user->id' and oauth_provider = '$oauth_provider'");
            $result = mysql_fetch_array($query);
            return $result;
        }
        return $result;
    }
}

?>
