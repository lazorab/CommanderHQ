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
	}
	else if(isset($_REQUEST['PerformanceId'])){
            $html .= $this->PerformanceHistory();
        }else if(isset($_REQUEST['WodId'])){
            $html .= $this->WODChart($_REQUEST['WodId'], $_REQUEST['WodTypeId']);
        }else if(isset($_REQUEST['BenchmarkId'])){
            $html .= $this->BenchmarkChart($_REQUEST['BenchmarkId']);
        }else if(isset($_REQUEST['BaselineId'])){
            $html .= $this->BaselineChart($_REQUEST['BaselineId']); 
        }else if(isset($_REQUEST['ExerciseId'])){
            $html .= $this->ExerciseChart($_REQUEST['ExerciseId']);           
        }else{   
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
    
    function getCompletedWods()
    {
        $Model=new ReportsModel();
        $WODs = $Model->getCompletedWods();
        $Html = '';
        if(count($WODs) > 0){
            $Html.='<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">';               
        foreach($WODs AS $Wod){
            $Html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getWOD();"><div style="height:26px;width:1px;float:left"></div>'.$Wod->WorkoutType.'<br/><span class="ui-li-count">'.$Wod->NumberCompleted.'</span></a></li>';          
        }
        $Html .= '</ul>';
        }
        
        return $Html;
    }
    
    function getCompletedActivities()
    {
        $Model=new ReportsModel();
        $Activities = $Model->getCompletedActivities();
        $Html = '';
        return $Html;
    }
    
    function getTimesSpent()
    {
        $Model=new ReportsModel();
        $TimesSpent = $Model->getTimesSpent(); 
        $Html = '';
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
        $TotalTime = ''.$this->number_pad($NewTotalMinutes,2).':'.$this->number_pad($NewTotalSeconds - floor($TotalSeconds / 60),2).':'.$this->number_pad($TotalSplitSeconds - floor($TotalSplitSeconds / 10),2).'';
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
        $Data = $Model->getExerciseHistory($Id);
           
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