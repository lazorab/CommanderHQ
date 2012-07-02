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
    
    function Output()
    {        
		$Model=new ReportsModel();
		
		if(isset($_REQUEST['action']))
		{

			if($_REQUEST['action'] == 'Pending')
			{
				return $this->PendingExercises();
			}
			else if($_REQUEST['action'] == 'Performance')
			{
				return $this->CompletedExercises();	
			}
            else if($_REQUEST['action'] == 'WOD')
			{
				return $this->WODExercises();	
			}
            else if($_REQUEST['action'] == 'Benchmarks')
			{
				return $this->BenchmarkExercises();	
			}
            else if($_REQUEST['action'] == 'Baseline')
			{
				return $this->BaselineExercises();	
			}
			else if($_REQUEST['action'] == 'Weight')
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
		$Html='<'.$this->Wall.'select name="WODId" id="WODId" onchange="getWODReport(this.value, reportform.datetime.value);">';
        $Html.='<'.$this->Wall.'option value=" ">Please Select</'.$this->Wall.'option>';
		foreach($ExerciseItems AS $Exercise) { 
			$Html.='<'.$this->Wall.'option value="'.$Exercise->ExerciseId.'">'.$Exercise->Exercise.'</'.$this->Wall.'option>';
		}
        $Html.='</'.$this->Wall.'select><br/><br/>';
		return $Html;	
	}
    
    function WODHistory()
    {
        $Model=new ReportsModel();
        $WODData = $Model->getWODHistory();
        $Html='';
        foreach($WODData as $Data)
        {
            $Html.=''.$Data->Exercise.'';
        }
        return $Html;
    }
    
    function BenchmarkExercises()
	{
        $Model=new ReportsModel();
		$ExerciseItems = $Model->getBenchmarkExercises();
		$Html='<'.$this->Wall.'select name="BenchmarkId" id="BenchmarkId" onchange="getBenchmarkReport(this.value, reportform.datetime.value);">';
        $Html.='<'.$this->Wall.'option value="">Logged Benchmarks</'.$this->Wall.'option>';
		foreach($ExerciseItems AS $Exercise) { 
			$Html.='<'.$this->Wall.'option value="'.$Exercise->ExerciseId.'">'.$Exercise->Exercise.'</'.$this->Wall.'option>';
		}
        $Html.='</'.$this->Wall.'select><br/><br/>';
		return $Html;	
	}
    
    function BenchmarkHistory()
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
		$Html='<'.$this->Wall.'select name="BaselineId" id="BaselineId" onchange="getBaselineReport(this.value, reportform.datetime.value);">';
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
        $Html='';
        foreach($BaselineData as $Data)
        {
           $Html.=''.$Data->TimeCreated.' - '.$Data->Attribute.':'.$Data->AttributeValue.'<br/>';
        }
        return $Html;
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