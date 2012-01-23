<?php

/* * ******************************************************
Class to manage members
Copyright Be-Mobile

Created By   : Darren Hart
Created Date : 10 January 2012

Last Modified Date: 10 January 2012

*********************************************************/

class Member
{
	var $Member;
	
	function __construct($UserId)
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");

		$sql='SELECT FirstName, LastName, UserName FROM Members WHERE UserId = '.$UserId.'';
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		$this->Member = new MemberDetails($row);
	}
	
	function Details()
	{
		return $this->Member;
	}
}

class MemberDetails
{
	var $FirstName;
	var $LastName;
	var $UserName;
	var $Weight;
	var $Height;
	var $Gender;
	var $Goals;
	
	function __construct($Row)
	{
		$this->FirstName = $Row['FirstName'];
		$this->LastName = $Row['LastName'];
		$this->UserName = $Row['UserName'];
		$this->Weight = $Row['Weight'];
		$this->Height = $Row['Height'];
		$this->Gender = $Row['Gender'];
		$this->Goals = unserialize($Row['Goals']);		
	}
}

class Login
{
	var $ReturnValue;
	
	function __construct($username,$password)
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");

		$sql='SELECT UserId FROM Members WHERE UserName = "'.$username.'" AND PassWord = "'.$password.'"';
		$result = mysql_query($sql);
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_assoc($result);	
			$this->ReturnValue = $row['UserId'];
		}
		else{
			$this->ReturnValue = false;
		}
	}

	function ReturnValue()
	{
		return $this->ReturnValue;
	}
}

class Register
{
	var $ReturnValue;
	
	function __construct($Credentials)
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");

		$sql='SELECT UserId FROM Members WHERE UserName = "'.$Credentials['UserName'].'" AND PassWord = "'.$Credentials['PassWord'].'"';		
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
				DOB,
				Weight,
				Height,
				Gender,
				Goals) 
				VALUES('".$Credentials['FirstName']."',
				'".$Credentials['LastName']."',
				'".$Credentials['Cell']."',
				'".$Credentials['Email']."',
				'".$Credentials['UserName']."',
				'".$Credentials['PassWord']."',
				'".$Credentials['DOB']."',
				'".$Credentials['Weight']."',
				'".$Credentials['Height']."',
				'".$Credentials['Gender']."',
				'".$Credentials['Goals']."')";

			mysql_query($sql);
			
			$this->ReturnValue = mysql_insert_id();
		}
	}
	
	function ReturnValue()
	{
		return $this->ReturnValue;
	}
}

class Retrieval
{
	var $ReturnValue;
	
	function __construct($username,$email)
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");

		$sql='SELECT FirstName, PassWord FROM Members WHERE UserName = "'.$username.'" AND Email = "'.$email.'"';
		$result = mysql_query($sql);
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_assoc($result);
			$PassWord = $row['PassWord'];
			$Name = $row['FirstName'];
			//Send a mail to REGISTRATION_EMAIL
			$mail = new Rmail();
			$mail->setFrom('X Fit<info@be-mobile.co.za>');
			$mail->setSubject('Login Details');
			$mail->setPriority('normal');
			$mail->setText('Hi '.$Name.', Your Password for accessing X-Fit is "'.$PassWord.'"');
			$this->ReturnValue = $mail->send(array($email));
		}
		else{
			$this->ReturnValue = false;
		}
	}

	function ReturnValue()
	{
		return $this->ReturnValue;
	}
}