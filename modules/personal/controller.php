<?php
class PersonalController extends Controller
{
        var $Origin;
	var $Workout;
	var $BMWS;
	var $Categories;
	var $Category;
        var $Height;
        var $Video;
	
	function __construct()
	{
            parent::__construct();
            session_start();
            if(!isset($_COOKIE['UID'])){
                header('location: index.php?module=login');
            }
            if(isset($_REQUEST['origin']))
                $this->Origin = $_REQUEST['origin'];
		$this->Height = floor(SCREENWIDTH * 0.717); 
		$Model = new PersonalModel;

                if(isset($_REQUEST['WorkoutId']) && $_REQUEST['WorkoutId'] > 0){
                    if(!isset($_REQUEST['WorkoutTypeId']) || $_REQUEST['WorkoutTypeId'] == 3){//Custom
                        $this->Workout = $Model->getCustomDetails($_REQUEST['WorkoutId']);
                    }else if($_REQUEST['WorkoutTypeId'] == 4){//My Gym
                        $this->Workout = $Model->getMyGymDetails($_REQUEST['WorkoutId']);
                    }
                    //var_dump($this->Workout);
                    //$this->Workout = $WorkoutDetails[0];
                }
	}
        
        function Message()
        {
            $Model = new PersonalModel;
            if($_REQUEST['baseline'] == 'yes')
                $Message = $Model->MakeBaseline($_REQUEST['WorkoutId'], $_REQUEST['WodTypeId']);
            else if($_REQUEST['baseline'] == 'no')
                $Message = $Model->ClearBaseline();            
            else if(isset($_REQUEST['RoutineTime'])){
            //Save Routine Time  
                $Message = $Model->SaveRoutineTime($_REQUEST['TimeFieldName']);
            }else{          
                $Message = $Model->Log();
            }
            return $Message;
        }       
        
