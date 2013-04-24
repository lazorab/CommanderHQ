<?php
class ReportsController extends Controller
{
    var $MemberDetails;
	
    function __construct()
    {
	parent::__construct();
	session_start();
	if(!isset($_COOKIE['UID'])){
            header('location: index.php?module=login');	
        }
        else{
            $Model=new ReportsModel();
            $this->MemberDetails=$Model->getDetails();
        }
    }
    
    function DummyData()
    {
        $XML = "<chart showLabels='0' canvasPadding='10' showYAxisValues='0' animation='0' lineColor='00008B' xAxisNamePadding='0' yAxisNamePadding='0' caption='Dummy Graph' xAxisName='Time' yAxisName='Output' showToolTip='0' showValues= '1'>";
        $XML .= "<categories>";
        $XML .= "<category label='07 Jan' />";
        $XML .= "<category label='15 Feb' />";
        $XML .= "<category label='03 Mar' />";
        $XML .= "<category label='18 Apr' />";
        $XML .= "<category label='20 May' />";
        $XML .= "<category label='06 Jun' />";
    $XML .= "</categories>";
    $XML .= "<dataset seriesName='Weight(kg)' color='A66EDD'>";
        $XML .= "<set value='2' />";
        $XML .= "<set value='4' />";
        $XML .= "<set value='6' />";
        $XML .= "<set value='5' />";
        $XML .= "<set value='6' />";
        $XML .= "<set value='5' />";
    $XML .= "</dataset>";
    $XML .= "<dataset seriesName='Reps' color='F6BD0F'>";
        $XML .= "<set value='20' />";
        $XML .= "<set value='25' />";
        $XML .= "<set value='22' />";
        $XML .= "<set value='26' />";
        $XML .= "<set value='30' />";
        $XML .= "<set value='36' />";
    $XML .= "</dataset>";

$XML .= "</chart>";
        
        return $XML;
    }
	
    function WODOutput()
    {
        return $this->WODHistory();
    }
	
    function BaselineOutput()
    {
        return $this->BaselineHistory();
    }
	
    function SkillsOutput()
    {
        return $this->MemberDetails->SkillLevel;
    }
    
    function Output()
    {        
        $html='';
	if(isset($_REQUEST['report']))
	{
            if($_REQUEST['report'] == 'wods')
            {
                $html .= $this->getCompletedWODs();	
            }
            else if($_REQUEST['report'] == 'activities')
            {
                $html .= $this->getCompletedActivities();	
            }
            else if($_REQUEST['report'] == 'time')
            {
                $html .= $this->getTimesSpent();	
            }
            else if($_REQUEST['report'] == 'weight')
            {
                $html .= $this->getWeightsLifted();	
            }            
            else if($_REQUEST['report'] == 'distance')
            {
                $html .= $this->getDistancesCovered();	
            }
            else if($_REQUEST['report'] == 'WOD')
            {
                $html .= $this->getWODHistory($_REQUEST['typeid'], $_REQUEST['id']);	
            }            
            else if($_REQUEST['report'] == 'Activity')
            {
                $html .= $this->getActivityHistory($_REQUEST['id']);	
            }
        }
        else if(isset($_REQUEST['ExerciseId']))
        {
            $html .= $this->ExerciseChart($_REQUEST['ExerciseId']);
        }
        else if(isset($_REQUEST['Graph']))
        {
            $html .= $this->Graph($_REQUEST['Graph']);
        }
        else if(isset($_REQUEST['WodTypeId']))
        {
            $html .= $this->getWodDetail($_REQUEST['WodTypeId'], $_REQUEST['WodId']);
        }
        else{    
            $Model=new ReportsModel();
            $CompletedWodCount = $Model->getCompletedWodCount();
            $CompletedActivityCount = $Model->getCompletedActivityCount();
            $TimeSpent = $this->getTimeSpent();
            $WeightLifted = $this->getWeightLifted();
            $DistanceCovered = $this->getDistanceCovered();
            $CaloriesConsumed = $Model->getCaloriesConsumed();
            $Strength = $Model->getStrength();
            $html.='<div style="padding:2%">';
            $html.='<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">';       
            $html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getCompletedWODs();"><div style="height:26px;width:1px;float:left"></div>WODs Completed<br/><span class="ui-li-count">'.$CompletedWodCount.'</span></a></li>';          
            $html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getCompletedActivities();"><div style="height:26px;width:1px;float:left"></div>Activities Done<br/><span class="ui-li-count">'.$CompletedActivityCount.'</span></a></li>';
            $html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getTimeSpent();"><div style="height:26px;width:1px;float:left"></div>Time Spent<br/><span class="ui-li-count">'.$TimeSpent.'</span></a></li>';
            $html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getWeightLifted();"><div style="height:26px;width:1px;float:left"></div>Weight Lifted<br/><span class="ui-li-count">'.$WeightLifted.'</span></a></li>';         
            $html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getDistanceCovered();"><div style="height:26px;width:1px;float:left"></div>Distance Covered<br/><span class="ui-li-count">'.$DistanceCovered.'</span></a></li>';         
            //$html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getCaloriesConsumed();"><div style="height:26px;width:1px;float:left"></div>Calories Consumed<br/><span class="ui-li-count"></span></a></li>';         
            //$html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getStrength();"><div style="height:26px;width:1px;float:left"></div>Strength<br/><span class="ui-li-count"></span></a></li>';         
            $html.='</ul></div>';  
            $html.='<div class="clear"></div><br/>';                
            }
            return $html;
    }
    
