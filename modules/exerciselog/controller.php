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
			$this->Html = $Model->getHtml($_REQUEST['exercise']);
			
			if($_REQUEST['submit'] == 'Save'){
				$this->Message = $Model->Validate($_REQUEST['exercise']);
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