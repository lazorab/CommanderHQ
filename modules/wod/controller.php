<?php
class WodController extends Controller
{
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_SESSION['UID']))
			header('location: index.php?module=login');	
	}
	
	function WodDetails()
	{
		$Model = new WodModel;
		$WOD = $Model->getWOD();
		return $WOD;
	}

	function CustomHeader()
	{
		$CustomHeader='';
		
		return $CustomHeader;
	}
}
?>