<?php
class ReportsController extends Controller
{
	var $Details;
	var $PendingExercises;
	
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_SESSION['UID']))
			header('location: index.php?module=login');	
			
		$Model=new ReportsModel($_SESSION['UID']);
		$this->Details=$Model->getDetails();
		$this->PendingExercises=$Model->getPendingExercises();
	}
	
	function Details()
	{
		return $this->Details;
	}
	
	function PendingExercises()
	{
		$Html='';
		foreach($this->PendingExercises AS $Exercise) { 
			$Html.='<'.$this->Wall.'br/><'.$this->Wall.'a href="index.php?module=exercisedetails&id='.$Exercise->Id.'">'.$Exercise->Exercise.'</'.$this->Wall.'a>';
		}
		return $Html;
	}
	
	function CustomHeader()
	{
		$CustomHeader='';
		
		return $CustomHeader;
	}
}
?>