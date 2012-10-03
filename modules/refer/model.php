<?php

class ReferModel extends Model
{
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
        }
	
	function ReferFriend()
	{
            $message = '';
            $InvCode = md5(time());
            $SQL = 'INSERT INTO MemberInvites(MemberId,InvitationCode,NewMemberEmail) VALUES("'.$_REQUEST['MemberId'].'","'.$InvCode.'","'.$_REQUEST['FriendEmail'].'")';
            mysql_query($SQL);
            $sql='SELECT FirstName FROM Members WHERE UserId = "'.$_REQUEST['MemberId'].'"';
            $result = mysql_query($sql);
            $row = mysql_fetch_assoc($result);
                   
                    $message .= 'Hi, Your friend '.$row['FirstName'].' thought you would like to use Commander HQ.<br/><br/>
                        Visit http://'.THIS_DOMAIN.'<br/><br/>
                            Sign up using the following Invitation Code:<br/>
                            <b>'.$InvCode.'</b>';
                      $message .= '<br/><br/>See you soon!<br/><br/>Commander support team';  

			$mail = new Rmail();
			$mail->setFrom('Commander HQ<info@be-mobile.co.za>');
			$mail->setSubject('Invitation to Commander HQ');
			$mail->setPriority('normal');
			$mail->setHTML($message);
			$mail->send(array($_REQUEST['FriendEmail']));
                        return 'Successfully referred';
	}
}

