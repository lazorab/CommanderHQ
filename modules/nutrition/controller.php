<?php
class NutritionController extends Controller
{
    var $Message;
    
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_SESSION['UID']))
			header('location: index.php?module=login');	
        if($_REQUEST['save'] == 'Save')
            $this->Save();
	}
	
	function Save()
	{
        $this->Message = '';
		$Model = new FoodlogModel;
        //Validate
        if($_REQUEST['meal'] == '')
            $this->Message = 'Meal is blank';
        else if($_REQUEST['mealtime'] == '')
            $this->Message = 'Meal time is blank';
        if($this->Message == '')
            $Model->Log();
	}
}
?>