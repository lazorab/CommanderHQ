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
		$mail = new Rmail();
		$mail->setFrom('Commander HQ<info@be-mobile.co.za>');
		$mail->setSubject('Welcom to Commander HQ');
		$mail->setPriority('normal');
		$mail->setHTML($message);
                $MailResult =  $mail->send(array($_REQUEST['Email']));                
            
            
            $SMS = new SmsManager(SITE_ID, trim($_REQUEST['Cell']), $message, 3, 0, SMS_FROM_NUMBER, 0, null, null);
            $SmsResult = $SMS->Send(); 
            
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