	function Output()
	{
            $html = '';
            
            $Model = new PersonalModel;

if(isset($_REQUEST['WorkoutId']) && $_REQUEST['WorkoutId'] != '')
{
    if(isset($_REQUEST['WorkoutTypeId']))
        $WorkoutTypeId = $_REQUEST['WorkoutTypeId'];
    else
	$WorkoutTypeId = 3;//Custom or My Gym
    $WorkoutId = $_REQUEST['WorkoutId'];
        /*
	$html.='<form name="form" id="personalform" action="index.php">
            <input type="hidden" name="origin" value="'.$this->Origin.'"/>
            <input type="hidden" name="WorkoutId" value="'.$WorkoutId.'"/>
            <input type="hidden" name="wodtype" value="'.$WorkoutTypeId.'"/>
            <input type="hidden" id="addround" name="RoundNo" value="1"/>
            <input type="hidden" name="form" value="submitted"/>';       
        */
        $html='<input type="checkbox" id="baseline" name="baseline" onClick="MakeBaseline(\''.$WorkoutId.'_'.$WorkoutTypeId.'\');" data-role="none"/>';
        $html.='Make this my baseline';   
        $html.='<p>'.$this->Workout[0]->Notes.'</p>';
        //$html.='<div class="ui-grid-b">';
        $html .= '<div data-role="collapsible-set" data-iconpos="right">';
        $ThisRoutine = '';
        $ThisRound = '';
        $OrderBy = '';
        $Attributes = array();   
	$ThisExerciseId = 0;
        $i=0;
        $j=0;
        //var_dump($this->Workout);
	foreach($this->Workout as $Detail){
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
            if($Detail->AttributeValue == '' || $Detail->AttributeValue == 0 || $Detail->AttributeValue == '-'){
                $AttributeValue = 'Max ';
            }else{
                $AttributeValue = $Detail->AttributeValue * $ConversionFactor;
            }   
            
		if($Detail->Attribute != 'TimeToComplete'){          
			if($ThisRoutine != $Detail->RoutineNo){
                            if($ThisExerciseId != null && $i > 0){
                                $html.='</h2><div id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$ThisExerciseId.'_History"><p style="color:red">'.$this->UpdateHistory($ThisExerciseId).'</p></div>';
            $j=0;
            $html .= '<div class="ActivityAttributes"><form id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$ThisExerciseId.'" name="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$ThisExerciseId.'">';
            //var_dump($Attributes);
            foreach($Attributes as $Attribute=>$Val){
                $UOM = $Model->getUserUnitOfMeasure($Attribute);
                $UnitOfMeasureId = $Model->getUnitOfMeasureId($Attribute);
                if($UnitOfMeasureId == '')
                    $UnitOfMeasureId = 0;   
                if($j > 0)
                    $TheseAttributes.='_';
                $TheseAttributes.=$Attribute;
                $html .= '<div style="float:left;margin:0 20px 0 20px"">'.$Attribute.'<br/><input value="'.$Val.'" style="width:80px" type="number" id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_new" name="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_'.$UnitOfMeasureId.'_'.$Detail->OrderBy.'" placeholder="'.$UOM.'"/></div>';
                $j++;
            }
            $Attributes = array();
            $html.='<input type="hidden" id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$Detail->OrderBy.'" name="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$Detail->OrderBy.'" value=""/>';
            $html.='<div class="clear"></div><div style="width:100%;height:25px"><div style="float:left;margin:10px 0 10px 20px"><input type="button" id="" name="timebtn" onClick="EnterActivityTime(\''.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$Detail->OrderBy.'\');" value="Add Time"/></div>';
            $html.='<div style="float:right;margin:10px 20px 10px 0"><input type="button" id="" name="btn" onClick="SaveTheseResults(\''.$WorkoutId.'_'.$WorkoutTypeId.'\', \''.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$ThisExerciseId.'\');" value="Add Results"/></div>';
            $html.='</div></form></div></div>'; 
            $html.='<div style="float:left;width:65%" id="'.$ThisRoutine.'_timerContainer"></div>';                       
            $html.='<div style="width:30%;float:right;margin:10px 4px 0 0"><input class="buttongroup" id="'.$ThisRoutine.'_ShowHideClock" type="button" onClick="DisplayStopwatch(\'personal\', \''.$WorkoutTypeId.'_'.$WorkoutId.'_'.$ThisRoutine.'\');" value="Time Routine"/></div><div class="clear"></div>';                                                                    
                            } 
                            $html.= '<h2>Routine '.$Detail->RoutineNo.'</h2>';
                            $html.= '<h2>Round '.$Detail->RoundNo.'</h2>';
                            $html.= '<div data-role="collapsible">';
                            $html.= '<h2>'.$Detail->Exercise.'<br/>';             
			}                    
			else if($Detail->TotalRounds > 1 && $Detail->RoundNo > 0 && $ThisRound != $Detail->RoundNo){
                            if($ThisExerciseId != null && $i > 0){
                                $html.='</h2><div id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$ThisExerciseId.'_History"><p style="color:red">'.$this->UpdateHistory($ThisExerciseId).'</p></div>';
            $j=0;
            $html .= '<div class="ActivityAttributes"><form id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$ThisExerciseId.'" name="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$ThisExerciseId.'">';
            //var_dump($Attributes);
            foreach($Attributes as $Attribute=>$Val){
                $UOM = $Model->getUserUnitOfMeasure($Attribute);
                $UnitOfMeasureId = $Model->getUnitOfMeasureId($Attribute);
                if($UnitOfMeasureId == '')
                    $UnitOfMeasureId = 0;   
                if($j > 0)
                    $TheseAttributes.='_';
                $TheseAttributes.=$Attribute;
                $html .= '<div style="float:left;margin:0 20px 0 20px"">'.$Attribute.'<br/><input value="'.$Val.'" style="width:80px" type="number" id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_new" name="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_'.$UnitOfMeasureId.'_'.$Detail->OrderBy.'" placeholder="'.$UOM.'"/></div>';
                $j++;
            }
            $Attributes = array();   
            $html .= '<input type="hidden" id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$Detail->OrderBy.'" name="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$Detail->OrderBy.'" value=""/>';
            $html .= '<div class="clear"></div><div style="width:100%;height:25px"><div style="float:left;margin:10px 0 10px 20px"><input type="button" id="" name="timebtn" onClick="EnterActivityTime(\''.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$Detail->OrderBy.'\');" value="Add Time"/></div>';
            $html .= '<div style="float:right;margin:10px 20px 10px 0"><input type="button" id="" name="btn" onClick="SaveTheseResults(\''.$WorkoutId.'_'.$WorkoutTypeId.'\', \''.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$ThisExerciseId.'\');" value="Add Results"/></div>';
            $html .= '</div></form></div><div class="clear"></div></div>';                                
                                         
                            }
                            //if($i > 0)
                            //    $html.= '<br/><br/>';                            
                            $html.= '<h2>Round '.$Detail->RoundNo.'</h2>';
                            $html.= '<div data-role="collapsible">';
                            $html.= '<h2>'.$Detail->Exercise.'<br/>';             
			}
			else if($ThisExerciseId != $Detail->ExerciseId || $OrderBy != $Detail->OrderBy){
                            if($ThisExerciseId != null && $i > 0){
                                $html.='</h2><div id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$ThisExerciseId.'_History"><p style="color:red">'.$this->UpdateHistory($ThisExerciseId).'</p></div>';
            $j=0;
            $html .= '<div class="ActivityAttributes"><form id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$ThisExerciseId.'" name="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$ThisExerciseId.'">';
            //var_dump($Attributes);
            foreach($Attributes as $Attribute=>$Val){
                $UOM = $Model->getUserUnitOfMeasure($Attribute);
                $UnitOfMeasureId = $Model->getUnitOfMeasureId($Attribute);
                if($UnitOfMeasureId == '')
                    $UnitOfMeasureId = 0;   
                if($j > 0)
                    $TheseAttributes.='_';
                $TheseAttributes.=$Attribute;
                $html .= '<div style="float:left;margin:0 20px 0 20px"">'.$Attribute.'<br/><input value="'.$Val.'" style="width:80px" type="number" id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_new" name="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_'.$UnitOfMeasureId.'_'.$Detail->OrderBy.'" placeholder="'.$UOM.'"/></div>';
                $j++;
            }
            $Attributes = array();
            $html .= '<input type="hidden" id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$Detail->OrderBy.'" name="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$Detail->OrderBy.'" value=""/>';
            $html .= '<div class="clear"></div><div style="width:100%;height:25px"><div style="float:left;margin:10px 0 10px 20px"><input type="button" id="" name="timebtn" onClick="EnterActivityTime(\''.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$Detail->OrderBy.'\');" value="Add Time"/></div>';
            $html .= '<div style="float:right;margin:10px 20px 10px 0"><input type="button" id="" name="btn" onClick="SaveTheseResults(\''.$WorkoutId.'_'.$WorkoutTypeId.'\', \''.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$ThisExerciseId.'\');" value="Add Results"/></div>';
            $html .= '</div></form></div><div class="clear"></div></div>';                               
                                
                            }       
                            $html.= '<div data-role="collapsible">';
                            $html.= '<h2>'.$Detail->Exercise.'<br/>';                          
                        }else{
                            $html.=' | ';
                        }
                        $html.=''.$Detail->Attribute.' : <span id="'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_'.$Detail->Attribute.'_html">'.$AttributeValue.'</span>'.$Detail->UnitOfMeasure.'';
                        $html.='<input type="hidden" id="'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_'.$Detail->Attribute.'" name="'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_'.$Detail->Attribute.'_'.$UnitOfMeasureId.'_'.$Detail->OrderBy.'"';
                        if($AttributeValue == 'Max'){
                            $html.='placeholder="'.$AttributeValue.'" value="">';
                        }else{
                            $html.='value="'.$AttributeValue.'">';
                        } 
                   $Attributes[''.$Detail->Attribute.''] = $AttributeValue != "-" ? $AttributeValue : "";                        
                }
              
        $ThisRoutine = $Detail->RoutineNo;        
	$ThisRound = $Detail->RoundNo;
        $OrderBy = $Detail->OrderBy;
	$ThisExerciseId = $Detail->ExerciseId;
        $i++;
	}
                            if($ThisExerciseId != null && $i > 0 && $Attribute != 'TimeToComplete'){
                                $html.='</h2><div id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$ThisExerciseId.'_History"><p style="color:red">'.$this->UpdateHistory($ThisExerciseId).'</p></div>';
            $j=0;
            $html .= '<div class="ActivityAttributes"><form id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$ThisExerciseId.'" name="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$ThisExerciseId.'">';
            //var_dump($Attributes);
            foreach($Attributes as $Attribute=>$Val){
                $UOM = $Model->getUserUnitOfMeasure($Attribute);
                $UnitOfMeasureId = $Model->getUnitOfMeasureId($Attribute);
                if($UnitOfMeasureId == '')
                    $UnitOfMeasureId = 0;   
                if($j > 0)
                    $TheseAttributes.='_';
                $TheseAttributes.=$Attribute;
                $html .= '<div style="float:left;margin:0 25px 0 25px"">'.$Attribute.'';
                if($UOM != '')
                $html .= '('.$UOM.')';
                $html .= '<br/><input ';
                if($Val == 'Max')
                    $html .= 'value="" placeholder="'.$Val.'"'; 
                else      
                    $html .= 'value="'.$Val.'"'; 
                $html .= ' style="width:60px" type="number" id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_new" name="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_'.$UnitOfMeasureId.'_'.$Detail->OrderBy.'"/></div>';
                $j++;
            }
            $Attributes = array();
            $html .= '<input type="hidden" id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$Detail->OrderBy.'" name="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$Detail->OrderBy.'" value=""/>';
            $html .= '<div class="clear"></div><div style="width:100%"><div style="float:left;margin:10px 0 10px 20px"><input type="button" id="" name="timebtn" onClick="EnterActivityTime(\''.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$Detail->OrderBy.'\');" value="Add Time"/></div>';
            $html .= '<div style="float:right;margin:10px 20px 10px 0"><input type="button" id="" name="btn" onClick="SaveTheseResults(\''.$WorkoutId.'_'.$WorkoutTypeId.'\', \''.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$ThisExerciseId.'\');" value="Add Results"/></div>';
            $html .= '</div></form></div><div class="clear"></div></div>';                                

                            }   
           $html.='<div style="float:left;width:65%" id="'.$ThisRoutine.'_timerContainer"></div>';                       
            $html.='<div style="width:30%;float:right;margin:10px 4px 0 0"><input class="buttongroup" id="'.$ThisRoutine.'_ShowHideClock" type="button" onClick="DisplayStopwatch(\'personal\', \''.$WorkoutTypeId.'_'.$WorkoutId.'_'.$ThisRoutine.'\');" value="Time Routine"/></div><div class="clear"></div>';                                                                    
     $html.='</div><br/><br/>';
    //$html.='</form>';

}else if($_REQUEST['history'] == 'refresh'){
    $html = $this->UpdateHistory($_REQUEST['ExerciseId']);
            }else{
    $Overthrow='';
    $Device = new DeviceManager;
    if($Device->IsGoogleAndroidDevice()) {
        $Overthrow='class="overthrow"';
    }
    $Workouts = $Model->getPersonalWorkouts();
     $html.='<div '.$Overthrow.'>
            <h2>Your Personal Workouts</h2>
            '.$this->getWorkoutList($Workouts).'
            </div>';    
}
$html.='<div class="clear"></div><br/>';
return $html;
	}
        
