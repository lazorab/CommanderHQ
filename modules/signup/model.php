<?php

class SignupModel extends Model
{
	function __construct()
	{

        }
        
	function Signup()
	{
            $Code = base_convert(time(), 10, 16);
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            if(isset($_SESSION['NEW_USER'])){
                $Id = $_SESSION['NEW_USER'];
            }else{
                $SQL='INSERT INTO Members(VerificationCode, FirstName, LastName, UserName, Password, Email, Cell)
                VALUES("'.$Code.'", , "'.$_REQUEST['FirstName'].'", "'.$_REQUEST['LastName'].'", "'.$_REQUEST['UserName'].'", "'.$_REQUEST['Password'].'""'.$_REQUEST['Email'].'", "'.$_REQUEST['Cell'].'")';
                $db->setQuery($SQL);
                $db->Query();            
                $Id = $db->insertid();
            }
            $message .= 'Your verification code for Commander is <b>'.$Code.'</b>';
            $message .= "\n";  
            $message .= 'Complete your registration <a href="http://'.THIS_DOMAIN.'/?module=verify&id='.$Id.'">HERE</a>';
            
            $MailResult = true;
            $SmsResult = true;

            $mail = new Rmail();
            $mail->setFrom('Commander HQ<info@be-mobile.co.za>');
            $mail->setSubject('Signup for Commander HQ');
            $mail->setPriority('normal');
            $mail->setHTML($message);
            $MailResult =  $mail->send(array($_REQUEST['Email']));                
            
            $SMS = new SmsManager(SITE_ID, trim($_REQUEST['Cell']), $message, 3, 0, SMS_FROM_NUMBER, 0, null, null);
            $SmsResult = $SMS->Send(); 
            
                 if(!$MailResult || !$SmsResult)
                    $ReturnMessage .= 'Error - Please Try again';
                else
                    $ReturnMessage .= 'Successfully Verified!';
                
            return $ReturnMessage;
	}
        
        function setMemberDetails()
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
                WHERE UserId = "'.$_SESSION['NEW_USER'].'"';
            
            $db->setQuery($SQL);
		
            $Member = $db->loadObject();           
            $_REQUEST['FirstName'] = $Member->FirstName;
            $_REQUEST['LastName'] = $Member->LastName;
            $_REQUEST['UserName'] = $Member->UserName;
        }        
}

