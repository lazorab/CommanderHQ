<?php
class MygymController extends Controller
{
	function __construct()
	{
            parent::__construct();
            session_start();
            if(!isset($_COOKIE['UID'])){
                header('location: index.php?module=login');
            }else if(!$this->MemberGym()){
                header('location: index.php?module=registergym');
            }
	}
	
	function TopSelection()
	{
            $Html='';
            if(isset($_REQUEST['topselection'])){
                $Display = $this->getTopSelection();
            }else{
                $Display = 'Workout Of the Day';
            }
            $Html='<li>'.$Display.'</li>';
            return $Html;
	}
        
        function getTopSelection()
        {
            $Html='';
            $Model = new MygymModel;
            $WodDetails = $Model->getTopSelection();
            if(count($WodDetails) == 0){
            $Gym = $this->MemberGym();
            $Html = $Gym->GymName;
            }else{
            $Description = $Model->WodDescription($WodDetails[0]->WodId);
            $Html .= 'Workout For '.date("D d M Y", strtotime($WodDetails[0]->WodDate)).':<br/><span style="font-size:small">'.$Description.'</span>';
            }
            return $Html;           
        }
	
	function WodDetails()
	{
            $Model = new MygymModel;
            $WOD = $Model->getWOD();
            return $WOD;
	}
        
        function Message()
        {
            $Model = new MygymModel;
            if($_REQUEST['baseline'] == 'yes')
                $Message = $Model->MakeBaseline($_REQUEST['WorkoutId'], $_REQUEST['WodTypeId']);
            else if($_REQUEST['baseline'] == 'no')
                $Message = $Model->ClearBaseline();
            else
                $Message = $Model->Log();

            return $Message;
        }
	
	function Output()
	{
            if($_REQUEST['history'] == 'refresh'){
                $html = $this->UpdateHistory($_REQUEST['ExerciseId']);
            }else{
            $html = '<div data-role="navbar">
            <ul>
                <li style="width:48%"><a href="#" onClick="Tabs(\'1\');" class="ui-btn-active">Well Rounded</a></li>
                <li style="width:48%"><a href="#" onClick="Tabs(\'2\');">Advanced</a></li>
            </ul>
        </div><div id="tab1"> ';

         $html .= '<div id="details1"></div>
                                </div>   
                                <div id="tab2"> ';

          $html .= ' <div id="details2"></div>
                                </div>';                
			
            }
            return $html;
	}
    
	function MemberGym()
	{
            $Model = new MygymModel;
            $MemberGym = $Model->getMemberGym();	
            return $MemberGym;
	}
        
 	function MyGymFeed()
	{
            $Html='';
            $Model = new MygymModel;
            $GymFeed = $Model->getMyGymFeed();
            $i = 0;
            foreach($GymFeed AS $Item)
            {
                if($i > 0)
                    $Html.='<a href="#" onClick="getDetails(\''.urlencode($Item->WodDate).'\')">'.$Item->WodDate.'</a><br/><br/>';
                $i++;
            }
            return $Html;
	}   
        
