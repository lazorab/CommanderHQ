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
			if(isset($_COOKIE['Username']) && isset($_COOKIE['Password']))
			{
				header('location: index.php?module=login&redirect=benchmark');			
			}	
			else
				header('location: index.php?module=login');		
		}	
		if($_REQUEST['form'] == 'submitted'){
			$Success = $Model->Log($_REQUEST);
		}
	}
	
	function html()
	{
	$Model = new BenchmarkModel;
	$RENDER = new Image(SITE_ID);
		$html='<br/>';
		
if(isset($_REQUEST['id']))
{
	$this->Workout = $Model->getWorkoutDetails($_REQUEST['id']);
	$Start = $RENDER->Image('start.png', $this->Device->GetScreenWidth());
	$Stop = $RENDER->Image('stop.png', $this->Device->GetScreenWidth());
	$Reset = $RENDER->Image('report.png', $this->Device->GetScreenWidth());
	$Save = $RENDER->Image('save.png', $this->Device->GetScreenWidth());
	$html.='<div id="bmdescription">';
	$html.= $this->Workout->Description;
	$html.='</div>';
	$html.='<form name="clockform" action="index.php">
	<input type="hidden" name="module" value="benchmark"/>
	<input type="hidden" name="benchmarkId" value="'.$_REQUEST['id'].'"/>
	<input type="hidden" name="form" value="submitted"/>
<input id="clock" name="clock" value="00:00:0"/>
</form>	
<div style="margin:0 30% 0 30%; width:50%">
<img src="'.$Start.'" onclick="start()"/>&nbsp;&nbsp;
<img src="'.$Stop.'" onclick="stop()"/><br/><br/>
<img src="'.$Reset.'" onclick="reset()"/>&nbsp;&nbsp;
<img src="'.$Save.'" onclick="save()"/>
</div><br/><br/>';
}
else
{
	$Categories = $Model->getCategories();
	$Header = $RENDER->Image('benchmark.png', $this->Device->GetScreenWidth());
	$Image = $RENDER->Image('BM_Select.png', $this->Device->GetScreenWidth());
	$explode = explode("_", $Image);
	$height = $explode[2];
	$categoryhtml.='<div data-role="page" id="categories">
		<div class="header" data-role="header">
		<img alt="Header" src="'.$Header.'"/>
	</div><!-- /header -->
	<div data-role="content">';
	
	foreach($Categories AS $Category){ 
	$bmwhtml.='<div data-role="page" id="Category_'.$Category->Id.'">
		<div class="header" data-role="header">
		<img alt="Header" src="'.$Header.'"/>
	</div><!-- /header -->
	<div data-role="content">';
	//$Model->getCategory($Category->Id);
	$BMWS = $Model->getBMWS($Category->Id);
		$Image = $RENDER->Image(''.$Category->Image.'.png', $this->Device->GetScreenWidth());
		
		$categoryhtml.='<a href="#Category_'.$Category->Id.'"><img style="margin:2% 5% 3% 5%" alt="Header" src="'.$Image.'"/></a>';	
		//$html.='<h3><a href="index.php?module=benchmark&catid='.$Category->Id.'&banner='.$Category->Name.'">'.$Category->Name.'</a></h3>';
	$bmwhtml.='<ul data-role="listview" data-inset="true" data-filter="true">';
	foreach($BMWS AS $BMW){ 
	
		$bmwhtml.='<li><a href="index.php?module=benchmark&id='.$BMW->Id.'&video='.$BMW->Video.'&banner='.$BMW->Banner.'">'.$BMW->Name.'</a></li>';
	
	/*
		$html.='<div class="benchmark" style="height:'.$height.'px;">
		<div style="width:70%;padding:4%;margin:1%;float:left;font-size:large;background-color:#fff;">
		<a href="index.php?module=benchmark&id='.$BMW->Id.'&video='.$BMW->Video.'&banner='.$BMW->Banner.'">
		'.$BMW->Name.'
		</a>
		</div>
		<div style="width:15%;margin:0 1% 1% 0;background-color:#fff;float:right">
		<a href="index.php?module=benchmark&id='.$BMW->Id.'&video='.$BMW->Video.'&banner='.$BMW->Banner.'">
		<img alt="Header" src="'.$Image.'"/>
		</a>
		</div>
		</div>
		<div class="clear"></div>';
		*/
		//$html.='<h3><a href="index.php?module=benchmark&id='.$BMW->Id.'&banner='.$BMW->Name.'">'.$BMW->Name.'</a></h3>';
	}
	//$html.='<br/>';
	$bmwhtml.='</ul></div><div class="footer" data-role="footer">
		Terms &amp; Conditions | About | Contact
	</div><!-- /footer --></div>';
	
	}
	$html=''.$categoryhtml.'</div><div class="footer" data-role="footer">
		Terms &amp; Conditions | About | Contact
	</div><!-- /footer --></div>'.$bmwhtml.'';
}
	
return $html;
	}	
}
?>