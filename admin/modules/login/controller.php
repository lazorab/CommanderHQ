<?php
class LoginController extends Controller
{
	var $Message='';
	
	function __construct()
	{
		$Model = new LoginModel();
		session_start();
		if(isset($_SESSION['GID'])){
			header('location: index.php?module=upload');	
		}
		else if($_REQUEST['action'] == 'Login')
		{
			$UserId = $Model->Login($_REQUEST['username'], $_REQUEST['password']);	
			if(!$UserId){
				$this->Message = 'Invalid Credentials, Please try again.';
			}
			else{
				if($_REQUEST['remember'] == 'yes'){
					setcookie("AdminUsername", $_REQUEST['username'], time() + (20 * 365 * 24 * 60 * 60), '/', THIS_DOMAIN, false, false);
					setcookie("AdminPassword", $_REQUEST['password'], time() + (20 * 365 * 24 * 60 * 60), '/', THIS_DOMAIN, false, false);
				}			
				$_SESSION['GID'] = $UserId;

				header('location: index.php?module=upload');
			}		
		}	
		else if($_REQUEST['action'] == 'Retrieve')
		{
			$Model = new LoginModel();
			if($_REQUEST['username'] == '')
				$this->Message = 'You must enter your Username';
			if($_REQUEST['email'] == '')
				$this->Message = 'You must enter your Email Address';
			if($this->Message == '')
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