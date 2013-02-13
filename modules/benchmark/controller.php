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
            if(!isset($_SESSION['UID'])){
                header('location: index.php?module=login');
            }
            if(isset($_REQUEST['origin']))
                $this->Origin = $_REQUEST['origin'];
		$this->Height = floor(SCREENWIDTH * 0.717); 
		$Model = new BenchmarkModel;
		if(isset($_REQUEST['benchmarkId']) && $_REQUEST['benchmarkId'] > 0){
                    $this->Workout = $Model->getWorkoutDetails($_REQUEST['benchmarkId']);
                    $this->Video = $this->Workout[0]->VideoId;
                    $this->Benchmark = $this->Workout[0];
                }
                else if(isset($_REQUEST['WorkoutId']) && $_REQUEST['WorkoutId'] > 0){
                    $this->Workout = $Model->getCustomDetails($_REQUEST['WorkoutId']);
                    $this->Benchmark = $this->Workout[0];
                }
	}
        
        function Video()
        {
            $Html = '';
            if($this->Video != '')
                $Html = '<iframe marginwidth="0px" marginheight="0px" width="'.SCREENWIDTH.'" height="'.$this->Height.'" src="http://www.youtube.com/embed/'.$this->Video.'" frameborder="0">';
          
            return $Html;
        }
        
        function Message()
        {
            $Model = new BenchmarkModel;
            $Message = $Model->Log();

            return $Message;
        }       
        
	function Output()
	{
            $html = '';
            
            $Model = new BenchmarkModel;

if(isset($_REQUEST['benchmarkId']) || isset($_REQUEST['WorkoutId']))
{
	$Clock = '';
	$Bhtml = '';
	$Chtml = '';
	$html.='<form name="form" id="benchmarkform" action="index.php">
            <input type="hidden" name="origin" value="'.$this->Origin.'"/>
            <input type="hidden" name="benchmarkId" value="'.$_REQUEST['benchmarkId'].'"/>
            <input type="hidden" name="WorkoutId" value="'.$_REQUEST['WorkoutId'].'"/>
            <input type="hidden" name="wodtype" value="3"/>
            <input type="hidden" id="addround" name="RoundNo" value="1"/>
            <input type="hidden" name="form" value="submitted"/>';       
        $html.='<input type="checkbox" name="baseline" value="yes" data-role="none"/>';
        $html.='Make this my baseline';
        $html.='<p>'.$this->Workout[0]->Notes.'</p>';
        $html.='<div class="ui-grid-b">';
        $ThisRound = 0;
	$ThisExercise = '';
        //var_dump($this->Workout);
	foreach($this->Workout as $Benchmark){
            $Style = '';
			if($Benchmark->TotalRounds > 1 && $ThisRound != $Benchmark->RoundNo){

				if($Chtml != '' && $Bhtml == ''){
					$html.='<div class="ui-block-b"></div>'.$Chtml.'';
					$Chtml = '';
					$Bhtml = '';
				}
				if($Chtml == '' && $Bhtml != ''){
					$html.=''.$Bhtml.'<div class="ui-block-c"></div>';
					$Chtml = '';
					$Bhtml = '';
				}
				$html.='<div class="ui-block-a"></div><div class="ui-block-b"></div><div class="ui-block-c"></div>';
				$html.='<div class="ui-block-a" style="padding:2px 0 2px 0">Round '.$Benchmark->RoundNo.'</div><div class="ui-block-b" style="padding:2px 0 2px 0"></div><div class="ui-block-c" style="padding:2px 0 2px 0"></div>';
				//$html.='<div class="ui-block-a"><input class="textinput" style="width:75%" readonly="readonly" type="text" data-inline="true" name="" value="'.$Benchmark->InputFieldName.'"/></div>';
			}   
             		if($Benchmark->Attribute == 'TimeToComplete'){
			$Clock = $this->getStopWatch();
		}
		else if($Benchmark->Attribute == 'CountDown'){
			$Clock = $this->getCountDown($Benchmark->AttributeValue);
                }                       
		else{

                    if(isset($_REQUEST['Rounds']) && $_REQUEST['Rounds'] != '')
                        $RoundNo = $_REQUEST['Rounds'];
                    else
                        $RoundNo = $Benchmark->RoundNo;               

                    if($ThisExercise != $Benchmark->Exercise){
                            
				if($Chtml != '' && $Bhtml == ''){
					$html.='<div class="ui-block-b"></div>'.$Chtml.'';
					$Chtml = '';
					$Bhtml = '';
				}
				if($Chtml == '' && $Bhtml != ''){
					$html.=''.$Bhtml.'<div class="ui-block-c"></div>';
					$Chtml = '';
					$Bhtml = '';
				}
                                if($Benchmark->Exercise == 'Total Rounds'){
                                    $Exercise = '<input class="buttongroup" data-inline="true" type="button" onclick="addRound();" value="+ Round"/>';
                                }else{
                                    $Exercise = '<input class="textinput" style="width:75%" readonly="readonly" type="text" data-inline="true" name="" value="'.$Benchmark->InputFieldName.'"/>';
                                }
				$html.='<div class="ui-block-a"></div><div class="ui-block-b"></div><div class="ui-block-c"></div>';
				$html.='<div class="ui-block-a">'.$Exercise.'</div>';
				}
			

		
            if($Benchmark->Attribute == 'Height' || 
               $Benchmark->Attribute == 'Distance' || 
               $Benchmark->Attribute == 'Weight' ||
               $Benchmark->Attribute == 'TimeLimit'){
                            $AttributeValue = '';	
				if($Benchmark->Attribute == 'Distance'){
                                    $Style='style="float:left;width:50%;color:white;font-weight:bold;background-color:#6f747a"';
					if($this->SystemOfMeasure() != 'Metric'){
						$Unit = '<span style="float:left">yards</span>';
                                                $AttributeValue = round($Benchmark->AttributeValue * 1.09, 2);
                                        }else{
						$Unit = '<span style="float:left">metres</span>';
                                                $AttributeValue = $Benchmark->AttributeValue;
                                        }
				}		
				else if($Benchmark->Attribute == 'Weight'){
                                    $Style='style="float:left;width:50%;color:white;font-weight:bold;background-color:#3f2b44"';
					if($this->SystemOfMeasure() != 'Metric'){
                                            $AttributeValue = round($Benchmark->AttributeValue * 2.20, 2);
						$Unit = '<span style="float:left">lbs</span>';
                                        }else{
						$Unit = '<span style="float:left">kg</span>';
                                                $AttributeValue = $Benchmark->AttributeValue;
                                        }
				}
				else if($Benchmark->Attribute == 'Height'){
                                    $Style='style="float:left;width:50%;color:white;font-weight:bold;background-color:#66486e"';
					if($this->SystemOfMeasure() != 'Metric'){
                                            $AttributeValue = round($Benchmark->AttributeValue * 0.39, 2);
						$Unit = '<span style="float:left">in</span>';
                                        }else{
						$Unit = '<span style="float:left">cm</span>';
                                                $AttributeValue = $Benchmark->AttributeValue;
                                        }
				}
				else{
                                    if($Benchmark->InputFieldName == 'Rest')
                                        $Style = 'disabled';
                                    $AttributeValue = $Benchmark->AttributeValue;
				}                                

				$Bhtml.='<div class="ui-block-b">';
				$Bhtml.='<input class="textinput" '.$Style.' type="number" data-inline="true" id="'.$RoundNo.'___'.$Benchmark->ExerciseId.'___'.$Benchmark->Attribute.'" name="'.$RoundNo.'___'.$Benchmark->ExerciseId.'___'.$Benchmark->Attribute.'" value="'.$AttributeValue.'"/>'.$Unit.'';
				$Bhtml.='</div>';		
				if($Chtml != ''){
					$html.=''.$Bhtml.''.$Chtml.'';
					$Chtml = '';
					$Bhtml = '';
				}
			}
                        
            else if($Benchmark->Attribute == 'Calories' || $Benchmark->Attribute == 'Reps' || $Benchmark->Attribute == 'Rounds'){
                                $Placeholder = '';
                                if($Benchmark->Attribute == 'Calories'){
                                    $Style='style="width:50%"';
                                    $Placeholder = 'placeholder="Calories"';
                                }
                                $InputAttributes = 'type="number"';
                                $InputName = ''.$RoundNo.'___'.$Benchmark->ExerciseId.'___'.$Benchmark->Attribute.'';
                                $Value = $Benchmark->AttributeValue;
                                if($Benchmark->Attribute == 'Rounds'){
                                    $Style='style="width:50%"';
                                    $InputAttributes .= ' id="addround"';
                                    $InputName = 'Rounds';
                                    $Value = $_REQUEST['Rounds'] + 1 ;
                                }
                                if($Benchmark->Attribute == 'Reps'){
                                    $Style='style="float:left;width:50%;color:black;font-weight:bold;background-color:#ccff66"';
                                }
				$Chtml.='<div class="ui-block-c">';
				$Chtml.='<input class="textinput" '.$InputAttributes.' '.$Style.' name="'.$InputName.'" '.$Placeholder.' value="'.$Value.'"/>';
				$Chtml.='</div>';
				if($Bhtml != ''){
					$html.=''.$Bhtml.''.$Chtml.'';
					$Bhtml = '';
					$Chtml = '';
				}
			}
                }
		
	$ThisRound = $Benchmark->RoundNo;
	$ThisExercise = $Benchmark->Exercise;
	}
				if($Chtml != '' && $Bhtml == ''){
					$html.='<div class="ui-block-b"></div>'.$Chtml.'';
					$Chtml = '';
					$Bhtml = '';
				}
				if($Chtml == '' && $Bhtml != ''){
					$html.=''.$Bhtml.'<div class="ui-block-c"></div>';
					$Chtml = '';
					$Bhtml = '';
				}	
    $html.='</div><br/><br/>';
    $html.=$Clock;
    $html.='</form>';		

}
else if(isset($_REQUEST['cat']) && $_REQUEST['cat'] != '')
{
    /*
    Categories:
    Girls
    Heros
    Various 
    Travel
    */
    $Workouts = $Model->getBMWS($_REQUEST['cat']);
    $Overthrow='';
    $Device = new DeviceManager;
    if($Device->IsGoogleAndroidDevice()) {
        $Overthrow='class="overthrow"';
}
    
     $html.='<div '.$Overthrow.'>
            <h2>'.$_REQUEST['cat'].'</h2>
            '.$this->getWorkoutList($Workouts).'
            </div>';

}else{
    //OpenThisPage(\'?module=benchmark&cat=Girls\')
    $html.='<div style="padding:2%">
            <ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
            <li><a style="font-size:large;margin-top:10px" href="#" onclick="getBenchmarks(\'Girls\');"><div style="height:26px;width:1px;float:left"></div>Girls<br/><span style="font-size:small"></span></a></li>             
            <li><a style="font-size:large;margin-top:10px" href="#" onclick="getBenchmarks(\'Heros\');"><div style="height:26px;width:1px;float:left"></div>Heros<br/><span style="font-size:small"></span></a></li>
            <li><a style="font-size:large;margin-top:10px" href="#" onclick="getBenchmarks(\'Various\');"><div style="height:26px;width:1px;float:left"></div>Various<br/><span style="font-size:small"></span></a></li>
            <li><a style="font-size:large;margin-top:10px" href="#" onclick="getBenchmarks(\'Travel\');"><div style="height:26px;width:1px;float:left"></div>Travel<br/><span style="font-size:small"></span></a></li>
            </ul>
            </div>';  
}
$html.='<div class="clear"></div><br/>';
return $html;
	}
        
        function getWorkoutList($Category)
        {
            $Model = new BenchmarkModel;
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
            $Html .= '<li>';
            $Html .= ''.$this->Benchmark->WorkoutName.':<br/><span style="font-size:small">'.$Description.'</span>';
            $Html .= '</li>';
            return $Html;	
	}	
}
?>