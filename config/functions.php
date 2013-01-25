<?php
require_once('/Sites/framework/general/databasemanager.class.php');
require_once('dbconfig.php');

class User {
    
    function __construct()
    {

    }
    
    function checkUser($user, $oauth_provider) 
	{
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        session_start();
        $explodedName = explode(' ', $user->name);
        $FirstName = $explodedName[0];
        $LastName= $explodedName[1];
        $SQL = "SELECT *, 'memberhome' AS redirect FROM `Members` WHERE oauth_uid = '$user->id' and oauth_provider = '$oauth_provider'";
        $db->setQuery($SQL);
	$db->Query();
	if($db->getNumRows() > 0){	
            $Row = $db->loadObject();
            $_SESSION['UID'] = $Row->UserId;
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
            }else if($oauth_provider == 'google'){
                $UserName = $user->email;
                if($user->gender == 'male')
                    $Gender = 'M';
                else if($user->gender == 'female')
                    $Gender = 'F';
            }
            $SQL = "INSERT INTO `Members` (oauth_provider, oauth_uid, FirstName, LastName, UserName) VALUES ('$oauth_provider', $user->id, '$FirstName', '$LastName','$UserName')";
            $db->setQuery($SQL);
            $db->Query();
            $NewId = $db->insertid();
            $SQL = "INSERT INTO `MemberDetails` (MemberId, Gender) VALUES ('$NewId', '$Gender')";
            $db->setQuery($SQL);
            $db->Query();
            $SQL = "SELECT *, 'profile' AS redirect FROM `Members` WHERE oauth_uid = '$user->id' and oauth_provider = '$oauth_provider'";
            $db->setQuery($SQL);
            $Row = $db->loadObject();

            $_SESSION['NEW_USER'] = $Row->UserId;
        }
        return $Row;
    }
}

?>
