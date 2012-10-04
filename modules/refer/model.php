<?php

class ReferModel extends Model
{
	function __construct()
	{
		//mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		//@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
        }
	
	function ReferFriend()
	{
 		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");           
            $ReturnMessage='';
            $message = '';
            $InvCode = base_convert(time(), 10, 16);
            $SQL = 'INSERT INTO MemberInvites(MemberId,InvitationCode,NewMemberName,NewMemberEmail,NewMemberCell) VALUES("'.$_SESSION['UID'].'","'.$InvCode.'","'.$_REQUEST['FriendName'].'","'.$_REQUEST['FriendEmail'].'","'.$_REQUEST['FriendCell'].'")';
            mysql_query($SQL);
            $sql='SELECT FirstName FROM Members WHERE UserId = "'.$_SESSION['UID'].'"';
            $result = mysql_query($sql);
            $row = mysql_fetch_assoc($result);
 
            $message .= ' Hi '.$_REQUEST['FriendName'].', Your friend '.$row['FirstName'].' has sent you an exclusive invite to CommanderHQ.
<br/>
The ONLY mobile Crossfit input and tracking tool.
<br/>
CommanderHQ feeds your gym\'s WOD onto your device, so you can easily record and track your progress during and after your workouts.
<br/>
If you can\'t make it to your gym - not too worry - you can browse through benchmarks, customize your own and or map out new baseline workouts.
<br/>
We\'ve created an environment that makes it easier to track and record your progress and we hope you enjoy it.
<br/>
There\'s a lot more to it than what we\'ve introduced above, so come on in and check it out.
<br/>
Your exculsive code is <b>'.$InvCode.'</b>
<br/>   
<a href="http://'.THIS_DOMAIN.'/?module=profile">REGISTER HERE</a> - NOW
<br/>
& WIN!
<br/>
<br/>
Eat Clean - Train Dirty!
<br/>
The Commander.';

            if($_REQUEST['FriendEmail'] != ''){
		$mail = new Rmail();
		$mail->setFrom('Commander HQ<info@be-mobile.co.za>');
		$mail->setSubject('Invitation to Commander HQ');
		$mail->setPriority('normal');
		$mail->setHTML($message);
                $success =  $mail->send(array($_REQUEST['FriendEmail']));
                if($success)
                    $ReturnMessage .= 'Successfully Referred by email<br/>';
                else
                    $ReturnMessage .= 'Email failed<br/>';
            }
            
            if($_REQUEST['FriendCell'] != ''){
                $SMS = new SmsManager(SITE_ID, trim($_REQUEST['FriendCell']), $message, 3, 0, SMS_FROM_NUMBER, 0, null, null);
                $success = $SMS->Send(); 
                if($success)
                    $ReturnMessage .= 'Successfully Referred by SMS<br/>';
                else
                    $ReturnMessage .= 'SMS failed<br/>';
            }
            return $ReturnMessage;
	}
}

