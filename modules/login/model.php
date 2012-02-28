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
	
	function RetrievePassword($username,$email)
	{
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
			$mail->send(array($email));
		}
		else{
			return false;
		}
	}
}

