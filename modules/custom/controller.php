<?php
class CustomController extends Controller
{
    var $Origin;
    var $SaveMessage;
    var $ChosenExercises;
    
	function __construct()
	{
            parent::__construct();
            session_start();
            if(!isset($_SESSION['UID'])){
                header('location: index.php?module=login');	
            }
            $this->Origin = $_REQUEST['origin'];
            $this->SaveMessage = '';
            if(!isset($_REQUEST['form']) && !isset($_REQUEST['NewExercise']))
                $this->ChosenExercises = array();
	}
        
    function Message()
    {
        $Model = new CustomModel;
        if(isset($_REQUEST['NewExercise'])){
            $Message = $this->SaveNewExercise();
        }else if($_REQUEST['thisform'] == 'addactivity'){
            $Message = $this->AddActivity();
        }else{
            $Message = $Model->Save();
        }       
        return $Message;
    }  
    
    function AddActivity(){
        $Model = new CustomModel;
        $ActivityFields = $Model->getActivityFields(false);
        $Attributes = $Model->getExerciseIdAttributes($ActivityFields[0]->ExerciseId);
        $i=0;
        //var_dump($ActivityFields);
        $html .= '<div data-role="collapsible-set" data-iconpos="right">'; 
        $html .= '<div data-role="collapsible">';
        $html .= '<h2>'.$ActivityFields[0]->Exercise.'<br/>';
        foreach($ActivityFields as $Activity){
            
            if($Activity->UnitOfMeasureId == null || $Activity->UnitOfMeasureId == 0){
                $UnitOfMeasureId = 0;
                $ConversionFactor = 1;
            }else{
                $UnitOfMeasureId = $Activity->UnitOfMeasureId;
                if($Activity->ConversionFactor == null || $Activity->ConversionFactor == 0){
                    $ConversionFactor = 1;
                }else{
                    $ConversionFactor = $Activity->ConversionFactor;
                }
            }
            if($Activity->AttributeValue == ''){
                $AttributeValue = 'Max';
            }else{
                $AttributeValue = $Activity->AttributeValue * $ConversionFactor;
            }            
                                  
            if($i > 0)
                $html.=' | ';

            $html.=''.$Activity->Attribute.' : <span id="RoundNo_'.$Activity->ExerciseId.'_'.$Activity->Attribute.'_html">'.$AttributeValue.'</span>';

            if($AttributeValue != 'Max'){
                $html.=''.$Activity->UnitOfMeasure.'';
            }
            $i++;
        }  
        $i=0;
        $html .= '</h2><div class="clear"></div><div class="ActivityAttributes">';
        $TheseAttributes='';
        foreach($Attributes as $Attribute){
            if($i > 0)
                $TheseAttributes.='_';
            $TheseAttributes.=$Attribute->Attribute;
            $html .= '<div style="float:left;margin:0 25px 0 25px"">'.$Attribute->Attribute.'<br/><input style="width:80px" type="number" id="RoundNo_'.$Activity->ExerciseId.'_'.$Attribute->Attribute.'_new" name="RoundNo_'.$Activity->ExerciseId.'_'.$Activity->Attribute.'_'.$UnitOfMeasureId.'_'.$Activity->OrderBy.'" placeholder="'.$Attribute->UOM.'"/></div>';    
            $i++;
        }
        $html .= '<div style="float:right;margin:10px 30px 10px 0"><input class="buttongroup" type="button" id="" name="btn" onClick="UpdateActivity(\'RoundNo_'.$Activity->ExerciseId.'\', \''.$TheseAttributes.'\');" value="Update"/></div>';
        $html .= '</div><div class="clear"></div>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }    
    
    function _AddActivity(){
        $Model = new CustomModel;
        $ActivityFields = $Model->getActivityFields(false);
        //var_dump($ActivityFields);
	$ExerciseId = 0;
        $i=0;
        //$html = var_dump($_REQUEST);
        if($Model->Message == ''){
        $html = '<ul id="RoundNo_RowNo" class="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d"><li>';
        
        foreach($ActivityFields as $Activity){
            if($Activity->UnitOfMeasureId == null || $Activity->UnitOfMeasureId == 0){
                $UnitOfMeasureId = 0;
                $ConversionFactor = 1;
            }else{
                $UnitOfMeasureId = $Activity->UnitOfMeasureId;
                if($Activity->ConversionFactor == null || $Activity->ConversionFactor == 0){
                    $ConversionFactor = 1;
                }else{
                    $ConversionFactor = $Activity->ConversionFactor;
                }
            }

            if($ExerciseId != $Activity->ExerciseId){ 
                $html.= ''.$Activity->Exercise.'<input style="float:right" type="button" id="" name="" onClick="RemoveFromList(\'RoundNo_RowNo\');" value="Delete"/><br/>';                           
            }else{
                $html.=' | ';
            }
            
            $html.=''.$Activity->Attribute.' : <span id="RoundNo_'.$Activity->ExerciseId.'_'.$Activity->Attribute.'_html">';
            
            if($Activity->AttributeValue == '' || $Activity->AttributeValue == 0){
                $AttributeValue = 'Max';
                //$html .= '<input style="width:50px" type="number" id="RoundNo_'.$Activity->ExerciseId.'_'.$Activity->Attribute.'" name="RoundNo_'.$Activity->ExerciseId.'_'.$Activity->Attribute.'_'.$UnitOfMeasureId.'_'.$Activity->OrderBy.'_Max" placeholder="Max" value=""/></span>';
            }else{
                $AttributeValue = $Activity->AttributeValue * $ConversionFactor;
            }
                $html.= $AttributeValue;
                $html.='</span>';
                if($AttributeValue != 'Max'){        
                    $html.=''.$Activity->UnitOfMeasure.'';
                }
                $html.='<input type="hidden" id="RoundNo_'.$Activity->ExerciseId.'_'.$Activity->Attribute.'" name="RoundNo_'.$Activity->ExerciseId.'_'.$Activity->Attribute.'_'.$UnitOfMeasureId.'_'.$Activity->OrderBy.'" value="'.$AttributeValue.'">';          
                       
            
            $ExerciseId = $Activity->ExerciseId;
            $i++;
        }   
        $html.='</li></ul>';
            return $html;
        }else{
            return $Model->Message;
        }
    }
    
    function UserUnitOfMeasure($Unit)
    {
        $Model = new CustomModel;
        return $Model->getUserUnitOfMeasure($Unit);
    }
    
    function Validate()
    {
        $Message = '';
        if($_REQUEST['NewExercise'] == ''){
            $Message = 'Error - Must Enter Exercise Name!';
        }else if($_REQUEST['NewActivityWeight'] == '' && $_REQUEST['NewActivityHeight'] == '' && $_REQUEST['NewActivityDistance'] == '' && $_REQUEST['NewActivityReps'] == ''){
            $Message = 'Error - Must Select at least one Attribute';
        //}else if(){
            
        }
        
        return $Message;
    }
    
    function SaveNewExercise()
    {
        $Result = '';

            $Validate = $this->Validate();
            if($Validate == ''){
                $Model = new CustomModel;
                //First Save the new Activity
                //Return Id of new Activity
                $Result = $Model->SaveNewExercise();
            }
            else{
                $Result = $Validate;
            }
            if($Result > 0){
                //Now for a mind f***:
         $WeightUOMId = $Model->getUnitOfMeasureId('Weight');   
         $HeightUOMId = $Model->getUnitOfMeasureId('Height');
         $_REQUEST[''.$_REQUEST['RoundNo'].'_'.$Result.'_Weight_'.$WeightUOMId.'_'.$_REQUEST['OrderBy'].''] = $_REQUEST['NewActivityWeight'];
         
         $_REQUEST[''.$_REQUEST['RoundNo'].'_'.$Result.'_Height_'.$HeightUOMId.'_'.$_REQUEST['OrderBy'].''] = $_REQUEST['NewActivityHeight'];
         $_REQUEST[''.$_REQUEST['RoundNo'].'_'.$Result.'_Distance_'.$_REQUEST['NewActivityDistanceUOM'].'_'.$_REQUEST['OrderBy'].''] = $_REQUEST['NewActivityDistance'];
         $_REQUEST[''.$_REQUEST['RoundNo'].'_'.$Result.'_Reps_0_'.$_REQUEST['OrderBy'].''] = $_REQUEST['NewActivityReps'];
                
                //Now Add it to the Routine
                $Result = $this->AddActivity();
            }
        
        return $Result;
    }
    
    function MainOutput()
    {
	$Html = '';
        $Html .= '<form action="index.php" id="customform" name="form">
        <input type="hidden" name="form" value="submitted"/>
        <input type="hidden" name="origin" value="'.$this->Origin.'"/>
        <input type="hidden" name="rowcount" id="rowcounter" value="0"/>
        <input type="hidden" name="Round1Counter" id="Round1Counter" value="0"/>
        <input type="hidden" name="Rounds" id="addround" value="1"/>
        <input type="hidden" name="RoutineCounter" id="RoutineCounter" value="1"/>
        <input class="textinput" type="date" name="WodDate" id="WodDate" placeholder="WOD Date" value="'.date('Y-m-d').'"/><br/>
            
        <input class="textinput" type="text" name="CustomName" id="CustomName" placeholder="Name for WOD" value=""/><br/>
        
        <textarea name="descr" placeholder="Describe your wod"></textarea><br/>';
        $Html .= '<div id="Routine1Label"></div>';
        $Html .= '<div id="Round1Label"></div>';       
        $Html .= '<div id="activity1list">'.$this->ChosenExercises().'</div>';
        
        $Html .= '<div id="Routines"></div>';
        
        $Html .= '<div class="ui-grid-b">';
        $Html .= '<div id="add_exercise">'.$this->AddExercise().'</div>';
        $Html .= '</div>';       
        
        $Html .= '<div id="SelectActivities">';
        
        $Html .= $this->getExercises('');
        
        $Html .= '<div id="timerContainer">';
        $Html .= '<div class="clear"></div>';
        $Html .= '<div id="clock" onClick="EnterTime();">00:00:0</div>';
        $Html .= '<input type="hidden" id="TimeToComplete" name="TimeToComplete" value="00:00:0">';
        $Html .= '<div class="StopwatchButton"><input id="resetbutton" class="buttongroup" onClick="resetclock();" type="button" value="Reset"/></div>';
        $Html .= '<div class="StopwatchButton"><input class="buttongroup" type="button" onClick="Start();" value="Start"/></div>';
        $Html .= '<div class="StopwatchButton"><input class="buttongroup" type="button" onClick="Stop();" value="Stop"/></div>';  
        $Html .= '<div class="clear"></div>';
        $Html .= '<br/><br/>   ';     
        $Html .= '</div>';
        $Html .= '<div class="StopwatchButton">';
        $Html .= '<input class="buttongroup" type="button" onClick="addRound();" value="Add a Round"/>';
        $Html .= '</div><div class="StopwatchButton">';  
        $Html .= '<input class="buttongroup" type="button" onClick="addRoutine();" value="Add a Routine"/>';
        $Html .= '</div><div class="StopwatchButton">';
        $Html .= '<input id="ShowHideClock" class="buttongroup" type="button" value="Time Workout" onClick="ShowHideStopwatch();"/>';
        $Html .= '</div><div class="StopwatchButton">';   
        $Html .= '<input class="buttongroup" type="button" value="Save Wod" onClick="Save();"/>';       
        $Html .= '</div><div class="clear"></div>';        
        $Html .= '</div>'; 
        $Html .= '</form><br/>';
     	
	return $Html;
    }     
    
    function getExercises($SelectedExercise)
    {
        $Html='';
        $Model = new CustomModel;
        $Exercises = $Model->getExercises();
        $Selected='';
        $Html .= '<br/><select class="select buttongroup" data-role="none" id="exercises" name="exercise" onChange="SelectionControl(this.value)">
         <option value="none">Add Activity</option>';
	foreach($Exercises AS $Exercise){
            if($Exercise->ActivityName == $SelectedExercise)
                $Selected='selected="selected"';
            else
                $Selected='';
            $Html .= '<option value="'.$Exercise->ActivityName.'" '.$Selected.'>'.$Exercise->ActivityName.'</option>';
	}
        $Html .= '</select><br/><div id="ExerciseInputs"></div>';
	return $Html;
    }
    
        function getExerciseHistory($ThisExercise)
        {
            $Html='';
            $ExplodedExercise = explode('_',$ThisExercise);
            $ThisRoundNo = $ExplodedExercise[0];
            $ThisExerciseId = $ExplodedExercise[1];
            $Model = new CustomModel;
            //var_dump($ThisExercise);
            $ExerciseHistory = $Model->getExerciseHistory($ThisExerciseId);
            
            if(count($ExerciseHistory) == 0){
                $Html.='No History for activity';
            }
            $i=0;
            $j=0;
            $TheseAttributes='';
            $Attributes = $Model->getExerciseIdAttributes($ThisExerciseId);
            $NumAttributes = count($Attributes);
            foreach($ExerciseHistory as $Detail){
                if($i < 3){
                    $Html.=''.$Detail->Attribute.' : '.$Detail->AttributeValue.''.$Detail->UnitOfMeasure.'';
                    $j++;
                    if($j == $NumAttributes){
                        $Html.='<br/>';
                        $j = 0;
                        $i++;
                    }else{
                        $Html.=' | ';
                    }
                }
            }
            $i=0;
            $Html .= '<div class="ActivityAttributes">';
            foreach($Attributes as $Attribute){
                if($i > 0)
                    $TheseAttributes.='_';
                $TheseAttributes.=$Attribute->Attribute;
                $Html .= '<div style="float:left;margin:0 25px 0 25px"">'.$Attribute->Attribute.'<br/><input style="width:80px" type="number" id="'.$ThisExercise.'_'.$Attribute->Attribute.'_new" name="" placeholder="'.$Attribute->UOM.'"/></div>';
                $i++;
            }

            $Html .= '<div style="float:right;margin:10px 30px 10px 0"><input class="buttongroup" type="button" id="" name="btn" onClick="UpdateActivity(\''.$ThisExercise.'\', \''.$TheseAttributes.'\');" value="Update"/></div>';
            $Html .= '</div><div class="clear"></div>';
            
            return $Html;
        }   
    
    function WorkoutTypes($Type){
        $Html='';
        if($Type != ''){
        $Model = new CustomModel;
        $WorkoutTypes = $Model->getWorkoutTypes();
         $Html .= '<select class="select" name="workouttype" id="workouttype" onchange="addTypeParams(this.value);">';
         $Html .= '<option value="none">Select Workout Type</option>';
        foreach($WorkoutTypes AS $WorkoutType){
            $Html .= '<option id="'.$WorkoutType->recid.'" value="'.$WorkoutType->ActivityType.'"';
            if($WorkoutType->ActivityType == $_REQUEST['workouttype'])
                $Html .='selected="selected"';
            $Html .= '>'.$WorkoutType->ActivityType.'</option>';
        }
	$Html .= '</select>';
        }
        return $Html;
    }
	
	function Output()
	{
            if(isset($_REQUEST['chosenexercise'])){
  		$Model = new CustomModel;
		$html = $Model->getExerciseAttributes($_REQUEST['chosenexercise']);              
            }
            else if($_REQUEST['dropdown'] == 'refresh'){
                $html = $this->getExercises($_REQUEST['selectedexercise']);
            }
            else{
                $html = $this->MainOutput();
            }
            return $html;
	}      
        
        function ChosenExercises()
        {
            return '';
        }
        
        function AddExercise()
        {
            return '';
        }
        
        function Clock()
        {
            $Html='';
            if($_REQUEST['form'] == 'submitted'){
                if($_REQUEST['workouttype'] == 'Total Reps'){
                    $Html .='<input type="number" name="Reps" value="" placeholder="Total Reps"/>';
                }
                else if($_REQUEST['workouttype'] == 'AMRAP Rounds'){
                    $Html.= $this->getRoundCounter();
                    $Html.= $this->getStopWatch();
                }  
                else if($_REQUEST['workouttype'] == 'AMRAP Reps'){
                    $Html.=$this->getCountDown('mm:ss:0');
                }
                
                if($_REQUEST['workouttype'] != 'AMRAP Rounds'){
                    $Html.='<input class="buttongroup" type="button" name="btnsubmit" value="Save" onclick="customsubmit();"/>';
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
		<input type="hidden" name="exercise" value="'.$_REQUEST['customexercise'].'"/>
		<input type="hidden" name="origin" value="'.$this->Origin.'"/>';

		foreach($Details AS $Detail){
 		if($_REQUEST['wodtype'] == 'Timed'){
            $AddLast = $this->getStopWatch();
		$SubmitOption = true;	
        }
        if($_REQUEST['wodtype'] == 'AMRAP Rounds'){
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
    
    function getWeight($exerciseId)
    {
		$RENDER = new Image();
		$Save = $RENDER->NewImage('save.png', SCREENWIDTH);
        $Html='<form name="form" action="index.php">
        <input type="hidden" name="module" value="baseline"/>
        <input type="hidden" name="baseline" value="'.$_REQUEST['baseline'].'"/>
        <input type="hidden" name="exercise" value="'.$exerciseId.'"/>
		<input type="number" name="Weight" value="" placeholder="Weight"/><br/><br/>
        <img alt="Save" '.$Save.' src="'.ImagePath.'save.png" onclick="document.form.submit();"/>
        </form>';
        
        return $Html;        
    }
    
    function getRoundCounter()
    {
        $Html='<div class="ui-block-b">';
        $Html.='<input class="buttongroup addARound" data-role="none" type="button" onclick="addRound();" value="Add a Round"/>';
        $Html.='</div>';
        
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
		<input type="number" name="Reps" value="" placeholder="Total Reps"/><br/><br/>
        <img alt="Save" '.$Save.' src="'.ImagePath.'save.png" onclick="document.form.submit();"/>
        </form>';
        
        return $Html;         
    }
    
    function getTabata()
    {
        $Html='<div id="timerContainer"><div id="timerLoading"></div></div>';
        
        return $Html;       
    }
    
    function getCountDown($Time)
    {
        $Placeholder = '';
	$RoundNo = 0;
        $ExerciseId = 63;
        if($Time == 'mm:ss'){
           $Placeholder = 'placeholder="'.$Time.'"';  
        }
        else{
            $TimeToComplete = $Time;
        }
        $StartStopButton = 'Start';
        if(isset($_REQUEST[''.$ExerciseId.'___TimeToComplete'])){
            $TimeToComplete = $_REQUEST[''.$ExerciseId.'___TimeToComplete'];
            if($TimeToComplete != $Time)
                $StartStopButton = 'Stop';
        }
	$Html ='<input type="hidden" name="'.$ExerciseId.'___CountDown[]" id="CountDown" value="'.$Time.'"/>';
        $Html.='<input id="clock" type="text" name="timer" value="'.$TimeToComplete.'" '.$Placeholder.'/>';
        $Html.='<input id="startstopbutton" class="buttongroup" type="button" onClick="startstopcountdown();" value="'.$StartStopButton.'"/>';
        $Html.='<input id="resetbutton" class="buttongroup" type="button" onClick="resetcountdown();" value="Reset"/>';
        
        return $Html;
    }
    
    function getAmrapClock()
    {
        $RoundNo = 0;
        $ExerciseId = 63;
        $Html='<select class="select" id="clock" name="timer">';
        $Html.='<option value="">00:00:0</option>';
        for($i=0;$i<60;$i++){
           $Html.='<option value="'.$i.':00:0">'.$i.':00:0</option>'; 
        }
        $Html.='</select>';
        $Html .='<input type="hidden" name="'.$RoundNo.'___'.$ExerciseId.'___CountDown" id="CountDown" value="00:00:0"/>';
        $Html.='<input id="startstopbutton" class="buttongroup" type="button" onClick="startstopcountdown();" value="Start"/>';
        $Html.='<input id="resetbutton" class="buttongroup" type="button" onClick="resetcountdown();" value="Reset"/>';
        
        return $Html;
    }
}
?>