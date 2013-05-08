<?php

/* * ******************************************************
Class to manage members
Copyright Be-Mobile

Created By   : Darren Hart
Created Date : 10 January 2012

Last Modified Date: 10 January 2012

*********************************************************/

class ForgotModel extends Model
{
	function __construct()
	{

        }
	
	function RetrieveDetails()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $message = '';
            $SQL='SELECT RegUserName, UserName, PassWord FROM Affiliates WHERE RegUserEmail = "'.$_REQUEST['email'].'"';
            $db->setQuery($SQL);
            $db->Query();
            $num_rows = $db->getNumRows();
            if($num_rows == 1){
		
                $Row = $db->loadObject();
                   
                    $message .= 'Hi '.$Row->RegUserName.',<br/><br/>So you forgot your Login details?<br/>Well just to remind you again...<br/>';
                    $message .= ' Username : "'.$Row->UserName.'"<br/>';
                    $message .= ' Password : "'.$Row->PassWord.'"<br/>';
  

			//Send a mail to REGISTRATION_EMAIL
			$mail = new Rmail();
			$mail->setFrom('Commander HQ<info@be-mobile.co.za>');
			$mail->setSubject('Login Details');
			$mail->setPriority('normal');
			$mail->setHTML($message);
			$mail->send(array($_REQUEST['email']));
                        $Status = 'Success';
		}
		else{
			$Status = 'Email Address does not exist!';
		}
                return $Status;
	}
}

