<?php
class LoginController extends Controller
{
	var $Message='';
	
	function __construct()
	{
		parent::__construct();	
		if($_REQUEST['submit'] == 'Submit')
		{
			$Model = new LoginModel();
			$UserId = $Model->Login($_REQUEST['username'], $_REQUEST['password']);
			if(!$UserId){
				$this->Message = 'Invalid Login, Please try again.';
			}
			else{
				session_start();
				$_SESSION['UID'] = $UserId;
				header('location: index.php?module=memberhome');
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