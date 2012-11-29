<?php
class UploadController extends Controller
{
    var $Origin;
    var $SaveMessage;
    var $ChosenExercises;
    
	function __construct()
	{
            parent::__construct();
            session_start();
            if(!isset($_SESSION['GID'])){
                header('location: index.php?module=login');	
            }
            $this->Origin = $_REQUEST['origin'];
            $this->SaveMessage = '';
            if(!isset($_REQUEST['form']) && !isset($_REQUEST['NewExercise']))
                $this->ChosenExercises = array();
	}
        
       function Message()
    {
        $Model = new UploadModel;
             if(isset($_REQUEST['NewExercise'])){
                $Message = $this->SaveNewExercise();
            }
            else{
                $Message = $Model->Save();
            }       
        return $Message;
    }      
        
    function Validate()
    {
        $Message = '';
        if($_REQUEST['NewExercise'] == ''){
            $Message = 'Must Enter Exercise Name!';
        }
        else if(count($_REQUEST['ExerciseAttributes']) == 0){
            $Message = 'Must Select at least one Attribute';
        }
        
        return $Message;
    }
    
    function SaveNewExercise()
    {
        $Result = '';

            $Validate = $this->Validate();
            if($Validate == ''){
                $Model = new UploadModel;
                $Result = $Model->SaveNewExercise();
            }
            else{
                $Result = $Validate;
            }
        
        return $Result;
    }

    function HtmlOutputs($type, $properties = 'unclassified')
    {
        if ($type == 'routine')
        {
            if ($properties == 'unclassified')
            {
                $properties = array('id' => 'unclassified');
            }

            $HtmlReturn= '
                <div class="routine" id="routine_'.$properties['id'].'">
                    <input name="routine_name_'.$properties['id'].'" type="text" value="Name of routine" />
                    <br />
                    '.$this->HtmlOutputs('activities').'
                <div>
                <a onclick="addRoutine('.$properties['id'].')" href="#" class="add_routine">+</a>';
        }
        elseif ($type == 'activities')
        {
            if ($properties == 'unclassified')
            {
                $properties = array('id' => 'unclassified');
            }

            $HtmlReturn = '';
            $Model = new UploadModel;
            $Activities = $Model->getActivities();  
            $HtmlReturn .= '<select class="select" name="activity" id="'.$properties['id'].'" onchange="SelectionControl(\'activity\',this.value);">
                        <option value="none">+ Activity</option>';
            foreach($Activities AS $Activity){
                $HtmlReturn .= '<option id="'.$Activity->recid.'" value="'.$Activity->recid.'">'.$Activity->ActivityName.'</option>';
            }
            $HtmlReturn .= '</select>';   
            
        }
        
        // Remove line breaks as javascript errors otherwise
        $HtmlReturn = str_replace(array("\r\n", "\r", "\n"), "", $HtmlReturn);
        
        return $HtmlReturn;
    }
    
    function MainOutput()
    {
        $Html = "<ul id='admin-menu'>
                    <li><a href='#'>Load New</a></li>
                    <li><a href='#'>Historic</a></li>
                    <li><a href='#'>Reports</a></li>
                    <li><a href='#'>Booking</a></li>
                    <li><a href='#'>Messages</a></li>
                 </ul>
                 <p class='clear'></p>
                 <br />";

        $Html .= "<div class='block-button'><p>Add Activity</p></div>";
        $Html .= "<div class='block-button'><p>Add Timing</p></div>";
        $Html .= "<div class='block-button'><p>Add Comments</p></div>";
        $Html .= "<p class='clear'></p>
                  <br />";
        
        $Html .= "<div class='routines-container'>
                    <form id='routines-form'>
                    ".$this->HtmlOutputs('routine', array('id' => 1))."
                    </form>

                    <br /><br />
                  </div>";

       $Html .= '<div id="workouttypes">';
        if(isset($_REQUEST['workouttype'])){
        $Html .= $this->WorkoutTypes($_REQUEST['workouttype']);
        }
        $Html .= '</div>';
                
        $Html .= '<br/>';
        
	if($_REQUEST['form'] == 'submitted'){
	$Html .= '<div class="ui-grid-c">';
    $Html .= '<div class="ui-block-a"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#3f2b44" value="Weight" readonly="readonly"/></div>';
    $Html .= '<div class="ui-block-b"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#66486e" value="Height" readonly="readonly"/></div>';
    $Html .= '<div class="ui-block-c"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#6f747a" value="Distance" readonly="readonly"/></div>';
    $Html .= '<div class="ui-block-d"><input type="text" data-role="none" style="width:80%;color:black;font-weight:bold;background-color:#ccff66" value="Reps" readonly="readonly"/></div>';
    $Html .= '</div>';
	}
    $Html .= '<div class="ui-grid-b">
                  <div id="display_benchmark"></div>
                  <div id="add_exercise">'.$this->AddExercise().'</div>
                  <div id="new_exercise">'.$this->ChosenExercises().'</div>
                  </div>
                  <div id="clock_input">'.$this->Clock().'</div>
                   <div id="btnsubmit"></div>   
                  </form><br/>';
     	
	return $Html;
    }
    
