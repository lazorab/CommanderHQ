<?php
class WodController extends Controller
{
	function __construct()
	{
            parent::__construct();
            session_start();
            if(!isset($_SESSION['UID'])){
                header('location: index.php?module=login');
            }
	}
	
	function TopSelection()
	{
            $Html='';
            if(isset($_REQUEST['topselection'])){
                if($_REQUEST['topselection'] == 'mygym'){
                    $Gym = $this->MemberGym();
                    $Display = $Gym->GymName;
                }else{
                    $Display = $this->getTopSelection();
                }
            }else{
                $Display = 'Workout Of the Day';                  
            }
            $Html='<li>'.$Display.'</li>';
            return $Html;
	}
        
        function getTopSelection()
        {
            $Html='';
            $Model = new WodModel;
            $WodDetails = $Model->getTopSelection();
            $Description = $Model->WodDescription($WodDetails[0]->WodId);
            $Html .= ''.$WodDetails[0]->WodDate.':<br/><span style="font-size:small">'.$Description.'</span>';
            return $Html;           
        }
	
	function WodDetails()
	{
            $Model = new WodModel;
            $WOD = $Model->getWOD();
            return $WOD;
	}
	
	function Save()
	{
            $Model = new WodModel;
            $WOD = $Model->Log();
	}
	
	function Output()
	{
            if($_REQUEST['wod'] == 'display'){//my gym
                //check for registered gym
                $Gym = $this->MemberGym();
                if(!$Gym){//must register gym
                    $WODdata = 'Must First Register Gym!';
		}
		else{//show details:
                    //$WODdata .='<h2>Workout for '.date('d M Y').'</h2>';
                    $WODdata = $this->MyGymWOD();
		}	
            }else if(isset($_REQUEST['Workout'])){
                $WODdata = $this->WorkoutDetails();
            }else{
                $WODdata='<div style="padding:2%">
                <ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="OpenThisPage(\'?module=baseline&origin=wod&baseline=Baseline\')"><div style="height:26px;width:1px;float:left"></div>Baseline</a></li>
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="OpenThisPage(\'?module=benchmark&origin=wod\')"><div style="height:26px;width:1px;float:left"></div>Benchmarks</a></li>
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="OpenThisPage(\'?module=custom&origin=wod\')"><div style="height:26px;width:1px;float:left"></div>Custom</a></li>
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="getWOD();"><div style="height:26px;width:1px;float:left"></div>My Gym</a></li>                
                </ul></div><br/>';              
            }	
            return $WODdata;
	}
    
	function MemberGym()
	{
            $Model = new WodModel;
            $MemberGym = $Model->getMemberGym();	
            return $MemberGym;
	}
        
 	function MyGymFeed()
	{
            $Html='';
            $Model = new WodModel;
            $GymFeed = $Model->getMyGymFeed();
            $i = 0;
            foreach($GymFeed AS $Item)
            {
                if($i > 0)
                    $Html.='<a href="#" onClick="getDetails(\''.urlencode($Item->WodDate).'\')">'.$Item->WodDate.'</a><br/><br/>';
                $i++;
            }
            return $Html;
	}      
        
