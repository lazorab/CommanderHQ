<?php
class RegistergymModel extends Model
{
	var $ReturnValue;
	var $Wall='';
	
	function __construct()
	{
	
	}
	
	function Register()
	{
	    mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
		$sql='SELECT * FROM RegisteredGyms WHERE GymName = "'.$_REQUEST['gymname'].'" OR URL = "'.$_REQUEST['url'].'"';
		$result = mysql_query($sql);
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_assoc($result);
			$GymId = $row['recid'];
			$message = "Gym has been added to your profile";
		}else{
			$sql="INSERT INTO RegisteredGyms(GymName,
				Country,
				Region,
				Email,
				TelNo,
				URL) 
				VALUES('".$_REQUEST['gymname']."',
				'".$_REQUEST['country']."',
				'".$_REQUEST['region']."',
				'".$_REQUEST['email']."',
				'".$_REQUEST['tel']."',
				'".$_REQUEST['url']."')";

			if(!mysql_query($sql)){
				$message = "Failed to register!";
			}
			else{
				$GymId = mysql_insert_id();
				$message = "Success";
			}
			
			$sql='Update MemberDetails
				SET GymId = "'.$GymId.'"
				WHERE MemberId = "'.$_SESSION['UID'].'"';

			mysql_query($sql);				
		}
		return $message;
	}
}
?>