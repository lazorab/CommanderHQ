<?php
class TravelworkoutsController extends Controller
{
	var $Workouts;
	
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_SESSION['UID']))
			header('location: index.php?module=login');
			
		$Model = new TravelworkoutsModel;
		$this->Workouts = $Model->getWorkouts();
	}
	
	function html()
	{
		$html='<h3>Travel Workouts</h3>';

		foreach($this->Workouts AS $Workout){ 
			$html.='<'.$this->Wall.'br/>';
			$html.= str_replace('{br}','<'.$this->Wall.'br/>',$Workout->Description);
		}
		
		return $html;
	}
	
	function CustomHeader()
	{
		$CustomHeader='';
		
		return $CustomHeader;
	}
}
?>