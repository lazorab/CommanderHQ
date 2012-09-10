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
                    $this->Exercise = $this->Workout[0]->Name;
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
            $html = '<div id="message">';
            $Model = new BenchmarkModel;
            if($_REQUEST['action'] == 'save'){
		$html .= $Model->Log();
            }
            //$RENDER = new Image(SITE_ID);
            $html .= '</div><br/>';

if(isset($_REQUEST['benchmarkId']))
{

	$html.='<form name="form" id="benchmarkform" action="index.php">
            <input type="hidden" name="origin" value="'.$this->Origin.'"/>
            <input type="hidden" name="benchmarkId" value="'.$_REQUEST['benchmarkId'].'"/>
            <input type="hidden" name="wodtype" value="3"/>
            <input type="hidden" name="action" value="save"/>';
	$clock = '';
		$Bhtml = '';
		$Chtml = '';
        $html.='<div class="ui-grid-b">';
        $ThisRound = '';
		$ThisExercise = '';
	foreach($this->Workout as $Benchmark){
		if($Benchmark->Attribute == 'TimeToComplete'){
			$clock = $this->getStopWatch($Benchmark->ExerciseId);
		}
		else if($Benchmark->Attribute == 'CountDown'){
			$clock = $this->getCountDown($Benchmark->ExerciseId,$Benchmark->AttributeValue);
		}
		else{
			
			if($ThisRound != $Benchmark->RoundNo && $Benchmark->RoundNo > 0){
			
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
				$html.='<div class="ui-block-a"></div><div class="ui-block-b">Round '.$Benchmark->RoundNo.'</div><div class="ui-block-c"></div>';
				$html.='<div class="ui-block-a" style="font-size:small">'.$Benchmark->Exercise.'</div>';
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
                                    $Exercise = $Benchmark->Exercise;
                                }
				$html.='<div class="ui-block-a"></div><div class="ui-block-b"></div><div class="ui-block-c"></div>';
				$html.='<div class="ui-block-a" style="font-size:small">'.$Exercise.'</div>';
				}
			}	

		
            if($Benchmark->Attribute == 'Height' || $Benchmark->Attribute == 'Distance' || $Benchmark->Attribute == 'Weight'){
                            $AttributeValue = '';	
				if($Benchmark->Attribute == 'Distance'){
					if($Model->SystemOfMeasure() != 'Metric'){
						$Unit = 'm';
                                                $AttributeValue = round($Benchmark->AttributeValue * 0.62, 2);
                                        }else{
						$Unit = 'km';
                                                $AttributeValue = $Benchmark->AttributeValue;
                                        }
				}		
				else if($Benchmark->Attribute == 'Weight'){
					if($Model->SystemOfMeasure() != 'Metric'){
                                            $AttributeValue = round($Benchmark->AttributeValue * 2.20, 2);
						$Unit = 'lbs';
                                        }else{
						$Unit = 'kg';
                                                $AttributeValue = $Benchmark->AttributeValue;
                                        }
				}
				else if($Benchmark->Attribute == 'Height'){
					if($Model->SystemOfMeasure() != 'Metric'){
                                            $AttributeValue = round($Benchmark->AttributeValue * 0.39, 2);
						$Unit = 'inches';
                                        }else{
						$Unit = 'cm';
                                                $AttributeValue = $Benchmark->AttributeValue;
                                        }
				}

				$Bhtml.='<div class="ui-block-b">';
				$Bhtml.='<input class="textinput" size="6" type="number" data-inline="true" name="'.$RoundNo.'___'.$Benchmark->ExerciseId.'___'.$Benchmark->Attribute.'" value="'.$AttributeValue.'"/> '.$Unit.'';
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
                                    $Placeholder = 'placeholder="Calories"';
                                }
                                $InputAttributes = 'class="textinput" type="number" size="6"';
                                $InputName = ''.$RoundNo.'___'.$Benchmark->ExerciseId.'___'.$Benchmark->Attribute.'';
                                $Value = $Benchmark->AttributeValue;
                                if($Benchmark->Attribute == 'Rounds'){
                                    $InputAttributes .= ' id="addround"';
                                    $InputName = 'Rounds';
                                    $Value = $_REQUEST['Rounds'] + 1;
                                }
				$Chtml.='<div class="ui-block-c">';
				$Chtml.='<input '.$InputAttributes.' name="'.$InputName.'" '.$Placeholder.' value="'.$Value.'"/>';
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
    $html.='</div>'.$clock.'</form><br/><br/>';		

}
else if(isset($_REQUEST['catid']))
{
	if($this->Category == 'Historic'){
		$html.= $this->getHistory();
	}
	else{
               $html .= '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d" data-icon="none">';
                foreach($this->BMWS AS $Exercise){
					$Description = str_replace('{br}',' | ',$Exercise->Description);
					$html .= '<li>
                        <a href="" onclick="getDetails('.$Exercise->Id.', \''.$this->Origin.'\');">'.$Exercise->Name.':<br/><span style="font-size:small">'.$Description.'</span></a>
                    </li>';
                }	
				$html .= '</ul><br/>';
	}

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
            $Html.='<li>'.$this->Exercise.'</li>';
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