<?php
class RegistergymController extends Controller
{
	var $Message;
	var $Model;
		
	function __construct()
	{
		parent::__construct();
		$Model = new RegistergymModel;
		$Validate = new ValidationUtils;

		if($_REQUEST['save'] == 'Save'){	
			$this->Message = $Model->Register();
			$this->Message;
		}	
	}
}
?>