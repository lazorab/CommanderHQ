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
		$Model = new BenchmarkModel;
		if(isset($_REQUEST['id']))
			$this->Workout = $Model->getWorkoutDetails($_REQUEST['id']);
		
		$this->Categories = $Model->getCategories();
		if(isset($_REQUEST['catid'])){
			$this->Category = $Model->getCategory($_REQUEST['catid']);
			$this->BMWS = $Model->getBMWS($_REQUEST);
		}
		
		if($_REQUEST['form'] == 'submitted'){
			$Success = $Model->Log($_REQUEST);
		}
	}
	
	function html()
	{
	$RENDER = new Image(SITE_ID);
		$html='<br/>';
		
if(isset($_REQUEST['id']))
{
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
else if(isset($_REQUEST['catid']))
{
	$Image = $RENDER->Image('BM_Select.png', $this->Device->GetScreenWidth());
	$explode = explode("_", $Image);
	$height = $explode[2];
	foreach($this->BMWS AS $BMW){ 

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
		//$html.='<h3><a href="index.php?module=benchmark&id='.$BMW->Id.'&banner='.$BMW->Name.'">'.$BMW->Name.'</a></h3>';
	}
	$html.='<br/>';
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
	var flagclock = 0;
	var flagstop = 0;
	var stoptime = 0;
	var splitcounter = 0;
	var currenttime;
	var splitdate = "";
	var clock;
	
	function save()
	{
		clockform.submit();
	}
		
	function start()
		{
		var startdate = new Date();
		var starttime = startdate.getTime();

		flagclock = 1;
		counter(starttime);
		}
		
	function stop()
		{
		var startdate = new Date();
		var starttime = startdate.getTime();

		flagclock = 0;
		flagstop = 1;
		splitdate = "";
		}	
		
	function counter(starttime)
		{
		clock = document.getElementById("clock");
		currenttime = new Date();
		var timediff = currenttime.getTime() - starttime;
		if(flagstop == 1)
			{
			timediff = timediff + stoptime
			}
		if(flagclock == 1)
			{
			clock.value = formattime(timediff,"");
			refresh = setTimeout("counter(" + starttime + ");",10);
			}
		else
			{
			window.clearTimeout(refresh);
			stoptime = timediff;
			}
		}
		
	function formattime(rawtime,roundtype)
		{
		if(roundtype == "round")
			{
			var ds = Math.round(rawtime/100) + "";
			}
		else
			{
			var ds = Math.floor(rawtime/100) + "";		
			}
		var sec = Math.floor(rawtime/1000);
		var min = Math.floor(rawtime/60000);
		ds = ds.charAt(ds.length - 1);
		if(min >= 60)
			{
			start();
			}
		sec = sec - 60 * min + "";
		if(sec.charAt(sec.length - 2) != "")
			{
			sec = sec.charAt(sec.length - 2) + sec.charAt(sec.length - 1);
			}
		else
			{
			sec = 0 + sec.charAt(sec.length - 1);
			}	
		min = min + "";
		if(min.charAt(min.length - 2) != "")
			{
			min = min.charAt(min.length - 2)+min.charAt(min.length - 1);
			}
		else
			{
			min = 0 + min.charAt(min.length - 1);
			}
		return min + ":" + sec + ":" + ds;
		}
		
	function reset()
		{
		flagstop = 0;
		stoptime = 0;
		splitdate = "";
		window.clearTimeout(refresh);
		splitcounter = 0;
		if(flagclock == 1)
			{
			var resetdate = new Date();
			var resettime = resetdate.getTime();
			counter(resettime);
			}
		else
			{
			clock.value = "00:00:0";
			}
		}
		
    function GetVideo(filename)
    {
		document.getElementById("videobutton").innerHTML = \'<wall:img alt="Video" src="'.$VideoImage.'"/>\';
        document.getElementById("video").innerHTML = \'<iframe marginwidth="0px" marginheight="0px" width="'.$this->Device->GetScreenWidth().'" height="'.($this->Device->GetScreenWidth() * 0.717).'" src="\' + filename + \'" frameborder="0"><\/iframe>\';
    }
</script>';
}
		return $CustomHeader;
	}
	
}
?>