<?php
class CustomController extends Controller
{
	var $Origin;
	function __construct()
	{
		parent::__construct();
		session_start();
        if(!isset($_SESSION['UID'])){
            header('location: index.php?module=login');	
        }
		$this->Origin = $_REQUEST['origin'];
		
        if($_REQUEST['action'] == 'save'){
            $this->SaveWorkout();
        }
	}
    
    function SaveWorkout()
	{
		$Model = new CustomModel;
		$Save = $Model->Log();
	}
    
    function Output()
    {
		$Html = '';
		$RENDER = new Image(SITE_ID);
		$Model = new CustomModel;
        if($_REQUEST['action'] == 'savecustom'){
            //validate
            $exerciseId = $Model->SaveCustom();
			$Html = $this->CustomDetails($exerciseId);
        }
		else{			
            $MemberCustomExercises = $Model->getMemberCustomExercises();
            if(isset($_REQUEST['customexercise']) && $_REQUEST['customexercise'] != 'new'){
                $Html = $this->CustomDetails($_REQUEST['customexercise']);               
            }
            else if($_REQUEST['customexercise'] != 'new'){
                $Html = '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
					<li><a href="#" onclick="OpenThisPage(\'?module=custom&customexercise=new&origin='.$this->Origin.'\');">Create New Exercise</a></li>';
                foreach($MemberCustomExercises AS $Exercise){
					$Html .= '<li><a href="#" onclick="OpenThisPage(\'?module=custom&customexercise='.$Exercise->recid.'&origin='.$this->Origin.'\');">'.$Exercise->ActivityName.'</a></li>';
                }	
				$Html .= '</ul><br/>';
            }
            if(count($MemberCustomExercises) == 0 || $_REQUEST['customexercise'] == 'new'){
                $CustomTypes = $Model->getCustomTypes();
				$Exercises = $Model->getExercises();
                $Html = '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">';
                $Html .= '<li>New Exercise</li>';
				$Html .= '</ul><br/>';		
				$Html .= '<form action="index.php" id="test" name="form">
					<input type="hidden" name="module" value="custom"/>
					<input type="hidden" name="action" value="savecustom"/>
					<input type="hidden" name="customexercise" value="new"/>
					<input type="hidden" name="origin" value="'.$this->Origin.'"/>
					<input type="hidden" name="fieldcount" id="fieldcounter" value="0"/>
					<input type="text" name="newcustom" placeholder="Exercise Name"/><br/><br/>';
				$Html .= '<select class="select" name="exercise" id="exercise">
					<option value="">Exercise</option>';	
				foreach($Exercises AS $Exercise){
					$Html .= '<option id="'.$Exercise->recid.'" value="'.$Exercise->ActivityName.'">'.$Exercise->ActivityName.'</option>';
				}		
				$Html .= '</select><br/>';	
				$Html .= '<select class="select" name="customtype" id="customtype" onchange="getCustomInputs(this.value);">
					<option value="">Activity Type</option>';
                foreach($CustomTypes AS $Type){
					$Disabled = '';
					if($Type->ActivityType == 'Tabata' || $Type->ActivityType == 'Other')
						$Disabled = ' disabled="disabled"';
					$Html .= '<option id="'.$Type->ActivityType.'" value="'.$Type->ActivityType.'" '.$Disabled.'>'.$Type->ActivityType.'</option>';
                        }	
				$Html .= '</select><br/>';
				$Html .= '<div id="custom_input"></div>';
					$Html .= '<button type="submit" data-theme="b" name="submit">Done</button>
					</form><br/>';
            }
		}
		return $Html;
    }
    
