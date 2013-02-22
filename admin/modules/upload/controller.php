<?php
class UploadController extends Controller
{
    var $Origin;
    var $SaveMessage;
    var $ChosenExercises;
    var $RoutineNumber;
    
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
            if($_REQUEST['form'] == "submitted" && $_REQUEST['btnsubmit'] == 'Save WOD'){
                $Model = new UploadModel;
                $Model->Save();               
            }
	}
        
       function Message()
    {
            if(isset($_REQUEST['NewExercise'])){
                $Message = $this->SaveNewExercise();
            }
            else if(isset($_REQUEST['Exercise'])){
                $Message = $this->Validate();
                if($Message == ''){
                    $Model = new UploadModel;
                    $Message = $Model->AddExercise();
                }
            }      
        return $Message; 
    } 
    
    function ValidateNew(){
        $Message = '';
        if(isset($_REQUEST['NewExercise']) && $_REQUEST['NewExercise'] == ''){
            $Message = 1;//'Must Enter Exercise Name!';            
        }else if(empty($_REQUEST['attributes'])){
            $Message = 2;//'Must Have at least one Attribute!';
        }else if(in_array('Distance', $_REQUEST['attributes']) && in_array('Height', $_REQUEST['attributes'])){
            $Message = 4;//'Can't have distance and height!';
        }
        return $Message;        
    }
        
    function Validate()
    {
        $Routines = $_REQUEST['RoutineCounter'];
        $RoundsVal = $_REQUEST['Rounds'];
        $FWeightVal = $_REQUEST['fWeight'];
        $MWeightVal = $_REQUEST['mWeight'];
        $FHeightVal = $_REQUEST['fHeight'];
        $MHeightVal = $_REQUEST['mHeight'];
        $Distance = $_REQUEST['Distance'];
        $RepsVal = $_REQUEST['Reps'];

        $Message = '';
        if(isset($_REQUEST['NewExercise']) && $_REQUEST['NewExercise'] == ''){
            $Message = 1;//'Must Enter Exercise Name!';
        }else if(isset($_REQUEST['Exercise']) && $_REQUEST['Exercise'] == 'none'){
            $Message = 3;//'Must Select Exercise!';            
        }else if($RoundsVal == '' && $FWeightVal == '' && $MWeightVal == '' && $FHeightVal == '' &&
                $MHeightVal == '' && $Distance == '' && $RepsVal == ''){
            $Message = 2;//'Must Have at least one Attribute';
        }
        return $Message;
    }
    
    function SaveNewExercise()
    {
        $Result = '';

            $Validate = $this->ValidateNew();
            if($Validate == ''){
                $Model = new UploadModel;
                $Result = $Model->SaveNewExercise();
            }
            else{
                $Result = $Validate;
            }
        
        return $Result;
    }


    function MainOutput()
    {    
        $Html ='<h2>Routine 1</h2>';
        $Html .= '<div id="Routine_1">';
        $Html .= $this->getExercises(1);
     	$Html .= '</div>';
        $Html .= '<input type="button" value="Custom Activity" onClick="addNewActivity();"/>';
        $Html .= '<br/>Comments<br/>';
        $Html .= '<textarea name="RoutineNumber_Notes" rows="4" cols="80"></textarea>';
      
	return $Html;
    }
    
        function AddNewExercise($ExerciseId)
	{
            $Model = new UploadModel;
            if(isset($_REQUEST['NewExercise']) && $ExerciseId > 0)
                $ExerciseName = $_REQUEST['NewExercise'];
 
            $Attributes = $Model->getExerciseAttributes($ExerciseId);
                $Message = '<input type="hidden" id="Exercise" name="Exercise" value="'.$ExerciseId.'"/>';
                foreach($Attributes as $Attribute){
                    $UnitsOfMeasure = $Model->getUnitsOfMeasure($Attribute->recid);
                if($Attribute->Attribute == 'Weight'){
                    $Message .= '<input placeholder="Weight(M)" size="8" type="text" id="mWeight" name="mWeight" value="'.$_REQUEST['mWeight'].'"/> 
                                <input placeholder="Weight(F)" size="8" type="text" id="fWeight" name="fWeight" value="'.$_REQUEST['fWeight'].'"/>';
                    $Message .= '<select name="WUOM" id="WUOM">';
                    foreach($UnitsOfMeasure as $Unit){
                    $Message .= '<option value="'.$Unit->recid.'">'.$Unit->UnitDescription.'</option>'; 
                    }
                    $Message .= '</select>';                   
                }
                if($Attribute->Attribute == 'Height'){
                    $Message .= '<input placeholder="Height(M)" size="8" type="text" id="mHeight" name="mHeight" value="'.$_REQUEST['mHeight'].'"/> 
                                <input placeholder="Height(F)" size="8" type="text" id="fHeight" name="fHeight" value="'.$_REQUEST['fHeight'].'"/>';
                    $Message .= '<select name="HUOM" id="HUOM">';
                    foreach($UnitsOfMeasure as $Unit){
                    $Message .= '<option value="'.$Unit->recid.'">'.$Unit->UnitDescription.'</option>'; 
                    }   
                    $Message .= '</select>';                   
                }
                if($Attribute->Attribute == 'Distance'){
                    $Message .= '<input placeholder="Distance" size="8" type="text" id="Distance" name="Distance" value="'.$_REQUEST['Distance'].'"/>';
                    $Message .= '<select name="DUOM" id="DUOM">';
                    foreach($UnitsOfMeasure as $Unit){
                    $Message .= '<option value="'.$Unit->recid.'">'.$Unit->UnitDescription.'</option>'; 
                    }
                    $Message .= '</select>';
                }
                if($Attribute->Attribute == 'Reps'){
                    $Message .= '<input placeholder="Reps" size="3" type="text" id="Reps" name="Reps" value="'.$_REQUEST['Reps'].'"/>';
                } 
                }
                $Message .= '<input class="buttongroup" type="button" name="btnsubmit" value="Add" onClick="addexercise();"/>';

            return $Message;  
        }
        
        function AddNewAdvancedExercise($ExerciseId)
	{
            $Model = new UploadModel;
            if(isset($_REQUEST['NewExercise']) && $ExerciseId > 0)
                $ExerciseName = $_REQUEST['NewExercise'];
 
            $Attributes = $Model->getExerciseAttributes($ExerciseId);
                $Message = '<input type="hidden" id="aExercise" name="Exercise" value="'.$ExerciseId.'"/>';
                foreach($Attributes as $Attribute){
                    $UnitsOfMeasure = $Model->getUnitsOfMeasure($Attribute->recid);
                if($Attribute->Attribute == 'Weight'){
                    $Message .= '<input placeholder="Weight(M)" size="8" type="text" id="amWeight" name="mWeight" value="'.$_REQUEST['mWeight'].'"/> 
                                <input placeholder="Weight(F)" size="8" type="text" id="afWeight" name="fWeight" value="'.$_REQUEST['fWeight'].'"/>';
                    $Message .= '<select name="WUOM" id="aWUOM">';
                    foreach($UnitsOfMeasure as $Unit){
                    $Message .= '<option value="'.$Unit->recid.'">'.$Unit->UnitDescription.'</option>'; 
                    }
                    $Message .= '</select>';                   
                }
                if($Attribute->Attribute == 'Height'){
                    $Message .= '<input placeholder="Height(M)" size="8" type="text" id="amHeight" name="mHeight" value="'.$_REQUEST['mHeight'].'"/> 
                                <input placeholder="Height(M)" size="8" type="text" id="afHeight" name="fHeight" value="'.$_REQUEST['fHeight'].'"/>';
                    $Message .= '<select name="HUOM" id="aHUOM">';
                    foreach($UnitsOfMeasure as $Unit){
                    $Message .= '<option value="'.$Unit->recid.'">'.$Unit->UnitDescription.'</option>'; 
                    }   
                    $Message .= '</select>';                   
                }
                if($Attribute->Attribute == 'Distance'){
                    $Message .= '<input placeholder="Distance" size="8" type="text" id="aDistance" name="Distance" value="'.$_REQUEST['Distance'].'"/>';
                    $Message .= '<select name="DUOM" id="aDUOM">';
                    foreach($UnitsOfMeasure as $Unit){
                    $Message .= '<option value="'.$Unit->recid.'">'.$Unit->UnitDescription.'</option>'; 
                    }
                    $Message .= '</select>';
                }
                if($Attribute->Attribute == 'Reps'){
                    $Message .= '<input placeholder="Reps" size="3" type="text" id="aReps" name="Reps" value="'.$_REQUEST['Reps'].'"/>';
                } 
                }
                $Message .= '<input class="buttongroup" type="button" name="btnsubmit" value="Add" onClick="addexerciseAdvanced();"/>';

            return $Message;  
        }
    
    function getExercises()
    {

        $Html='';
        $Model = new UploadModel;
        $Exercises = $Model->getActivities();
        //$Html.='<div style="height:42px;width:980px">';
        //$Html.='<form action="index.php" id="exerciseselect" name="exerciseselect">';
        $Html.='<select style="width:150px" name="Exercise" id="Exercise" onChange="getInputFields(this.value);">';
        $Html.='<option value="none">Select Activity</option>';
        foreach($Exercises AS $Exercise){
            $Html.='<option value="'.$Exercise->recid.'">'.$Exercise->ActivityName.'</option>';
        }
        $Html.='</select>';
        /*
        $Html .= '<input size="8" type="text" id="mWeight" name="mWeight" placeholder="Weight(M)"/>';
        $Html .= '<input size="8" type="text" id="fWeight" name="fWeight" placeholder="Weight(F)"/>';
        
        $Html .= '<input size="8" type="text" id="mHeight" name="mHeight" placeholder="Height(M)"/>';
        $Html .= '<input size="8" type="text" id="fHeight" name="fHeight" placeholder="Height(F)"/>';
        
        $Html .= '<input size="8" type="text" id="Distance" name="Distance" placeholder="Distance"/>';
        
        $Html .= '<input size="4" type="text" id="Reps" name="Reps" placeholder="Reps"/>';   
        $Html .= '<input class="buttongroup" type="button" name="btnsubmit" value="Add" onClick="addexercise();"/>';
         * 
         */
       // $Html.='</form><br/>';
        //$Html.='</div>';
        return $Html;
    }   
    
    function getAdvancedExercises()
    {

        $Html='';
        $Model = new UploadModel;
        $Exercises = $Model->getActivities();
        //$Html.='<div style="height:42px;width:980px">';
        //$Html.='<form action="index.php" id="aexerciseselect" name="exerciseselect">';
        $Html.='<select style="width:150px" name="Exercise" id="aexerciseselect" onChange="getAdvancedInputFields(this.value);">';
        $Html.='<option value="none">Select Activity</option>';
        foreach($Exercises AS $Exercise){

            $Html.='<option value="'.$Exercise->recid.'">'.$Exercise->ActivityName.'</option>';

        }
        $Html.='</select>';
        //$Html .= '<input size="8" type="text" id="amWeight" name="mWeight" placeholder="Weight(M)"/>';
        //$Html .= '<input size="8" type="text" id="afWeight" name="fWeight" placeholder="Weight(F)"/>';
        //$Html .= '<input size="8" type="text" id="amHeight" name="mHeight" placeholder="Height(M)"/>';
        //$Html .= '<input size="8" type="text" id="afHeight" name="fHeight" placeholder="Height(F)"/>';
        //$Html .= '<input size="8" type="text" id="aDistance" name="Distance" placeholder="Distance"/>';
        //$Html .= '<input size="4" type="text" id="aReps" name="Reps" placeholder="Reps"/>';
        //$Html .= '<input class="buttongroup" type="button" name="btnsubmit" value="Add" onclick="addexerciseAdvanced();"/>';          
        //$Html.='</form><br/>';
        //$Html.='</div>';
        return $Html;
    }    
    
    function TimingTypes(){
        
        $Html='<div id="timing"><input type="hidden" name="RoutineNumber_TimingType" id="RoutineNumber_TimingType" value="0"/>';
        $Model = new UploadModel;
        $WorkoutTypes = $Model->getWorkoutTypes();
        foreach($WorkoutTypes AS $WorkoutType){
            $Html .= '<br/><input type="button" onclick="SelectTimingType('.$WorkoutType->recid.');" name="TimingType_'.$WorkoutType->recid.'" value="'.$WorkoutType->ActivityType.'"/>';
        }
        $Html.='<br/><input style="width:150px;margin-left:4px" type="text" name="RoutineNumber_Timing" id="RoutineNumber_Timing" value="" placeholder="00:00"/>';
        $Html.='</div>';
        return $Html;
    }
	
	function Output()
	{
            if(isset($_REQUEST['chosenexercise'])){
  		$Model = new UploadModel;
		$html = $Model->getExerciseAttributes($_REQUEST['chosenexercise']);              
            }else if($_REQUEST['dropdown'] == 'refresh'){
                $html = $this->getExercises($_REQUEST['routineno']);
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
