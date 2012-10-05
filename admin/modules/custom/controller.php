<?php
class CustomController extends Controller
{
    var $SaveMessage;
    var $ChosenExercises;
    
	function __construct()
	{
            parent::__construct();
            session_start();
            if(!isset($_SESSION['GID'])){
                header('location: index.php?module=login');	
            }
            $this->SaveMessage = '';
            if(!isset($_REQUEST['action']) && !isset($_REQUEST['newexercise']))
                $this->ChosenExercises = array();
	}
        
    function Validate()
    {
        $Message = '';
        foreach($_REQUEST AS $Key=>$Val){
            if($Val == ''){
                $Message = ''.$Key.' has no value!';
            }
        }
        return $Message;
    }
    
    function SaveWorkout()
    {
        $Model = new CustomModel;
        $Result = $Model->Save();
        
        return $Result;
    }
    
    function SaveNewExercise()
    {
        $Result = '';
        if(count($_REQUEST['ExerciseAttributes']) == 0){
            $Result = 'Must Select at least one Attribute';
        }else{
            $Validate = $this->Validate();
            if($Validate == ''){
                $Model = new CustomModel;
                $Result = $Model->SaveNewExercise();
            }
            else{
                $Result = $Validate;
            }
        }
        return $Result;
    }
    
    function MainOutput()
    {
	$Html = '';
	$Model = new CustomModel;

        $WorkoutTypes = $Model->getWorkoutTypes();
	$Exercises = $Model->getExercises();

        $Html .= '<form action="index.php" id="customform" name="form">
                    <input type="hidden" name="action" value="save"/>
                    <input type="hidden" name="rowcount" id="rowcounter" value="0"/>
                    <input class="textinput" type="text" name="WorkoutName" value="" placeholder="Enter Workout Name"/>';
        $Html .= '<select class="select" name="workouttype" id="workouttype" onchange="addTypeParams(this.value);">
                    <option value="none">Workout Type</option>';
        foreach($WorkoutTypes AS $WorkoutType){
            $Html .= '<option id="'.$WorkoutType->recid.'" value="'.$WorkoutType->ActivityType.'"';
            if($WorkoutType->ActivityType == $_REQUEST['workouttype'])
                $Html .='selected="selected"';
            $Html .= '>'.$WorkoutType->ActivityType.'</option>';
        }
	$Html .= '</select>';
	$Html .= '<select class="select" name="exercise" id="exercise" onchange="SelectionControl(this.value);">
                    <option value="none">+ Activity</option>';
	foreach($Exercises AS $Exercise){
            $Html .= '<option id="'.$Exercise->recid.'" value="'.$Exercise->ActivityName.'">'.$Exercise->ActivityName.'</option>';
	}
	$Html .= '</select>';
	if($_REQUEST['action'] == 'save'){
	$Html .= '<div class="ui-grid-c">';
    $Html .= '<div class="ui-block-a"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#3f2b44" value="Weight" readonly="readonly"/></div>';
    $Html .= '<div class="ui-block-b"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#66486e" value="Height" readonly="readonly"/></div>';
    $Html .= '<div class="ui-block-c"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#6f747a" value="Distance" readonly="readonly"/></div>';
    $Html .= '<div class="ui-block-d"><input type="text" data-role="none" style="width:80%;color:black;font-weight:bold;background-color:#ccff66" value="Reps" readonly="readonly"/></div>';
    $Html .= '</div>';
	}
    $Html .= '<div class="ui-grid-b">
                  <div id="add_exercise">'.$this->AddExercise().'</div>
                  <div id="new_exercise">'.$this->ChosenExercises().'</div>
                  </div>
                  <div id="btnsubmit">'.$this->SubmitButton().'</div>                         
                  </form><br/>';
     	
	return $Html;
    }
	
	function Output()
	{
            $html='';
            if(isset($_REQUEST['newexercise'])){
                $html = '<div id="message">'.$this->SaveNewExercise().'</div>';
                $html.= $this->MainOutput();
            }
            else if($_REQUEST['action'] == 'save'){
                $html= '<div id="message">'.$this->SaveWorkout().'</div>';
                $html.= $this->MainOutput();
            }
            else{
		$Model = new CustomModel;
		$html = $Model->getExerciseAttributes($_REQUEST['chosenexercise']);
            }
            return $html;
	}
        
