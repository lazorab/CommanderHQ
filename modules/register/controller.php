<?php
class RegisterController extends Controller
{
	var $Message;
	var $Model;
	var $SystemWeight;
	var $SystemHeight;	
	var $System;
	var $AlternateSystem;
		
	function __construct()
	{
		parent::__construct();
		$Model = new RegisterModel;
		$Validate = new ValidationUtils;
		$this->System = 'Metric';
		$this->AlternateSystem = 'Imperial';
		$this->SystemWeight = 'Kg';
		$this->SystemHeight = 'cm';		
		
		if($_REQUEST['formsubmitted'] == 'yes'){

		if($_REQUEST['system'] == 'Metric'){
			$this->System = 'Metric';
			$this->SystemWeight = 'Kg';
			$this->SystemHeight = 'cm';	
			$this->AlternateSystem = 'Imperial';
		}
		else if($_REQUEST['system'] == 'Imperial'){
			$this->System = 'Imperial';
			$this->SystemWeight = 'lbs';
			$this->SystemHeight = 'inches';	
			$this->AlternateSystem = 'Metric';	
		}
            
		if($_REQUEST['save'] == 'Save'){	

	if($_REQUEST['firstname'] == '')
		$this->Message = 'Firstname Required';
	elseif($_REQUEST['lastname'] == '')
		$this->Message = 'Lastname Required';
	elseif($_REQUEST['cell'] == '' && $_REQUEST['email'] == '')
		$this->Message = 'Either a Cell or Email Required';
	elseif($_REQUEST['cell'] != '' && !$Validate->CheckMobileNumber($_REQUEST['cell']))
		$this->Message = 'Cell number invalid!';
	elseif($_REQUEST['email'] != '' && !$Validate->CheckEmailAddress($_REQUEST['email']))
		$this->Message = 'Email Address invalid!';
	elseif($_REQUEST['username'] == '')
		$this->Message = 'Username Required';		
	elseif($_REQUEST['password'] == '')
		$this->Message = 'Password Required';
	elseif($_REQUEST['DOB'] == '')
		$this->Message = 'Invalid Date of Birth';		
	elseif($_REQUEST['weight'] == '')
		$this->Message = 'Weight Required';
	elseif($_REQUEST['height'] == '')
		$this->Message = 'Height Required';
	elseif($_REQUEST['gender'] == '')		
		$this->Message = 'Select Gender';
	
	if($this->Message == '')
	{	
		$Model->Register();
		if(!$Model->ReturnValue()){
			$this->Message = 'Member already exists, Please try again.';
		}
		else{
			session_start();
			$_SESSION['UID'] = $Model->ReturnValue();
			header('location: index.php?module=memberhome');
		}
	}
	}
}	
	}
	
	function Message()
	{
		return $this->Message;
	}
}
?>