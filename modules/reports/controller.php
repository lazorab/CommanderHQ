<?php
class ReportsController extends Controller
{
	var $Details;
	var $Html;
	var $Model;
	
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_SESSION['UID']))
			header('location: index.php?module=login');	
			
		$this->Model=new ReportsModel($_SESSION['UID']);
		$this->Details=$this->Model->getDetails();
		if($_REQUEST['form'] == 'submitted')
		{
			if($_REQUEST['action'] == 'Pending Exercises')
			{
				$this->PendingExercises();
			}
			else if($_REQUEST['action'] == 'Performance History')
			{
				$this->CompletedExercises();	
			}
		}
		else if(isset($_REQUEST['id']))
			$this->PerformanceHistory($_REQUEST['id']);
		else
			$this->DrawForm();
	}
	
	function DrawForm()
	{
		$this->Html='<'.$this->Wall.'form action = "" method="post">
				<'.$this->Wall.'input type="hidden" name="module" value="reports"/>
				<'.$this->Wall.'input type="hidden" name="form" value="submitted"/>
				<'.$this->Wall.'input type="submit" name="action" value="Pending Exercises"/>
				<'.$this->Wall.'input type="submit" name="action" value="Performance History"/>
				</'.$this->Wall.'form>
		';
	}
	
	function Details()
	{
		return $this->Details;
	}
	
	function CompletedExercises()
	{
		$ExerciseItems = $this->Model->getCompletedExercises();
		$this->Html='Completed Exercises:';
		foreach($ExerciseItems AS $Exercise) { 
			$this->Html.='<'.$this->Wall.'br/><'.$this->Wall.'a href="index.php?module=reports&id='.$Exercise->Id.'">'.$Exercise->Exercise.'</'.$this->Wall.'a>';
		}
		return $this->Html;	
	}
	
	function PerformanceHistory($Id)
	{
		$this->Html.='Date  Duration  Performance<'.$this->Wall.'br/>';
		$PerformanceData = $this->Model->getPerformanceHistory($Id);
		$previous = '';
		foreach($PerformanceData AS $Data)
		{
			$Time = explode(':',$Data->Duration);
			$Hours=$Time[0];
			$Minutes=$Time[1];
			$Seconds=$Time[2];
			$TotalSeconds=($Hours*60*60) + ($Minutes*60) + $Seconds;
			if($previous == '')
				$performance = '--';
			else
				$performance = $TotalSeconds / $previous;
			$previous = $TotalSeconds;
			$this->Html.=''.$Data->TimeCreated.'  '.$Data->Duration.'  '.$performance.'<'.$this->Wall.'br/>';
		}
		return $this->Html;	
	}
	
	function PendingExercises()
	{
		$PendingExercises = $this->Model->getPendingExercises();
		$this->Html='Pending Skill Exercises:';
		foreach($PendingExercises AS $Exercise) { 
			$this->Html.='<'.$this->Wall.'br/><'.$this->Wall.'a href="index.php?module=exercisedetails&id='.$Exercise->Id.'">'.$Exercise->Exercise.'</'.$this->Wall.'a>';
		}
		return $this->Html;
	}
	
	function CustomHeader()
	{
		$CustomHeader='';
		
		return $CustomHeader;
	}
}
?>