    function Benchmarks()
    {
  	$Html = '';
	$Model = new UploadModel;

	$Benchmarks = $Model->getBenchmarks(); 
  	$Html .= '<select class="select" name="benchmark" id="benchmark" onchange="SelectionControl(\'benchmark\',this.value);">
                    <option value="none">Benchmark</option>';
	foreach($Benchmarks AS $Benchmark){
            $Html .= '<option id="'.$Benchmark->recid.'" value="'.$Benchmark->recid.'">'.$Benchmark->WorkoutName.'</option>';
	}
	$Html .= '</select>';   
        
        return $Html;       
    }
    
    function Activities()
    {

    }
    
    function WorkoutTypes(){
        $Html='';

        $Model = new UploadModel;
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
        
        return $Html;
    }
	
	function Output()
	{
            if(isset($_REQUEST['activityid'])){
  		$Model = new UploadModel;
		$html = $Model->getExerciseAttributes($_REQUEST['activityid']);              
            }
            else if(isset($_REQUEST['benchmarkid'])){
  		$Model = new UploadModel;
		$html = $Model->getBenchmarkDetails($_REQUEST['benchmarkid']);              
            }
            else{
                $html = $this->MainOutput();
            }
            return $html;
	}
        
        function AddExercise()
        {
            $Html='';
            if(isset($_REQUEST['NewExercise'])){
                $Html .='<br/><input class="textinput" type="text" id="NewExercise" name="NewExercise" value="" placeholder="New Exercise Name"/>';
                $Html .='<br/><input class="textinput" type="text" id="Acronym" name="Acronym" value="" placeholder="Acronym for Exercise?"/>';
                $Html .= '<br/>Applicable Attributes:<br/><br/>';
                $Html .= '<input type="checkbox" name="ExerciseAttributes[]" value="Weight"/>Weight';
                $Html .= ' <input type="checkbox" name="ExerciseAttributes[]" value="Height"/>Height<br/>';
                $Html .= '<input type="checkbox" name="ExerciseAttributes[]" value="Distance"/>Distance';
                $Html .= ' <input type="checkbox" name="ExerciseAttributes[]" value="Reps"/>Reps<br/><br/>';
                $Html .= '<input class="buttongroup" type="button" name="btnsubmit" value="Add" onclick="addnew();"/>'; 
            }
             return $Html;
        }
        
