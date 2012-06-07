<?php
class WodController extends Controller
{
	function __construct()
	{
		parent::__construct();
		session_start();
		if($_REQUEST['action'] == 'save')
			if(!isset($_SESSION['UID'])){
				header('location: index.php?module=login');	
			}else{
				$this->Save();
				header('location: index.php?module=wod');
			}
	}
	
	function WodDetails()
	{
		$Model = new WodModel;
		$WOD = $Model->getWOD();
		return $WOD;
	}
	
	function Save()
	{
		$Model = new WodModel;
		$WOD = $Model->Log();
	}
	
	function Content($Params)
	{
		$WODdata = '';
		$RENDER = new Image(SITE_ID);
		
		if($Params['wodtype'] == 1){
		
		}
		else if($Params['wodtype'] == 2){
		
		}
		else if($Params['wodtype'] == 3 && isset($Params['benchmark'])){
			$Model = new WodModel;
			$WOD = $Model->getBenchmark($Params['benchmark']);
	$Start = $RENDER->Image('start.png', $this->Device->GetScreenWidth());
	$Stop = $RENDER->Image('stop.png', $this->Device->GetScreenWidth());
	$Reset = $RENDER->Image('report.png', $this->Device->GetScreenWidth());
	$Save = $RENDER->Image('save.png', $this->Device->GetScreenWidth());
	$WODdata.='<div id="bmdescription">';
	$WODdata.= $WOD->Description;
	$WODdata.='</div>';
	$WODdata.='<form name="clockform" action="index.php">
	<input type="hidden" name="module" value="benchmark"/>
	<input type="hidden" name="benchmarkId" value="'.$Params['benchmark'].'"/>
	<input type="hidden" name="form" value="submitted"/>
<input id="clock" name="clock" value="00:00:0"/>
</form>	
<div style="margin:0 30% 0 30%; width:50%">
<img alt="Start" src="'.$Start.'" onclick="start()"/>&nbsp;&nbsp;
<img alt="Stop" src="'.$Stop.'" onclick="stop()"/><br/><br/>
<img alt="Reset" src="'.$Reset.'" onclick="reset()"/>&nbsp;&nbsp;
<img alt="Save" src="'.$Save.'" onclick="save()"/>
</div><br/><br/>';			
		}
		else{
			$WODdata = 'Make your selection above';
		}
		return $WODdata;	
	}
}
?>