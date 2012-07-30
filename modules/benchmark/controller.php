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
        if(!isset($_SESSION['UID'])){
            header('location: index.php?module=login');
        }
		if($_REQUEST['action'] == 'save'){
				$this->Save();
        }
		
		$Model = new BenchmarkModel;
		if(isset($_REQUEST['id']))
			$this->Workout = $Model->getWorkoutDetails($_REQUEST['id']);
		
		$this->Categories = $Model->getCategories();
		if(isset($_REQUEST['catid'])){
			$this->Category = $Model->getCategory($_REQUEST['catid']);
			if($this->Category != 'Historic'){
				$this->BMWS = $Model->getBMWS($_REQUEST['catid']);
			}
		}
		
		if($_REQUEST['form'] == 'submitted'){
			$Success = $Model->Log($_REQUEST);
		}
		return $this->BenchmarkSelection();
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
    $Start = $RENDER->NewImage('start.png', $this->Device->GetScreenWidth());
    $Stop = $RENDER->NewImage('stop.png', $this->Device->GetScreenWidth());
    $Reset = $RENDER->NewImage('report.png', $this->Device->GetScreenWidth());
    $Save = $RENDER->NewImage('save.png', $this->Device->GetScreenWidth());
    $Height = floor($this->Device->GetScreenWidth() * 0.717);
	$html.='<div id="video">
    <iframe marginwidth="0px" marginheight="0px" width="'.$this->Device->GetScreenWidth().'" height="'.$Height.'" src="http://www.youtube.com/embed/'.$this->Workout->Video.'" frameborder="0">
    </iframe>    
	</div>';    
	//$html.='<div id="bmdescription">';
	//$html.= str_replace('{br}','<br/>',$this->Workout->Description);
	//$html.='</div>';
	$html.='<form name="clockform" action="index.php">
        <input type="hidden" name="module" value="benchmark"/>
        <input type="hidden" name="benchmarkId" value="'.$_REQUEST['id'].'"/>
		<input type="hidden" name="wodtype" value="3"/>
		<input type="hidden" name="action" value="save"/>';
	$html.=$this->Workout->InputFields;	
	//id of timed activity below:
    $html.='<input id="clock" name="63___TimeToComplete" value="00:00:0"/>';
	$html.='<input class="buttongroup" type="button" onclick="startstop()" value="Start/Stop"/>';
    $html.='<input class="buttongroup" type="button" onclick="reset()" value="Reset"/>';
	 $html.='<input class="buttongroup" type="submit" value="Save"/>';
    $html.='</form><br/><br/>';		
/*	
    $html.='<div style="margin:0 30% 0 30%; width:50%">
        <img alt="Start" '.$Start.' src="'.ImagePath.'start.png" onclick="start()"/>&nbsp;&nbsp;
        <img alt="Stop" '.$Stop.' src="'.ImagePath.'stop.png" onclick="stop()"/><br/><br/>
        <img alt="Reset" '.$Reset.' src="'.ImagePath.'reset.png" onclick="reset()"/>&nbsp;&nbsp;
        <img alt="Save" '.$Save.' src="'.ImagePath.'save.png" onclick="save()"/>
        </div>';
*/
}
else if(isset($_REQUEST['catid']))
{
	if($this->Category == 'Historic'){
		$html.= $this->getHistory();
	}
	else{
               $html .= '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d" data-icon="none">';
                foreach($this->BMWS AS $Exercise){
					$Description = str_replace('{br}',' | ',$Exercise->Description);
					$html .= '<li>
                        <a href="" onclick="getDetails('.$Exercise->Id.');">'.$Exercise->Name.':<br/><span style="font-size:small">'.$Description.'</span></a>
                    </li>';
                }	
				$html .= '</ul><br/>';
	}
/*
	$ImageSize = $RENDER->NewImage('BM_Select.png', $this->Device->GetScreenWidth());
    $explode = explode('"',$ImageSize);
    $height = $explode[1];
	foreach($this->BMWS AS $BMW){ 

		$html.='<div class="benchmark" style="height:'.$height.'px;">
		<div style="width:70%;margin:4% 0 0 4%;float:left;font-size:large;background-color:#fff;">';
		//<a href="index.php?module=benchmark&id='.$BMW->Id.'&video='.$BMW->Video.'&banner='.$BMW->Banner.'"">
		$html.=''.$BMW->Name.'';
		//</a>
		$html.='</div>
		<div style="width:15%;margin:0 0.5% 1% 0;background-color:#fff;float:right">';
		//<a href="index.php?module=benchmark&id='.$BMW->Id.'&video='.$BMW->Video.'&banner='.$BMW->Banner.'"">
		$html.='<img onclick="getDetails(\''.$BMW->Id.'\');" '.$ImageSize.' alt="'.$BMW->Name.'" src="'.ImagePath.'BM_Select.png"/>';
		//</a>
		$html.='</div>
		</div>
		<div class="clear"></div>';
		
		//$html.='<h3><a href="index.php?module=benchmark&id='.$BMW->Id.'&banner='.$BMW->Name.'">'.$BMW->Name.'</a></h3>';
	}
	$html.='<br/>';
*/
}
/*
else
{

	$html.=$this->BenchmarkSelection();

	foreach($this->Categories AS $Category){ 
		$ImageSize = $RENDER->NewImage(''.$Category->Image.'.png', $this->Device->GetScreenWidth());
		$html.='<div>';
		//$test='<a href="index.php?module=benchmark&catid='.$Category->Id.'&banner='.$Category->Banner.'">';
		$html.='<img onclick="getBenchmarks(\''.$Category->Id.'\');" '.$ImageSize.' style="margin:2% 5% 3% 5%" alt="'.$Category->Name.'" src="'.ImagePath.''.$Category->Image.'.png"/>';
		//$test='</a>';
		$html.='</div>';	
		//$html.='<h3><a href="index.php?module=benchmark&catid='.$Category->Id.'&banner='.$Category->Name.'">'.$Category->Name.'</a></h3>';
	}
}	
*/
return $html;
	}
	
	function getHistory()
	{
		$Model = new BenchmarkModel;
		$HistoricalData = $Model->getHistory();
		if(empty($HistoricalData)){
			$History = 'Oops! You have not recorded any Benchmark workouts yet.';
		}else{
			foreach($HistoricalData AS $Data){
				$History.=''.$Data->TimeCreated.' : '.$Data->Name.' : '.$Data->AttributeValue.'<br/>';
			}
		}
		return $History;
	}
	
	function BenchmarkSelection()
	{
		$Html='<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">';
		if($_REQUEST['catid'] == '1'){
			$Html.='<li>The Girls</li>';
		}else if($_REQUEST['catid'] == '2'){
			$Html.='<li>The Heros</li>';
		}else if($_REQUEST['catid'] == '3'){
			$Html.='<li>Travel</li>';
		}else if($_REQUEST['catid'] == '4'){
			$Html.='<li>Historic</li>';		
		}else{
			$Html.='<li><a href="#" onclick="OpenThisPage(\'?module=benchmark&catid=1\')">The Girls</a></li>
				<li><a href="#" onclick="OpenThisPage(\'?module=benchmark&catid=2\')">The Heros</a></li>
				<li><a href="#" onclick="OpenThisPage(\'?module=benchmark&catid=3\')">Travel</a></li>
				<li><a href="#" onclick="OpenThisPage(\'?module=benchmark&catid=4\')">Historic</a></li>';
		}
		$Html.='</ul>';
		return $Html;	
	}
}
?>