    function getWodDetail($TypeId, $Id)
    {
        $Model=new ReportsModel();
        $WorkoutType = $Model->getWorkoutType($TypeId);
        if($WorkoutType == "Custom"){
            $Details = $Model->getCustomDetails($Id);
        }else if($WorkoutType == "Baseline"){
            $NewModel = new BaselineModel();
            $Details = $NewModel->getBaselineDetails();
        }else if($WorkoutType == "Benchmark"){
            $Details = $Model->getBenchmarkDetails($Id);
        }else{
            $Details = $Model->getMyGymDetails($Id);
        }
        $html .= '<div data-role="collapsible-set" data-iconpos="right">';
        $ThisRoutine = '';
        $ThisRound = '';
        $OrderBy = '';
        $Attributes = array();   
	$ThisExerciseId = 0;
        $i=0;
        $j=0;
        //var_dump($this->Workout);
	foreach($Details as $Detail){
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
                                $html.='</h2>';
                                                                    
                            } 
                            $html.= '<h3>Routine '.$Detail->RoutineNo.'</h3>';
                            $html.= '<h3>Round '.$Detail->RoundNo.'</h3>';
                            $html.= '<div data-role="collapsible">';
                            $html.= '<h2>'.$Detail->Exercise.'<br/>';             
			}                    
			else if($Detail->TotalRounds > 1 && $Detail->RoundNo > 0 && $ThisRound != $Detail->RoundNo){
                            if($Detail->ExerciseId != null && $i > 0){
                                $html.='</h2>';
                                
                                         
                            }
                            //if($i > 0)
                            //    $html.= '<br/><br/>';                            
                            $html.= '<h3>Round '.$Detail->RoundNo.'</h3>';
                            $html.= '<div data-role="collapsible">';
                            $html.= '<h2>'.$Detail->Exercise.'<br/>';             
			}
			else if($ThisExerciseId != $Detail->ExerciseId || $OrderBy != $Detail->OrderBy){
                            if($Detail->ExerciseId != null && $i > 0){
                                $html.='</h2>';
                              
                                
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
                                

                              

        return $html;
    }
    
    function getWODHistory($TypeId)
    {
        $Model=new ReportsModel();
        $WODs = $Model->getWODHistory($TypeId);
        $Html = '<div id="WodDetail"></div><ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">'; 
        foreach($WODs AS $Wod){
            $Html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getWodDetail(\''.$Wod->WorkoutTypeId.'\', \''.$Wod->WorkoutId.'\')"><div style="height:26px;width:1px;float:left"></div>'.$Wod->WorkoutName.'<br/><span style="font-size:small">'.$Wod->TimeCreated.'</span></a></li>';          
        }
        $Html.='</ul>';
        return $Html;
    }
    
    function getActivityHistory($Id)
    {
        $Model=new ReportsModel();
        $Activities = $Model->getActivityHistory($Id);
        $Html = '<div id="graph"></div><ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">'; 
        foreach($Activities AS $Activity){
            $Html.='<li><a style="font-size:large;margin-top:10px" href="#"><div style="height:26px;width:1px;float:left"></div>'.$Activity->TimeCreated.'<br/></a></li>';          
        }
        $Html.='</ul>';
        return $Html;       
    }
    
    function getCompletedWods()
    {
        $Model=new ReportsModel();
        $WODs = $Model->getCompletedWods();
        $Html = '';
        if(count($WODs) > 0){
            $Html.='<div id="graph"></div><ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">';               
        foreach($WODs AS $Wod){
            $Html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getWOD(\''.$Wod->WodTypeId.'\', \''.$Wod->WodId.'\');"><div style="height:26px;width:1px;float:left"></div>'.$Wod->WorkoutType.'<br/><span class="ui-li-count">'.$Wod->NumberCompleted.'</span></a></li>';          
        }
            $Html .= '</ul>';
        }else{
            $Html = 'No complted WODs yet';
        }
        
        return $Html;
    }
    
    function getCompletedActivities()
    {
        $Model=new ReportsModel();
        $Activities = $Model->getCompletedActivities();
        $Html = '';
        if(count($Activities) > 0){
            $Html.='<div id="graph"></div><ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">';               
        foreach($Activities AS $Activity){
            $Html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getActivity(\''.$Activity->ExerciseId.'\', \'activities\');"><div style="height:26px;width:1px;float:left"></div>'.$Activity->Exercise.'<br/><span class="ui-li-count">'.$Activity->NumberCompleted.'</span></a></li>';          
        }
        $Html .= '</ul>';
        }else{
            $Html = 'No logged activities yet';
        }
        
        return $Html;
    }
    
    function getTimesSpent()
    {
        $Model=new ReportsModel();
        /*
        $TotalTimeSpent = $this->getTimeSpent();
        $Time = explode(':',$TotalTimeSpent);
        $Hours=$Time[0];
        $Minutes = $Time[1];
        $Seconds = $Time[2];
        $SplitSeconds = $Time[3]; 
        $TotalSeconds =($Hours*60*60) + ($Minutes*60) + $Seconds;
         */
        $TimesSpent = $Model->getTimesSpent(); 
        $Html = '';
        if(count($TimesSpent) > 0){   
            $Html .= '<chart showvalues="1" caption="Time Spent" showlegend="1" enablesmartlabels="0" showlabels="0" showpercentvalues="1" animation="0">'; 
            foreach($TimesSpent AS $Time){
                $LoggedTime = explode(':',$Time->LoggedTime);
                //$Hours=$Time[0];
                $Minutes = $LoggedTime[0];
                $Seconds = $LoggedTime[1];
                $SplitSeconds = $LoggedTime[2];
                $ActivitySeconds = ($Minutes*60) + $Seconds + ($SplitSeconds/10);
            
                $Html.='<set value="'.$ActivitySeconds.'" label="'.$Time->Exercise.'"/>';
            }
            $Html.='</chart>';
        }else{
            $Html = 'No logged times yet';
        }       
        return $Html;        
    }
    
    function getTimeSpent()
    {
        $Model=new ReportsModel();
        $TimesSpent = $Model->getTimesSpent();
        $TotalTime = '';
        $Minutes = 0;
        $Seconds = 0;
        $SplitSeconds = 0;
        $TotalMinutes = 0;
        $TotalHours = 0;
        $TotalSeconds = 0;
        $TotalSplitSeconds = 0;
        foreach($TimesSpent AS $Time){
            $Time = explode(':',$Time->LoggedTime);
            //$Hours=$Time[0];
            $Minutes = $Time[0];
            $Seconds = $Time[1];
            $SplitSeconds = $Time[2];
            
            $TotalMinutes = $TotalMinutes + $Minutes;  
            $TotalSeconds = $TotalSeconds + $Seconds;  
            $TotalSplitSeconds = $TotalSplitSeconds + $SplitSeconds;           
        }
        $NewTotalSeconds = $TotalSeconds + floor($TotalSplitSeconds / 10);
        $NewTotalMinutes = $TotalMinutes + floor($NewTotalSeconds / 60);
        $TotalHours = $TotalHours + floor($NewTotalMinutes / 60);
        $TotalTime = ''.$this->number_pad($TotalHours,2).':'.$this->number_pad($NewTotalMinutes - floor($TotalMinutes / 60),2).':'.$this->number_pad($NewTotalSeconds - floor($TotalSeconds / 60),2).'';
        return $TotalTime;
    }
    
    private function number_pad($number,$n) {
        return str_pad((int) $number,$n,"0",STR_PAD_LEFT);
    }
    
    function getWeightsLifted()
    {
        $Model=new ReportsModel();
        $WeightsLifted = $Model->getWeightsLifted(); 
        $Html = '';
        if(count($WeightsLifted) > 0){
            $Html.='<div id="graph"></div><ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">';               
        foreach($WeightsLifted AS $Weight){
            $Html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getActivity(\''.$Weight->ExerciseId.'\', \'weights\');"><div style="height:26px;width:1px;float:left"></div>'.$Weight->Exercise.'<br/><span class="ui-li-count">'.$Weight->NumberCompleted.'</span></a></li>';          
        }
        $Html .= '</ul>';
        }else{
            $Html = 'No logged weights yet';
        }
        
        return $Html;        
    }
    
    function getWeightLifted()
    {
        $Model=new ReportsModel();
        $WeightsLifted = $Model->getWeightsLifted();
        $TotalWeight = 0;
        $TotalMetricWeight = 0;
        $TotalImperialWeight = 0;
        foreach($WeightsLifted AS $Weight){
            if($Weight->UnitOfMeasure == 'kg'){
                $TotalMetricWeight = $TotalMetricWeight + $Weight->LoggedWeight;
            }else if($Weight->UnitOfMeasure == 'lbs'){
                $TotalImperialWeight = $TotalImperialWeight + $Weight->LoggedWeight;
            }           
        }
        if($this->SystemOfMeasure() == 'Metric'){
            $TotalWeight = $TotalMetricWeight + ($TotalImperialWeight * 0.45).'kg';
        }else{
            $TotalWeight = $TotalImperialWeight + ($TotalMetricWeight * 2.20).'lbs';
        }
        return $TotalWeight;
    }
    
    function getDistancesCovered()
    {
        $Model=new ReportsModel();
        $DistancesCovered = $Model->getDistancesCovered();  
        $Html = '';
        if(count($DistancesCovered) > 0){
            $Html.='<div id="graph"></div><ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">';               
        foreach($DistancesCovered AS $Distance){
            $Html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getActivity(\''.$Distance->ExerciseId.'\', \'distances\');"><div style="height:26px;width:1px;float:left"></div>'.$Distance->Exercise.'<br/><span class="ui-li-count">'.$Distance->NumberCompleted.'</span></a></li>';          
        }
        $Html .= '</ul>';
        }else{
            $Html = 'No logged distances yet';
        }
                
        return $Html;        
    }
    
    function getDistanceCovered()
    {
        $Model=new ReportsModel();
        $DistancesCovered = $Model->getDistancesCovered();
        $TotalDistance = 0;
        $TotalDistanceM = 0;
        $TotalDistanceKm = 0;
        $TotalDistanceMi = 0;
        $TotalDistanceYd = 0;
        foreach($DistancesCovered AS $Distance){
            if($Distance->UnitOfMeasure == 'm'){
                $TotalDistanceM = $TotalDistanceM + $Distance->LoggedDistance;
            }else if($Distance->UnitOfMeasure == 'km'){
                $TotalDistanceKm = $TotalDistanceKm + $Distance->LoggedDistance;
            }else if($Distance->UnitOfMeasure == 'mi'){
                $TotalDistanceMi = $TotalDistanceMi + $Distance->LoggedDistance;
            }else if($Distance->UnitOfMeasure == 'yd'){
                $TotalDistanceYd = $TotalDistanceYd + $Distance->LoggedDistance;
            }
        }
        if($this->SystemOfMeasure() == 'Metric'){
            $TotalDistance = $TotalDistanceKm + floor($TotalDistanceM / 1000).'km';
        }else{
            $TotalDistance = $TotalDistanceMi + floor($TotalDistanceYd / 1760).'mi';
        }        
        return $TotalDistance;
    }
    
    function Details()
    {
        $Model=new ReportsModel();
        $Details=$Model->getDetails();
	return $Details;
    }
    
    function getCompletedExercises()
    {
        $Model=new ReportsModel();
	$ExerciseItems = $Model->getCompletedExercises();
	$Html .= '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">';
	
        foreach($ExerciseItems AS $Exercise){
            if($Exercise->ExerciseId > 0)
            $Html .= '<li><a style="font-size:large;margin-top:5px" href="#" onclick="getExerciseReport(\''.$Exercise->ExerciseId.'\');">'.$Exercise->Exercise.'</a></li>';
        }	
				
	$Html .= '</ul>';
        $Html.='<div class="clear"></div><br/>';  
	return $Html;	
    }    
    
    function getBenchmarks()
    {
        $Model=new ReportsModel();
	$ExerciseItems = $Model->getBenchmarks();
	$Html .= '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">';
	
        foreach($ExerciseItems AS $Exercise){
            if($Exercise->ExerciseId > 0)
            $Html .= '<li><a style="font-size:large;margin-top:5px" href="#" onclick="getBenchmarkReport(\''.$Exercise->ExerciseId.'\');">'.$Exercise->WorkoutName.'</a></li>';
        }	
	$Html.='<div class="clear"></div><br/>';  			
	$Html .= '</ul>';

	return $Html;	
    }   
    
    function getWODs()
    {
        $Model=new ReportsModel();
	$WODs = $Model->getWODs();
	$Html .= '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">';
	
        foreach($WODs AS $WOD){
            if($WOD->WodId > 0)
            $Html .= '<li><a style="font-size:large;margin-top:5px" href="#" onclick="getWODReport(\''.$WOD->WodId.'\', \''.$WOD->WodTypeId.'\');">'.$WOD->WorkoutName.'</a></li>';
        }	
	$Html.='<div class="clear"></div><br/>';  			
	$Html .= '</ul>';

	return $Html;	
    }    
    
    function getBaseline()
    {
        $Model=new ReportsModel();
	$ExerciseItems = $Model->getBaselineExercises();
	$Html .= '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">';
	
        foreach($ExerciseItems AS $Exercise){
            $Html .= '<li><a href="" onclick="getBaselineReport(\''.$Exercise->ExerciseId.'\');">'.$Exercise->Exercise.'</a></li>';
        }	
				
	$Html .= '</ul>';

	return $Html;	
    }    
        
    private function getChartData($ThisData)
    {
        $NumLogs=0;
        foreach($ThisData as $Data)
        {
            if($Data->Attribute == 'TimeToComplete'){
                $ExplodedTime = explode(':', $Data->AttributeValue);
                $Seconds = ($ExplodedTime[0] * 60) + $ExplodedTime[1];
                $ChartData .= "<set label='".$Data->TimeCreated."' value='".$Seconds."'/>";
                $TotalSeconds = $TotalSeconds + $Seconds;
                $NumLogs++;
            }   
        }
        $Average = floor($TotalSeconds / $NumLogs);
        $ChartData .= "<trendLines>";
        $ChartData .= "<line startValue='".$Average."' color='009933' lineThickness='3' displayvalue=' '/>";
        $ChartData .= "</trendLines>";
           
        return $ChartData;        
    }
    
    function BaselineChart()
    {
        $Model=new ReportsModel();
        $Data = $Model->getBaselineHistory();

        $ChartData = "<chart showLabels='0' canvasPadding='10' showYAxisValues='0' animation='0' lineColor='00008B' xAxisNamePadding='0' yAxisNamePadding='0' caption='Baseline' xAxisName='Time' yAxisName='Output' showToolTip='0' showValues= '0'>";

        if(count($Data) > 0){
            $ChartData .= $this->getChartData($Data);
        }
        $ChartData .= "</chart>"; 
           
        return $ChartData;
    }  
    
    function BenchmarkChart($Id)
    {
        $Model=new ReportsModel();
        $Data = $Model->getBenchmarkHistory($Id);
           
        return json_encode($Data);
    }    
    
    function WODChart($Id, $Type)
    {
        $Model=new ReportsModel();
        $Data = $Model->getWODHistory($Id, $Type);
           
        return json_encode($Data);
    }    
    
    function ExerciseChart($Id)
    {
        $Model=new ReportsModel();
        $Data = $Model->getActivityHistory($Id);
           
        return json_encode($Data);
    }    
    
    function Graph($type)
    {
        $Model=new ReportsModel();
        if($type == 'Activities')
            $Data = $Model->getCompletedActivities();
        else if($type == 'Wods')
            $Data = $Model->getCompletedWodsByMonth();
           
        return json_encode($Data);
    }
	
	function PerformanceHistory($Id)
	{
        $Model=new ReportsModel();
		$Html.='<div style="height:20px">';
		$Html.='<div style="width:120px;float:left">Date</div><div style="width:80px;float:left">Recorded Time</div><div style="width:100px;float:left">Performance</div></div>';
		$PerformanceData = $Model->getPerformanceHistory($Id);
		$previous = '';
		foreach($PerformanceData AS $Data)
		{
			$Time = explode(':',$Data->Duration);
			$Hours=$Time[0];
			$Minutes=$Time[1];
			$Seconds=$Time[2];
			$TotalSeconds=($Hours*60*60) + ($Minutes*60) + $Seconds;
			if($previous != '' && $TotalSeconds > 0){
				if($previous > $TotalSeconds){
					$direction = 'Up by ';
					$performance = ''.round(((($previous - $TotalSeconds) / $TotalSeconds) * 100),2).'&#37;';
					
				}
				else if($previous < $TotalSeconds){
					$direction = 'Down by ';
					$performance = ''.round(((($TotalSeconds - $previous) / $previous) * 100),2).'&#37;';
				}
			}
			else{
				$direction = '';
				$performance = '--';
			}
			$previous = $TotalSeconds;
			$Html.='<div style="height:20px"><div style="width:120px;float:left">'.$Data->TimeCreated.'</div><div style="width:80px;float:left">'.$Data->Duration.'</div><div style="width:100px;float:left">'.$direction.''.$performance.'</div></div>';
		}
		return $Html;	
	}
	
	function WeightHistory($System)
	{
        $Model=new ReportsModel();
		$Html='';
		$History=$Model->getWeightHistory();
		if($System == 'Metric')
			$Units = 'kg';
		else
			$Units = 'lbs';
		foreach($History AS $Item)
		{
			$Html.=''.$Item->TimeCreated.'	'.$Item->Weight.'	'.$Units.'<br/>';
		}
		return $Html;
	}
	
	function PendingExercises()
	{
        $Model=new ReportsModel();
		$PendingExercises = $Model->getPendingExercises();
		$Html='Pending Skill Exercises:';
		foreach($PendingExercises AS $Exercise) { 
			$Html.='<br/><a href="index.php?module=exercisedetails&id='.$Exercise->Id.'">'.$Exercise->Exercise.'</a>';
		}
		return $Html;
	}
}
?>