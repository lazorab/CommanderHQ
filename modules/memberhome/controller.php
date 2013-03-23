<?php
class MemberhomeController extends Controller
{	
    function __construct()
    {
	parent::__construct();
	session_start();
	if(!isset($_COOKIE['UID']))
            header('location: index.php?module=login');
        
        //var_dump($_SESSION);
    }	
        
    function FirstTimeMessage()
    {
        $FirstTimeMessage = '';
        if(isset($_SESSION['NEW_USER'])){
            $FirstTimeMessage = '<script type="text/javascript">';
            $FirstTimeMessage .= "var message = 'Commander - One in an official position of command or control\n';";
            $FirstTimeMessage .= "message += 'Commander HQ has been designed to give practitioners of CrossFit a tool that provides you with the measures of control to record your workouts,\n';";
            $FirstTimeMessage .= "message += 'track your progress, challenge your biggest rival - yourself  (or your friends) and engage with like minded people across the Globe\n';";
            $FirstTimeMessage .= "message += 'Connect with your Gym for easy access to WOD, Bookings or if you are traveling, find an affiliate in your location.\n';";
            $FirstTimeMessage .= "message += 'We have all the information you\'ll need right at your fingertips, should we be missing some - just give us a shutout either by mail or on our FB page or on twitter and well address it.\n';";
            $FirstTimeMessage .= "message += 'remember - eat clean, train dirty!\n';";
            $FirstTimeMessage .= "message += 'The Commander';";
            $FirstTimeMessage .= "alert(message);";
            $FirstTimeMessage .= "</script>";
            $FirstTimeMessage .= '<script type="application/javascript" src="/js/add2home.js"></script>';
        } 
        return $FirstTimeMessage;
    }
}
?>