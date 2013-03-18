<?php
class ReportsController extends Controller
{
    var $MemberDetails;
	
    function __construct()
    {
	parent::__construct();
	session_start();
	if(!isset($_SESSION['UID'])){
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
            if($_REQUEST['report'] == 'Pending')
            {
                $html .= $this->PendingExercises();
            }
            else if($_REQUEST['report'] == 'Performance')
            {
                $html .= $this->CompletedExercises();	
            }
            else if($_REQUEST['report'] == 'WOD')
            {
                $html .= $this->getWODs();	
            }
            else if($_REQUEST['report'] == 'Benchmarks')
            {
                $html .= $this->getBenchmarks();	
            }
            else if($_REQUEST['report'] == 'Baseline')
            {
                $html .= $this->BaselineHistory();	
            }
            else if($_REQUEST['report'] == 'Exercises')
            {
                $html .= $this->getCompletedExercises();	
            }            
            else if($_REQUEST['report'] == 'Weight')
            {
                $html .= $this->WeightHistory($this->MemberDetails->SystemOfMeasure);	
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
            $html.='<div style="padding:2%">';
            $html.='<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">';
            $html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getDummyReport();"><div style="height:26px;width:1px;float:left"></div>Dummy Graph<br/><span style="font-size:small"></span></a></li>';                    
            $html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getReport(\'WOD\');"><div style="height:26px;width:1px;float:left"></div>WOD<br/><span style="font-size:small"></span></a></li>';          
            $html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getReport(\'Benchmarks\');"><div style="height:26px;width:1px;float:left"></div>Benchmarks<br/><span style="font-size:small"></span></a></li>';
            $html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getBaselineReport();"><div style="height:26px;width:1px;float:left"></div>Baseline<br/><span style="font-size:small"></span></a></li>';         
            $html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getReport(\'Exercises\')"><div style="height:26px;width:1px;float:left"></div>Activities<br/><span style="font-size:small"></span></a></li>';         
            $html.='</ul></div>';  
            $html.='<div class="clear"></div><br/>';                
            }
            return $html;
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