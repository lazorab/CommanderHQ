<?php
session_start();
		
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
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
		
		$sql='SELECT UserId FROM Members WHERE UserName = "'.$username.'" AND PassWord = "'.$password.'"';
		$result = mysql_query($sql);
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_assoc($result);	
			return $row['UserId'];
		}
		else{
			return false;
		}	
	}
?>