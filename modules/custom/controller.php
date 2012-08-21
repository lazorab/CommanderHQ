<?php
class CustomController extends Controller
{
    var $Origin;
    var $SaveMessage;
    
	function __construct()
	{
		parent::__construct();
		session_start();
        if(!isset($_SESSION['UID'])){
            header('location: index.php?module=login');	
        }
		$this->Origin = $_REQUEST['origin'];
		$this->SaveMessage = '';

	}
    
    function SaveWorkout()
	{
		$Model = new CustomModel;
		return $Model->Log();
	}
    
    function MainOutput()
    {
		$Html = '';
		$Model = new CustomModel;

				$Exercises = $Model->getExercises();
                $Html .= '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">';
                $Html .= '<li>Custom Exercise</li>';
				$Html .= '</ul><br/>';		
				$Html .= '<form action="index.php" id="customform" name="form">
					<input type="hidden" name="action" value="save"/>
					<input type="hidden" name="customexercise" value="new"/>
					<input type="hidden" name="origin" value="'.$this->Origin.'"/>
					<input type="hidden" name="rowcount" id="rowcounter" value="0"/>';
					
				$Html .= '<select class="select" name="exercise" id="exercise" onchange="addNewExercise(this.value);">
					<option value="none">+ Activity</option>';
									foreach($Exercises AS $Exercise){
					$Html .= '<option id="'.$Exercise->recid.'" value="'.$Exercise->ActivityName.'">'.$Exercise->ActivityName.'</option>';
				}
				$Html .= '</select><br/>';
					
				$Html.='<div class="ui-grid-b">
                                            <div id="new_exercise"></div>
                                        </div>
                                        <div id="clock_input"></div>
                                        <div id="btnsubmit"></div>                                      
                                        </form><br/>';	      
		
		return $Html;
    }
	
	function Output()
	{
            if($_REQUEST['action'] == 'save'){
                $html= '<div id="message">'.$this->SaveWorkout().'</div>';
                $html.= $this->MainOutput();
                return $html;
            }
            else{
		$Model = new CustomModel;
		return $Model->getExerciseAttributes($_REQUEST['chosenexercise']);
            }
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
            $AddLast = $this->getStopWatch();
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
    
    function getStopWatch()
    {
        //$RENDER = new Image();
        //$Start = $RENDER->NewImage('start.png', $this->Device->GetScreenWidth());
        //$Stop = $RENDER->NewImage('stop.png', $this->Device->GetScreenWidth());
        //$Reset = $RENDER->NewImage('report.png', $this->Device->GetScreenWidth());
        //$Save = $RENDER->NewImage('save.png', $this->Device->GetScreenWidth());
       // $Html.='<input type="text" id="clock" name="TimeToComplete" value="00:00:0"/>';

        $Html.='<input class="buttongroup" type="button" onclick="startstop()" value="Start/Stop"/>';

        $Html.='<input class="buttongroup" type="button" onclick="reset()" value="Reset"/>';

       // $Html.='<div style="margin:0 30% 0 30%; width:50%">';
        //$Html.='<img alt="Start" '.$Start.' src="'.ImagePath.'start.png" onclick="startstop();"/>&nbsp;&nbsp;';
        //$Html.='<img alt="Stop" '.$Stop.' src="'.ImagePath.'stop.png" onclick="stop()"/><br/><br/>';
        //$Html.='<img alt="Reset" '.$Reset.' src="'.ImagePath.'reset.png" onclick="reset()"/>&nbsp;&nbsp;';
        //$Html.='<img alt="Save" '.$Save.' src="'.ImagePath.'save.png" onclick="savecustom();"/>';
		//$Html.='</div>';
        
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