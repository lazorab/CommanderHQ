<?php
class ExerciselogController extends Controller
{
	var $Html='';
	var $Message='';
	
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_SESSION['UID']))
			header('location: index.php?module=login');
	}
	
	function BuildHtml()
	{
		$Model = new ExerciselogModel;
		if($_REQUEST['formsubmitted'] == 'yes')
		{	
			if($_REQUEST['hours'] == '00' && $_REQUEST['minutes'] == '00' && $_REQUEST['seconds'] == '00') 
				$this->Message = 'Must Enter Time';
			if($Model->isBaseline($_REQUEST['exercise']))
			{
				$this->Html = $Model->TimeInput();
			}
			else if($Model->isBenchMark($_REQUEST['exercise']))
			{ 
				$this->Html = $Model->getWorkoutHtml();
				if(isset($_REQUEST['reps']) && $_REQUEST['reps'] == ''){
					$this->Message = 'Must Enter Number of Rounds';	
				} 
			}
			else
			{ 
				$this->Html = $Model->getExerciseHtml();
				if(isset($_REQUEST['membersweight']) && $_REQUEST['weight'] == '')
					$this->Message = 'Must Enter Your Weight';
			}
			
			if($_REQUEST['submit'] == 'Save'){
				if($this->Message == ''){		
					$Success = $Model->Log($_REQUEST);
					if($Success)
						$this->Message = '<'.$this->Wall.'br/>Log Successful';
					else
						$this->Message = '<'.$this->Wall.'br/>Error: Unsuccessful Log';		
				}
			}
			else{
				$this->Message = '';
			}	
			$this->Html.='
				<'.$this->Wall.'br/>
				<'.$this->Wall.'input type="submit" name="submit" value="Save"/><'.$this->Wall.'br/><'.$this->Wall.'br/>';
		}
		else
		{
			$this->Html = $Model->defaultHtml();
		}
	}
	
	function Message()
	{
		$this->BuildHtml();
		return $this->Message;
	}
	
	function Html()
	{
		return $this->Html;
	}
	
	function CustomHeader()
	{
		$CustomHeader='';
		
		return $CustomHeader;
	}
}
?>