    function UpdateHistory($ExerciseId){
        $Model = new PersonalModel;
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
        
        function getExerciseHistory($ThisExercise)
        {
            $Html='';
            $ExplodedExercise = explode('_',$ThisExercise);
            $ThisRoundNo = $ExplodedExercise[0];
            $ThisExerciseId = $ExplodedExercise[1];
            $Model = new PersonalModel;
            $ExerciseHistory = $Model->getExerciseHistory($ThisExerciseId);
            //var_dump($ThisExerciseId);
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
        
        function getWorkoutList($Workouts)
        {
            $Model = new PersonalModel;
            $html = '<ul class="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">';
            foreach($Workouts AS $Workout){
                //$Description = $Model->getDescription($Workout->Id);
                $html .= '<li>';
                $html .= '<a href="" onclick="getDetails('.$Workout->Id.');">'.$Workout->WorkoutName.':<br/><span style="font-size:small">'.$Workout->Notes.'</span></a>';
                $html .= '</li>';
            }	
            $html .= '</ul><div class="clear"></div><br/>';
            return $html;
        }
        
        function getCustomMemberWorkouts()
        {
            $html = '';
            $Model = new PersonalModel;
            $CustomMemberWorkouts = $Model->getCustomMemberWorkouts();
            if(empty($CustomMemberWorkouts)){
                $html .= '<br/>Oops! You have not recorded any Custom Workouts yet.';
            }else{
            $html .= '<ul class="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d" data-icon="none">';
            foreach($CustomMemberWorkouts AS $Workout){
                //$Description = $Model->getCustomDescription($Workout->recid);
                $html .= '<li>';
                $html .= '<a href="" onclick="getCustomDetails(\''.$Workout->recid.'\', \''.$this->Origin.'\');">'.$Workout->WorkoutName.':<br/><span style="font-size:small">'.$Workout->Notes.'</span></a>';
                $html .= '</li>';
            }	
            $html .= '</ul><br/>';
            }
            return $html;
        }
        
        function getCustomPublicWorkouts()
        {
            $html = '';
            $Model = new PersonalModel;
            $CustomPublicWorkouts = $Model->getCustomPublicWorkouts();
            if(empty($CustomPublicWorkouts)){
                $html .= '<br/>Looks like there are none yet!';
            }else{
            $html .= '<ul class="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d" data-icon="none">';
            foreach($CustomPublicWorkouts AS $Workout){
                $Description = $Model->getCustomDescription($Workout->recid);
                $html .= '<li>';
                $html .= '<a href="" onclick="getCustomDetails(\''.$Workout->recid.'\', \''.$this->Origin.'\');">'.$Workout->WorkoutName.':<br/><span style="font-size:small">'.$Description.'</span></a>';
                $html .= '</li>';
            }	
            $html .= '</ul><br/>';
            }
            return $html;
        }
	
	function getHistory()
	{
		$Model = new PersonalModel;
		$HistoricalData = $Model->getHistory();
		if(empty($HistoricalData)){
			$History = 'Oops! You have not recorded any Benchmark workouts yet.';
		}else{
			foreach($HistoricalData AS $Data){
				$History.=''.$Data->TimeCreated.' : '.$Data->Name.' : '.$Data->AttributeValue.'<br/>';
			}
		}
		return $History;
	}
	
	function TopSelection()
	{
            $Model = new PersonalModel;
            //$Description = $Model->getDescription($_REQUEST['topselection']);
            $Html .= '<li>';
            $Html .= ''.$this->Workout[0]->WorkoutName.'';
            //$Html .= ':<br/><span style="font-size:small">'.$Description.'</span>';
            $Html .= '</li>';
            return $Html;	
	}	
}
?>