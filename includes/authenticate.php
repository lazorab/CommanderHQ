<?php
        session_start();
	if(!isset($_COOKIE['UID']))
	{
            if(isset($_COOKIE['Username']) && isset($_COOKIE['Password'])){
                $Username = $_COOKIE['Username'];
		$Password = $_COOKIE['Password'];
                $UserId = AutoLogin($Username, $Password);	
		if(!$UserId){
                    header('location: index.php?module=login');
		}
		else{
                    setcookie('UID', $UserId, time() + (20 * 365 * 24 * 60 * 60), '/', THIS_DOMAIN, false, false);
                }				
            }
	}				
		
	function AutoLogin($username,$password)
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
		
            $SQL='SELECT UserId FROM Members WHERE UserName = "'.$username.'" AND PassWord = "'.$password.'"';
            $db->setQuery($SQL);
            $db->Query();
            if($db->getNumRows() > 0){         	
		return $db->loadResult();
            }
            else{
		return false;
            }	
	}
?>