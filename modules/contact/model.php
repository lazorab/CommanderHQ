<?php
class ContactModel extends Model
{

	function __Construct()
        {
            
        }
        
        function SendForm()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL='SELECT FirstName, LastName, Email FROM Members WHERE UserId = "'.$_SESSION['UID'].'"';
            $db->setQuery($SQL);
            $Row = $db->loadObject(); ;
            $message = 'A User by the name of <b>'.$Row->FirstName.' '.$Row->LastName.'</b><br/>
                Email:<a href="mailto:'.$Row->Email.'">'.$Row->Email.'</a><br/><br/>
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