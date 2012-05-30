<?php
class LoginController extends Controller
{
	var $Message='';
	
	function __construct()
	{
		parent::__construct();	
		$Model = new LoginModel();
		
		if($_REQUEST['submit'] == 'Submit')
		{
			$UserId = $Model->Login($_REQUEST['username'], $_REQUEST['password']);	
				if(!$UserId){
				$this->Message = 'Invalid Credentials, Please try again.';
			}
			else{
				session_start();
				$_SESSION['UID'] = $UserId;
				if($_REQUEST['remember'] == 'yes'){
					setcookie("Username", $_REQUEST['username']);
					setcookie("Password", $_REQUEST['password']);
				}
				header('location: index.php?module=memberhome');
			}		
		}
		else if(isset($_REQUEST['redirect']))
		{	
			$UserId = $Model->Login($_COOKIE['Username'], $_COOKIE['Password']);
			if(!$UserId){
				$this->Message = 'Invalid Credentials, Please try again.';
			}
			else{
				session_start();
				$_SESSION['UID'] = $UserId;
				header('location: index.php?module='.$_REQUEST['redirect'].'');
			}			
		}				
		
		if($_REQUEST['submit'] == 'Retrieve')
		{
			$Model = new LoginModel();
			if($_REQUEST['username'] == '')
				$this->Message = 'You must enter your Username';
			if($_REQUEST['email'] == '')
				$this->Message = 'You must enter your Email Address';
			if($Message == '')
			{
				$Successful = $Model->RetrievePassword($_REQUEST['username'], $_REQUEST['email']);
				if(!$Successful)
					$this->Message = 'Error sending email';
				else
					$this->Message = 'You have been sent an email';
			}
		}
	}
	
	function CustomHeader()
	{
		$CustomHeader='';
		
		return $CustomHeader;
	}
	
}
?>