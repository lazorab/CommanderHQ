<?php
class FeedbackModel extends Model
{

    function __Construct()
    {
            
    }
        
    function SendFeedback()
    {
        $mail = new Rmail();
	$mail->setFrom('Commander HQ<info@be-mobile.co.za>');
	$mail->setSubject('Commander HQ Feedback');
	$mail->setPriority('normal');
	$mail->setHTML($_REQUEST['Comments']);
        $mail->send(array(COMMANDER_EMAIL));
    }
}
?>