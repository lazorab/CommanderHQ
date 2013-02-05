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
    $html.='</div>';
    $html.=$Clock;
    $html.='<input class="buttongroup" type="button" onClick="benchmarksubmit();" value="Save"/>';
    $html.='</form><div class="clear"></div><br/>';		

}
else
{
    $Girls = $Model->getBMWS('The Girls');
    $Heros = $Model->getBMWS('The Heros');
    $Various = $Model->getBMWS('Various');
    $Travel = $Model->getBMWS('Travel');
    $Overthrow='';
    $Device = new DeviceManager;
    if($Device->IsGoogleAndroidDevice()) {
        $Overthrow=' overthrow';
}
    
    $html.='<div id="slides">
        <div class="slides_container">';
    /*
    $html.='<div class="slide'.$Overthrow.'">
            <ul class="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                <li>The Girls</li>
            </ul>
            '.$this->getWorkoutList($Girls).'
            </div>';
            
     $html .='<div class="slide'.$Overthrow.'">
            <ul class="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                <li>The Heros</li>
            </ul>
                '.$this->getWorkoutList($Heros).'
            </div>';
     */
    
     $html.='<div class="slide'.$Overthrow.'">
            <ul class="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                <li>Benchmarks</li>
            </ul>
            <h1>Girls</h1>
            '.$this->getWorkoutList($Girls).'
            <h1>Heros</h1>    
            '.$this->getWorkoutList($Heros).'
            <h1>Various</h1>    
            '.$this->getWorkoutList($Various).' 
            <h1>Travel</h1>    
            '.$this->getWorkoutList($Travel).'
            </div>';
    /*
     $html .='<div class="slide'.$Overthrow.'">
            <ul class="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                <li>Various</li>
            </ul>
                '.$this->getWorkoutList($Various).'
            </div>';
     
     $html .='<div class="slide">
            <ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                <li>Popular</li>
            </ul>
                
            </div>';

     $html .='<div class="slide'.$Overthrow.'">
            <ul class="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                <li>Travel Workouts</li>
            </ul>
                '.$this->getWorkoutList($Travel).'
            </div>';
*/
     $html .='<div class="slide'.$Overthrow.'">
            <ul class="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
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
        <a href="#" class="prev"><img src="'.IMAGE_RENDER_PATH.'arrow-next.png" width="36" height="36" alt="Arrow Prev"></a>
        <a href="#" class="next"><img src="'.IMAGE_RENDER_PATH.'arrow-prev.png" width="36" height="36" alt="Arrow Next"></a>
    </div>';
	

}

return $html;
	}
        
        function getWorkoutList($Category)
        {
            $Model = new BenchmarkModel;
            $html = '<ul class="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d" data-icon="none">';
            foreach($Category AS $Workout){
                $Description = $Model->getBenchmarkDescription($Workout->Id);
                $html .= '<li>';
                $html .= '<a href="" onclick="getDetails('.$Workout->Id.', \''.$this->Origin.'\');">'.$Workout->WorkoutName.':<br/><span style="font-size:small">'.$Description.'</span></a>';
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
	
    function getStopWatch()
    {
        //$Html ='<div id="timerContainer">'; 
        $Html.='<br/>';
        $Html.='<input type="text" id="clock" name="0___63___TimeToComplete" value="00:00:0" readonly/>';
        $Html.='<input type="hidden" name="clockType" id="clockType" value=""/>';
        $Html.='<input type="hidden" name="CountDown" id="CountDown" value=""/>';
        $Html.='<input type="hidden" name="startstopbutton" id="startstopbutton" value=""/>';
        $Html.='<br/><br/>';
        $Html.='<div class="ui-grid-b">';
        $Html.='<div class="ui-block-a">';
        $Html.='<input id="resetbutton" class="buttongroup" onClick="reset();" type="button" value="Reset"/>';
        $Html.='</div><div class="ui-block-b">';
        $Html.='<input class="buttongroup" type="button" onClick="startstop();" value="Start"/>';
        $Html.='</div><div class="ui-block-c">';
        $Html.='<input class="buttongroup" type="button" onClick="startstop();" value="Stop"/>';
        $Html.='</div></div>'; 
        //$Html.='</div>';      

        return $Html;
    }
	
    function getCountDown($Time)
    {
        $TimeToComplete = $Time;
        $StartStopButton = 'Start';
        if(isset($_REQUEST['0___63___CountDown'])){
            $TimeToComplete = $_REQUEST['0___63___CountDown'];
            if($TimeToComplete != $Time)
                $StartStopButton = 'Stop';
        }
	$Html ='<input type="hidden" name="0___63___CountDown" id="CountDown" value="'.$Time.'"/>';
        $Html.='<input type="hidden" name="clockType" id="clockType" value="timer"/>';
        $Html.='<input id="clock" name="timer" value="'.$TimeToComplete.'"/>';
        $Html.='<input id="startstopbutton" class="buttongroup" type="button" onClick="startstopcountdown();" value="'.$StartStopButton.'"/>';
        $Html.='<input id="resetbutton" class="buttongroup" type="button" onClick="resetcountdown();" value="Reset"/>';
		
        return $Html;
    }	
}
?>