<?php
class TabataController extends Controller
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
		$Model = new TabataModel;
		if($_REQUEST['formsubmitted'] == 'yes')
		{			
			if($_REQUEST['submit'] == 'Save'){
				if($this->Message == ''){		
					$Success = $Model->Log($_REQUEST);
					if($Success)
						$this->Message = '<'.$this->Wall.'br/>Log Successful';
					else
						$this->Message = '<'.$this->Wall.'br/>Error: Unsuccessful Log';		
				}
				$this->Html = $Model->defaultHtml();
			}
			else{
				$this->Html = $Model->getHtml($_REQUEST['exercise']);				
				$this->Message = '';
			}	
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