<?php

class ReferModel extends Model
{
	function __construct()
	{

        }
	
        function CheckFriendExists()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL='SELECT MemberId
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
        
	function ReferFriend()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $ReturnMessage='';
            $message = '';
            $InvCode = base_convert(time(), 10, 16);
            $SQL = 'INSERT INTO MemberInvites(MemberId, NewMemberName, NewMemberEmail, NewMemberCell) 
                VALUES("'.$_COOKIE['UID'].'", "'.$_REQUEST['FriendName'].'", "'.$_REQUEST['FriendEmail'].'", "'.$_REQUEST['FriendCell'].'")';
            $db->setQuery($SQL);
            $db->Query();
            $SQL='SELECT FirstName FROM Members WHERE UserId = "'.$_COOKIE['UID'].'"';
            $db->setQuery($SQL);
            
            $FirstName = $db->loadResult();
 
            $message .= "Hi ".$_REQUEST['FriendName'].", ".$FirstName." has sent you an exclusive invite to CommanderHQ.";
            $message .= "\n";
            $message .= 'A Crossfit interface, allowing you to record &amp; track your progress during &amp; after your workouts.';
            $message .= "\n";
            $message .= 'You will receive a unique code sent to you for registration after successfull verification';
            $message .= "\n";  
            $message .= '<a href="http://'.THIS_DOMAIN.'/?module=verify&Cell='.trim($_REQUEST['FriendCell']).'&Email='.trim($_REQUEST['FriendEmail']).'">VERIFY YOURSELF HERE</a>';
            $message .= "\n";
            
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

            $SMS = new SmsManager(SITE_ID, trim($_REQUEST['FriendCell']), $message, 3, 0, SMS_FROM_NUMBER, 0, null, null);
            $SmsResult = $SMS->Send(); 
            
            
                 if(!$MailResult || !$SmsResult)
                    $ReturnMessage .= 'Error Referring - Please Try again';
                else
                    $ReturnMessage .= 'Friend Successfully Referred!';           
            return $ReturnMessage;
	}
}