        function ChosenExercises()
        {
            $Model = new UploadModel;
            $html='';
            $ThisExercise='';
            if($_REQUEST['form'] == 'submitted'){
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
				$html.='<div class="ui-block-a"><input class="textinput" style="width:75%" readonly="readonly" type="text" data-inline="true" name="" value="'.$Attribute->InputFieldName.'"/></div>';
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
                                    $Exercise = '<input class="textinput" style="width:75%" readonly="readonly" type="text" data-inline="true" name="" value="'.$Attribute->InputFieldName.'"/>';
                                }
				$html.='<div class="ui-block-a"></div><div class="ui-block-b"></div><div class="ui-block-c"></div>';
				$html.='<div class="ui-block-a">'.$Exercise.'</div>';
				}
				

		
            if($Attribute->Attribute == 'Height' || $Attribute->Attribute == 'Distance' || $Attribute->Attribute == 'Weight'){
                            $AttributeValue = '';	
				if($Attribute->Attribute == 'Distance'){
                                    $Style='style="float:left;width:50%;color:white;font-weight:bold;background-color:#6f747a"';
					if($this->SystemOfMeasure() != 'Metric'){
						$Unit = '<span style="float:left">yd</span>';
                                                $AttributeValue = round($Attribute->AttributeValue * 1.09, 2);
                                        }else{
						$Unit = '<span style="float:left">m</span>';
                                                $AttributeValue = $Attribute->AttributeValue;
                                        }
				}		
				else if($Attribute->Attribute == 'Weight'){
                                    $Style='style="float:left;width:50%;color:white;font-weight:bold;background-color:#3f2b44"';
					if($this->SystemOfMeasure() != 'Metric'){
                                            $AttributeValue = round($Attribute->AttributeValue * 2.20, 2);
						$Unit = '<span style="float:left">lbs</span>';
                                        }else{
						$Unit = '<span style="float:left">kg</span>';
                                                $AttributeValue = $Attribute->AttributeValue;
                                        }
				}
				else if($Attribute->Attribute == 'Height'){
                                    $Style='style="float:left;width:50%;color:white;font-weight:bold;background-color:#66486e"';
					if($this->SystemOfMeasure() != 'Metric'){
                                            $AttributeValue = round($Attribute->AttributeValue * 0.39, 2);
						$Unit = '<span style="float:left">in</span>';
                                        }else{
						$Unit = '<span style="float:left">cm</span>';
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
                                    $Style='style="width:50%"';
                                    $Placeholder = 'placeholder="Calories"';
                                }
                                $InputAttributes = 'type="number"';
                                $InputName = ''.$RoundNo.'___'.$Attribute->recid.'___'.$Attribute->Attribute.'';
                                $Value = $Attribute->AttributeValue;
                                if($Attribute->Attribute == 'Rounds'){
                                    $Style='style="width:50%"';
                                    $InputAttributes .= ' id="addround"';
                                    $InputName = 'Rounds';
                                    $Value = $_REQUEST['Rounds'] + 1 ;
                                }
                                if($Attribute->Attribute == 'Reps'){
                                    $Style='style="float:left;width:50%;color:black;font-weight:bold;background-color:#ccff66"';
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
        
        function Clock()
        {
            $Html='';
            if($_REQUEST['form'] == 'submitted'){
                if($_REQUEST['workouttype'] == 'Total Reps'){
                    $Html .='<input type="number" name="Reps" value="" placeholder="Total Reps"/>';
                }
                if($_REQUEST['workouttype'] == 'Total Rounds'){
                    $Html.='<div class="ui-grid-a">';
                    $Html.='<div class="ui-block-a"><input class="buttongroup" data-inline="true" type="button" onclick="addRound();" value="+ Round"/></div>';
                    $Html.='<div class="ui-block-b"><input style="width:75%" id="addround" data-inline="true" type="number" name="0___66___Rounds" value="0"/></div>';
                    $Html.='</div>';
                }  

                //$Html.= $this->getStopWatch();
            } 
            return $Html;
        }
        
    
    function getCustomActivities()
    {        
        $Model = new UploadModel;
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
        $Model = new UploadModel;
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
	
    function UploadDetails($Id)
    {
        $Model = new UploadModel;
        $Details = $Model->getCustomDetails($Id);
		$SubmitOption = false;
        $Html = '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
		<li>'.$Details[0]->ActivityName.'</li>
		</ul><br/>

		<form name="uploadform" action="index.php">
        <input type="hidden" name="module" value="upload"/>
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
	$Html ='<input class="textinput" type="text" id="clock" name="'.$RoundNo.'___'.$ExerciseId.'___TimeToComplete" value="'.$TimeToComplete.'" readonly/>';

        $Html.='<input class="buttongroup" type="button" name="btnsubmit" value="Save" onclick="uploadsubmit();"/>';
        
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
	$Html.='<input class="buttongroup" type="button" name="btnsubmit" value="Save" onclick="customsubmit();"/>';
        
        return $Html;
    }
    
    function getAmrapClock()
    {
        $RoundNo = 0;
        $ExerciseId = 63;

        $Html .='<input class="textinput" type="hidden" name="'.$RoundNo.'___'.$ExerciseId.'___TimeToComplete" id="TimeToComplete" placeholder="00:00:0" value=""/>';

        $Html.='<input class="buttongroup" type="button" name="btnsubmit" value="Save" onclick="uploadsubmit();"/>';
        
        return $Html;
    }
}
?>