    function getCustomActivities()
    {        
        $Model = new CustomModel;
        $InputFields = $Model->getInputFields();
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
    
    function getMemberActivities()
    {
        $Model = new CustomModel;
        $Activities = $Model->getMemberActivities();
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
        $Model = new CustomModel;
        $Details = $Model->getCustomDetails($Id);
		$SubmitOption = false;
        $Html = '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
		<li>'.$Details[0]->ActivityName.'</li>
		</ul><br/>

		<form name="customform" action="index.php">
        <input type="hidden" name="module" value="custom"/>
		<input type="hidden" name="action" value="save"/>
		<input type="hidden" name="exercise" value="'.$_REQUEST['customexercise'].'"/>
		<input type="hidden" name="origin" value="'.$this->Origin.'"/>';

		foreach($Details AS $Detail){
 		if($Detail->ActivityType == 'Timed'){
            $AddLast = $this->getStopWatch($Detail->recid);
			$SubmitOption = true;	
        }
        if($Detail->ActivityType == 'AMRAP'){
            $AddLast = $this->getCountDown($Detail);
			$SubmitOption = true;
        }
		
        if($Detail->ActivityType == 'Weight'){
            $Html .= '<label for="'.$Detail->Attribute.'">Weight</label>
			<input id="Weight" type="number" name="Weight" value="'.$Detail->AttributeValue.'"/><br/><br/>';
        }
        if($Detail->ActivityType == 'Reps'){
            $Html .= '<label for="'.$Detail->Attribute.'">Reps</label>
			<input id="Reps" type="number" name="Reps" value="'.$Detail->AttributeValue.'"/><br/><br/>';
        }
        if($Detail->ActivityType == 'Tabata'){
            $Html .= $this->getTabata($Detail);
        }
        if($Detail->ActivityType == 'Other'){
            $Html .= '?';
        }

		}
			$Html.= $AddLast;
		if(!$SubmitOption)
			$Html.='<input type="button" onclick="savecustom();" value="Save"/>';
		$Html.='</form>';
        return $Html;
    }
    
    function getStopWatch($exerciseId)
    {
        $RENDER = new Image(SITE_ID);
        $Start = $RENDER->NewImage('start.png', $this->Device->GetScreenWidth());
        $Stop = $RENDER->NewImage('stop.png', $this->Device->GetScreenWidth());
        $Reset = $RENDER->NewImage('report.png', $this->Device->GetScreenWidth());
        $Save = $RENDER->NewImage('save.png', $this->Device->GetScreenWidth());
        $Html.='<input type="text" id="clock" name="TimeToComplete" value="00:00:0"/>
 
        <div style="margin:0 30% 0 30%; width:50%">
        <img alt="Start" '.$Start.' src="'.ImagePath.'start.png" onclick="start()"/>&nbsp;&nbsp;
        <img alt="Stop" '.$Stop.' src="'.ImagePath.'stop.png" onclick="stop()"/><br/><br/>
        <img alt="Reset" '.$Reset.' src="'.ImagePath.'reset.png" onclick="reset()"/>&nbsp;&nbsp;
        <img alt="Save" '.$Save.' src="'.ImagePath.'save.png" onclick="savecustom();"/>
        </div><br/><br/>';
        
        return $Html;
    }
    
    function getWeight($exerciseId)
    {
		$RENDER = new Image(SITE_ID);
		$Save = $RENDER->NewImage('save.png', $this->Device->GetScreenWidth());
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
		$RENDER = new Image(SITE_ID);
		$Save = $RENDER->NewImage('save.png', $this->Device->GetScreenWidth());
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
        $RENDER = new Image(SITE_ID);
        $Start = $RENDER->NewImage('start.png', $this->Device->GetScreenWidth());
        $Stop = $RENDER->NewImage('stop.png', $this->Device->GetScreenWidth());
        $Reset = $RENDER->NewImage('report.png', $this->Device->GetScreenWidth());
        $Save = $RENDER->NewImage('save.png', $this->Device->GetScreenWidth());
        $Html='
		<input type="hidden" name="CountDown" value="'.$Details->AttributeValue.'"/>
        <input id="clock" name="timer" value="'.$Details->AttributeValue.'"/>
        <div style="margin:0 30% 0 30%; width:50%">
        <img alt="Start" '.$Start.' src="'.ImagePath.'start.png" onclick="startcountdown(document.customform.timer.value)"/>&nbsp;&nbsp;
        <img alt="Stop" '.$Stop.' src="'.ImagePath.'stop.png" onclick="stopcountdown()"/><br/><br/>
        <img alt="Reset" '.$Reset.' src="'.ImagePath.'reset.png" onclick="resetcountdown(\''.$Details->AttributeValue.'\')"/>&nbsp;&nbsp;
        <img alt="Save" '.$Save.' src="'.ImagePath.'save.png" onclick="savecustom()"/>
		</div><br/><br/>';
		
        return $Html;
    }
}
?>