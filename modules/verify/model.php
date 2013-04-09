<?php

class VerifyModel extends Model
{
	function __construct()
	{

        }
        
	function Verify()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL='SELECT UserId,
                oauth_provider,
                FirstName,
                LastName,
                UserName,
                PassWord,
                Email,
                Cell,
                VerificationCode
                FROM Members
                WHERE VericationCode = "'.$_REQUEST['code'].'"';
            $db->setQuery($SQL);
            $Member = $db->loadObject();     
            if($Member->Cell == $_REQUEST['Cell']){
                $SQL='UPDATE Members SET Verified = 1 WHERE UserId = "'.$Member->UserId.'"';
                $db->setQuery($SQL);
                $db->Query();
                setcookie('UID', $Member->UserId, time() + (20 * 365 * 24 * 60 * 60), '/', THIS_DOMAIN, false, false);
                $message = 'Successfully verified. Welcome to Commander HQ!';
                $message .= "\n";
                if($Member->oauth_provider != ''){
                    $message .= 'You have signed up using your '.$Member->oauth_provider.' profile';
                }else{
                    $message .= 'Your Username is '.$Member->UserName.'';
                    $message .= "\n";
                    $message .= 'Your Password is '.$Member->PassWord.'';
                }
		$mail = new Rmail();
		$mail->setFrom('Commander HQ<info@be-mobile.co.za>');
		$mail->setSubject('Welcome to Commander HQ');
		$mail->setPriority('normal');
		$mail->setHTML($message);
                $MailResult =  $mail->send(array($_REQUEST['Email']));                
            
            $ReturnMessage .= 'Successfully Verified!';
            }
            else{
                $ReturnMessage .= 'Incorrect Code!';
            }
                
            return $ReturnMessage;
	}
        
        function getMemberVerificationDetails()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT FirstName,
                LastName,
                UserName,
                PassWord,
                Email,
                Cell,
                VerificationCode
                FROM Members
                WHERE UserId = "'.$_REQUEST['id'].'"';
            
            $db->setQuery($SQL);
		
            return $db->loadObject();           
        }        
}

