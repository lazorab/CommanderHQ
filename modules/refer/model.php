<?php

class ReferModel extends Model
{
	function __construct()
	{

        }
	
	function ReferFriend()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $ReturnMessage='';
            $message = '';
            $InvCode = base_convert(time(), 10, 16);
            $SQL = 'INSERT INTO MemberInvites(MemberId,InvitationCode,NewMemberName,NewMemberEmail,NewMemberCell) VALUES("'.$_SESSION['UID'].'","'.$InvCode.'","'.$_REQUEST['FriendName'].'","'.$_REQUEST['FriendEmail'].'","'.$_REQUEST['FriendCell'].'")';
            $db->setQuery($SQL);
            $db->Query();
            $SQL='SELECT FirstName FROM Members WHERE UserId = "'.$_SESSION['UID'].'"';
            $db->setQuery($SQL);
            
            $FirstName = $db->loadResult();
 
            $message .= "Hi ".$_REQUEST['FriendName'].", ".$FirstName." has sent you an exclusive invite to CommanderHQ.";
            $message .= "\n";
            $message .= 'A Crossfit interface, allowing you to record &amp; track your progress during &amp; after your workouts.';
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

            if($_REQUEST['FriendEmail'] != ''){
		$mail = new Rmail();
		$mail->setFrom('Commander HQ<info@be-mobile.co.za>');
		$mail->setSubject('Invitation to Commander HQ');
		$mail->setPriority('normal');
		$mail->setHTML($message);
                $MailResult =  $mail->send(array($_REQUEST['FriendEmail']));                
            }
            
            if($_REQUEST['FriendCell'] != ''){
                $SMS = new SmsManager(SITE_ID, trim($_REQUEST['FriendCell']), $message, 3, 0, SMS_FROM_NUMBER, 0, null, null);
                $SmsResult = $SMS->Send(); 
            }
            
                 if(!$MailResult || !$SmsResult)
                    $ReturnMessage .= 'Error Referring - Please Try again';
                else
                    $ReturnMessage .= 'Friend Successfully Referred!';           
            return $ReturnMessage;
	}
}

