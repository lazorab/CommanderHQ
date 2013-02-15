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
        var $Benchmark;
	
	function __construct()
	{
            parent::__construct();
            session_start();
            if(!isset($_SESSION['UID'])){
                header('location: index.php?module=login');
            }
            if(isset($_REQUEST['origin']))
                $this->Origin = $_REQUEST['origin'];
		$this->Height = floor(SCREENWIDTH * 0.717); 
		$Model = new PersonalModel;
		if(isset($_REQUEST['customId']) && $_REQUEST['customId'] > 0){
                    $this->Workout = $Model->getWorkoutDetails($_REQUEST['customId']);
                    $this->Video = $this->Workout[0]->VideoId;
                    $this->Benchmark = $this->Workout[0];
                }
                else if(isset($_REQUEST['WorkoutId']) && $_REQUEST['WorkoutId'] > 0){
                    $this->Workout = $Model->getCustomDetails($_REQUEST['WorkoutId']);
                    $this->Benchmark = $this->Workout[0];
                }
	}
        
        function Message()
        {
            $Model = new PersonalModel;
            $Message = $Model->Log();

            return $Message;
        }       
        
	function Output()
	{
            $html = '';
            
            $Model = new PersonalModel;

if(isset($_REQUEST['customId']) || isset($_REQUEST['WorkoutId']))
{
	$Clock = '';
	$Bhtml = '';
	$Chtml = '';
	$html.='<form name="form" id="personalform" action="index.php">
            <input type="hidden" name="origin" value="'.$this->Origin.'"/>
            <input type="hidden" name="customId" value="'.$_REQUEST['customId'].'"/>
            <input type="hidden" name="WorkoutId" value="'.$_REQUEST['WorkoutId'].'"/>
            <input type="hidden" name="wodtype" value="3"/>
            <input type="hidden" id="addround" name="RoundNo" value="1"/>
            <input type="hidden" name="form" value="submitted"/>';       
        $html.='<input type="checkbox" name="baseline" value="yes" data-role="none"/>';
        $html.='Make this my baseline';
        $html.='<p>'.$this->Workout[0]->Notes.'</p>';
        //$html.='<div class="ui-grid-b">';
        $html = '<div data-role="collapsible-set" data-iconpos="right">';
        $ThisRound = '';
	$ThisExerciseId = 0;
        //var_dump($this->Workout);
	foreach($this->Workout as $Detail){
            if($Detail->UnitOfMeasureId == null){
                $UnitOfMeasureId = 0;
                $ConversionFactor = 1;
            }else{
                $UnitOfMeasureId = $Detail->UnitOfMeasureId;
                $ConversionFactor = $Detail->ConversionFactor;
            }
		if($Detail->Attribute == 'TimeToComplete'){
			$Clock = $this->getStopWatch();
		}
		else{
			
			if($Detail->TotalRounds > 1 && $Detail->RoundNo > 0 && $ThisRound != $Detail->RoundNo){
                            if($ThisExerciseId != null && $i > 0){
                                $html.='</h2><p style="color:red">'.$this->getExerciseHistory("".$Detail->RoundNo."_".$ThisExerciseId."").'</p></div><br/><br/>';
                            }                           	
                            $html.= '<h2>Round '.$Detail->RoundNo.'</h2>';
                            $html.= '<div data-role="collapsible">';
                            $html.= '<h2>'.$Detail->Exercise.'<br/>';             
			}
			else if($ThisExerciseId != $Detail->ExerciseId){

                            if($ThisExerciseId != null && $i > 0){
                                $html.='</h2><p style="color:red">'.$this->getExerciseHistory("".$Detail->RoundNo."_".$ThisExerciseId."").'</p></div>';
                            }       
                            $html.= '<div data-role="collapsible">';
                            $html.= '<h2>'.$Detail->Exercise.'<br/>';                           
                        }else{
                            $html.=' | ';
                        }
                        $html.=''.$Detail->Attribute.' : <span id="'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_'.$Detail->Attribute.'_html">'.$Detail->AttributeValue * $ConversionFactor.'</span>'.$Detail->UnitOfMeasure.'';
                        $html.='<input type="hidden" id="'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_'.$Detail->Attribute.'" name="'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_'.$Detail->Attribute.'_'.$UnitOfMeasureId.'" value="'.$Detail->AttributeValue.'">';
                }
	$ThisRound = $Detail->RoundNo;
	$ThisExerciseId = $Detail->ExerciseId;
        $i++;
	}
                            if($ThisExerciseId != null && $i > 0){
                                $html.='</h2><p style="color:red">'.$this->getExerciseHistory("".$Detail->RoundNo."_".$ThisExerciseId."").'</p></div>';
                            }             
    $html.='</div>';
    $html.=$this->getStopWatch();
    $html.='</form><br/><br/>';            

}
$html.='<div class="clear"></div><br/>';
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
            $TimeCreated = '';
            $TheseAttributes='';
            $Attributes = $Model->getExerciseIdAttributes($ThisExerciseId);
            //var_dump(json_encode($Attributes));
            //$Html = '<div id="'.$ThisExercise.'" class="ExerciseHistory">';
            foreach($ExerciseHistory as $Detail){
                if($i < 3){
                if($i > 0){
                    if($Detail->TimeCreated != $TimeCreated)
                        $Html.='<br/>';
                    else
                        $Html.=' | ';
                }
                $Html.=''.$Detail->Attribute.' : '.$Detail->AttributeValue.''.$Detail->UnitOfMeasure.'';
                $i++;
                }
                $TimeCreated = $Detail->TimeCreated;
            }
            $i=0;
            $Html .= '<div>';
            foreach($Attributes as $Attribute){
                if($i > 0)
                    $TheseAttributes.='_';
                $TheseAttributes.=$Attribute->Attribute;
                $Html .= '<div style="float:left;margin:0 10px 0 10px"">'.$Attribute->Attribute.'<input size="9" type="number" id="'.$Attribute->Attribute.'" name="" placeholder="'.$Attribute->UOM.'"/></div>';
                $i++;
            }

            $Html .= '<div style="float:right;margin:10px 20px 0 0"><input type="button" id="" name="" onClick="UpdateActivity(\''.$ThisExercise.'\', \''.$TheseAttributes.'\');" value="Update"/></div>';
            $Html .= '</div><div class="clear"></div>';
            
            return $Html;
        }        
        
        function getWorkoutList($Category)
        {
            $Model = new PersonalModel;
            $html = '<ul class="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d" data-icon="none">';
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
            $Model = new PersonalModel;
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
            $Description = $Model->getBenchmarkDescription($this->Benchmark->Id);
            $Html .= '<li>';
            $Html .= ''.$this->Benchmark->WorkoutName.':<br/><span style="font-size:small">'.$Description.'</span>';
            $Html .= '</li>';
            return $Html;	
	}	
}
?>