  	function WorkoutDetails($type)
	{
            $html='';
            $Model = new MygymModel;
            $WodDetails = $Model->getWODDetails($type);
            //var_dump($WodDetails);
            $Gym = $this->MemberGym();
            
            if(count($WodDetails) == 0){
                $html=' No WOD loaded from '.$Gym->GymName.' today';
            }else{
	$WorkoutTypeId = 4;
        $WorkoutId = $WodDetails[0]->Id;                
        $html='<input type="checkbox" id="baseline" name="baseline" onClick="MakeBaseline(\\\''.$WorkoutId.'_'.$WorkoutTypeId.'\\\');" data-role="none"/>';
        $html.='Make this my baseline';   
        $html.='<p>'.$WodDetails[0]->Notes.'</p>';
        $html .= '<div data-role="collapsible-set" data-iconpos="right">';
        $ThisRoutine = '';
        $ThisRound = '';
        $OrderBy = '';
        $Attributes = array();   
	$ThisExerciseId = 0;
        $i=0;
        $j=0;
        //var_dump($this->Workout);
	foreach($WodDetails as $Detail){
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
                            if($Detail->ExerciseId != null && $i > 0){
                                $html.='</h2><div id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$Detail->ExerciseId.'_History">'.$this->UpdateHistory($Detail->ExerciseId).'</div>';
            $j=0;
            $html .= '<div class="ActivityAttributes"><form id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$Detail->ExerciseId.'" name="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$Detail->ExerciseId.'">';
            //var_dump($Attributes);
            foreach($Attributes as $Attribute=>$Val){
                $UOM = $Model->getUserUnitOfMeasure($Attribute);
                $UnitOfMeasureId = $Model->getUnitOfMeasureId($Attribute);
                if($UnitOfMeasureId == '')
                    $UnitOfMeasureId = 0;   
                if($j > 0)
                    $TheseAttributes.='_';
                $TheseAttributes.=$Attribute;
                $html .= '<div style="float:left;margin:0 20px 0 20px"">'.$Attribute.'<br/><input value="'.$Val.'" style="width:80px" type="number" id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_'.$Attribute.'_new" name="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_'.$Attribute.'_'.$UnitOfMeasureId.'_'.$Detail->OrderBy.'" placeholder="'.$UOM.'"/></div>';
                $j++;
            }
            $Attributes = array();
            $html.='<input type="hidden" id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_TimeToComplete_0_'.$Detail->OrderBy.'" name="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_TimeToComplete_0_'.$Detail->OrderBy.'" value=""/>';
            $html.='<div class="clear"></div><div style="width:100%;height:25px"><div style="float:left;margin:10px 0 10px 20px"><input class="buttongroup" data-mini="true" type="button" id="" name="timebtn" onClick="EnterActivityTime(\\\''.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_TimeToComplete_0_'.$Detail->OrderBy.'\\\');" value="Add Time"/></div>';
            $html.='<div style="float:right;margin:10px 20px 10px 0"><input class="buttongroup" type="button" id="" name="btn" data-mini="true" onClick="SaveTheseResults(\\\''.$WorkoutId.'_'.$WorkoutTypeId.'\\\', \\\''.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$Detail->ExerciseId.'\\\');" value="Add Results"/></div>';
            $html.='</div></form></div></div>'; 
            $html.='<div style="float:left;width:65%" id="'.$ThisRoutine.'_timerContainer"></div>';                       
            $html.='<div style="width:30%;float:right;margin:10px 4px 0 0"><input data-mini="true" class="buttongroup" id="'.$ThisRoutine.'_ShowHideClock" type="button" onClick="DisplayStopwatch(\\\'mygym\\\', \\\''.$WorkoutTypeId.'_'.$WorkoutId.'_'.$ThisRoutine.'\\\');" value="Timer"/></div><div class="clear"></div>';                                                                    
                            } 
                            $html.= '<h3>Routine '.$Detail->RoutineNo.'</h3>';
                            $html.= '<h3>Round '.$Detail->RoundNo.'</h3>';
                            $html.= '<div data-role="collapsible">';
                            $html.= '<h2>'.$Detail->Exercise.'<br/>';             
			}                    
			else if($Detail->TotalRounds > 1 && $Detail->RoundNo > 0 && $ThisRound != $Detail->RoundNo){
                            if($Detail->ExerciseId != null && $i > 0){
                                $html.='</h2><div id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$Detail->ExerciseId.'_History">'.$this->UpdateHistory($Detail->ExerciseId).'</div>';
            $j=0;
            $html .= '<div class="ActivityAttributes"><form id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$Detail->ExerciseId.'" name="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$Detail->ExerciseId.'">';
            //var_dump($Attributes);
            foreach($Attributes as $Attribute=>$Val){
                $UOM = $Model->getUserUnitOfMeasure($Attribute);
                $UnitOfMeasureId = $Model->getUnitOfMeasureId($Attribute);
                if($UnitOfMeasureId == '')
                    $UnitOfMeasureId = 0;   
                if($j > 0)
                    $TheseAttributes.='_';
                $TheseAttributes.=$Attribute;
                $html .= '<div style="float:left;margin:0 20px 0 20px"">'.$Attribute.'<br/><input value="'.$Val.'" style="width:80px" type="number" id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_'.$Attribute.'_new" name="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_'.$Attribute.'_'.$UnitOfMeasureId.'_'.$Detail->OrderBy.'" placeholder="'.$UOM.'"/></div>';
                $j++;
            }
            $Attributes = array();   
            $html .= '<input type="hidden" id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_TimeToComplete_0_'.$Detail->OrderBy.'" name="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_TimeToComplete_0_'.$Detail->OrderBy.'" value=""/>';
            $html .= '<div class="clear"></div><div style="width:100%;height:25px"><div style="float:left;margin:10px 0 10px 20px"><input class="buttongroup" type="button" id="" data-mini="true" name="timebtn" onClick="EnterActivityTime(\\\''.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_TimeToComplete_0_'.$Detail->OrderBy.'\\\');" value="Add Time"/></div>';
            $html .= '<div style="float:right;margin:10px 20px 10px 0"><input class="buttongroup" type="button" id="" name="btn" data-mini="true" onClick="SaveTheseResults(\\\''.$WorkoutId.'_'.$WorkoutTypeId.'\\\', \\\''.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$Detail->ExerciseId.'\\\');" value="Add Results"/></div>';
            $html .= '</div></form></div><div class="clear"></div></div>';                                
                                         
                            }
                            //if($i > 0)
                            //    $html.= '<br/><br/>';                            
                            $html.= '<h3>Round '.$Detail->RoundNo.'</h3>';
                            $html.= '<div data-role="collapsible">';
                            $html.= '<h2>'.$Detail->Exercise.'<br/>';             
			}
			else if($ThisExerciseId != $Detail->ExerciseId || $OrderBy != $Detail->OrderBy){
                            if($Detail->ExerciseId != null && $i > 0){
                                $html.='</h2><div id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$Detail->ExerciseId.'_History">'.$this->UpdateHistory($Detail->ExerciseId).'</div>';
            $j=0;
            $html .= '<div class="ActivityAttributes"><form id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$Detail->ExerciseId.'" name="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$Detail->ExerciseId.'">';
            //var_dump($Attributes);
            foreach($Attributes as $Attribute=>$Val){
                $UOM = $Model->getUserUnitOfMeasure($Attribute);
                $UnitOfMeasureId = $Model->getUnitOfMeasureId($Attribute);
                if($UnitOfMeasureId == '')
                    $UnitOfMeasureId = 0;   
                if($j > 0)
                    $TheseAttributes.='_';
                $TheseAttributes.=$Attribute;
                $html .= '<div style="float:left;margin:0 20px 0 20px"">'.$Attribute.'<br/><input value="'.$Val.'" style="width:80px" type="number" id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_'.$Attribute.'_new" name="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_'.$Attribute.'_'.$UnitOfMeasureId.'_'.$Detail->OrderBy.'" placeholder="'.$UOM.'"/></div>';
                $j++;
            }
            $Attributes = array();
            $html .= '<input type="hidden" id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_TimeToComplete_0_'.$Detail->OrderBy.'" name="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_TimeToComplete_0_'.$Detail->OrderBy.'" value=""/>';
            $html .= '<div class="clear"></div><div style="width:100%;height:25px"><div style="float:left;margin:10px 0 10px 20px"><input class="buttongroup" data-mini="true" type="button" id="" name="timebtn" onClick="EnterActivityTime(\\\''.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_TimeToComplete_0_'.$Detail->OrderBy.'\\\');" value="Add Time"/></div>';
            $html .= '<div style="float:right;margin:10px 20px 10px 0"><input class="buttongroup" data-mini="true" type="button" id="" name="btn" onClick="SaveTheseResults(\\\''.$WorkoutId.'_'.$WorkoutTypeId.'\\\', \\\''.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$Detail->ExerciseId.'\\\');" value="Add Results"/></div>';
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
                                $html.='</h2><div id="'.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$ThisExerciseId.'_History">'.$this->UpdateHistory($ThisExerciseId).'</div>';
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
            $html .= '<div class="clear"></div><div style="width:100%"><div style="float:left;margin:10px 0 10px 20px"><input class="buttongroup" data-mini="true" type="button" id="" name="timebtn" onClick="EnterActivityTime(\\\''.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$Detail->OrderBy.'\\\');" value="Add Time"/></div>';
            $html .= '<div style="float:right;margin:10px 20px 10px 0"><input class="buttongroup" type="button" id="" name="btn" data-mini="true" onClick="SaveTheseResults(\\\''.$WorkoutId.'_'.$WorkoutTypeId.'\\\', \\\''.$Detail->RoutineNo.'_'.$Detail->RoundNo.'_'.$Detail->OrderBy.'_'.$ThisExerciseId.'\\\');" value="Add Results"/></div>';
            $html .= '</div></form></div><div class="clear"></div></div>';                                

                            }   
           $html.='<div style="float:left;width:65%" id="'.$ThisRoutine.'_timerContainer"></div>';                       
            $html.='<div style="width:30%;float:right;margin:10px 4px 0 0"><input data-mini="true" class="buttongroup" id="'.$ThisRoutine.'_ShowHideClock" type="button" onClick="DisplayStopwatch(\\\'mygym\\\', \\\''.$WorkoutTypeId.'_'.$WorkoutId.'_'.$ThisRoutine.'\\\');" value="Timer"/></div><div class="clear"></div>';                                                                    
     $html.='</div><br/><br/>';	
    $html.='<div class="clear"></div><br/>';

            }

            return $html;
	} 
        
     function UpdateHistory($ExerciseId){
        $Model = new MygymModel;
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
        
        function MyGymWOD()
        {
            $Html='';
            $Model = new MygymModel;
            $DataObject = $Model->getGymWodWorkouts();
            if(count($DataObject) == 0){
                $Html='No data from your gym today';
            }else{
            foreach($DataObject as $Item){
                $Html.='<a href="#" onClick="getDetails(\''.$Item->WodId.'\',\''.$Item->WodType.'\')">Workout for '.date('d F Y',strtotime($Item->WodDate)).'</a><br/><br/>';
            }
            }
            return $Html;
        }
        
         function getMyGymFeed()
        {
            $Html='';
            $Model = new MygymModel;
            $DataObject = $Model->getMyGymFeed();
            foreach($DataObject as $Data){
                $Html .= '';
            }
            return $Html;
        }       
    
    function getWeight($exerciseId)
    {
		$RENDER = new Image();
		$Save = $RENDER->NewImage('save.png', SCREENWIDTH);
        $Html='<form name="form" action="index.php">
        <input type="hidden" name="module" value="wod"/>
		<input type="hidden" name="action" value="save"/>
        <input type="hidden" name="wodtype" value="'.$_REQUEST['wodtype'].'"/>
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
        <input type="hidden" name="module" value="wod"/>
		<input type="hidden" name="action" value="save"/>
        <input type="hidden" name="wodtype" value="'.$_REQUEST['wodtype'].'"/>
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
}
?>