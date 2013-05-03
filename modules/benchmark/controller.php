<?php
class BenchmarkController extends Controller
{
        var $Origin;
	var $Workout;
	var $BMWS;
	var $Categories;
	var $Category;
        var $Height;
        var $Video;
        var $Benchmark;
	
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
		$Model = new BenchmarkModel;
		if(isset($_REQUEST['benchmarkId']) && $_REQUEST['benchmarkId'] > 0){
                    $this->Workout = $Model->getBenchmarkDetails($_REQUEST['benchmarkId']);
                    $this->Video = $this->Workout[0]->VideoId;
                    $this->Benchmark = $this->Workout[0];
                }
	}
        
        function Video()
        {
            $Html = '';
            if($this->Video != '')
                $Html = '<iframe marginwidth="0px" marginheight="0px" width="'.SCREENWIDTH.'" height="'.$this->Height.'" src="http://www.youtube.com/embed/'.$this->Video.'" frameborder="0"></iframe> ';
          
            return $Html;
        }
        
        function Message()
        {
            $Model = new BenchmarkModel;
            if($_REQUEST['baseline'] == 'yes')
                $Message = $Model->MakeBaseline($_REQUEST['WorkoutId'], $_REQUEST['WodTypeId']);
            else if($_REQUEST['baseline'] == 'no')
                $Message = $Model->ClearBaseline();            
            else if(isset($_REQUEST['RoutineTime'])){
            //Save Routine Time  
                $Message = $Model->SaveRoutineTime($_REQUEST['TimeFieldName']);
            }else
                $Message = $Model->Log();

            return $Message;
        }       
        
	function Output()
	{
            $html = '';
            
            $Model = new BenchmarkModel;

if(isset($_REQUEST['benchmarkId']) && $_REQUEST['benchmarkId'] > 0)
{
        $WorkoutTypeId = $this->Workout[0]->WodTypeId;
        $WorkoutId = $this->Workout[0]->Id;
    /*
	$html.='<form name="form" id="benchmarkform" action="index.php">
            <input type="hidden" id="origin" name="origin" value="'.$this->Origin.'"/>
            <input type="hidden" id="benchmarkId" name="benchmarkId" value="'.$_REQUEST['benchmarkId'].'"/>
            <input type="hidden" id="addround" name="RoundNo" value="1"/>'; 
     */  
    
        $html='<input type="checkbox" id="baseline" name="baseline" onClick="MakeBaseline(\''.$WorkoutId.'_'.$WorkoutTypeId.'\');" data-role="none"/>';
        $html.='Make this my baseline';
        $html.='<p>'.$this->Workout[0]->Notes.'</p>';
        //$html.='<div class="ui-grid-b">';
        $html .= '<div data-role="collapsible-set" data-iconpos="right">';
        $ThisRoutineNo = '';
        $ThisRoundNo = '';
        $ThisOrderBy = '';
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
                $html .= '<div style="float:left;margin:0 20px 0 20px"">'.$Attribute.'<br/><input value="'.$Val.'" style="width:50px" class="textinput" type="number" id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_new" name="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_'.$UnitOfMeasureId.'_'.$ThisOrderBy.'" placeholder="'.$UOM.'"/></div>';
                $j++;
            }
            $Attributes = array();
            $html.='<input type="hidden" id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'" name="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'" value=""/>';
            $html.='<div class="clear"></div><div style="width:100%;height:25px"><div style="float:left;margin:10px 0 10px 20px"><input type="button" id="" name="timebtn" onClick="EnterActivityTime(\'benchmark\', \''.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'\');" value="Add Time"/></div>';
            $html.='<div style="float:right;margin:10px 20px 10px 0"><input type="button" id="" name="btn" onClick="SaveTheseResults(\''.$WorkoutId.'_'.$WorkoutTypeId.'\', \''.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisOrderBy.'_'.$ThisExerciseId.'\');" value="Add Results"/></div>';
            $html.='</div></form></div></div>'; 
            $html.='<div style="float:left;width:65%" id="'.$ThisRoutineNo.'_timerContainer"></div>';                       
            $html.='<div style="width:30%;float:right;margin:10px 4px 0 0"><input class="buttongroup" id="'.$ThisRoutineNo.'_ShowHideClock" type="button" onClick="DisplayStopwatch(\'benchmark\', \''.$WorkoutTypeId.'_'.$WorkoutId.'_'.$ThisRoutineNo.'\');" value="Timer"/></div><div class="clear"></div>';                                                                    
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
                $html .= '<div style="float:left;margin:0 20px 0 20px"">'.$Attribute.'<br/><input value="'.$Val.'" style="width:50px" class="textinput" type="number" id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_new" name="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_'.$UnitOfMeasureId.'_'.$ThisOrderBy.'" placeholder="'.$UOM.'"/></div>';
                $j++;
            }
            $Attributes = array();   
            $html .= '<input type="hidden" id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'" name="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'" value=""/>';
            $html .= '<div class="clear"></div><div style="width:100%;height:25px"><div style="float:left;margin:10px 0 10px 20px"><input class="buttongroup" data-mini="true" type="button" id="" name="timebtn" onClick="EnterActivityTime(\'benchmark\', \''.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'\');" value="Add Time"/></div>';
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
                $html .= '<div style="float:left;margin:0 20px 0 20px"">'.$Attribute.'<br/><input value="'.$Val.'" style="width:50px" class="textinput" type="number" id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_new" name="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_'.$UnitOfMeasureId.'_'.$ThisOrderBy.'" placeholder="'.$UOM.'"/></div>';
                $j++;
            }
            $Attributes = array();
            $html .= '<input type="hidden" id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'" name="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'" value=""/>';
            $html .= '<div class="clear"></div><div style="width:100%;height:25px"><div style="float:left;margin:10px 0 10px 20px"><input data-mini="true" class="buttongroup" type="button" id="" name="timebtn" onClick="EnterActivityTime(\'benchmark\', \''.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'\');" value="Add Time"/></div>';
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
                $html .= ' style="width:50px" class="textinput" type="number" id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_new" name="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_'.$Attribute.'_'.$UnitOfMeasureId.'_'.$ThisOrderBy.'"/></div>';
                $j++;
            }
            $Attributes = array();
            $html .= '<input type="hidden" id="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'" name="'.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'" value=""/>';
            $html .= '<div class="clear"></div><div style="width:100%"><div style="float:left;margin:10px 0 10px 20px"><input data-mini="true" class="buttongroup" type="button" id="" name="timebtn" onClick="EnterActivityTime(\'benchmark\', \''.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisExerciseId.'_TimeToComplete_0_'.$ThisOrderBy.'\');" value="Add Time"/></div>';
            $html .= '<div style="float:right;margin:10px 20px 10px 0"><input type="button" id="" class="buttongroup" data-mini="true" name="btn" onClick="SaveTheseResults(\''.$WorkoutId.'_'.$WorkoutTypeId.'\', \''.$ThisRoutineNo.'_'.$ThisRoundNo.'_'.$ThisOrderBy.'_'.$ThisExerciseId.'\');" value="Add Results"/></div>';
            $html .= '</div></form></div><div class="clear"></div></div>';                                

                            }   
           $html.='<div style="float:left;width:65%" id="'.$ThisRoutineNo.'_timerContainer"></div>';                       
            $html.='<div style="width:30%;float:right;margin:10px 4px 0 0"><input data-mini="true" class="buttongroup" id="'.$ThisRoutineNo.'_ShowHideClock" type="button" onClick="DisplayStopwatch(\'benchmark\', \''.$WorkoutTypeId.'_'.$WorkoutId.'_'.$ThisRoutineNo.'\');" value="Timer"/></div><div class="clear"></div>';                                                                    
     $html.='</div>';
    $html.='<br/><br/>';

}else if($_REQUEST['history'] == 'refresh'){
    $html = $this->UpdateHistory($_REQUEST['ExerciseId']);
            }
