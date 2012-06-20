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
	
	function Output()
	{
		$WODdata = '';
		$RENDER = new Image(SITE_ID);
		$Model = new WodModel;
		
		if($_REQUEST['wodtype'] == 1){//custom
            $MemberCustomExercises = $Model->getMemberCustomExercises();
            if(count($MemberCustomExercises) > 0){
               $WODdata .= '<select id="customexercises" name="customexercises">
                <option value="">Please Select</option>';
                foreach($MemberCustomExercises AS $Exercise){
                    $WODdata .= '<option value="'.$Exercise->recid.'">'.$Exercise->ActivityName.'</option>';
                }
                $WODdata .= '</select>';
            }
            else{
                $WODdata .= 'New Exercise Name<br/>
                <input type="text" name="newcustom"/>';
                $CustomTypes = $Model->getCustomTypes();
                $WODdata .= '
                <form id="test">
                <label for="custom">Type</label>
                    <select id="customselect" name="custom"  onchange="getCustomContent(this.value);">
                    <option value="">Please Select</option>';
                    foreach($CustomTypes AS $Type){
                        $WODdata .= '<option value="'.$Type->recid.'">'.$Type->ActivityType.'</option>';
                    }
                $WODdata .= '</select>';               
            }
            $WODdata .= '</form><br/><br/><br/>';
		}
		else if($_REQUEST['wodtype'] == 2){//my gym
		
		}
		else if($_REQUEST['wodtype'] == 3){//benchmarks
			$Benchmarks = $Model->getBenchmarks();	
			foreach($Benchmarks as $WOD)
			{
				$WODdata .= '<a href="#" onclick="getBenchmark('.$WOD->recid.');">'.$WOD->ActivityName.'</a><br/><br/>';	
			}			
		}
		else if(isset($_REQUEST['benchmark'])){
			$WOD = $Model->getBenchmark($_REQUEST['benchmark']);
	$Start = $RENDER->Image('start.png', $this->Device->GetScreenWidth());
	$Stop = $RENDER->Image('stop.png', $this->Device->GetScreenWidth());
	$Reset = $RENDER->Image('report.png', $this->Device->GetScreenWidth());
	$Save = $RENDER->Image('save.png', $this->Device->GetScreenWidth());
	$WODdata.='<div id="bmdescription">';
	$WODdata.= $WOD->Description;
	$WODdata.='</div>';
	$WODdata.='<form name="clockform" action="index.php">
	<input type="hidden" name="module" value="wod"/>
	<input type="hidden" name="wodtype" value="3"/>
	<input type="hidden" name="exercise" value="'.$_REQUEST['benchmark'].'"/>
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
		else{
			$WODdata = 'Make your selection above';
		}
		return $WODdata;	
	}
}
?>