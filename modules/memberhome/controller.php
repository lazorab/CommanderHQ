<?php
class MemberhomeController extends Controller
{
	var $MemberDetails;
	
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_SESSION['UID']))
			header('location: index.php?module=login');		
		$Member = new Member($_SESSION['UID']);
		$this->MemberDetails = $Member->Details();
	}
	
	
	function CustomHeader()
	{
		$CustomHeader='';
		
		return $CustomHeader;
	}	
}
?>