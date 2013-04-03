<?php
class FeedbackModel extends Model
{

    function __Construct()
    {
            
    }
        
    function SendFeedback()
    {
        $Member = $this->getMemberDetails($_COOKIE['UID']);
        $mail = new Rmail();
	$mail->setFrom($Member->Email);
	$mail->setSubject('Commander HQ Feedback');
	$mail->setPriority('normal');
	$mail->setHTML("".$Member->FirstName." ".$Member->LastName." has the following feedback: \n\n ".$_REQUEST['Comments']."");
        $mail->send(array(COMMANDER_EMAIL));
    }
}
?>