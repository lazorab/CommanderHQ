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
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
        }
	
	function RetrievePassword()
	{
            $message = '';
		$sql='SELECT FirstName, UserName, PassWord, oauth_provider FROM Members WHERE Email = "'.$_REQUEST['email'].'"';
		$result = mysql_query($sql);
                $num_rows = mysql_num_rows($result);
		if($num_rows == 1){
                    $row = mysql_fetch_assoc($result);
                    $Name = $row['FirstName'];
                    $UserName = $row['UserName'];
                    $PassWord = $row['PassWord'];
                   
                    $message .= 'Hi '.$Name.',<br/><br/>So you forgot your password?<br/>Well just to remind you again...<br/>';
                    if($row['oauth_provider'] == ''){
                        $message .= ' your Password for accessing Commander is "'.$PassWord.'"<br/>';
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
                    $i=0;
                    while($row = mysql_fetch_assoc($result))
                    {
                        $i++;
                        $Name = $row['FirstName'];
                        $UserName = $row['UserName'];
			$PassWord = $row['PassWord'];
			$method = $row['oauth_provider'];
                        if($i == 1)
                            $message .= 'Hi '.$Name.',<br/><br/>So you forgot your password?<br/>Well just to remind you again...<br/><br/>You have multiple accounts with Commander:<br/>';

                        if($method == ''){
                            $message .= '<br/>Username:'.$UserName.'<br/>';
                            $message .= 'Password:'.$PassWord.'<br/>';
                        }else if($row['oauth_provider'] == 'google'){
                            $message .= '<br/>You access Commander with your Google account<br/>';  
                        }else if($row['oauth_provider'] == 'twitter'){
                            $message .= '<br/>You access Commander with your Twitter account<br/>';
                        }else if($row['oauth_provider'] == 'facebook'){
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

