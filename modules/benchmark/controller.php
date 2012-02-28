<?php
class BenchmarkController extends Controller
{
	var $Workout;
	var $BMWS;
	
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_SESSION['UID']))
			header('location: index.php?module=login');
					
		$Model = new BenchmarkModel;
		if(isset($_REQUEST['id']))
			$this->Workout = $Model->getWorkoutDetails($_REQUEST['id']);
		$this->BMWS = $Model->getBMWS($_REQUEST);
	}
	
	function html()
	{
		$html='';
		
if(isset($_REQUEST['id']))
{

if ($this->SupportOnlineVideo) {				
	$html.= '<h3>'.$this->Workout->WorkoutName.'</h3>
	<a onclick="GetVideo(\''.$this->Workout->SmartVideoLink.'\')" href="#">Click here for video</a><'.$this->Wall.'br/><'.$this->Wall.'br/>';
	}else{
		$html.= '<h3>'.$this->Workout->WorkoutName.'</h3>
		<a onclick="GetVideo(\''.$this->Workout->LegacyVideoLink.'\')" href="#">Click here for video</a><'.$this->Wall.'br/><'.$this->Wall.'br/>';
	}
	$html.= str_replace('{br}','<'.$this->Wall.'br/>',$this->Workout->WorkoutDescription);
}
else
{
	
	$html.='<h3>BenchMark Workouts</h3>';

	foreach($this->BMWS AS $BMW){ 
		$html.='<h3><a href="index.php?module=benchmark&id='.$BMW->Id.'">'.$BMW->WorkoutName.'</a></h3>';
	}
}	
return $html;
	}
	
	function CustomHeader()
	{
		if($this->Environment == 'website'){
		$CustomHeader='
		<script type="text/javascript">
    function GetVideo(filename)
    {
        document.getElementById("header").innerHTML = \'<iframe marginwidth="0px" marginheight="0px" width="608" height="436" src="\' + filename + \'" frameborder="0"></iframe>\';
    }
</script>';
}
else{
		$CustomHeader='
		<script type="text/javascript">
    function GetVideo(filename)
    {
        document.getElementById("header").innerHTML = \'<iframe marginwidth="0px" marginheight="0px" width="'.$this->Device->GetScreenWidth().'" height="'.($this->Device->GetScreenWidth() * 0.717).'" src="\' + filename + \'" frameborder="0"></iframe>\';
    }
</script>';
}
		return $CustomHeader;
	}
}
?>