else if(isset($_REQUEST['cat']) && $_REQUEST['cat'] != '')
{
    /*
    Categories:
    Girls
    Heros
    Various 
    Travel
    Running
    */
    $Workouts = $Model->getBMWS($_REQUEST['cat']);
    $Overthrow='';
    $Device = new DeviceManager();
    if($Device->IsGoogleAndroidDevice()) {
        $Overthrow='class="overthrow"';
}
    
     $html.='<div '.$Overthrow.'>
            <h2>'.$_REQUEST['cat'].'</h2>
            '.$this->getWorkoutList($Workouts).'
            </div>';

}else{
    //OpenThisPage(\'?module=benchmark&cat=Girls\')
    $html.='<div style="padding:2%">';
    $html.='<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">';
    $html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getBenchmarks(\'Girls\');"><div style="height:26px;width:1px;float:left"></div>Girls<br/><span style="font-size:small"></span></a></li>';             
    $html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getBenchmarks(\'Heros\');"><div style="height:26px;width:1px;float:left"></div>Heros<br/><span style="font-size:small"></span></a></li>';
    //$html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getBenchmarks(\'Running\');"><div style="height:26px;width:1px;float:left"></div>Running<br/><span style="font-size:small"></span></a></li>';          
    //$html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getBenchmarks(\'Various\');"><div style="height:26px;width:1px;float:left"></div>Various<br/><span style="font-size:small"></span></a></li>';
    $html.='</ul>';
    $html.='</div>';  
}
$html.='<div class="clear"></div><br/>';
return $html;
	}
        
    function UpdateHistory($ExerciseId){
        $Model = new BenchmarkModel;
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
        
        function getWorkoutList($Category)
        {
            $Model = new BenchmarkModel;
            $html = '<ul class="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">';
            foreach($Category AS $Workout){
                $Description = $Model->getBenchmarkDescription($Workout->Id);
                $html .= '<li>';
                $html .= '<a href="" onclick="getDetails('.$Workout->Id.', \''.$Workout->Category.'\');">'.$Workout->WorkoutName.':<br/><span style="font-size:small">'.$Description.'</span></a>';
                $html .= '</li>';
            }	
            $html .= '</ul><div class="clear"></div><br/>';
            return $html;
        }
        
        function getCustomMemberWorkouts()
        {
            $html = '';
            $Model = new BenchmarkModel;
            $CustomMemberWorkouts = $Model->getCustomMemberWorkouts();
            if(empty($CustomMemberWorkouts)){
                $html .= '<br/>Oops! You have not recorded any Custom Workouts yet.';
            }else{
            $html .= '<ul class="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d" data-icon="none">';
            foreach($CustomMemberWorkouts AS $Workout){
                $Description = $Model->getCustomDescription($Workout->recid);
                $html .= '<li>';
                $html .= '<a href="" onclick="getCustomDetails(\''.$Workout->recid.'\', \''.$this->Origin.'\');">'.$Workout->WorkoutName.':<br/><span style="font-size:small">'.$Description.'</span></a>';
                $html .= '</li>';
            }	
            $html .= '</ul><br/>';
            }
            return $html;
        }
        
        function getCustomPublicWorkouts()
        {
            $html = '';
            $Model = new BenchmarkModel;
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
		$Model = new BenchmarkModel;
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
            $Model = new BenchmarkModel;
            $Description = $Model->getBenchmarkDescription($this->Benchmark->Id);
            $Html = 'WOD: '.$this->Benchmark->WorkoutName.'<br/>';
            $Html .= '<span style="font-size:small">'.$Description.'</span>';
            return $Html;	
	}	
}
?>