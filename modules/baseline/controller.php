<?php
class BaselineController extends Controller
{
    var $Baseline;
    var $SelectedBaseline;
    var $SaveMessage;
	
	function __construct()
	{
            parent::__construct();
            session_start();
            if(!isset($_SESSION['UID'])){
                header('location: index.php?module=login');	
            }

	}
    
    function SaveWorkout()
	{
		$Model = new BaselineModel;
		return $Model->Log();
	}
    
    function Output()
    {
        $Html = '';
        if($_REQUEST['action'] == 'save'){
            $Html .= '<div id="message">'.$this->SaveWorkout().'</div>';
        }

      	$RENDER = new Image(SITE_ID);
	$Model = new BaselineModel;
        if($_REQUEST['action'] == 'savecustom'){
            //validate
            $exerciseId = $Model->SaveCustom();
			$Html .= $this->CustomDetails($exerciseId);
        }
	else if($_REQUEST['baseline'] == 'Custom'){//custom
	
	}
		else if($_REQUEST['baseline'] == 'Baseline'){//Baseline
            $Html.= $this->getStopWatch('0'); 
		}
		else if($_REQUEST['baseline'] == 'Benchmark'){//Benchmarks
			$Benchmarks = $Model->getBenchmarks();	
            
            $Html .= '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d" data-icon="none">';
            foreach($Benchmarks AS $Exercise){
                $Description = str_replace('{br}',' | ',$Exercise->Description);
                $Html .= '<li>
                <a href="" onclick="getBenchmark('.$Exercise->recid.');">'.$Exercise->ActivityName.':<br/><span style="font-size:small">'.$Description.'</span></a>
                </li>';
            }	
            $Html .= '</ul><br/>';
            
		}
		else if(isset($_REQUEST['benchmark'])){
			$Benchmark = $Model->getBenchmark($_REQUEST['benchmark']);
            $Html.='<div id="bmdescription">';
            $Html.= str_replace('{br}','<br/>',$Benchmark->Description);
            $Html.='</div>';
            $Html.= $this->getStopWatch($_REQUEST['benchmark']);        
		}		
		return $Html;
    }
    
    function getCustomBaselineActivities()
    {        
        $Model = new BaselineModel;
        $InputFields = $Model->getBaselineInputFields();
        foreach($InputFields AS $Field){
            $Html.='<div class="ui-block-a">
            <input class="textinput" style="width:75%" type="text" data-inline="true" name="Activity" value="Squat"/>
            </div>
            <div class="ui-block-b"></div>
            <div class="ui-block-c">
            <input class="textinput" style="width:75%" type="text" data-inline="true" name="Reps" value="40"/>
            </div>';        
        }   
    }
    
    function getMemberBaselineActivities()
    {
        $Model = new BaselineModel;
        $Activities = $Model->getMemberBaselineActivities();
        $Html.='<div class="ui-grid-b">
        <div class="ui-block-a">
        Activity
        </div>
        <div class="ui-block-b">
        Distance
        </div>
        <div class="ui-block-c">
        Reps
        </div>';
        

        foreach($Activities AS $Activity){
            $Html.='<div class="ui-block-a">
            <input class="textinput" style="width:75%" readonly="readonly" type="text" data-inline="true" name="'.$Activity->recid.'" value="'.$Activity->ActivityName.'"/>
            </div>';
            $Html.='<div class="ui-block-b">';
            if($Activity->Attribute == 'Distance')
                $Html.='<input class="textinput" style="width:75%" type="text" data-inline="true" name="'.$Activity->recid.'___Distance" value="'.$Activity->AttributeValue.'"/>';
            $Html.='</div>';
            $Html.='<div class="ui-block-c">';
            if($Activity->Attribute == 'Reps')
                $Html.='<input class="textinput" style="width:75%" type="text" data-inline="true" name="'.$Activity->recid.'___Reps" value="'.$Activity->AttributeValue.'"/>';
            $Html.='</div>';        
        }        
        
        $Html.='</div>';
        
        return $Html;
    }
	
    function CustomDetails($Id)
    {
        $Model = new BaselineModel;
        $Details = $Model->getCustomDetails($Id);
        $Html = '<div style="text-align:center"><h3>'.$Details->ActivityName.'</h3></div>';
        if($Details->ActivityType == 'Timed'){
            $Html.= $this->getStopWatch($Details->recid); 
        }
        else if($Details->ActivityType == 'AMRAP'){
			
            $Html .= $this->getCountDown($Details);
        }
        else if($Details->ActivityType == 'Weight'){
            $Html .= $this->getWeight($Details->recid);
        }
        else if($Details->ActivityType == 'Reps'){
            $Html .= $this->getReps($Details->recid);
        }
        else if($Details->ActivityType == 'Tabata'){
            $Html .= $this->getTabata($Details);
        }
        else if($Details->ActivityType == 'Other'){
            $Html .= '?';
        }
        return $Html;
    }
    
