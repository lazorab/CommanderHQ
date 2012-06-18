<?php
class RegisterModel extends Model
{
	var $ReturnValue;
	var $Wall='';
	
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
	}
	
	function Register()
	{
		$sql='SELECT UserId FROM Members WHERE UserName = "'.$_REQUEST['username'].'" AND PassWord = "'.$_REQUEST['password'].'"';

		$result = mysql_query($sql);
		if(mysql_num_rows($result) > 0){
			$this->ReturnValue = false;
		}
		else{
			$sql="INSERT INTO Members(FirstName,
				LastName,
				Cell,
				Email,
				UserName,
				PassWord,
				SystemOfMeasure) 
				VALUES('".$_REQUEST['firstname']."',
				'".$_REQUEST['lastname']."',
				'".$_REQUEST['cell']."',
				'".$_REQUEST['email']."',
				'".$_REQUEST['username']."',
				'".$_REQUEST['password']."',
				'".$_REQUEST['system']."')";

			mysql_query($sql);
		
			$this->ReturnValue = mysql_insert_id();
			
			if($_REQUEST['system'] == 'Imperial'){
			//convert to metric for storage in db. Displaying of values will be converted back.
				$Weight = round($_REQUEST['weight'] * 0.45, 2);
				$Height = floor($_REQUEST['height'] * 2.54);
			}
			else{
				$Weight = $_REQUEST['weight'];
				$Height = $_REQUEST['height'];			
			}
			$HeightInMeters = $Height / 100;
			$BMI = floor($Weight / ($HeightInMeters * $HeightInMeters));
			
			$sql="INSERT INTO MemberDetails(
				MemberId,
				DOB,
				Weight,
				Height,
				Gender,
				BMI) 
				VALUES('".$this->ReturnValue."',
				'".$_REQUEST['DOB']."',
				'".$Weight."',
				'".$Height."',
				'".$_REQUEST['gender']."',
				'".$BMI."')";

			mysql_query($sql);				
		}
	}
	
	function ReturnValue()
	{
		return $this->ReturnValue;
	}
}
?>