<?php
class EditController extends Controller
{
	var $Message;
	var $Model;
	var $MemberDetails;
	
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_SESSION['UID']))
			header('location: index.php?module=login');
		
		$this->Model = new EditModel;
		$Validate = new ValidationUtils;
		$this->Message = '';
if($_REQUEST['formsubmitted'] == 'yes')
{
	if($_REQUEST['FirstName'] == '')
		$this->Message = 'Firstname Required';
	elseif($_REQUEST['LastName'] == '')
		$this->Message = 'Lastname Required';
	elseif($_REQUEST['Cell'] == '' && $_REQUEST['Email'] == '')
		$this->Message = 'Either a Cell or Email Required';
	elseif($_REQUEST['Cell'] != '' && !$Validate->CheckMobileNumber($_REQUEST['Cell']))
		$this->Message = 'Cell number invalid!';
	elseif($_REQUEST['Email'] != '' && !$Validate->CheckEmailAddress($_REQUEST['Email']))
		$this->Message = 'Email Address invalid!';
	elseif($_REQUEST['UserName'] == '')
		$this->Message = 'Username Required';		
	elseif($_REQUEST['PassWord'] == '')
		$this->Message = 'Password Required';
	elseif($_REQUEST['Day'] == '')
		$this->Message = 'Invalid Date of Birth';		
	elseif($_REQUEST['Month'] == '')
		$this->Message = 'Invalid Date of Birth';
	elseif($_REQUEST['Year'] == '')
		$this->Message = 'Invalid Date of Birth';		
	elseif($_REQUEST['Weight'] == '')
		$this->Message = 'Weight Required';
	elseif($_REQUEST['Height'] == '')
		$this->Message = 'Height Required';
	elseif($_REQUEST['Gender'] == '')		
		$this->Message = 'Select Gender';
	
	$this->Model->setCredentials();	
	if($this->Message == '')
	{
		$this->Model->Save($this->Model->MemberDetails());
		header('location: index.php?module=memberhome');
	}
}	
else{
	$this->Model->getCredentials($_SESSION['UID']);
}
	$this->MemberDetails = $this->Model->MemberDetails();
	}
	
	function Model()
	{
		return $this->Model;
	}
	
	function MemberDetails()
	{
		return $this->MemberDetails;
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