    function getStopWatch($exerciseId)
    {
        //$RENDER = new Image(SITE_ID);
        //$Start = $RENDER->NewImage('start.png', $this->Device->GetScreenWidth());
       // $Stop = $RENDER->NewImage('stop.png', $this->Device->GetScreenWidth());
        //$Reset = $RENDER->NewImage('report.png', $this->Device->GetScreenWidth());
        //$Save = $RENDER->NewImage('save.png', $this->Device->GetScreenWidth());
        $Html='<form name="clockform" id="baselineform" action="index.php">
        <input type="hidden" name="baseline" value="'.$_REQUEST['baseline'].'"/>
        <input type="hidden" name="exercise" value="'.$exerciseId.'"/>
        <input type="hidden" name="action" value="save"/>';
        if($_REQUEST['baseline'] == 'Baseline'){
            $Html.=$this->getMemberBaselineActivities();
        }
        $TimeToComplete = '00:00:0';
        $StartStopButton = 'Start';
        if(isset($_REQUEST['TimeToComplete'])){
            $TimeToComplete = $_REQUEST['TimeToComplete'];
            if($TimeToComplete != '00:00:0')
                $StartStopButton = 'Stop';            
        }
        $Html.='<input type="text" id="clock" name="63___TimeToComplete" value="'.$TimeToComplete.'"/>';
	$Html.='<input id="startstopbutton" class="buttongroup" type="button" onClick="startstop();" value="'.$StartStopButton.'"/>';
	$Html.='<input id="resetbutton" class="buttongroup" type="button" onClick="resetclock();" value="Reset"/>';
	$Html.='<input class="buttongroup" type="button" onclick="baselinesubmit();" value="Save"/>';
        $Html.='</form><br/><br/>';
		/*
        $Html.='<div style="margin:0 30% 0 30%; width:50%">
        <img alt="Start" '.$Start.' src="'.ImagePath.'start.png" onclick="start();"/>&nbsp;&nbsp;
        <img alt="Stop" '.$Stop.' src="'.ImagePath.'stop.png" onclick="stop();"/><br/><br/>
        <img alt="Reset" '.$Reset.' src="'.ImagePath.'reset.png" onclick="reset();"/>&nbsp;&nbsp;
        <img alt="Save" '.$Save.' src="'.ImagePath.'save.png" onclick="baselinesubmit();"/>
        </div><br/><br/>';
        */
        return $Html;
    }
    
    function getWeight($exerciseId)
    {
		$RENDER = new Image();
		$Save = $RENDER->NewImage('save.png', SCREENWIDTH);
        $Html='<form name="form" action="index.php">
        <input type="hidden" name="module" value="baseline"/>
        <input type="hidden" name="baseline" value="'.$_REQUEST['baseline'].'"/>
        <input type="hidden" name="exercise" value="'.$exerciseId.'"/>
        <input type="hidden" name="action" value="save"/>
		<input type="number" name="Weight" value="" placeholder="Weight"/><br/><br/>
        <img alt="Save" '.$Save.' src="'.ImagePath.'save.png" onclick="document.form.submit();"/>
        </form>';
        
        return $Html;        
    }
    
    function getReps($exerciseId)
    {
		$RENDER = new Image();
		$Save = $RENDER->NewImage('save.png', SCREENWIDTH);
        $Html='<form name="form" action="index.php">
        <input type="hidden" name="module" value="baseline"/>
        <input type="hidden" name="baseline" value="'.$_REQUEST['baseline'].'"/>
        <input type="hidden" name="exercise" value="'.$exerciseId.'"/>
        <input type="hidden" name="action" value="save"/>
		<input type="number" name="Reps" value="" placeholder="Reps"/><br/><br/>
        <img alt="Save" '.$Save.' src="'.ImagePath.'save.png" onclick="document.form.submit();"/>
        </form>';
        
        return $Html;         
    }
    
    function getTabata($Details)
    {
        $Html='Tabata';
        
        return $Html;       
    }
    
    function getCountDown($Details)
    {
        $RENDER = new Image();
        $Start = $RENDER->NewImage('start.png', SCREENWIDTH);
        $Stop = $RENDER->NewImage('stop.png', SCREENWIDTH);
        $Reset = $RENDER->NewImage('report.png', SCREENWIDTH);
        $Save = $RENDER->NewImage('save.png', SCREENWIDTH);
        $Html='<form name="clockform" action="index.php">
        <input type="hidden" name="module" value="baseline"/>
        <input type="hidden" name="baseline" value="'.$_REQUEST['baseline'].'"/>
        <input type="hidden" name="exercise" value="'.$Details->recid.'"/>
        <input type="hidden" name="action" value="save"/>
		<input type="hidden" name="CountDown" value="'.$Details->AttributeValue.'"/>
		<input type="hidden" name="Rounds" id="rounds" value="0"/>
        <input id="clock" name="timer" value="'.$Details->AttributeValue.'"/>
        </form>	
        <div style="margin:0 30% 0 30%; width:50%">
        <img alt="Start" '.$Start.' src="'.ImagePath.'start.png" onclick="startcountdown(document.clockform.timer.value)"/>&nbsp;&nbsp;
        <img alt="Stop" '.$Stop.' src="'.ImagePath.'stop.png" onclick="stopcountdown()"/><br/><br/>
        <img alt="Reset" '.$Reset.' src="'.ImagePath.'reset.png" onclick="resetcountdown(\''.$Details->AttributeValue.'\')"/>&nbsp;&nbsp;
        <img alt="Save" '.$Save.' src="'.ImagePath.'save.png" onclick="save()"/>
        </div><br/>
		<ul data-role="listview" id="listview" data-inset="true">
        <li><a href="" onclick="countclicks();">+ Rounds <span class="ui-li-count">0</span></a></li>
		</ul>
		<br/>';
        
        return $Html;
    }
}
?>