<?php

/* * ******************************************************
Class to manage members
Copyright Be-Mobile

Created By   : Darren Hart
Created Date : 10 January 2012

Last Modified Date: 10 January 2012

*********************************************************/

class LoginModel extends Model
{
    function __construct()
    {

    }
	
    function Login($username,$password)
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
	$SQL='SELECT AffiliateId 
            FROM Affiliates
            WHERE UserName = "'.$username.'" AND PassWord = "'.$password.'"';
        $db->setQuery($SQL);
	$db->Query();
	if($db->getNumRows() > 0){	
            return $db->loadResult();
	}
	else{
            return false;
        }	
    }
    
    function Register()
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $SQL='SELECT Registered FROM Affiliates WHERE GymName = "'.$_REQUEST['gymname'].'"';
        $db->setQuery($SQL);        
	if($db->loadResult() != 1){       
        $Password = base_convert(time(), 10, 16);
        $SQL='UPDATE Affiliates SET UserName = "'.$_REQUEST['gymname'].'", 
                PassWord = "'.$Password.'", 
                RegUserName = "'.$_REQUEST['name'].'",
                RegEmail = "'.$_REQUEST['email'].'",
                RegPhone = "'.$_REQUEST['phone'].'",
                Registered = "1"
                WHERE GymName = "'.$_REQUEST['gymname'].'"';
        $db->setQuery($SQL);
	$db->Query();    
        $message="Successfully Registered\n";
        $message.="\n";
        $message.="Username is ".$_REQUEST['gymname']."\n";
        $message.="\n";
        $message.="Password is ".$Password."\n";
        $mail = new Rmail();
        $mail->setFrom('Commander HQ<info@be-mobile.co.za>');
        $mail->setSubject('Commander HQ Gym Registration');
        $mail->setPriority('normal');
        $mail->setHTML($message);
        $MailResult =  $mail->send(array($_REQUEST['email']));
        return '<div style="text-align:right;font-size:large;color:green">Successfully Registered!<br/>You Have been sent an Email with your Username and Password</div>';
        }else{
        return '<div style="text-align:right;font-size:large;color:red">Already a Registered Gym!</div>';
        }
    }
    
    function getAffiliates()
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $SQL='SELECT GymName FROM Affiliates WHERE GymName LIKE "'.$_REQUEST['term'].'%"';
        $db->setQuery($SQL);
        return $db->loadObjectList();
    }
}

