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
            if(!isset($_COOKIE['UID'])){
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

        $ActivityFields = $Model->getActivityFields();
        //$HistoryAttributes = $Model->getExerciseIdAttributes($ActivityFields[0]->ExerciseId);
        //$ExerciseHistory = $Model->getExerciseHistory($ActivityFields[0]->ExerciseId);
        //var_dump($ExerciseHistory);
        $Attributes = array();
        $i=0;
        //var_dump($ActivityFields);
        $html .= '<ul id="RoutineNo_RoundNo_RowNo" class="listview" data-role="listview" data-inset="true" data-iconpos="right">'; 
        //$html .= '<div data-role="collapsible">';
        $html .= '<li>'.$ActivityFields[0]->Exercise.'<input class="delete" type="button" onClick="RemoveFromList(\'RoutineNo_RoundNo_RowNo\');" value="Delete"/><br/>';  
        
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
                $AttributeValue = '-';
            }else{
                $AttributeValue = $Activity->AttributeValue * $ConversionFactor;
            }            
                                  
            if($i > 0)
                $html.=' | ';

            $html.=''.$Activity->Attribute.' : <span id="RoutineNo_RoundNo_OrderBy_'.$Activity->ExerciseId.'_'.$Activity->Attribute.'_html">'.$AttributeValue.'</span>';
            $html.='<input type="hidden" id="RoutineNo_RoundNo_OrderBy_'.$Activity->ExerciseId.'_'.$Activity->Attribute.'" name="RoutineNo_RoundNo_'.$Activity->ExerciseId.'_'.$Activity->Attribute.'_'.$UnitOfMeasureId.'_OrderBy" value="'.$AttributeValue.'"/>';
            //if($AttributeValue != '-'){
                $html.=''.$Activity->UnitOfMeasure.'';
            //}
            $i++;
            $Attributes[''.$Activity->Attribute.''] = $AttributeValue != "-" ? $AttributeValue : "";
        }  
        $i=0;
        $html.='</li></ul>';  

        return $html;
    }    
    
    function UpdateHistory($ExerciseId){
        $Model = new CustomModel;
        $Attributes = $Model->getExerciseIdAttributes($ExerciseId);
        $ExerciseHistory = $Model->getExerciseHistory($ExerciseId);
        $html.='<p style="color:red">';
   
            if(count($ExerciseHistory) == 0){
                $html.='No History for activity';
            }
            $j=0;
            $NumAttributes = count($Attributes);
            $t=0;
            foreach($ExerciseHistory as $Detail){
                if($t < 3){
                    $html.=''.$Detail->Attribute.' : '.$Detail->AttributeValue.''.$Detail->UnitOfMeasure.'';
                    $j++;
                    if($j == $NumAttributes){
                        $html.='<br/>';
                        $j = 0;
                        $t++;
                    }else{
                        $html.=' | ';
                    }
                }
            }        
        $html.='</p>'; 
        return $html;
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
        }else if($_REQUEST['NewActivityWeight'] != '' && $_REQUEST['NewActivityHeight'] != ''){
            $Message = 'Error - Can\'t have Weight and Height';
        }else if($_REQUEST['NewActivityWeight'] != '' && $_REQUEST['NewActivityDistance'] != ''){
            $Message = 'Error - Can\'t have Weight and Distance';
        }else if($_REQUEST['NewActivityDistance'] != '' && $_REQUEST['NewActivityHeight'] != ''){
            $Message = 'Error - Can\'t have Height and Distance';
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
        <input type="hidden" name="Routine1Round1Counter" id="Routine1Round1Counter" value="0"/>
        <input type="hidden" name="Routine1RoundCounter" id="Routine1RoundCounter" value="1"/>
        <input type="hidden" name="RoutineCounter" id="RoutineCounter" value="1"/>';
        $Html .= '<div class="ui-grid-a">';
        $Html .= '<div class="ui-block-a" style="width:45%;">';
        $Html .= '<input class="textinput" type="text" name="CustomName" id="CustomName" placeholder="WOD Name" value=""/>';
        $Html .= '</div><div class="ui-block-b" style="width:45%;float:right">';
        $Html .= '<input class="textinput" type="date" name="WodDate" id="WodDate" placeholder="WOD Date" value="'.date('Y-m-d').'"/>';        
        $Html .= '</div></div>';  
        $Html .= '<textarea name="descr" placeholder="Describe Your WOD"></textarea>';
        $Html .= '<h3>Routine 1</h3>';
        $Html .= '<h3>Round 1</h3>';       
        $Html .= '<div id="activity1list">'.$this->ChosenExercises().'</div>';
        
        $Html .= '<div id="Routines"></div>';
        
        $Html .= '<div id="add_exercise">'.$this->AddExercise().'</div>';

        $Html .= '<div id="CenterButtonText">';  
        $Html .= '<ul id="autocomplete" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="Add Activity..." data-filter-theme="d"></ul>';
        $Html .= '<div id="ExerciseInputs"></div>';  
        $Html .= '<br/>'; 
        $Html .= '<div class="ui-grid-a">
	<div class="ui-block-a"><button id="DuplicateActivity" type="button" onClick="DuplicateLastActivity();">Copy Activity</button></div>
	<div class="ui-block-b"><button type="button" onClick="addRound();">Add a Round</button></div>
        </div>';
        $Html .= '<div class="ui-grid-a">';
        $Html .= '<div class="ui-block-a">';
        $Html .= '<button type="button" onClick="addNewExercise();">Create Activity</button>';
        $Html .= '</div>'; 
        $Html .= '<div class="ui-block-b">';
        $Html .= $this->getBenchmarks('');
        $Html .= '</div>'; 
        $Html .= '</div>'; 
        $Html .= '<div class="ui-grid-a">
	<div class="ui-block-a"><button type="button" onClick="addRoutine();">Add a Routine</button></div>
	<div class="ui-block-b"><button type="button" onClick="Save();">Save Wod</button></div>
</div>';        

        $Html .= '<div class="clear"></div>'; 
        $Html .= '</div>'; 
        $Html .= '</form>';
     	
	return $Html;
    }    
    
    function getBenchmark()
    {
        $Model = new CustomModel;
        $Benchmark = $Model->getBenchmarkDetails($_REQUEST['benchmarkId']);
        $Attributes = array();
        $ThisRound = 0;
        $OrderBy = 0;
	$ThisExerciseId = 0;
        $i = 0;       
        $html .= '<div data-role="collapsible-set" data-iconpos="right">';
        //var_dump($this->Workout);
	foreach($Benchmark as $Detail){
            if($Detail->UnitOfMeasureId == null || $Detail->UnitOfMeasureId == 0){
                $UnitOfMeasureId = 0;
                $ConversionFactor = 1;
            }else{
                $UnitOfMeasureId = $Detail->UnitOfMeasureId;
                if($Detail->ConversionFactor == null || $Detail->ConversionFactor == 0){
                    $ConversionFactor = 1;
                }else{
                    $ConversionFactor = $Detail->ConversionFactor;
                }
            }
            if($Detail->AttributeValue == ''){
                $AttributeValue = '-';
            }else{
                $AttributeValue = $Detail->AttributeValue * $ConversionFactor;
            }            
		if($Detail->Attribute != 'TimeToComplete'){
			
			if($Detail->TotalRounds > 1 && $Detail->RoundNo > 0 && $ThisRound != $Detail->RoundNo){
                            if($ThisExerciseId != null && $i > 0){
                                $html.='</h2>';
            $i=0;
            $html .= '<div class="ActivityAttributes"><form id="RoutineNo_'.$ThisRound.'_'.$OrderBy.'_'.$ThisExerciseId.'" name="RoutineNo_'.$ThisRound.'_'.$OrderBy.'_'.$ThisExerciseId.'">';
            //var_dump($Attributes);
            foreach($Attributes as $Attribute=>$Val){
                $UOM = $Model->getUserUnitOfMeasure($Attribute);
                $UnitOfMeasureId = $Model->getUnitOfMeasureId($Attribute);
                if($UnitOfMeasureId == '')
                    $UnitOfMeasureId = 0;   
                if($i > 0)
                    $TheseAttributes.='_';
                $TheseAttributes.=$Attribute;
                $html .= '<div style="float:left;margin:0 25px 0 25px"">'.$Attribute.'<br/><input value="'.$Val.'" style="width:80px" type="number" id="RoutineNo_'.$ThisRound.'_'.$ThisExerciseId.'_'.$Attribute.'_new" name="RoutineNo_'.$ThisRound.'_'.$ThisExerciseId.'_'.$Attribute.'_'.$UnitOfMeasureId.'_'.$OrderBy.'" placeholder="'.$UOM.'"/></div>';
                $i++;
            }

            $html .= '<div style="float:right;margin:10px 30px 10px 0"><input class="buttongroup" type="button" id="" name="btn" onClick="UpdateActivity(\'RoutineNo_'.$ThisRound.'_'.$ThisExerciseId.'\', \''.$TheseAttributes.'\');" value="Update Values"/></div>';
            $html .= '</form></div><div class="clear"></div></div>';                                
                                $Attributes = array();
                            }                           	
                            $html.= '<h2>Round '.$Detail->RoundNo.'</h2>';
                            $html.= '<div data-role="collapsible">';
                            $html.= '<h2>'.$Detail->Exercise.'<br/>';             
			}
			else if($ThisExerciseId != $Detail->ExerciseId){

                            if($ThisExerciseId != null && $i > 0){
                                $html.='</h2>';
            $i=0;
            $html .= '<div class="ActivityAttributes"><form id="RoutineNo_'.$ThisRound.'_'.$OrderBy.'_'.$ThisExerciseId.'" name="RoutineNo_'.$ThisRound.'_'.$OrderBy.'_'.$ThisExerciseId.'">';
            //var_dump($Attributes);
            foreach($Attributes as $Attribute=>$Val){
                $UOM = $Model->getUserUnitOfMeasure($Attribute);
                $UnitOfMeasureId = $Model->getUnitOfMeasureId($Attribute);
                if($UnitOfMeasureId == '')
                    $UnitOfMeasureId = 0;   
                if($i > 0)
                    $TheseAttributes.='_';
                $TheseAttributes.=$Attribute;
                $html .= '<div style="float:left;margin:0 25px 0 25px"">'.$Attribute.'<br/><input value="'.$Val.'" style="width:80px" type="number" id="RoutineNo_'.$ThisRound.'_'.$ThisExerciseId.'_'.$Attribute.'_new" name="RoutineNo_'.$ThisRound.'_'.$ThisExerciseId.'_'.$Attribute.'_'.$UnitOfMeasureId.'_'.$OrderBy.'" placeholder="'.$UOM.'"/></div>';
                $i++;
            }

            $html .= '<div style="float:right;margin:10px 30px 10px 0"><input class="buttongroup" type="button" id="" name="btn" onClick="UpdateActivity(\'RoutineNo_'.$ThisRound.'_'.$ThisExerciseId.'\', \''.$TheseAttributes.'\');" value="Update Values"/></div>';
            $html .= '</form></div><div class="clear"></div></div>';                                
                                $Attributes = array();
                            }       
                            $html.= '<div data-role="collapsible">';
                            $html.= '<h2>'.$Detail->Exercise.'<br/>';                           
                        }else{
                            $html.=' | ';
                        }
                        $html.=''.$Detail->Attribute.' : <span id="RoutineNo_'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_'.$Detail->Attribute.'_html">'.$AttributeValue.'</span>'.$UOM.'';
                        $html.='<input type="hidden" id="RoutineNo_'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_'.$Detail->Attribute.'" name="RoutineNo_'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_'.$Detail->Attribute.'_'.$UnitOfMeasureId.'_'.$Detail->OrderBy.'" value="'.$AttributeValue.'"/>';
                }
        $Attributes[''.$Detail->Attribute.''] = $AttributeValue != "-" ? $AttributeValue : "";        
	$ThisRound = $Detail->RoundNo;
        $OrderBy = $Detail->OrderBy;
	$ThisExerciseId = $Detail->ExerciseId;
        $i++;
	}
                            if($ThisExerciseId != null && $i > 0){
                                $html.='</h2>';
            $i=0;
            $html .= '<div class="ActivityAttributes"><form id="RoutineNo_'.$ThisRound.'_'.$OrderBy.'_'.$ThisExerciseId.'" name="RoutineNo_'.$ThisRound.'_'.$OrderBy.'_'.$ThisExerciseId.'">';
            //var_dump($Attributes);
            foreach($Attributes as $Attribute=>$Val){
                $UOM = $Model->getUserUnitOfMeasure($Attribute);
                $UnitOfMeasureId = $Model->getUnitOfMeasureId($Attribute);
                if($UnitOfMeasureId == '')
                    $UnitOfMeasureId = 0;   
                if($i > 0)
                    $TheseAttributes.='_';
                $TheseAttributes.=$Attribute;
                $html .= '<div style="float:left;margin:0 25px 0 25px"">'.$Attribute.'<br/><input value="'.$Val.'" style="width:80px" type="number" id="RoutineNo_'.$ThisRound.'_'.$ThisExerciseId.'_'.$Attribute.'_new" name="RoutineNo_'.$ThisRound.'_'.$ThisExerciseId.'_'.$Attribute.'_'.$UnitOfMeasureId.'_'.$OrderBy.'" placeholder="'.$UOM.'"/></div>';
                $i++;
            }

            $html .= '<div style="float:right;margin:10px 30px 10px 0"><input class="buttongroup" type="button" id="" name="btn" onClick="UpdateActivity(\'RoutineNo_'.$ThisRound.'_'.$ThisExerciseId.'\', \''.$TheseAttributes.'\');" value="Update Values"/></div>';
            $html .= '</form></div><div class="clear"></div></div>';                                
                                $Attributes = array();
                            }             
        $html.='</div>';
    
        return $html;
    }
    
    function getBenchmarks($SelectedExercise)
    {
        $Model = new CustomModel;
        $Benchmarks = $Model->getBenchmarks();   
        $Selected='';
        $Html .= '<select class="select buttongroup" data-role="none" id="benchmark" name="benchmark" onChange="AddBenchmark(this.value)">
         <option value="none">Add Benchmark</option>';
	foreach($Benchmarks AS $Benchmark){
            if($Benchmark->WorkoutName == $SelectedExercise)
                $Selected='selected="selected"';
            else
                $Selected='';
            $Html .= '<option value="'.$Benchmark->Id.'" '.$Selected.'>'.$Benchmark->WorkoutName.'</option>';
	}
        $Html .= '</select>';
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
            $Model = new CustomModel;
            if(isset($_REQUEST['benchmarkId'])){   
                $html = $this->getBenchmark();
            }else if(isset($_REQUEST['chosenexercise'])){
		$html = $Model->getExerciseIdAttributes($_REQUEST['chosenexercise']);              
            }
            else if(isset($_REQUEST['q'])){
            $Affiliates = $Model->getExercises($_REQUEST['q']);
            $Json = array();
            foreach($Affiliates AS $Affiliate){
                $Json[] = $Affiliate;
            }
            $html = ''.$_REQUEST['callback'].'('.json_encode($Json).');';
            }
            else if($_REQUEST['history'] == 'refresh'){
                $html = $this->UpdateHistory($_REQUEST['ExerciseId']);
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