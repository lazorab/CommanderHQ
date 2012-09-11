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

        $WODTypes = $Model->getCustomTypes();
	$Exercises = $Model->getExercises();
        $Html .= '<form action="index.php" id="customform" name="form">';
        $Html .= '<input type="hidden" name="module" value="custom"/>';
        $Html .= '<select class="select" name="wodtype" id="wodtype" onchange="this.form.submit();">
            <option value="none">Custom Type</option>';
	foreach($WODTypes AS $WODType){
            $Html .= '<option id="'.$WODType->recid.'" value="'.$WODType->ActivityType.'"';
            if($WODType->ActivityType == $_REQUEST['wodtype'])
                $Html .='selected="selected"';
            $Html .= '>'.$WODType->ActivityType.'</option>';
        }
	$Html .= '</select></form><br/>';
        if(isset($_REQUEST['wodtype'])){
        $Html .= '<form action="index.php" id="customform" name="form">
		<input type="hidden" name="action" value="save"/>
		<input type="hidden" name="wodtype" value="new'.$_REQUEST['wodtype'].'"/>
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
               <div id="clock_input"></div>';
                
  	if($_REQUEST['wodtype'] == 'Timed'){
            $Html.= $this->getStopWatch();
		$SubmitOption = false;	
        }
        else if($_REQUEST['wodtype'] == 'AMRAP'){
            $Html.= $this->getCountDown($Detail);
		$SubmitOption = false;
        }
        else if($_REQUEST['wodtype'] == 'EMOM'){
            $Html.= $this->getCountDown('01:00:0');
		$SubmitOption = false;
        }  
        else if($_REQUEST['wodtype'] == 'Total Reps'){
            $Html .='<input type="number" name="Reps" value="" placeholder="Total Reps"/>';
        }
        else if($_REQUEST['wodtype'] == 'Total Rounds'){
            $Html.='<div class="ui-grid-a">';
            $Html .='<div class="ui-block-a"><input class="buttongroup" data-inline="true" type="button" onclick="addRound();" value="+ Round"/></div>';
            $Html .='<div class="ui-block-b"><input id="addround" data-inline="true" type="number" name="Rounds" value="0"/></div>';
            $Html.='</div>';
        }
        $Html.='<div id="btnsubmit"></div>

                                                     
               </form><br/>';
        }
		
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
 		if($_REQUEST['wodtype'] == 'Timed'){
            $AddLast = $this->getStopWatch();
		$SubmitOption = true;	
        }
        if($_REQUEST['wodtype'] == 'AMRAP'){
            $AddLast = $this->getCountDown($Detail);
		$SubmitOption = true;
        }
        
        if($_REQUEST['wodtype'] == 'EMOM'){
            $AddLast = $this->getCountDown('01:00:0');
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
			$Html.='<input class="buttongroup" type="button" onclick="savecustom();" value="Save"/>';
		$Html.='</form>';
        return $Html;
    }
    
	function getStopWatch()
    {
	$RoundNo = 0;
        $ExerciseId = 63;
        $TimeToComplete = '00:00:0';
        $StartStopButton = 'Start';
        if(isset($_REQUEST[''.$RoundNo.'___'.$ExerciseId.'___TimeToComplete'])){
            $TimeToComplete = $_REQUEST[''.$RoundNo.'___'.$ExerciseId.'___TimeToComplete'];
            if($TimeToComplete != '00:00:0')
                $StartStopButton = 'Stop';
        }
	$Html ='<input type="text" id="clock" name="'.$RoundNo.'___'.$ExerciseId.'___TimeToComplete" value="'.$TimeToComplete.'" readonly/>';
	$Html.='<input id="startstopbutton" class="buttongroup" type="button" onClick="startstop();" value="'.$StartStopButton.'"/>';
        //$Html.='<input id="splitbutton" class="buttongroup" type="button" value="Split time" onClick="splittime();"/>';
	$Html.='<input id="resetbutton" class="buttongroup" type="button" onClick="resetclock();" value="Reset"/>';
        
        
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
		<input type="number" name="Reps" value="" placeholder="Total Reps"/><br/><br/>
        <img alt="Save" '.$Save.' src="'.ImagePath.'save.png" onclick="document.form.submit();"/>
        </form>';
        
        return $Html;         
    }
    
    function getTabata($Details)
    {
        $Html='Tabata';
        
        return $Html;       
    }
    
    function getCountDown($Time)
    {
	$RoundNo = 0;
        $ExerciseId = 63;
        $TimeToComplete = $Time;
        $StartStopButton = 'Start';
        if(isset($_REQUEST[''.$RoundNo.'___'.$ExerciseId.'___TimeToComplete'])){
            $TimeToComplete = $_REQUEST[''.$RoundNo.'___'.$ExerciseId.'___TimeToComplete'];
            if($TimeToComplete != $Time)
                $StartStopButton = 'Stop';
        }
	$Html ='<input type="hidden" name="'.$RoundNo.'___'.$ExerciseId.'___CountDown" id="CountDown" value="'.$Time.'"/>';
        $Html.='<input id="clock" name="timer" value="'.$TimeToComplete.'"/>';
        $Html.='<input id="startstopbutton" class="buttongroup" type="button" onClick="startstopcountdown();" value="'.$StartStopButton.'"/>';
        $Html.='<input id="resetbutton" class="buttongroup" type="button" onClick="resetcountdown();" value="Reset"/>';
		
        return $Html;
    }
}
?>