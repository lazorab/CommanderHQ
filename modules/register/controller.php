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
		$this->Model = new RegisterModel;
		$Validate = new ValidationUtils;
		$this->System = 'Metric';
		$this->AlternateSystem = 'Imperial';
		$this->SystemWeight = 'Kg';
		$this->SystemHeight = 'cm';		
		
if($_REQUEST['formsubmitted'] == 'yes')
{
		if($_REQUEST['system'] == 'Metric'){
			$this->System = 'Metric';
			$this->SystemWeight = 'Kg';
			$this->SystemHeight = 'cm';	
			$this->AlternateSystem = 'Imperial';
		}
		if($_REQUEST['system'] == 'Imperial'){
			$this->System = 'Imperial';
			$this->SystemWeight = 'lbs';
			$this->SystemHeight = 'inches';	
			$this->AlternateSystem = 'Metric';	
		}

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
	elseif($_REQUEST['day'] == '')
		$this->Message = 'Invalid Date of Birth';		
	elseif($_REQUEST['month'] == '')
		$this->Message = 'Invalid Date of Birth';
	elseif($_REQUEST['year'] == '')
		$this->Message = 'Invalid Date of Birth';		
	elseif($_REQUEST['weight'] == '')
		$this->Message = 'Weight Required';
	elseif($_REQUEST['height'] == '')
		$this->Message = 'Height Required';
	elseif($_REQUEST['gender'] == '')		
		$this->Message = 'Select Gender';
		
	if($this->Message == '' && $_REQUEST['submit'] == 'Save')
	{
		$_CREDENTIALS=array(
			'FirstName'=>''.$_REQUEST['firstname'].'',
			'LastName'=>''.$_REQUEST['lastname'].'',
			'Cell'=>''.$_REQUEST['cell'].'',
			'Email'=>''.$_REQUEST['email'].'',		
			'UserName'=>''.$_REQUEST['username'].'',
			'PassWord'=>''.$_REQUEST['password'].'',
			'SystemOfMeasure'=>''.$_REQUEST['system'].'',
			'DOB'=>''.$_REQUEST['year'].'-'.$_REQUEST['month'].'-'.$_REQUEST['day'].'',
			'Weight'=>''.$_REQUEST['weight'].'',
			'Height'=>''.$_REQUEST['height'].'',
			'Gender'=>''.$_REQUEST['gender'].'',
			'Goals'=>''.serialize($_REQUEST['goals']).'');		
		$this->Model->Register($_CREDENTIALS);
		if(!$this->Model->ReturnValue()){
			$this->Message = 'Member already exists, Please try again.';
		}
		else{
			session_start();
			$_SESSION['UID'] = $this->Model->ReturnValue();
			header('location: index.php?module=memberhome');
		}
	}
}	
	}
	
	function Model()
	{
		return $this->Model;
	}
	
	function Message()
	{
		return $this->Message;
	}
	
	function CustomHeader()
	{
		$CustomHeader='';
		
		return $CustomHeader;
	}
}
?>