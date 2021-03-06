<?php
class BaselineController extends Controller
{
    var $Baseline;
    var $SelectedBaseline;
    var $SaveMessage;
	
    function __construct()
    {
        parent::__construct();
        session_start();
        if(!isset($_COOKIE['UID'])){
            header('location: index.php?module=login');	
        }
    }
    
    function Message()
    {
        $Model = new BaselineModel;
            if(isset($_REQUEST['RoutineTime'])){
            //Save Routine Time  
                $Message = $Model->SaveRoutineTime($_REQUEST['TimeFieldName']);
            }else{          
                $Message = $Model->Log();
            }
        
        return $Message;
    }    
    
    function Output()
    {
        if($_REQUEST['history'] == 'refresh'){
            $Html = $this->UpdateHistory($_REQUEST['ExerciseId']);
        }else{
            $Html = $this->getBaselineDetails(); 
        }
	return $Html;
    }
    
    function getBaselineDetails()
    {
        $Model = new BaselineModel;
        $BaselineDetails = $Model->getBaselineDetails();
        //var_dump($BaselineDetails);
        $WorkoutTypeId = $BaselineDetails[0]->WodTypeId;
        $WorkoutId = $BaselineDetails[0]->WorkoutId;       
        $html='<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">';
        $html.='<li>Baseline : '.$BaselineDetails[0]->WorkoutName.'</li>';
        $html.='</ul>';
/*
        $html.='<form name="baselineform" id="baselineform" action="index.php">
        <input type="hidden" name="BaselineType" value="'.$BaselineDetails[0]->BaselineType.'"/>
        <input type="hidden" name="WorkoutId" value="'.$BaselineDetails[0]->WorkoutId.'"/>';
*/
        $html .= '<div data-role="collapsible-set" data-iconpos="right">';
        $ThisRoutineNo = 0;
        $ThisRoundNo = 0;
        $ThisOrderBy = 0;
        $Attributes = array();   
	$ThisExerciseId = 0;
        $i=0;
        $j=0;
        //var_dump($this->Workout);
	foreach($BaselineDetails as $Detail){
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
			if($ThisRoutineNo != $Detail->RoutineNo){
                            if($Detail->ExerciseId != null && $i > 0){
                                $html.='</h2><div id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisOrderBy.'_'.$ThisExerciseId.'_History">'.$this->UpdateHistory($ThisExerciseId).'</div>';
            $j=0;
            $html .= '<div class="ActivityAttributes"><form id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisOrderBy.'_'.$ThisExerciseId.'" name="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisOrderBy.'_'.$ThisExerciseId.'">';
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
                $html .= ' style="width:50px" type="number" id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_new" name="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_'.$UnitOfMeasureId.'_'.$ThisOrderBy.'"/></div>';
                $j++;
            }
            $Attributes = array();
            $html.='<input type="hidden" id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'" name="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'" value=""/>';
            $html.='<div class="clear"></div><div style="width:100%;height:25px"><div style="float:left;margin:10px 0 10px 20px"><input type="button" id="" name="timebtn" onClick="EnterActivityTime(\'baseline\', \''.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'\');" value="Add Time"/></div>';
            $html.='<div style="float:right;margin:10px 20px 10px 0"><input type="button" id="" name="btn" onClick="SaveTheseResults(\''.$WorkoutId.'_'.$WorkoutTypeId.'\', \''.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisOrderBy.'_'.$ThisExerciseId.'\');" value="Add Results"/></div>';
            $html.='</div></form></div></div>'; 
            $html.='<div style="float:left;width:65%" id="'.$ThisRoutineNo.'_timerContainer"></div>';                       
            $html.='<div style="width:30%;float:right;margin:10px 4px 0 0"><input class="buttongroup" id="'.$ThisRoutineNo.'_ShowHideClock" type="button" onClick="DisplayStopwatch(\'baseline\', \''.$WorkoutTypeId.'_'.$WorkoutId.'_'.$ThisRoutineNo.'\');" value="Timer"/></div><div class="clear"></div>';                                                                    
                            } 
                            $html.= '<h3>Routine '.$Detail->RoutineNo.'</h3>';
                            $html.= '<h3>Round '.$Detail->RoundNo.'</h3>';
                            $html.= '<div data-role="collapsible">';
                            $html.= '<h2>'.$Detail->Exercise.'<br/>';             
			}                    
			else if($Detail->TotalRounds > 1 && $Detail->RoundNo > 0 && $ThisRoundNo != $Detail->RoundNo){
                            if($Detail->ExerciseId != null && $i > 0){
                                $html.='</h2><div id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisOrderBy.'_'.$ThisExerciseId.'_History">'.$this->UpdateHistory($ThisExerciseId).'</div>';
            $j=0;
            $html .= '<div class="ActivityAttributes"><form id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisOrderBy.'_'.$ThisExerciseId.'" name="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisOrderBy.'_'.$ThisExerciseId.'">';
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
                $html .= ' style="width:50px" type="number" id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_new" name="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_'.$UnitOfMeasureId.'_'.$ThisOrderBy.'"/></div>';
                $j++;
            }
            $Attributes = array();   
            $html .= '<input type="hidden" id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'" name="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'" value=""/>';
            $html .= '<div class="clear"></div><div style="width:100%;height:25px"><div style="float:left;margin:10px 0 10px 20px"><input class="buttongroup" data-mini="true" type="button" id="" name="timebtn" onClick="EnterActivityTime(\'baseline\', \''.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'\');" value="Add Time"/></div>';
            $html .= '<div style="float:right;margin:10px 20px 10px 0"><input class="buttongroup" data-mini="true" type="button" id="" name="btn" onClick="SaveTheseResults(\''.$WorkoutId.'_'.$WorkoutTypeId.'\', \''.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisOrderBy.'_'.$ThisExerciseId.'\');" value="Add Results"/></div>';
            $html .= '</div></form></div><div class="clear"></div></div>';                                
                                         
                            }
                            //if($i > 0)
                            //    $html.= '<br/><br/>';                            
                            $html.= '<h3>Round '.$Detail->RoundNo.'</h3>';
                            $html.= '<div data-role="collapsible">';
                            $html.= '<h2>'.$Detail->Exercise.'<br/>';             
			}
			else if($ThisExerciseId != $Detail->ExerciseId || $ThisOrderBy != $Detail->OrderBy){
                            if($Detail->ExerciseId != null && $i > 0){
                                $html.='</h2><div id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisOrderBy.'_'.$ThisExerciseId.'_History">'.$this->UpdateHistory($ThisExerciseId).'</div>';
            $j=0;
            $html .= '<div class="ActivityAttributes"><form id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisOrderBy.'_'.$ThisExerciseId.'" name="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisOrderBy.'_'.$ThisExerciseId.'">';
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
                $html .= ' style="width:50px" type="number" id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_new" name="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_'.$UnitOfMeasureId.'_'.$ThisOrderBy.'"/></div>';
                $j++;
            }
            $Attributes = array();
            $html .= '<input type="hidden" id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'" name="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'" value=""/>';
            $html .= '<div class="clear"></div><div style="width:100%;height:25px"><div style="float:left;margin:10px 0 10px 20px"><input data-mini="true" class="buttongroup" type="button" id="" name="timebtn" onClick="EnterActivityTime(\'baseline\', \''.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'\');" value="Add Time"/></div>';
            $html .= '<div style="float:right;margin:10px 20px 10px 0"><input class="buttongroup" data-mini="true" type="button" id="" name="btn" onClick="SaveTheseResults(\''.$WorkoutId.'_'.$WorkoutTypeId.'\', \''.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisOrderBy.'_'.$ThisExerciseId.'\');" value="Add Results"/></div>';
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
            $ThisRoutineNo = $Detail->RoutineNo;        
            $ThisRoundNo = $Detail->RoundNo;
            $ThisOrderBy = $Detail->OrderBy;
            $ThisExerciseId = $Detail->ExerciseId;                   
            }
        $i++;
	}
                            if($ThisExerciseId != null && $i > 0 && $Attribute != 'TimeToComplete'){
                                $html.='</h2><div id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisOrderBy.'_'.$ThisExerciseId.'_History">'.$this->UpdateHistory($ThisExerciseId).'</div>';
            $j=0;
            $html .= '<div class="ActivityAttributes"><form id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisOrderBy.'_'.$ThisExerciseId.'" name="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisOrderBy.'_'.$ThisExerciseId.'">';
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
                $html .= ' style="width:50px" type="number" id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_new" name="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_'.$UnitOfMeasureId.'_'.$ThisOrderBy.'"/></div>';
                $j++;
            }
            $Attributes = array();
            $html .= '<input type="hidden" id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'" name="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'" value=""/>';
            $html .= '<div class="clear"></div><div style="width:100%"><div style="float:left;margin:10px 0 10px 20px"><input data-mini="true" type="button" id="" name="timebtn" onClick="EnterActivityTime(\'baseline\', \''.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'\');" value="Add Time"/></div>';
            $html .= '<div style="float:right;margin:10px 20px 10px 0"><input type="button" id="" data-mini="true" name="btn" onClick="SaveTheseResults(\''.$WorkoutId.'_'.$WorkoutTypeId.'\', \''.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisOrderBy.'_'.$ThisExerciseId.'\');" value="Add Results"/></div>';
            $html .= '</div></form></div><div class="clear"></div></div>';                                

                            }   
           $html.='<div style="float:left;width:65%" id="'.$ThisRoutineNo.'_timerContainer"></div>';                       
            $html.='<div style="width:30%;float:right;margin:10px 4px 0 0"><input data-mini="true" class="buttongroup" id="'.$ThisRoutineNo.'_ShowHideClock" type="button" onClick="DisplayStopwatch(\'baseline\', \''.$WorkoutTypeId.'_'.$WorkoutId.'_'.$ThisRoutineNo.'\');" value="Timer"/></div><div class="clear"></div>';                                                                    
     $html.='</div>';
    $html.='<br/><br/>';
        return $html;
    }
    
    function UpdateHistory($ExerciseId){
        $Model = new BaselineModel;
        $Attributes = $Model->getExerciseIdAttributes($ExerciseId);
        $ExerciseHistory = $Model->getExerciseHistory($ExerciseId);
        $html ='';
            if(count($ExerciseHistory) == 0){
                $html='<p style="color:red">No History for activity</p>';
            }else{
            $j=1;
            $NumAttributes = count($Attributes);
            $NumRows = count($ExerciseHistory);
            $i=1;
            foreach($ExerciseHistory as $Detail){
                if($j == 1){
                    $html.='<p';
                    if($i < ($NumRows / $NumAttributes)){
                        $html.=' style="color:red;font-size:16px;"';
                    }else{
                        $html.=' style="color:green;font-size:16px;"';
                    }
                    $html.='>';
                }
                $html.=''.$Detail->Attribute.' : '.$Detail->AttributeValue.''.$Detail->UnitOfMeasure.'';
                    
                    if($j == $NumAttributes){
                        $html.='</p>';
                        $j = 0;
                        $i++;
                    }else{
                        $html.=' | ';
                    }
                    $j++; 
                } 
            } 
        return $html;
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
    
    function getCountDown($Time)
    {
	$RoundNo = 0;
        $TimeToComplete = $Time;
        $StartStopButton = 'Start';
        if(isset($_REQUEST[''.$RoundNo.'___63___CountDown'])){
            $TimeToComplete = $_REQUEST[''.$RoundNo.'___'.$ExerciseId.'___TimeToComplete'];
            if($TimeToComplete != $Time)
                $StartStopButton = 'Stop';
        }
	$Html ='<input type="hidden" name="'.$RoundNo.'___'.$ExerciseId.'___CountDown" id="CountDown" value="'.$Time.'"/>';
        $Html.='<input id="clock" name="timer" value="'.$TimeToComplete.'"/>';
        $Html.='<input id="startstopbutton" class="buttongroup" type="button" onClick="startstopcountdown();" value="'.$StartStopButton.'"/>';
        $Html.='<input id="resetbutton" class="buttongroup" type="button" onClick="resetcountdown();" value="Reset"/>';
        $Html.='<input class="buttongroup" type="button" onClick="benchmarksubmit();" value="Save"/>';
		
        return $Html;
    }
}
?>