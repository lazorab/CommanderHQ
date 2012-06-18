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
		if($_REQUEST['action'] == 'save'){
			if(!isset($_SESSION['UID'])){
				header('location: index.php?module=login');	
			}else{
				$this->Save();
			}
        }
		$Model = new BenchmarkModel;
		if(isset($_REQUEST['id']))
			$this->Workout = $Model->getWorkoutDetails($_REQUEST['id']);
		
		$this->Categories = $Model->getCategories();
		if(isset($_REQUEST['catid'])){
			$this->Category = $Model->getCategory($_REQUEST['catid']);
			$this->BMWS = $Model->getBMWS($_REQUEST['catid']);
		}
		
		if($_REQUEST['form'] == 'submitted'){
			$Success = $Model->Log($_REQUEST);
		}
	}
	
	function Save()
	{
		$Model = new BenchmarkModel;
		$Benchmark = $Model->Log();
	}	
	
	function Output()
	{
	$RENDER = new Image(SITE_ID);
		$html='<br/>';
		
if(isset($_REQUEST['id']))
{
	$Start = $RENDER->Image('start.png', SCREENWIDTH);
	$Stop = $RENDER->Image('stop.png', $this->Device->GetScreenWidth());
	$Reset = $RENDER->Image('report.png', $this->Device->GetScreenWidth());
	$Save = $RENDER->Image('save.png', $this->Device->GetScreenWidth());
    $Height = floor($this->Device->GetScreenWidth() * 0.717);
	$html.='<div id="video">
    <iframe marginwidth="0px" marginheight="0px" width="'.$this->Device->GetScreenWidth().'" height="'.$Height.'" src="http://www.youtube.com/embed/'.$this->Workout->Video.'" frameborder="0">
    </iframe>    
	</div>';    
	$html.='<div id="bmdescription">';
	$html.= $this->Workout->Description;
	$html.='</div>';
	$html.='<form name="clockform" action="index.php">
	<input type="hidden" name="module" value="benchmark"/>
	<input type="hidden" name="benchmarkId" value="'.$_REQUEST['id'].'"/>
		<input type="hidden" name="action" value="save"/>
<input id="clock" name="TimeToComplete" value="00:00:0"/>
</form>	
<div style="margin:0 30% 0 30%; width:50%">
<img alt="Start" src="'.$Start.'" onclick="start()"/>&nbsp;&nbsp;
<img alt="Stop" src="'.$Stop.'" onclick="stop()"/><br/><br/>
<img alt="Reset" src="'.$Reset.'" onclick="reset()"/>&nbsp;&nbsp;
<img alt="Save" src="'.$Save.'" onclick="save()"/>
</div><br/><br/>';
}
else if(isset($_REQUEST['catid']))
{
	$Image = $RENDER->Image('BM_Select.png', $this->Device->GetScreenWidth());
	$explode = explode("_", $Image);
	$height = $explode[2];
	foreach($this->BMWS AS $BMW){ 

		$html.='<div class="benchmark" style="height:'.$height.'px;">
		<div style="width:70%;padding:4%;margin:1%;float:left;font-size:large;background-color:#fff;">';
		//<a href="index.php?module=benchmark&id='.$BMW->Id.'&video='.$BMW->Video.'&banner='.$BMW->Banner.'"">
		$html.=''.$BMW->Name.'';
		//</a>
		$html.='</div>
		<div style="width:15%;margin:0 1% 1% 0;background-color:#fff;float:right">';
		//<a href="index.php?module=benchmark&id='.$BMW->Id.'&video='.$BMW->Video.'&banner='.$BMW->Banner.'"">
		$html.='<img onclick="getDetails(\''.$BMW->Id.'\');" alt="'.$BMW->Name.'" src="'.$Image.'"/>';
		//</a>
		$html.='</div>
		</div>
		<div class="clear"></div>';
		
		//$html.='<h3><a href="index.php?module=benchmark&id='.$BMW->Id.'&banner='.$BMW->Name.'">'.$BMW->Name.'</a></h3>';
	}
	$html.='<br/>';
}
else
{
	foreach($this->Categories AS $Category){ 
		$Image = $RENDER->Image(''.$Category->Image.'.png', $this->Device->GetScreenWidth());
		$html.='<div>';
		//$test='<a href="index.php?module=benchmark&catid='.$Category->Id.'&banner='.$Category->Banner.'">';
		$html.='<img onclick="getBenchmarks(\''.$Category->Id.'\');" style="margin:2% 5% 3% 5%" alt="'.$Category->Name.'" src="'.$Image.'"/>';
		//$test='</a>';
		$html.='</div>';	
		//$html.='<h3><a href="index.php?module=benchmark&catid='.$Category->Id.'&banner='.$Category->Name.'">'.$Category->Name.'</a></h3>';
	}
}	
return $html;
	}
}
?>