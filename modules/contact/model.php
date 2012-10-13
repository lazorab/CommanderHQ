<?php
class ContactModel extends Model
{

	function __Construct()
        {
            
        }
        
        function SendForm()
        {
            mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
            @mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
            $sql='SELECT FirstName, LastName, Email FROM Members WHERE UserId = "'.$_SESSION['UID'].'"';
            $result = mysql_query($sql);
            $row = mysql_fetch_assoc($result);
            $message = 'A User by the name of <b>'.$row['FirstName'].' '.$row['LastName'].'</b><br/>
                Email:<a href="mailto:'.$row['Email'].'">'.$row['Email'].'</a><br/><br/>
                    Has the following comments:<br/><br/>'.$_REQUEST['Comments'].'';
		$mail = new Rmail();
		$mail->setFrom('Commander HQ<info@be-mobile.co.za>');
		$mail->setSubject('Commander HQ Feedback');
		$mail->setPriority('normal');
		$mail->setHTML($message);
                $MailResult =  $mail->send(array(COMMANDER_EMAIL));
                if(!$MailResult)
                    $ReturnMessage .= 'Error Referring - Please Try again';
                else
                    $ReturnMessage .= 'Success';           
            return $ReturnMessage;
        }
}
?>