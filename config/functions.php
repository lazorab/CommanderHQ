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
        session_start();
        $explodedName = explode(' ', $user->name);
        $FirstName = $explodedName[0];
        $LastName= $explodedName[1];
        $Sql = "SELECT *, 'memberhome' AS redirect FROM `Members` WHERE oauth_uid = '$user->id' and oauth_provider = '$oauth_provider'";
        //echo $Sql;
        $query = mysql_query($Sql) or die(mysql_error());
        $result = mysql_fetch_array($query);
        if (!empty($result)) {
            $_SESSION['UID'] = $result['UserId'];
            $_SESSION['FirstName'] = $result['FirstName'];
        } else {
            $Gender = '';
            #user not present. Insert a new Record
            if($oauth_provider == 'twitter'){
                $UserName = $user->screen_name;
            }else if($oauth_provider == 'facebook'){
                $UserName = $user->username;
                if($user->gender == 'male')
                    $Gender = 'M';
                else if($user->gender == 'female')
                    $Gender = 'F';
            }
            $Sql = "INSERT INTO `Members` (oauth_provider, oauth_uid, FirstName, LastName, UserName) VALUES ('$oauth_provider', $user->id, '$FirstName', '$LastName','$UserName')";
            //echo $Sql;
            $query = mysql_query($Sql) or die(mysql_error());
            $newUser = mysql_insert_id();
            $Sql = "INSERT INTO `MemberDetails` (MemberId, Gender) VALUES ('$newUser', '$Gender')";
            //echo $Sql;
            $query = mysql_query($Sql) or die(mysql_error());
            $Sql = "SELECT *, 'profile' AS redirect FROM `Members` WHERE oauth_uid = '$user->id' and oauth_provider = '$oauth_provider'";
            //echo $Sql;
            $query = mysql_query($Sql);
            $result = mysql_fetch_array($query);

            $_SESSION['NEW'] = $result['UserId'];
            $_SESSION['FirstName'] = $result['FirstName'];
            return $result;
        }
        return $result;
    }
}

?>
