<?php

class SignupModel extends Model
{
	function __construct()
	{

        }
	
        function CheckFriendExists()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL='SELECT NewMemberId
                FROM MemberInvites 
                WHERE NewMemberEmail = "'.$_REQUEST['FriendEmail'].'"
                OR NewMemberCell = "'.$_REQUEST['FriendCell'].'"';
            $db->setQuery($SQL);
            $db->Query();
            if($db->getNumRows() > 0)
                return true;
            else 
                return false;            
        }
        
	function Verify()
	{
            $InvCode = base_convert(time(), 10, 16);
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL='INSERT INTO MemberVerification(InvitationCode, NewMemberEmail, NewMembercell)
                VALUES("'.$InvCode.'", "'.$_REQUEST['Email'].'", "'.$_REQUEST['Cell'].'")';
            $db->setQuery($SQL);
            $db->Query();            
 
            $message .= 'Your unique code is <b>'.$InvCode.'</b>';
            $message .= "\n";  
            $message .= 'Complete your registration <a href="http://'.THIS_DOMAIN.'/?module=profile&InvCode='.$InvCode.'">HERE</a> - NOW';
            $message .= "\n";
            $message .='& STAND A CHANCE TO WIN!';
            $message .= "\n\n";
            $message .='Eat Clean - Train Dirty!';
            $message .= "\n";
            $message .='The Commander.';
            
            $MailResult = true;
            $SmsResult = true;

            if($_REQUEST['Email'] != ''){
		$mail = new Rmail();
		$mail->setFrom('Commander HQ<info@be-mobile.co.za>');
		$mail->setSubject('Verification for Commander HQ');
		$mail->setPriority('normal');
		$mail->setHTML($message);
                $MailResult =  $mail->send(array($_REQUEST['Email']));                
            }
            
            $SMS = new SmsManager(SITE_ID, trim($_REQUEST['Cell']), $message, 3, 0, SMS_FROM_NUMBER, 0, null, null);
            $SmsResult = $SMS->Send(); 
            
                 if(!$MailResult || !$SmsResult)
                    $ReturnMessage .= 'Error - Please Try again';
                else
                    $ReturnMessage .= 'Successfully Verified!';
                
            return $ReturnMessage;
	}
}

