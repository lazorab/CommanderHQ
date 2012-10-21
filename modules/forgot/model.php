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
	
	function RetrievePassword()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $message = '';
            $SQL='SELECT FirstName, UserName, PassWord, oauth_provider FROM Members WHERE Email = "'.$_REQUEST['email'].'"';
            $db->setQuery($SQL);
            $db->Query();
            $num_rows = $db->getNumRows();
            if($num_rows == 1){
		
                $Row = $db->loadObject();
                   
                    $message .= 'Hi '.$Row->FirstName.',<br/><br/>So you forgot your password?<br/>Well just to remind you again...<br/>';
                    if($row['oauth_provider'] == ''){
                        $message .= ' your Password for accessing Commander is "'.$Row->PassWord.'"<br/>';
                    }else if($row['oauth_provider'] == 'google'){
                        $message .= ' you access Commander with your Google account<br/>';  
                    }else if($row['oauth_provider'] == 'twitter'){
                        $message .= ' you access Commander with your Twitter account<br/>';
                    }else if($row['oauth_provider'] == 'facebook'){
                        $message .= ' you access Commander with your Facebook account<br/>';
                    }
                      $message .= '<br/><br/>Train hard!<br/><br/>Commander support team';  

			//Send a mail to REGISTRATION_EMAIL
			$mail = new Rmail();
			$mail->setFrom('Commander HQ<info@be-mobile.co.za>');
			$mail->setSubject('Login Details');
			$mail->setPriority('normal');
			$mail->setHTML($message);
			$mail->send(array($_REQUEST['email']));
                        return 'Success';
		}
                else if($num_rows > 1){
                    $Rows = $db->loadObjectList();
                    $i=0;
                    foreach($Rows AS $Row)
                    {
                        $i++;
                        if($i == 1)
                            $message .= 'Hi '.$Row->FirstName.',<br/><br/>So you forgot your password?<br/>Well just to remind you again...<br/><br/>You have multiple accounts with Commander:<br/>';

                        if($Row->oauth_provider == ''){
                            $message .= '<br/>Username:'.$Row->UserName.'<br/>';
                            $message .= 'Password:'.$Row->PassWord.'<br/>';
                        }else if($Row->oauth_provider == 'google'){
                            $message .= '<br/>You access Commander with your Google account<br/>';  
                        }else if($Row->oauth_provider == 'twitter'){
                            $message .= '<br/>You access Commander with your Twitter account<br/>';
                        }else if($Row->oauth_provider == 'facebook'){
                            $message .= '<br/>You access Commander with your Facebook account<br/>';
                        }
                    }
                    $message .= '<br/><br/>Train hard!<br/><br/>Commander support team';  
                        //Send a mail to REGISTRATION_EMAIL
			$mail = new Rmail();
			$mail->setFrom('Commander HQ<info@be-mobile.co.za>');
			$mail->setSubject('Login Details');
			$mail->setPriority('normal');
			$mail->setHTML($message);
			$mail->send(array($_REQUEST['email']));
                        return 'Success';
                }
		else{
			return 'Email Address does not exist!';
		}
	}
}

