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
        var $Exercise;
	
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
		if(isset($_REQUEST['benchmarkId'])){
                    $this->Workout = $Model->getWorkoutDetails($_REQUEST['benchmarkId']);
                    $this->Video = $this->Workout[0]->Video;
                    $this->Exercise = $this->Workout[0];
                }
                else if(isset($_REQUEST['customId'])){
                    $this->Workout = $Model->getCustomDetails($_REQUEST['customId']);
                    $this->Exercise = $this->Workout[0];
                }
		$this->Categories = $Model->getCategories();
		if(isset($_REQUEST['catid'])){
			$this->Category = $Model->getCategory($_REQUEST['catid']);
			if($this->Category != 'Historic'){
				$this->BMWS = $Model->getBMWS($_REQUEST['catid']);
			}
		}
	}
        
        function Video()
        {
            $Html = '<iframe marginwidth="0px" marginheight="0px" width="'.SCREENWIDTH.'" height="'.$this->Height.'" src="http://www.youtube.com/embed/'.$this->Video.'" frameborder="0">';
            return $Html;
        }
	
	function Output()
	{
            $html = '';
            $Model = new BenchmarkModel;
            if($_REQUEST['action'] == 'save'){
                $html = '<div id="message">';
		$html .= $Model->Log();
                $html .= '</div>';
            }

if(isset($_REQUEST['benchmarkId']) || isset($_REQUEST['customId']))
{
	$Clock = '';
	$Bhtml = '';
	$Chtml = '';
	$html.='<form name="form" id="benchmarkform" action="index.php">
            <input type="hidden" name="origin" value="'.$this->Origin.'"/>
            <input type="hidden" name="benchmarkId" value="'.$_REQUEST['benchmarkId'].'"/>
            <input type="hidden" name="customId" value="'.$_REQUEST['customId'].'"/>
            <input type="hidden" name="wodtype" value="3"/>
            <input type="hidden" name="action" value="save"/>';       
        $html.='<input type="checkbox" name="baseline" value="yes" data-role="none"/>';
        $html.='Make this my baseline<br/><br/>';
        $html.='<div class="ui-grid-b">';
        $ThisRound = '';
		$ThisExercise = '';
	foreach($this->Workout as $Benchmark){
		if($Benchmark->Attribute == 'TimeToComplete'){
			$Clock = $this->getStopWatch($Benchmark->ExerciseId);
		}
		else if($Benchmark->Attribute == 'CountDown'){
			$Clock = $this->getCountDown($Benchmark->ExerciseId,$Benchmark->AttributeValue);
		}
		else{
			
			if($Benchmark->TotalRounds > 1 && $Benchmark->RoundNo > 0 && $ThisRound != $Benchmark->RoundNo){
			
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
				$html.='<div class="ui-block-a"><input data-role="none" style="width:75%" readonly="readonly" type="text" data-inline="true" name="" value="'.$Benchmark->InputFieldName.'"/></div>';
			}
			else if($ThisExercise != $Benchmark->Exercise){
                            
                                if(isset($_REQUEST['Rounds']))
                                    $RoundNo = $_REQUEST['Rounds'];
                                else
                                    $RoundNo = $Benchmark->RoundNo;

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
                                    $Exercise = '<input data-role="none" style="width:75%" readonly="readonly" type="text" data-inline="true" name="" value="'.$Benchmark->InputFieldName.'"/>';
                                }
				$html.='<div class="ui-block-a"></div><div class="ui-block-b"></div><div class="ui-block-c"></div>';
				$html.='<div class="ui-block-a">'.$Exercise.'</div>';
				}
			}	

		
            if($Benchmark->Attribute == 'Height' || $Benchmark->Attribute == 'Distance' || $Benchmark->Attribute == 'Weight'){
                            $AttributeValue = '';	
				if($Benchmark->Attribute == 'Distance'){
                                    $Style='style="width:75%;color:white;font-weight:bold;background-color:#6f747a"';
					if($this->SystemOfMeasure() != 'Metric'){
						$Unit = 'm';
                                                $AttributeValue = round($Benchmark->AttributeValue * 0.62, 2);
                                        }else{
						$Unit = 'km';
                                                $AttributeValue = $Benchmark->AttributeValue;
                                        }
				}		
				else if($Benchmark->Attribute == 'Weight'){
                                    $Style='style="width:75%;color:white;font-weight:bold;background-color:#3f2b44"';
					if($this->SystemOfMeasure() != 'Metric'){
                                            $AttributeValue = round($Benchmark->AttributeValue * 2.20, 2);
						$Unit = 'lbs';
                                        }else{
						$Unit = 'kg';
                                                $AttributeValue = $Benchmark->AttributeValue;
                                        }
				}
				else if($Benchmark->Attribute == 'Height'){
                                    $Style='style="width:75%;color:white;font-weight:bold;background-color:#66486e"';
					if($this->SystemOfMeasure() != 'Metric'){
                                            $AttributeValue = round($Benchmark->AttributeValue * 0.39, 2);
						$Unit = 'inches';
                                        }else{
						$Unit = 'cm';
                                                $AttributeValue = $Benchmark->AttributeValue;
                                        }
				}

				$Bhtml.='<div class="ui-block-b">';
				$Bhtml.='<input data-role="none" '.$Style.' type="number" data-inline="true" name="'.$RoundNo.'___'.$Benchmark->ExerciseId.'___'.$Benchmark->Attribute.'" value="'.$AttributeValue.'"/>';
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
                                    $Style='style="width:75%"';
                                    $Placeholder = 'placeholder="Calories"';
                                }
                                $InputAttributes = 'type="number"';
                                $InputName = ''.$RoundNo.'___'.$Benchmark->ExerciseId.'___'.$Benchmark->Attribute.'';
                                $Value = $Benchmark->AttributeValue;
                                if($Benchmark->Attribute == 'Rounds'){
                                    $Style='style="width:75%"';
                                    $InputAttributes .= ' id="addround"';
                                    $InputName = 'Rounds';
                                    $Value = $_REQUEST['Rounds'] + 1 ;
                                }
                                if($Benchmark->Attribute == 'Reps'){
                                    $Style='style="width:75%;color:black;font-weight:bold;background-color:#ccff66"';
                                }
				$Chtml.='<div class="ui-block-c">';
				$Chtml.='<input data-role="none" '.$InputAttributes.' '.$Style.' name="'.$InputName.'" '.$Placeholder.' value="'.$Value.'"/>';
				$Chtml.='</div>';
				if($Bhtml != ''){
					$html.=''.$Bhtml.''.$Chtml.'';
					$Bhtml = '';
					$Chtml = '';
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
    $html.='</div>';
    $html.=$Clock;
    $html.='</form><br/><br/>';		

}
else
{
    $Girls = $Model->getBMWS('1');
    $Heros = $Model->getBMWS('2');
    $Travel = $Model->getBMWS('3');
    
    $html.='    <div id="slides">
        <div class="slides_container">
        
            <div class="slide">
            <ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                <li>The Girls</li>
            </ul>
            '.$this->getWorkoutList($Girls).'
            </div>';
            
     $html .='<div class="slide">
            <ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                <li>The Heros</li>
            </ul>
                '.$this->getWorkoutList($Heros).'
            </div>';
            
     $html .='<div class="slide">
            <ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                <li>Various</li>
            </ul>
                
            </div>';
     
     $html .='<div class="slide">
            <ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                <li>Popular</li>
            </ul>
                
            </div>';

     $html .='<div class="slide">
            <ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                <li>Travel Workouts</li>
            </ul>
                '.$this->getWorkoutList($Travel).'
            </div>';

     $html .='<div class="slide">
            <ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                <li>My Saved WODs</li>
            </ul>
                '.$this->getCustomMemberWorkouts().'
            </div>';
  /*   
     $html .='<div class="slide">
            <ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                <li>Custom Workouts from Others</li>
            </ul>
                '.$this->getCustomPublicWorkouts().'
            </div>';
  */   
     $html.='           
        </div>
        <a href="#" class="prev"><img src="images/arrow-next.png" width="36" height="36" alt="Arrow Prev"></a>
        <a href="#" class="next"><img src="images/arrow-prev.png" width="36" height="36" alt="Arrow Next"></a>
    </div>';
	

}

return $html;
	}
        
        function getWorkoutList($Category)
        {
            $html = '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d" data-icon="none">';
            foreach($Category AS $Exercise){
                $Description = str_replace('{br}',' | ',$Exercise->Description);
                $html .= '<li>';
                $html .= '<a href="" onclick="getDetails('.$Exercise->Id.', \''.$this->Origin.'\');">'.$Exercise->Name.':<br/><span style="font-size:small">'.$Description.'</span></a>';
                $html .= '</li>';
            }	
            $html .= '</ul><br/>';
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
            $html .= '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d" data-icon="none">';
            foreach($CustomMemberWorkouts AS $Exercise){
                $html .= '<li>';
                $html .= '<a href="" onclick="getCustomDetails('.$Exercise->Id.', \''.$this->Origin.'\');">'.$Exercise->Name.':<br/><span style="font-size:small">'.$Exercise->Description.'</span></a>';
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
            $html .= '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d" data-icon="none">';
            foreach($CustomPublicWorkouts AS $Exercise){
                $html .= '<li>';
                $html .= '<a href="" onclick="getCustomDetails('.$Exercise->Id.', \''.$this->Origin.'\');">'.$Exercise->Name.':<br/><span style="font-size:small">'.$Exercise->Description.'</span></a>';
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
            $Description = str_replace('{br}',' | ',$this->Exercise->Description);
            $Html .= '<li>';
            $Html .= ''.$this->Exercise->Name.':<br/><span style="font-size:small">'.$Description.'</span>';
            $Html .= '</li>';
            return $Html;	
	}
	
    function getStopWatch($ExerciseId)
    {
	$RoundNo = 0;
        $TimeToComplete = '00:00:0';
        $StartStopButton = 'Start';
        if(isset($_REQUEST[''.$RoundNo.'___'.$ExerciseId.'___TimeToComplete'])){
            $TimeToComplete = $_REQUEST[''.$RoundNo.'___'.$ExerciseId.'___TimeToComplete'];
            if($TimeToComplete != '00:00:0')
                $StartStopButton = 'Stop';
        }
	$Html ='<input type="text" id="clock" name="'.$RoundNo.'___'.$ExerciseId.'___TimeToComplete" value="'.$TimeToComplete.'" readonly/>';
	$Html.='<input id="startstopbutton" class="buttongroup" type="button" onClick="startstop();" value="'.$StartStopButton.'"/>';
        //$Html.='<input id="splitbutton" class="buttongroup" type="button" value="Split time" onClick="splittime();"/>';
	$Html.='<input id="resetbutton" class="buttongroup" type="button" onClick="resetclock();" value="Reset"/>';
	$Html.='<input class="buttongroup" type="button" onclick="benchmarksubmit();" value="Save"/>';
        //$Html.='<textarea id="output"></textarea>';
        
        return $Html;
    }
	
    function getCountDown($ExerciseId,$Time)
    {
	$RoundNo = 0;
        $TimeToComplete = $Time;
        $StartStopButton = 'Start';
        if(isset($_REQUEST[''.$RoundNo.'___'.$ExerciseId.'___TimeToComplete'])){
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