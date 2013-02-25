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
 
            $message .= "Hi ".$_REQUEST['FriendName'].", Your friend ".$FirstName." has sent you an exclusive invite to CommanderHQ.";
            $message .= "\n";
            $message .= 'The ONLY mobile Crossfit input and tracking tool.';
            $message .= "\n";
            $message .= 'CommanderHQ feeds your gym\'s WOD onto your device, so you can easily record and track your progress during and after your workouts.';
            $message .= "\n";
            $message .= 'If you can\'t make it to your gym - not too worry - you can browse through benchmarks, customize your own and or map out new baseline workouts.';
            $message .= "\n";
            $message .= 'We\'ve created an environment that makes it easier to track and record your progress and we hope you enjoy it.';
            $message .= "\n";
            $message .= 'There\'s a lot more to it than what we\'ve introduced above, so come on in and check it out.';
            $message .= "\n";
            $message .= 'Your exculsive code is <b>'.$InvCode.'</b>';
            $message .= "\n";  
            $message .= '<a href="http://'.THIS_DOMAIN.'/?module=profile">REGISTER HERE</a> - NOW';
            $message .= "\n";
            $message .='& WIN!';
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

