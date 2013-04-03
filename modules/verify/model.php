<?php

class VerifyModel extends Model
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
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $ReturnMessage='';
            $message = '';
            $SQL='SELECT M.FirstName, MI.NewMemberName, MI.InvitationCode 
                FROM Members M JOIN MemberInvites MI ON MI.MemberId = M.MemberId
                WHERE NewMemberCell = "'.$_REQUEST['Cell'].'"
                AND NewMemberId = ""';
            $db->setQuery($SQL);
	$db->Query();
	if($db->getNumRows() > 0){            
            $Row = $db->loadObject();
            $FriendName = $Row->FirstName;
            $FirstName = $Row->NewMemberName;
            $InvCode = $Row->InvitationCode;
 
            $message .= "Hi ".$FirstName.", You have been successfully verified!";
            $message .= "\n";
            $message .= 'Your unique code is <b>'.$InvCode.'</b>';
            $message .= "\n";  
            $message .= '<a href="http://'.THIS_DOMAIN.'/?module=profile">REGISTER HERE</a> - NOW';
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
		$mail->setSubject('Invitation to Commander HQ');
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
        }else{
            $ReturnMessage .= 'Error - Invalid Credentials!';
        }
            return $ReturnMessage;
	}
}

