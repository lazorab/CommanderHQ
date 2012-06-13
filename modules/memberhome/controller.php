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
	}	
}
?>