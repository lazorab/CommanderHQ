<?php
class TabataController extends Controller
{
	var $Html='';
	var $Message='';
	var $Counter = 1;
	
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_SESSION['UID']))
			header('location: index.php?module=login');
		$this->Message = '<'.$this->Wall.'br/>';
	}
	
	function BuildHtml()
	{
		$Model = new TabataModel;
		$this->Html = $Model->getHtml();
		$this->Counter = $_REQUEST['counter'];
		if($_REQUEST['formsubmitted'] == 'yes')
		{	
			if($_REQUEST['submit'] == 'Log'){
				$this->Counter = $_REQUEST['counter'] + 1;
				if($this->Message == '<'.$this->Wall.'br/>'){		
					$Success = $Model->Log($_REQUEST, $this->Counter);
					if($Success)
						$this->Message = 'Log Successful';
					else
						$this->Message = 'Error: Unsuccessful Log';
					if($this->Counter == 9){
						$this->Counter = 1;		
						$this->Message .= '<'.$this->Wall.'br/>Round Completed';
					}
				}
				$this->Html .= '<'.$this->Wall.'input type="hidden" name="counter" value="'.$this->Counter.'"/>';
			}
		}
	}
	
	function Message()
	{
		$this->BuildHtml();
		return $this->Message;
	}
	
	function Counter()
	{
		return "Round:".$this->Counter."";
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