<?php
class LoginController extends Controller
{
	var $Message='';
	
	function __construct()
	{
		parent::__construct();	
		$Model = new LoginModel();
		
		if($_REQUEST['action'] == 'Login')
		{
			$UserId = $Model->Login($_REQUEST['username'], $_REQUEST['password']);	
			if(!$UserId){
				$this->Message = 'Invalid Credentials, Please try again.';
			}
			else{
				if($_REQUEST['remember'] == 'yes'){
					setcookie("CommanderUsername", $_REQUEST['username'], time() + (20 * 365 * 24 * 60 * 60), '/', 'crossfit.be-mobile.co.za', false, false);
					setcookie("CommanderPassword", $_REQUEST['password'], time() + (20 * 365 * 24 * 60 * 60), '/', 'crossfit.be-mobile.co.za', false, false);
				}			
				session_start();
				$_SESSION['UID'] = $UserId;

				header('location: index.php?module=memberhome');
			}		
		}				
		
		else if($_REQUEST['action'] == 'Retrieve')
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
}
?>