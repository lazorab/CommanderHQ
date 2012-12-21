<?php
class BaselineController extends Controller
{
    var $Baseline;
    var $SelectedBaseline;
    var $SaveMessage;
	
    function __construct()
    {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['UID'])){
            header('location: index.php?module=login');	
        }
    }
    
    function Message()
    {
        $Model = new BaselineModel;
        $Message = $Model->Log();
        
        return $Message;
    }    
    
    function Output()
    {
        $Html = $this->getBaselineDetails(); 
	return $Html;
    }
    
    function getBaselineDetails()
    {
        $Model = new BaselineModel;
        $BaselineDetails = $Model->getBaselineDetails();
        $html.='<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">';
        $html.='<li>Baseline : '.$BaselineDetails[0]->WorkoutName.'</li>';
        $html.='</ul>';
        $html.='<div class="ui-grid-c">';
        $html.='<div class="ui-block-a"><input data-role="none" type="text" style="width:75%;color:white;font-weight:bold;background-color:#3f2b44" value="Weight" readonly="readonly"/></div>';
        $html.='<div class="ui-block-b"><input data-role="none" type="text" style="width:75%;color:white;font-weight:bold;background-color:#66486e" value="Height" readonly="readonly"/></div>';
        $html.='<div class="ui-block-c"><input data-role="none" type="text" style="width:75%;color:white;font-weight:bold;background-color:#6f747a" value="Distance" readonly="readonly"/></div>';
        $html.='<div class="ui-block-d"><input data-role="none" type="text" style="width:75%;color:black;font-weight:bold;background-color:#ccff66" value="Reps" readonly="readonly"/></div>';
        $html.='</div>';
        $Clock = '';
	$Bhtml = '';
	$Chtml = '';
        $ThisRound = '';
        $ThisExercise = '';
        $html.='<form name="baselineform" id="baselineform" action="index.php">
        <input type="hidden" name="BaselineType" value="'.$BaselineDetails[0]->BaselineType.'"/>
        <input type="hidden" name="WorkoutId" value="'.$BaselineDetails[0]->WorkoutId.'"/>';

        $html.='<div class="ui-grid-b">';

	foreach($BaselineDetails as $Baseline){
		if($Baseline->Attribute == 'TimeToComplete'){
			$Clock = $this->getStopWatch();
		}
		else if($Baseline->Attribute == 'CountDown'){
			$Clock = $this->getCountDown($Baseline->AttributeValue);
		}
		else{
			
			if($Baseline->TotalRounds > 1 && $ThisRound != $Baseline->RoundNo && $Baseline->RoundNo > 0){
			
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
				$html.='<div class="ui-block-a"></div><div class="ui-block-b">Round '.$Baseline->RoundNo.'</div><div class="ui-block-c"></div>';
				$html.='<div class="ui-block-a" style="font-size:small"><input class="textinput" style="width:75%" readonly="readonly" type="text" data-inline="true" name="" value="'.$Baseline->InputFieldName.'"/></div>';
			}
			else if($ThisExercise != $Baseline->Exercise){
                            
                                if(isset($_REQUEST['Rounds']))
                                    $RoundNo = $_REQUEST['Rounds'];
                                else
                                    $RoundNo = $Baseline->RoundNo;

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
                                if($Baseline->Exercise == 'Total Rounds'){
                                    $Exercise = '<input class="buttongroup" data-inline="true" type="button" onclick="addRound();" value="+ Round"/>';
                                }else{
                                    $Exercise = '<input class="textinput" style="width:75%" readonly="readonly" type="text" data-inline="true" name="'.$Baseline->ExerciseId.'" value="'.$Baseline->InputFieldName.'"/>';
                                }
				$html.='<div class="ui-block-a"></div><div class="ui-block-b"></div><div class="ui-block-c"></div>';
				$html.='<div class="ui-block-a" style="font-size:small">'.$Exercise.'</div>';
				}
			}	

		
            if($Baseline->Attribute == 'Height' || $Baseline->Attribute == 'Distance' || $Baseline->Attribute == 'Weight'){
                            $AttributeValue = '';	
				if($Baseline->Attribute == 'Distance'){
                                    $Style='style="float:left;width:50%;color:white;font-weight:bold;background-color:#6f747a"';
					if($this->SystemOfMeasure() != 'Metric'){
						$Unit = '<span style="float:left">m</span>';
                                                $AttributeValue = round($Baseline->AttributeValue * 1.09, 2);
                                        }else{
						$Unit = '<span style="float:left">km</span>';
                                                $AttributeValue = $Baseline->AttributeValue;
                                        }
				}		
				else if($Baseline->Attribute == 'Weight'){
                                    $Style='style="float:left;width:50%;color:white;font-weight:bold;background-color:#3f2b44"';
					if($this->SystemOfMeasure() != 'Metric'){
                                            $AttributeValue = round($Baseline->AttributeValue * 2.20, 2);
						$Unit = '<span style="float:left">lbs</span>';
                                        }else{
						$Unit = '<span style="float:left">kg</span>';
                                                $AttributeValue = $Baseline->AttributeValue;
                                        }
				}
				else if($Baseline->Attribute == 'Height'){
                                    $Style='style="float:left;width:50%;color:white;font-weight:bold;background-color:#66486e"';
					if($this->SystemOfMeasure() != 'Metric'){
                                            $AttributeValue = round($Baseline->AttributeValue * 0.39, 2);
						$Unit = '<span style="float:left">in</span>';
                                        }else{
						$Unit = '<span style="float:left">cm</span>';
                                                $AttributeValue = $Baseline->AttributeValue;
                                        }
				}

				$Bhtml.='<div class="ui-block-b">';
				$Bhtml.='<input class="textinput" '.$Style.' type="number" data-inline="true" name="'.$RoundNo.'___'.$Baseline->ExerciseId.'___'.$Baseline->Attribute.'" value="'.$AttributeValue.'"/>'.$Unit.'';
				$Bhtml.='</div>';		
				if($Chtml != ''){
					$html.=''.$Bhtml.''.$Chtml.'';
					$Chtml = '';
					$Bhtml = '';
				}
			}
                        
            else if($Baseline->Attribute == 'Calories' || $Baseline->Attribute == 'Reps' || $Baseline->Attribute == 'Rounds'){
                                $Placeholder = '';
                                if($Baseline->Attribute == 'Calories'){
                                    $Style='style="width:50%"';
                                    $Placeholder = 'placeholder="Calories"';
                                }
                                $InputAttributes = 'class="textinput" type="number"';
                                $InputName = ''.$RoundNo.'___'.$Baseline->ExerciseId.'___'.$Baseline->Attribute.'';
                                $Value = $Baseline->AttributeValue;
                                if($Baseline->Attribute == 'Rounds'){
                                    $Style='style="width:50%"';
                                    $InputAttributes .= ' id="addround"';
                                    $InputName = 'Rounds';
                                    $Value = $_REQUEST['Rounds'] + 1 ;
                                }
                                if($Baseline->Attribute == 'Reps'){
                                    $Style='style="float:left;width:50%;color:black;font-weight:bold;background-color:#ccff66"';
                                }
				$Chtml.='<div class="ui-block-c">';
				$Chtml.='<input '.$InputAttributes.' '.$Style.' name="'.$InputName.'" '.$Placeholder.' value="'.$Value.'"/>';
				$Chtml.='</div>';
				if($Bhtml != ''){
					$html.=''.$Bhtml.''.$Chtml.'';
					$Bhtml = '';
					$Chtml = '';
				}
			}
		
		
	$ThisRound = $Baseline->RoundNo;
	$ThisExercise = $Baseline->Exercise;
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
    $html.='</div>'.$Clock.'</form><br/><br/>';
        
        return $html;
    }
    
    function getStopWatch()
    {
        //$Html ='<div id="timerContainer">'; 
        $Html.='<br/>';
        $Html.='<input type="text" id="clock" name="0___63___TimeToComplete" value="00:00:0" readonly/>';
        $Html.='<input type="hidden" name="clockType" id="clockType" value=""/>';
        $Html.='<input type="hidden" name="CountDown" id="CountDown" value=""/>';
        $Html.='<input type="hidden" name="startstopbutton" id="startstopbutton" value=""/>';
        $Html.='<br/>';
        $Html.='<div class="ui-grid-b">';
        $Html.='<div class="ui-block-a">';
        $Html.='<input id="resetbutton" class="buttongroup" onClick="reset();" type="button" value="Reset"/>';
        $Html.='</div><div class="ui-block-b">';
        $Html.='<input class="buttongroup" type="button" onClick="startstop();" value="Start"/>';
        $Html.='</div><div class="ui-block-c">';
        $Html.='<input class="buttongroup" type="button" onClick="startstop();" value="Stop"/>';
        $Html.='</div></div>'; 

        $Html.='<input type="button" value="Save" onClick="baselinesubmit();"/>';    

        return $Html;
    }
    
    function getWeight($exerciseId)
    {
		$RENDER = new Image();
		$Save = $RENDER->NewImage('save.png', SCREENWIDTH);
        $Html='<form name="form" action="index.php">
        <input type="hidden" name="module" value="baseline"/>
        <input type="hidden" name="baseline" value="'.$_REQUEST['baseline'].'"/>
        <input type="hidden" name="exercise" value="'.$exerciseId.'"/>
		<input type="number" name="Weight" value="" placeholder="Weight"/><br/><br/>
        <img alt="Save" '.$Save.' src="'.ImagePath.'save.png" onclick="document.form.submit();"/>
        </form>';
        
        return $Html;        
    }
    
    function getReps($exerciseId)
    {
		$RENDER = new Image();
		$Save = $RENDER->NewImage('save.png', SCREENWIDTH);
        $Html='<form name="form" action="index.php">
        <input type="hidden" name="module" value="baseline"/>
        <input type="hidden" name="baseline" value="'.$_REQUEST['baseline'].'"/>
        <input type="hidden" name="exercise" value="'.$exerciseId.'"/>
		<input type="number" name="Reps" value="" placeholder="Reps"/><br/><br/>
        <img alt="Save" '.$Save.' src="'.ImagePath.'save.png" onclick="document.form.submit();"/>
        </form>';
        
        return $Html;         
    }
    
    function getTabata($Details)
    {
        $Html='Tabata';
        
        return $Html;       
    }
    
    function getCountDown($Time)
    {
	$RoundNo = 0;
        $TimeToComplete = $Time;
        $StartStopButton = 'Start';
        if(isset($_REQUEST[''.$RoundNo.'___63___CountDown'])){
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