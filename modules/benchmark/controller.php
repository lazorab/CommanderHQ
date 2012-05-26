<?php
class BenchmarkController extends Controller
{
	var $Workout;
	var $BMWS;
	var $Categories;
	var $Category;
	
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_SESSION['UID']))
			header('location: index.php?module=login');			
		$Model = new BenchmarkModel;
		if(isset($_REQUEST['id']))
			$this->Workout = $Model->getWorkoutDetails($_REQUEST['id']);
		
		$this->Categories = $Model->getCategories();
		if(isset($_REQUEST['catid'])){
			$this->Category = $Model->getCategory($_REQUEST['catid']);
			$this->BMWS = $Model->getBMWS($_REQUEST);
		}
	}
	
	function html()
	{
	$RENDER = new Image(SITE_ID);
		$html='';
		
if(isset($_REQUEST['id']))
{

if ($this->SupportOnlineVideo) {				
	$html.= '<h3>'.$this->Workout->Name.'</h3>
	<a onclick="GetVideo(\''.$this->Workout->SmartVideoLink.'\')" href="#">Click here for video</a><'.$this->Wall.'br/><'.$this->Wall.'br/>';
	}else{
		$html.= '<h3>'.$this->Workout->Name.'</h3>
		<a onclick="GetVideo(\''.$this->Workout->LegacyVideoLink.'\')" href="#">Click here for video</a><'.$this->Wall.'br/><'.$this->Wall.'br/>';
	}
	$html.='<textarea cols="15" rows="5" style="margin:10%;">';
	$html.= $this->Workout->Description;
	$html.='</textarea>';
}
else if(isset($_REQUEST['catid']))
{
	foreach($this->BMWS AS $BMW){ 

		$html.='<div>
		<a href="index.php?module=benchmark&id='.$BMW->Id.'&video='.$BMW->Video.'&banner='.$BMW->Banner.'">
		'.$BMW->Name.'
		</a>
		</div>';
		//$html.='<h3><a href="index.php?module=benchmark&id='.$BMW->Id.'&banner='.$BMW->Name.'">'.$BMW->Name.'</a></h3>';
	}
}
else
{
	foreach($this->Categories AS $Category){ 
		$Image = $RENDER->Image(''.$Category->Image.'.png', $this->Device->GetScreenWidth());
		$html.='<div>
		<a href="index.php?module=benchmark&catid='.$Category->Id.'&banner='.$Category->Banner.'">
		<img style="margin:2% 5% 3% 5%" alt="Header" src="'.$Image.'"/>
		</a>
		</div>';	
		//$html.='<h3><a href="index.php?module=benchmark&catid='.$Category->Id.'&banner='.$Category->Name.'">'.$Category->Name.'</a></h3>';
	}
}	
return $html;
	}
	
	function CustomHeader()
	{
		$RENDER = new Image(SITE_ID);
		if($this->Environment == 'website'){
		$CustomHeader='
		<script type="text/javascript">
    function GetVideo(filename)
    {
        document.getElementById("video").innerHTML = \'<iframe marginwidth="0px" marginheight="0px" width="608" height="436" src="\' + filename + \'" frameborder="0"></iframe>\';
    }
</script>';
}
else{
		$VideoImage = $RENDER->Image('video_specific_active.png', $this->Device->GetScreenWidth());
		$CustomHeader='
		<script type="text/javascript">
    function GetVideo(filename)
    {
		document.getElementById("videobutton").innerHTML = \'<wall:img alt="Header" src="'.$VideoImage.'"/>\';
        document.getElementById("video").innerHTML = \'<iframe marginwidth="0px" marginheight="0px" width="'.$this->Device->GetScreenWidth().'" height="'.($this->Device->GetScreenWidth() * 0.717).'" src="\' + filename + \'" frameborder="0"></iframe>\';
    }
</script>';
}
		return $CustomHeader;
	}
	
}
?>