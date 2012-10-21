<?php
	if(!isset($_SESSION['UID']))
	{
            if(isset($_COOKIE['CommanderUsername']) && isset($_COOKIE['CommanderPassword'])){
                $Username = $_COOKIE['CommanderUsername'];
		$Password = $_COOKIE['CommanderPassword'];
                $UserId = AutoLogin($Username, $Password);	
		if(!$UserId){
                    header('location: index.php?module=login');
		}
		else{			
                    $_SESSION['UID'] = $UserId;
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