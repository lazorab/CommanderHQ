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
            if(!isset($_COOKIE['GID'])){
                header('location: index.php?module=login');	
            }
            $this->Origin = $_REQUEST['origin'];
            $this->SaveMessage = '';
            if(!isset($_REQUEST['form']) && !isset($_REQUEST['NewExercise']))
                $this->ChosenExercises = array();
	}
        
    function ValidateSave()
    {
        if($_REQUEST['WodName'] == ''){
            $Result = 'No name given!';
        }else if($_REQUEST['WodDate'] == ''){
            $Result = 'Must select date!';
        }else if($_REQUEST['WodDate'] < date('Y-m-d')){
            $Result = 'Invalid Date!';            
        }else if($_REQUEST['WodDate'] > date('Y-m-d', strtotime("+30 days"))){
            $Result = 'Date too far ahead!';            
        }else if($_REQUEST['rowcount'] == 0){
            $Result = 'No data!';            
        }else{
            $Model = new UploadModel;
            $Result = $Model->Save();        
        }
        return $Result;
    }
        
    function Message()
    {        
        if($_REQUEST['form'] == "submitted"){     
            $Message = $this->ValidateSave();
        }else if(isset($_REQUEST['benchmarkId'])){
            $Message = $this->getBenchmarkDetails();
        }else if(isset($_REQUEST['NewExercise'])){
            $Message = $this->SaveNewExercise();
        }else if(isset($_REQUEST['Exercise'])){
            $Message = $this->Validate();
            if($Message == ''){
                $Message = $this->AddThisExercise();
            }
        }      
        return $Message; 
    } 
    
    function getBenchmarkDetails()
    {
        $Model = new UploadModel;
        $Details = $Model->getBenchmarkDetails($_REQUEST['benchmarkId']);  
        $Html = '<table style="width:100%"><tr style="width:100%" id="row_ThisRow"><td style="width:95%">Benchmark : '.$Details->BenchmarkName.'<input type="hidden" name="ThisRoutine_Benchmark" value="'.$Details->BenchmarkId.'"/></td>';
        $Html .= '<td style="width:5%"><input type="button" value="Delete" onClick="Remove(\'ThisRow\');"/></td></tr></table>';       
        
        return $Html;    
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

        $Message = '';
        if(isset($_REQUEST['NewExercise']) && $_REQUEST['NewExercise'] == ''){
            $Message = 1;//'Must Enter Exercise Name!';
        }else if(isset($_REQUEST['Exercise']) && $_REQUEST['Exercise'] == 'none'){
            $Message = 3;//'Must Select Exercise!';            
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

        $Html.='<select style="width:250px" name="Exercise" id="Exercise" onChange="getInputFields(this.value);">';
        $Html.='<option value="none">Select Activity</option>';
        foreach($Exercises AS $Exercise){
            $Html.='<option value="'.$Exercise->recid.'">'.$Exercise->ActivityName.'</option>';
        }
        $Html.='</select>';

        return $Html;
    }   
    
    function getBenchmarks()
    {
        $Model = new UploadModel;
        $Benchmarks = $Model->getBenchmarks();   
        $Html .= '<select style="width:250px" class="select buttongroup" data-role="none" id="benchmark" name="benchmark" onChange="AddBenchmark(this.value)">
         <option value="none">Add Benchmark</option>';
	foreach($Benchmarks AS $Benchmark){
            $Html .= '<option value="'.$Benchmark->Id.'">'.$Benchmark->WorkoutName.'</option>';
	}
        $Html .= '</select>';
	return $Html;        
    }    
    
    function getAdvancedBenchmarks()
    {
        $Model = new UploadModel;
        $Benchmarks = $Model->getBenchmarks();   
        $Html .= '<select style="width:250px" class="select buttongroup" data-role="none" id="abenchmark" name="benchmark" onChange="AddBenchmarkAdvanced(this.value)">
         <option value="none">Add Benchmark</option>';
	foreach($Benchmarks AS $Benchmark){
            $Html .= '<option value="'.$Benchmark->Id.'">'.$Benchmark->WorkoutName.'</option>';
	}
        $Html .= '</select>';
	return $Html;        
    }
    
    function getAdvancedExercises()
    {
        $Html='';
        $Model = new UploadModel;
        $Exercises = $Model->getActivities();
        $Html.='<select style="width:250px" name="Exercise" id="aexerciseselect" onChange="getAdvancedInputFields(this.value);">';
        $Html.='<option value="none">Select Activity</option>';
        foreach($Exercises AS $Exercise){
            $Html.='<option value="'.$Exercise->recid.'">'.$Exercise->ActivityName.'</option>';
        }
        $Html.='</select>';

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
            $Model = new UploadModel;
            if(isset($_REQUEST['benchmarkId'])){   
                $html = $this->getBenchmark();
            }else if(isset($_REQUEST['chosenexercise'])){
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
        
    function AddThisExercise()
    {
        $Model = new UploadModel;
        $ExerciseId = $_REQUEST['Exercise'];
        $ExerciseDetails = $Model->getExerciseDetails($ExerciseId);
        $i=0;
        $Message = '<table style="width:100%"><tr style="width:100%" id="row_ThisRow"><td style="width:25%">'.$ExerciseDetails->Exercise.':'.$ExerciseDetails->Acronym.'</td>';
        //$Message .= '<td></td><td></td>';
        if(isset($_REQUEST['mWeight'])){
            if($_REQUEST['mWeight'] == '')
                $mWeight = '[Max]';
            else
                $mWeight = $_REQUEST['mWeight'];
            if($_REQUEST['fWeight'] == '')
                $fWeight = '[Max]';
            else
                $fWeight = $_REQUEST['fWeight'];            
            $Message .= '<td style="width:20%">Weight(M):'.$mWeight.'<input type="hidden" name="ThisRoutine_ThisRound_ThisOrderBy_'.$ExerciseId.'_mWeight" value="'.$_REQUEST['mWeight'].'"/>'.$Model->getUnitOfMeasure($_REQUEST['WUOM']).'</td>
                        <td style="width:20%">Weight(F):'.$fWeight.'<input type="hidden" name="ThisRoutine_ThisRound_ThisOrderBy_'.$ExerciseId.'_fWeight" value="'.$_REQUEST['fWeight'].'"/>'.$Model->getUnitOfMeasure($_REQUEST['WUOM']).'
                        <input type="hidden" name="ThisRoutine_ThisRound_ThisOrderBy_'.$ExerciseId.'_WUOM" value="'.$_REQUEST['WUOM'].'"/></td>';//WeightUnitOfMeasure     

        }else if(isset($_REQUEST['mHeight'])){
            if($_REQUEST['mHeight'] == '')
                $mHeight = '[Max]';
            else
                $mHeight = $_REQUEST['mHeight'];
            if($_REQUEST['fHeight'] == '')
                $fHeight = '[Max]';
            else
                $fHeight = $_REQUEST['fHeight'];            
            $Message .= '<td style="width:20%">Height(M):'.$mHeight.'<input type="hidden" name="ThisRoutine_ThisRound_ThisOrderBy_'.$ExerciseId.'_mHeight" value="'.$_REQUEST['mHeight'].'"/>'.$Model->getUnitOfMeasure($_REQUEST['HUOM']).'</td> 
                        <td style="width:20%">Height(F):'.$fHeight.'<input type="hidden" name="ThisRoutine_ThisRound_ThisOrderBy_'.$ExerciseId.'_fHeight" value="'.$_REQUEST['fHeight'].'"/>'.$Model->getUnitOfMeasure($_REQUEST['HUOM']).'
                        <input type="hidden" name="ThisRoutine_ThisRound_ThisOrderBy_'.$ExerciseId.'_HUOM" value="'.$_REQUEST['HUOM'].'"/></td>';//HeightUnitOfMeasure

       }else if(isset($_REQUEST['Distance'])){
            if($_REQUEST['Distance'] == '')
                $Distance = '[Max]';
            else
                $Distance = $_REQUEST['Distance'];            
            $Message .= '<td style="width:20%"></td><td style="width:15%"></td><td style="width:20%">Distance:'.$Distance.'<input type="hidden" name="ThisRoutine_ThisRound_ThisOrderBy_'.$ExerciseId.'_Distance" value="'.$_REQUEST['Distance'].'"/>
                        '.$Model->getUnitOfMeasure($_REQUEST['DUOM']).'<input type="hidden" name="ThisRoutine_ThisRound_ThisOrderBy_'.$ExerciseId.'_DUOM" value="'.$_REQUEST['DUOM'].'"/></td>';//DistanceUnitOfMeasure
        }
        if(!isset($_REQUEST['Distance'])){
            $Message .= '<td style="width:20%"></td>';
        }
        if(isset($_REQUEST['Reps'])){
            if($_REQUEST['Reps'] == '')
                $Reps = '[Max]';
            else
                $Reps = $_REQUEST['Reps'];
            $Message .= '<td style="width:15%">Reps:'.$Reps.'<input type="hidden" name="ThisRoutine_ThisRound_ThisOrderBy_'.$ExerciseId.'_Reps" value="'.$_REQUEST['Reps'].'"/></td>';
        }else{
            $Message .= '<td style="width:15%"></td>';
        }
                
        $Message .= '<td style="width:10%"><input type="button" value="Delete" onClick="Remove(\'ThisRow\');"/></td></tr></table>';

        return $Message;
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