  	function WorkoutDetails()
	{
            $html='';
            $Model = new WodModel;
            $WodDetails = $Model->getWODDetails($_REQUEST['Workout']);

	$Clock = '';
	$Bhtml = '';
	$Chtml = '';
	$html.='<form name="form" id="wodform" action="index.php">
            <input type="hidden" name="wodtype" value="2"/>
            <input type="hidden" name="form" value="submitted"/>';       
        $html.='<input type="checkbox" name="baseline" value="yes" data-role="none"/>';
        $html.='Make this my baseline';
        $html.='<p>'.$WodDetails[0]->Notes.'</p>';
        $html.='<div class="ui-grid-b">';
        $ThisRound = '';
		$ThisExercise = '';
	foreach($WodDetails as $Detail){
		if($Detail->Attribute == 'TimeToComplete'){
			$Clock = $this->getStopWatch();
		}
		else if($Detail->Attribute == 'CountDown'){
			$Clock = $this->getCountDown($Detail->ExerciseId,$Detail->AttributeValue);
		}
		else{
			
			if($Detail->TotalRounds > 1 && $Detail->RoundNo > 0 && $ThisRound != $Detail->RoundNo){
			
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
				$html.='<div class="ui-block-a" style="padding:2px 0 2px 0">Round '.$Detail->RoundNo.'</div><div class="ui-block-b" style="padding:2px 0 2px 0"></div><div class="ui-block-c" style="padding:2px 0 2px 0"></div>';
				$html.='<div class="ui-block-a"><input data-role="none" style="width:75%" readonly="readonly" type="text" data-inline="true" name="" value="'.$Detail->InputFieldName.'"/></div>';
			}
			else if($ThisExercise != $Detail->Exercise){
                            
                                if(isset($_REQUEST['Rounds']))
                                    $RoundNo = $_REQUEST['Rounds'];
                                else
                                    $RoundNo = $Detail->RoundNo;

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
                                if($Detail->Exercise == 'Total Rounds'){
                                    $Exercise = '<input class="buttongroup" data-inline="true" type="button" onclick="addRound();" value="+ Round"/>';
                                }else{
                                    $Exercise = '<input data-role="none" style="width:75%" readonly="readonly" type="text" data-inline="true" name="" value="'.$Detail->InputFieldName.'"/>';
                                }
				$html.='<div class="ui-block-a"></div><div class="ui-block-b"></div><div class="ui-block-c"></div>';
				$html.='<div class="ui-block-a">'.$Exercise.'</div>';
				}
			}	

		
            if($Detail->Attribute == 'Height' || $Detail->Attribute == 'Distance' || $Detail->Attribute == 'Weight'){
                            $AttributeValue = '';	
				if($Detail->Attribute == 'Distance'){
                                    $Style='style="float:left;width:50%;color:white;font-weight:bold;background-color:#6f747a"';
					if($this->SystemOfMeasure() != 'Metric'){
						$Unit = '<span style="float:left">yd</span>';
                                                $AttributeValue = round($Detail->AttributeValue * 1.09, 2);
                                        }else{
						$Unit = '<span style="float:left">m</span>';
                                                $AttributeValue = $Detail->AttributeValue;
                                        }
				}		
				else if($Detail->Attribute == 'Weight'){
                                    $Style='style="float:left;width:50%;color:white;font-weight:bold;background-color:#3f2b44"';
					if($this->SystemOfMeasure() != 'Metric'){
                                            $AttributeValue = round($Detail->AttributeValue * 2.20, 2);
						$Unit = '<span style="float:left">lbs</span>';
                                        }else{
						$Unit = '<span style="float:left">kg</span>';
                                                $AttributeValue = $Detail->AttributeValue;
                                        }
				}
				else if($Detail->Attribute == 'Height'){
                                    $Style='style="float:left;width:50%;color:white;font-weight:bold;background-color:#66486e"';
					if($this->SystemOfMeasure() != 'Metric'){
                                            $AttributeValue = round($Detail->AttributeValue * 0.39, 2);
						$Unit = '<span style="float:left">in</span>';
                                        }else{
						$Unit = '<span style="float:left">cm</span>';
                                                $AttributeValue = $Detail->AttributeValue;
                                        }
				}

				$Bhtml.='<div class="ui-block-b">';
				$Bhtml.='<input data-role="none" '.$Style.' type="number" data-inline="true" name="'.$RoundNo.'___'.$Detail->ExerciseId.'___'.$Detail->Attribute.'" value="'.$AttributeValue.'"/>'.$Unit.'';
				$Bhtml.='</div>';		
				if($Chtml != ''){
					$html.=''.$Bhtml.''.$Chtml.'';
					$Chtml = '';
					$Bhtml = '';
				}
			}
                        
            else if($Detail->Attribute == 'Calories' || $Detail->Attribute == 'Reps' || $Detail->Attribute == 'Rounds'){
                                $Placeholder = '';
                                if($Detail->Attribute == 'Calories'){
                                    $Style='style="width:50%"';
                                    $Placeholder = 'placeholder="Calories"';
                                }
                                $InputAttributes = 'type="number"';
                                $InputName = ''.$RoundNo.'___'.$Detail->ExerciseId.'___'.$Detail->Attribute.'';
                                $Value = $Detail->AttributeValue;
                                if($Detail->Attribute == 'Rounds'){
                                    $Style='style="width:50%"';
                                    $InputName = 'Rounds';
                                }
                                if($Detail->Attribute == 'Reps'){
                                    $Style='style="float:left;width:50%;color:black;font-weight:bold;background-color:#ccff66"';
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
		
		
	$ThisRound = $Detail->RoundNo;
	$ThisExercise = $Detail->Exercise;
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


            return $html;
	}       
        
        function MyGymWOD()
        {
            $Html='';
            $Model = new WodModel;
            $DataObject = $Model->getGymWodWorkouts();
            if(count($DataObject) == 0){
                $Html='No data from your gym today';
            }else{
            foreach($DataObject as $Item){
                $Html.='<a href="#" onClick="getDetails(\''.$Item->WodId.'\',\''.$Item->WodType.'\')">Workout for '.date('d F Y',strtotime($Item->WodDate)).'</a><br/><br/>';
            }
            }
            return $Html;
        }
        
         function getMyGymFeed()
        {
            $Html='';
            $Model = new WodModel;
            $DataObject = $Model->getMyGymFeed();
            foreach($DataObject as $Data){
                $Html .= '';
            }
            return $Html;
        }       

	function getStopWatch()
    {
	$RoundNo = 0;
        $ExerciseId = 63;
        $TimeToComplete = '00:00:0';
        $StartStopButton = 'Start';
        if(isset($_REQUEST[''.$ExerciseId.'___TimeToComplete'])){
            $TimeToComplete = $_REQUEST[''.$ExerciseId.'___TimeToComplete'];
            if($TimeToComplete != '00:00:0')
                $StartStopButton = 'Stop';
        }
	$Html ='<br/><input type="text" id="clock" name="'.$ExerciseId.'___TimeToComplete[]" value="'.$TimeToComplete.'" readonly/>';
	$Html.='<input id="startstopbutton" class="buttongroup" type="button" onClick="startstop();" value="'.$StartStopButton.'"/>';
	$Html.='<input id="resetbutton" class="buttongroup" type="button" onClick="resetclock();" value="Reset"/>';
        $Html.='<input class="buttongroup" type="button" onclick="wodsubmit();" value="Save"/>';

        return $Html;
    }
    
    function getWeight($exerciseId)
    {
		$RENDER = new Image();
		$Save = $RENDER->NewImage('save.png', SCREENWIDTH);
        $Html='<form name="form" action="index.php">
        <input type="hidden" name="module" value="wod"/>
		<input type="hidden" name="action" value="save"/>
        <input type="hidden" name="wodtype" value="'.$_REQUEST['wodtype'].'"/>
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
        <input type="hidden" name="module" value="wod"/>
		<input type="hidden" name="action" value="save"/>
        <input type="hidden" name="wodtype" value="'.$_REQUEST['wodtype'].'"/>
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
        $Html.='<input class="buttongroup" type="button" onClick="wodsubmit();" value="Save"/>';
		
        return $Html;
    }
}
?>