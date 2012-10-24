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
	if(isset($_REQUEST['report']))
	{
            if($_REQUEST['report'] == 'Pending')
            {
                return $this->PendingExercises();
            }
            else if($_REQUEST['report'] == 'Performance')
            {
                return $this->CompletedExercises();	
            }
            else if($_REQUEST['report'] == 'WOD')
            {
                return $this->WODExercises();	
            }
            else if($_REQUEST['report'] == 'Benchmarks')
            {
                return $this->BenchmarkHistory2();	
            }
            else if($_REQUEST['report'] == 'Baseline')
            {
                return $this->BaselineExercises();	
            }
            else if($_REQUEST['report'] == 'Weight')
            {
                return $this->WeightHistory($this->MemberDetails->SystemOfMeasure);	
            }
	}
	else if(isset($_REQUEST['PerformanceId']))
            return $this->PerformanceHistory();
        else if(isset($_REQUEST['WODId']))
            return $this->WODHistory();
        else if(isset($_REQUEST['BenchmarkId']))
            return $this->BenchmarkHistory();
        else if(isset($_REQUEST['BaselineId']))
            return $this->BaselineHistory();    
    }
    
	
    function Details()
    {
        $Model=new ReportsModel();
        $Details=$Model->getDetails();
	return $Details;
    }
	
    function CompletedExercises()
    {
        $Model=new ReportsModel();
	$ExerciseItems = $Model->getCompletedExercises();
	$Html='Completed Exercises:';
	foreach($ExerciseItems AS $Exercise) { 
            $Html.='<'.$this->Wall.'br/><'.$this->Wall.'a href="index.php?module=reports&id='.$Exercise->Id.'">'.$Exercise->Exercise.'</'.$this->Wall.'a>';
	}
	return $Html;	
    }
    
    function WODExercises()
    {
        $Model=new ReportsModel();
	$ExerciseItems = $Model->getWODExercises();
	$Html='<'.$this->Wall.'select name="WODId" id="WODId" class="select" onchange="getWODReport(this.value);">';
        $Html.='<'.$this->Wall.'option value=" ">Select Exercise</'.$this->Wall.'option>';
	foreach($ExerciseItems AS $Exercise) { 
            $Html.='<'.$this->Wall.'option value="'.$Exercise->ExerciseId.'">'.$Exercise->Exercise.'</'.$this->Wall.'option>';
	}
        $Html.='</'.$this->Wall.'select><br/><br/>';
	return $Html;	
    }
    
    function WODBenchmarks()
    {
        $Model=new ReportsModel();
	$BenchmarkItems = $Model->getBenchmarks();
	$Html='<'.$this->Wall.'select name="WODId" id="WODId" class="select" onchange="getBenchmarkReport(this.value);">';
        $Html.='<'.$this->Wall.'option value=" ">Select Benchmark</'.$this->Wall.'option>';
	foreach($BenchmarkItems AS $Exercise) { 
            $Html.='<'.$this->Wall.'option value="'.$Exercise->ExerciseId.'">'.$Exercise->WorkoutName.'</'.$this->Wall.'option>';
	}
        $Html.='</'.$this->Wall.'select><br/><br/>';
	return $Html;	
    }
    
    function WODHistory()
    {
        $Model=new ReportsModel();
        $WODData = $Model->getWODHistory();
        /*
        $Html='';
        foreach($WODData as $Data)
        {
            $Html.=''.$Data->TimeCreated.' - '.$Data->Exercise.' : '.$Data->Attribute.' - '.$Data->AttributeValue.' -<br/>';
        }
        return $Html;
        */
       return $WODData;
    }
    
        function BenchmarkHistory()
    {
        $Model=new ReportsModel();
        $BenchmarkData = $Model->getBenchmarkHistory();
        return $BenchmarkData;
    }
    
    function BenchmarkExercises()
    {
        $Model=new ReportsModel();
	$ExerciseItems = $Model->getBenchmarkHistory();
	$Html .= '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">';
	
        foreach($ExerciseItems AS $Exercise){
            $Html .= '<li><a href="" onclick="getBenchmarkReport(\''.$Exercise->ExerciseId.'\',\'\');">'.$Exercise->Exercise.'</a></li>';
        }	
				
	$Html .= '</ul>';

	return $Html;	
    }
    
    function BenchmarkHistory2()
    {
        $Model=new ReportsModel();
        $BenchmarkData = $Model->getBenchmarkHistory();
        $Html='';
        foreach($BenchmarkData as $Data)
        {
            $Html.=''.$Data->TimeCreated.' - '.$Data->TimeToComplete.'<br/>';
        }
        return $Html;
    }    
    
    function BaselineExercises()
	{
        $Model=new ReportsModel();
		$ExerciseItems = $Model->getBaselineExercises();
		$Html='<'.$this->Wall.'select name="BaselineId" id="BaselineId" class="select" onchange="getBaselineReport(this.value, reportform.datetime.value);">';
        $Html.='<'.$this->Wall.'option value="">Baseline Exercises</'.$this->Wall.'option>';
		foreach($ExerciseItems AS $Exercise) { 
			$Html.='<'.$this->Wall.'option value="'.$Exercise->ExerciseId.'">'.$Exercise->Exercise.'</'.$this->Wall.'option>';
		}
        $Html.='</'.$this->Wall.'select><br/><br/>';
		return $Html;	
	}
    
    function BaselineHistory()
    {
        $Model=new ReportsModel();
        $BaselineData = $Model->getBaselineHistory();
        $NumLogs = 0;
        $TotalSeconds = 0;
        $ChartData = "<chart showLabels='0' showYAxisValues='0' animation='0' lineColor='00008B' xAxisNamePadding='0' caption='Baseline' xAxisName='Time' yAxisName='Output' showValues= '0'>";
        foreach($BaselineData as $Data)
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

        $ChartData .= "</chart>";       
        return $ChartData;
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
			$Html.=''.$Item->TimeCreated.'	'.$Item->Weight.'	'.$Units.'<'.$this->Wall.'br/>';
		}
		return $Html;
	}
	
	function PendingExercises()
	{
        $Model=new ReportsModel();
		$PendingExercises = $Model->getPendingExercises();
		$Html='Pending Skill Exercises:';
		foreach($PendingExercises AS $Exercise) { 
			$Html.='<'.$this->Wall.'br/><'.$this->Wall.'a href="index.php?module=exercisedetails&id='.$Exercise->Id.'">'.$Exercise->Exercise.'</'.$this->Wall.'a>';
		}
		return $Html;
	}
}
?>