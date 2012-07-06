<?php
class WodController extends Controller
{
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
        if(isset($_REQUEST['customtype'])){
            $Model->SaveCustom();
        }
		if($_REQUEST['wodtype'] == 1){//custom
            $MemberCustomExercises = $Model->getMemberCustomExercises();
            if(count($MemberCustomExercises) == 1){
                echo $this->CustomDetails($MemberCustomExercises[0]->recid);
            }
            else if(isset($_REQUEST['customexercise'])){
                echo $this->CustomDetails($_REQUEST['customexercise']);               
            }
            else if(count($MemberCustomExercises) > 1){
               $WODdata .= 'Available Exercises:<br/>
                <select id="customexercises" name="customexercise" class="select" onchange="document.form.submit();">
                <option value="">Please Select</option>';
                foreach($MemberCustomExercises AS $Exercise){
                    $WODdata .= '<option value="'.$Exercise->recid.'">'.$Exercise->ActivityName.'</option>';
                }
                $WODdata .= '</select><br/><br/>';
            }
            else{
                $CustomTypes = $Model->getCustomTypes();
                $WODdata .= '
                <form action="index.php" id="test" name="form">
                <input type="hidden" name="module" value="wod"/>
                <input type="hidden" name="wodtype" value="1"/>
                <br/>New Exercise Name:<br/>
                <input type="text" name="newcustom"/><br/><br/>
                <label for="custom">Type</label><br/>
                    <select id="customselect" name="customtype" class="select" onchange="document.form.submit();">
                    <option value="">Please Select</option>';
                    foreach($CustomTypes AS $Type){
                        $WODdata .= '<option value="'.$Type->recid.'">'.$Type->ActivityType.'</option>';
                    }
                $WODdata .= '</select></form><br/><br/>';               
            }
		}
		else if($_REQUEST['wodtype'] == 2){//my gym
		
		}
		else if($_REQUEST['wodtype'] == 3){//benchmarks
			$Benchmarks = $Model->getBenchmarks();	
            $ImageSize = $RENDER->NewImage('BM_Select.png', $this->Device->GetScreenWidth());
            $explode = explode('"',$ImageSize);
            $height = $explode[1];
			foreach($Benchmarks as $WOD)
			{
                $WODdata.='<div class="benchmark" style="height:'.$height.'px;">
                    <div style="width:70%;margin:4% 0 0 4%;float:left;font-size:large;background-color:#fff;">';
                $WODdata.=''.$WOD->ActivityName.'';
                $WODdata.='</div>
                    <div style="width:15%;margin:0 0.5% 1% 0;background-color:#fff;float:right">';
                $WODdata.='<img onclick="getBenchmark(\''.$WOD->recid.'\');" '.$ImageSize.' alt="'.$WOD->ActivityName.'" src="'.ImagePath.'BM_Select.png"/>';
                $WODdata.='</div>
                    </div>
                    <div class="clear"></div>';
            }
            $WODdata.='<br/>';
		}
		else if(isset($_REQUEST['benchmark'])){
			$WOD = $Model->getBenchmark($_REQUEST['benchmark']);
            $WODdata.='<div id="bmdescription">';
            $WODdata.= $WOD->Description;
            $WODdata.='</div>';
            $WODdata.= $this->StopWatch(3, $_REQUEST['benchmark']);        
		}		
		return $WODdata;	
	}
    
    function CustomDetails($Id)
    {
        $Model = new WodModel;
        $Details = $Model->getCustomDetails($Id);
        $WODdata = '<div style="text-align:center"><h3>'.$Details->ActivityName.'</h3></div>';
        if($Details->ActivityType == 'Timed'){
            $WODdata.= $this->getStopWatch(1, $Details->recid); 
        }
        else if($Details->ActivityType == 'AMRAP'){
            $WODdata .= $this->getAMRAP();
        }
        else if($Details->ActivityType == 'Weight'){
            $WODdata .= $this->getWeight();
        }
        else if($Details->ActivityType == 'Reps'){
            $WODdata .= $this->getReps();
        }
        else if($Details->ActivityType == 'Tabata'){
            $WODdata .= $this->getTabata();
        }
        else if($Details->ActivityType == 'Other'){
            $WODdata .= '?';
        }
        return $WODdata;
    }
    
    function getStopWatch($Type, $Value)
    {
        $RENDER = new Image(SITE_ID);
        $Start = $RENDER->NewImage('start.png', $this->Device->GetScreenWidth());
        $Stop = $RENDER->NewImage('stop.png', $this->Device->GetScreenWidth());
        $Reset = $RENDER->NewImage('report.png', $this->Device->GetScreenWidth());
        $Save = $RENDER->NewImage('save.png', $this->Device->GetScreenWidth());
        $WODdata='<form name="clockform" action="index.php">
        <input type="hidden" name="module" value="wod"/>
        <input type="hidden" name="wodtype" value="'.$Type.'"/>
        <input type="hidden" name="exercise" value="'.$Value.'"/>
        <input type="hidden" name="action" value="save"/>
        <input id="clock" name="TimeToComplete" value="00:00:0"/>
        </form>	
        <div style="margin:0 30% 0 30%; width:50%">
        <img alt="Start" '.$Start.' src="'.ImagePath.'start.png" onclick="start()"/>&nbsp;&nbsp;
        <img alt="Stop" '.$Stop.' src="'.ImagePath.'stop.png" onclick="stop()"/><br/><br/>
        <img alt="Reset" '.$Reset.' src="'.ImagePath.'reset.png" onclick="reset()"/>&nbsp;&nbsp;
        <img alt="Save" '.$Save.' src="'.ImagePath.'save.png" onclick="save()"/>
        </div><br/><br/>';
        
        return $WODdata;
    }
    
    function getAMRAP()
    {
        $Html='AMRAP';
        
        return $Html;
    }
    
    function getWeight()
    {
        $Html='Weight';
        
        return $Html;        
    }
    
    function getReps()
    {
        $Html='Reps';
        
        return $Html;        
    }
    
    function getTabata()
    {
        $Html='Tabata';
        
        return $Html;       
    }
    
    function getCountDown($Type, $Value)
    {
        $RENDER = new Image(SITE_ID);
        $Start = $RENDER->NewImage('start.png', $this->Device->GetScreenWidth());
        $Stop = $RENDER->NewImage('stop.png', $this->Device->GetScreenWidth());
        $Reset = $RENDER->NewImage('report.png', $this->Device->GetScreenWidth());
        $Save = $RENDER->NewImage('save.png', $this->Device->GetScreenWidth());
        $WODdata='<form name="clockform" action="index.php">
        <input type="hidden" name="module" value="wod"/>
        <input type="hidden" name="wodtype" value="'.$Type.'"/>
        <input type="hidden" name="exercise" value="'.$Value.'"/>
        <input type="hidden" name="action" value="save"/>
        <input id="clock" name="TimeToComplete" value="'.$Time.'"/>
        </form>	
        <div style="margin:0 30% 0 30%; width:50%">
        <img alt="Start" '.$Start.' src="'.ImagePath.'start.png" onclick="start()"/>&nbsp;&nbsp;
        <img alt="Stop" '.$Stop.' src="'.ImagePath.'stop.png" onclick="stop()"/><br/><br/>
        <img alt="Reset" '.$Reset.' src="'.ImagePath.'reset.png" onclick="reset()"/>&nbsp;&nbsp;
        <img alt="Save" '.$Save.' src="'.ImagePath.'save.png" onclick="save()"/>
        </div><br/><br/>';
        
        return $WODdata;
    }
}
?>