        function AddExercise()
        {
            $Html='';
            if(isset($_REQUEST['newexercise'])){
                $Html ='<input class="textinput" type="text" id="NewExercise" name="NewExercise" value="" placeholder="New Exercise Name"/>';
                $Html .= '<br/>Applicable Attributes:<br/><br/>';
                $Html .= '<input type="checkbox" name="ExerciseAttributes[]" value="Weight"/>Weight';
                $Html .= ' <input type="checkbox" name="ExerciseAttributes[]" value="Height"/>Height<br/>';
                $Html .= '<input type="checkbox" name="ExerciseAttributes[]" value="Distance"/>Distance';
                $Html .= ' <input type="checkbox" name="ExerciseAttributes[]" value="Reps"/>Reps<br/><br/>';
                $Html .= '<input class="buttongroup" type="button" name="btnsubmit" value="Add" onclick="addnew();"/>'; 
                return $Html;
            }
        }
        
        function ChosenExercises()
        {
            $Model = new CustomModel;
            $html='';
            $ThisExercise='';
            if($_REQUEST['action'] == 'save'){
                foreach($_REQUEST AS $Key=>$Val){
                    $ExplodedKey = explode('_', $Key);
                    if($ExplodedKey[0] == 'exercise' && $Val != 'none'){

                        $Attributes = $Model->getExerciseAttributes($Val);
                    
                        foreach($Attributes AS $Attribute){

			
			if($Attribute->TotalRounds > 1 && $Attribute->RoundNo > 0 && $ThisRound != $Attribute->RoundNo){
			
				if($Chtml != '' && $Bhtml == ''){
					$html.='<div class="ui-block-b"></div>'.$Chtml.'';
					$Chtml = '';
					$Bhtml = '';
				}
				if($Chtml == '' && $Bhtml != ''){
					$html.=''.$Bhtml.'<div class="ui-block-c"></div>';
					$Chtml = '';
					$Bhtml = '';
				}
				$html.='<div class="ui-block-a"></div><div class="ui-block-b"></div><div class="ui-block-c"></div>';
				$html.='<div class="ui-block-a" style="padding:2px 0 2px 0">Round '.$Attribute->RoundNo.'</div><div class="ui-block-b" style="padding:2px 0 2px 0"></div><div class="ui-block-c" style="padding:2px 0 2px 0"></div>';
				$html.='<div class="ui-block-a"><input class="textinput" style="width:75%" readonly="readonly" type="text" data-inline="true" name="" value="'.$Attribute->ActivityName.'"/></div>';
			}
			else if($ThisExercise != $Attribute->ActivityName){
                            
                                if(isset($_REQUEST['Rounds']))
                                    $RoundNo = $_REQUEST['Rounds'];
                                else
                                    $RoundNo = $Attribute->RoundNo;

				if($Chtml != '' && $Bhtml == ''){
					$html.='<div class="ui-block-b"></div>'.$Chtml.'';
					$Chtml = '';
					$Bhtml = '';
				}
				if($Chtml == '' && $Bhtml != ''){
					$html.=''.$Bhtml.'<div class="ui-block-c"></div>';
					$Chtml = '';
					$Bhtml = '';
				}
                                if($Attribute->ActivityName == 'Total Rounds'){
                                    $Exercise = '<input class="buttongroup" data-inline="true" type="button" onclick="addRound();" value="+ Round"/>';
                                }else{
                                    $Exercise = '<input class="textinput" style="width:75%" readonly="readonly" type="text" data-inline="true" name="" value="'.$Attribute->ActivityName.'"/>';
                                }
				$html.='<div class="ui-block-a"></div><div class="ui-block-b"></div><div class="ui-block-c"></div>';
				$html.='<div class="ui-block-a">'.$Exercise.'</div>';
				}
				

		
            if($Attribute->Attribute == 'Height' || $Attribute->Attribute == 'Distance' || $Attribute->Attribute == 'Weight'){
                            $AttributeValue = '';	
				if($Attribute->Attribute == 'Distance'){
                                    $Style='style="width:75%;color:white;font-weight:bold;background-color:#6f747a"';
					if($this->SystemOfMeasure() != 'Metric'){
						$Unit = 'm';
                                                $AttributeValue = round($Attribute->AttributeValue * 0.62, 2);
                                        }else{
						$Unit = 'km';
                                                $AttributeValue = $Attribute->AttributeValue;
                                        }
				}		
				else if($Attribute->Attribute == 'Weight'){
                                    $Style='style="width:75%;color:white;font-weight:bold;background-color:#3f2b44"';
					if($this->SystemOfMeasure() != 'Metric'){
                                            $AttributeValue = round($Attribute->AttributeValue * 2.20, 2);
						$Unit = 'lbs';
                                        }else{
						$Unit = 'kg';
                                                $AttributeValue = $Attribute->AttributeValue;
                                        }
				}
				else if($Attribute->Attribute == 'Height'){
                                    $Style='style="width:75%;color:white;font-weight:bold;background-color:#66486e"';
					if($this->SystemOfMeasure() != 'Metric'){
                                            $AttributeValue = round($Attribute->AttributeValue * 0.39, 2);
						$Unit = 'inches';
                                        }else{
						$Unit = 'cm';
                                                $AttributeValue = $Attribute->AttributeValue;
                                        }
				}

				$Bhtml.='<div class="ui-block-b">';
				$Bhtml.='<input class="textinput" '.$Style.' type="number" data-inline="true" name="'.$RoundNo.'___'.$Attribute->recid.'___'.$Attribute->Attribute.'" value="'.$AttributeValue.'"/>';
				$Bhtml.='</div>';		
				if($Chtml != ''){
					$html.=''.$Bhtml.''.$Chtml.'';
					$Chtml = '';
					$Bhtml = '';
				}
			}
                        
            else if($Attribute->Attribute == 'Calories' || $Attribute->Attribute == 'Reps' || ($Attribute->Attribute == 'Rounds' && $Attribute->ActivityType == 'Total Rounds')){
                                $Placeholder = '';
                                if($Attribute->Attribute == 'Calories'){
                                    $Style='style="width:75%"';
                                    $Placeholder = 'placeholder="Calories"';
                                }
                                $InputAttributes = 'type="number"';
                                $InputName = ''.$RoundNo.'___'.$Attribute->recid.'___'.$Attribute->Attribute.'';
                                $Value = $Attribute->AttributeValue;
                                if($Attribute->Attribute == 'Rounds'){
                                    $Style='style="width:75%"';
                                    $InputAttributes .= ' id="addround"';
                                    $InputName = 'Rounds';
                                    $Value = $_REQUEST['Rounds'] + 1 ;
                                }
                                if($Attribute->Attribute == 'Reps'){
                                    $Style='style="width:75%;color:black;font-weight:bold;background-color:#ccff66"';
                                }
				$Chtml.='<div class="ui-block-c">';
				$Chtml.='<input class="textinput" '.$InputAttributes.' '.$Style.' name="'.$InputName.'" '.$Placeholder.' value="'.$Value.'"/>';
				$Chtml.='</div>';
				if($Bhtml != ''){
					$html.=''.$Bhtml.''.$Chtml.'';
					$Bhtml = '';
					$Chtml = '';
				}
			}
		
		
	$ThisRound = $Attribute->RoundNo;
	$ThisExercise = $Attribute->ActivityName;                           
                        }
                    }
                }
            } 
            return $html;
        }
        
        function SubmitButton()
        {
            $Html='';
            if($_REQUEST['action'] == 'save'){
                $Html='<input class="buttongroup" type="button" name="btnsubmit" value="Save" onclick="customsubmit();"/>';      
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
    
	function getStopWatch($type)
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
        $Placeholder = '';
	$RoundNo = 0;
        $ExerciseId = 63;
        if($Time == '00:00:0'){
           $Placeholder = 'placeholder="'.$Time.'"';  
        }
        else{
            $TimeToComplete = $Time;
        }
        $StartStopButton = 'Start';
        if(isset($_REQUEST[''.$RoundNo.'___'.$ExerciseId.'___TimeToComplete'])){
            $TimeToComplete = $_REQUEST[''.$RoundNo.'___'.$ExerciseId.'___TimeToComplete'];
            if($TimeToComplete != $Time)
                $StartStopButton = 'Stop';
        }
	$Html ='<input type="hidden" name="'.$RoundNo.'___'.$ExerciseId.'___CountDown" id="CountDown" value="'.$Time.'"/>';
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