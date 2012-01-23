<?php

/**
 * class for returning deals
 *
 * @author Darren Hart
 * 15 March 2011
 */
class Register {

    var $member;

    function __construct(&$member) {
        $connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        @mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");

        $this->member = $member;
    }

    function register() {

        try {
            //If the member does not exist we need to create him
            if (!$this->member->member_exists())
                $this->member->save();

            //Link the member to the site
            try {
                $this->member->link_to_site('BobIsHere', SITE_ID);
                //$request->post['Password']
            } catch (Exception $e) {
                echo $e->getMessage();
                utility::log_error('Error adding member to site in registration ' . $_REQUEST['formMobile'] . ' with password BobIsHere');
                draw_register_form($_REQUEST['formName'], $_REQUEST['formSurname'], $_REQUEST['formEmail'], $_REQUEST['formMobile'], $request, $remoteSignup);
            }

            //Update attributes
            $this->member->edit_attribute('First_Name', $_REQUEST['formName']);
            $this->member->edit_attribute('Last_Name', $_REQUEST['formSurname']);
            $this->member->edit_attribute('Email', $_REQUEST['formEmail']);
            if (isset($_REQUEST['Interests']))
                $this->member->edit_attribute('Interests', serialize($_REQUEST['Interests']));
            if (isset($_REQUEST['Method']))
                $this->member->edit_attribute('CommunicationMethod', serialize($_REQUEST['Method']));
            if (isset($_REQUEST['WhatUpdates']))
                $this->member->edit_attribute('WhatUpdates', serialize($_REQUEST['WhatUpdates']));
        } catch (Exception $e) {
            echo $e->getMessage();
            utility::log_error('Error registering member to site in registration ' . $_REQUEST['formMobile']);
            draw_register_form($_REQUEST['formName'], $_REQUEST['formSurname'], $_REQUEST['formEmail'], $_REQUEST['formMobile'], $request, $remoteSignup);
        }
    }

    function SendRegistrationEmail() {
        $msg = "A new registration has been received on m.southafrica.net\n";
        $msg .= "Details are as follows:\n";
        $msg .= "First Name: " . $_REQUEST['formName'] . "\n";
        $msg .= "Last Name: " . $_REQUEST['formSurname'] . "\n";

        if (isset($_REQUEST['formEmail']) && strlen(trim($_REQUEST['formEmail'])) > 0)
            $msg .= "Email: " . $_REQUEST['formEmail'] . "\n";

        if (isset($_REQUEST['formMobile']) && strlen(trim($_REQUEST['formMobile'])) > 0)
            $msg .= "Cell: " . $_REQUEST['formMobile'] . "\n";

        //Send a mail to REGISTRATION_EMAIL
        $mail = new Rmail();
        $mail->setFrom('SouthAfica.Net Mobi Site<info@be-mobile.co.za>');
        $mail->setSubject('SAT Mobi Registration');
        $mail->setPriority('normal');
        $mail->setText($msg);
        $result = $mail->send(array(REGISTRATION_EMAIL));
    }

    function SendMemberEmail($Link) {

        $result = new ActionResult();

        $msg = "Thank you for registering on m.southafrica.net\n";
        $msg .= "Details are as follows:\n";
        $msg .= "First Name: " . $_REQUEST['formName'] . "\n";
        $msg .= "Last Name: " . $_REQUEST['formSurname'] . "\n";
        $msg .= "Email: " . $_REQUEST['formEmail'] . "\n";

        if (isset($_REQUEST['formMobile']) && strlen(trim($_REQUEST['formMobile'])) > 0)
            $msg .= "Cell: " . $_REQUEST['formMobile'] . "\n";

        $msg .= "To unsubscribe please visit " . $Link . "";

        //Send a mail to new member
        $mail = new Rmail();
        $mail->setFrom('SouthAfica.Net Mobi Site<info@be-mobile.co.za>');
        $mail->setSubject('SAT Mobi Registration');
        $mail->setPriority('normal');
        $mail->setText($msg);
        $emailResult = $mail->send(array($_REQUEST['formEmail']));
        if ($emailResult) {
            $result->Successful = true;
            $result->ErrorMessage = '<p>Thank you, you will receive a confirmation via email</p>';
        } else {
            $result->Successful = false;
            $result->ErrorMessage = '<p>Registration error</p>';
        }
        
        return $result;
    }

    function SendSMS($Link) {
        $result = new ActionResult();
        $get = new tiny_url($Link);
        $url = $get->TinyURL('http://m.southafrica.net');
        $text = 'Thank you for registering. To unsubscribe please visit ' . $url . '';
        $action = new utility_base;
        $success = $action->send_sms($cell, $text, $this->member->get_id(), 0);
        if ($success) {
            $result->Successful = true;
            $result->ErrorMessage = '<p>Thank you, you will receive a confirmation via SMS</p>';            
        } else {
            $result->Successful = false;
            $result->ErrorMessage = 'SMS to ' . $cell . ' Failed!';
        }
        return $result;
    }

}

?>