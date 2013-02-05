<?php
class MygymController extends Controller
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
                $Display = $this->getTopSelection();
            }else{
                $Display = 'Workout Of the Day';
            }
            $Html='<li>'.$Display.'</li>';
            return $Html;
	}
        
        function getTopSelection()
        {
            $Html='';
            $Model = new MygymModel;
            $WodDetails = $Model->getTopSelection();
            if(count($WodDetails) == 0){
            $Gym = $this->MemberGym();
            $Html = $Gym->GymName;
            }else{
            $Description = $Model->WodDescription($WodDetails[0]->WodId);
            $Html .= 'Workout For '.date("D d M Y", strtotime($WodDetails[0]->WodDate)).':<br/><span style="font-size:small">'.$Description.'</span>';
            }
            return $Html;           
        }
	
	function WodDetails()
	{
            $Model = new MygymModel;
            $WOD = $Model->getWOD();
            return $WOD;
	}
        
        function Message()
        {
            $Model = new MygymModel;
            $Message = $Model->Log();

            return $Message;
        }
	
	function Output()
	{
                $Gym = $this->MemberGym();
                if(!$Gym){//must register gym
                    $WODdata = 'Must First Register Gym!';
		}else{          
                    $WODdata = '<div data-role="navbar">
            <ul>
                <li><a href="#" data-role="tab" onClick="Tabs(\'1\');" class="ui-btn-active">Well Rounded</a></li>
                <li><a href="#" data-role="tab" onClick="Tabs(\'2\');">Advanced</a></li>
            </ul>
        </div>
                        <div id="tab1"> 
    <div class="ui-grid-c">
    <div class="ui-block-a"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#3f2b44" value="Weight" readonly="readonly"/></div>
    <div class="ui-block-b"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#66486e" value="Height" readonly="readonly"/></div>
    <div class="ui-block-c"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#6f747a" value="Distance" readonly="readonly"/></div>
    <div class="ui-block-d"><input type="text" data-role="none" style="width:80%;color:black;font-weight:bold;background-color:#ccff66" value="Reps" readonly="readonly"/></div>
    </div>                              
                                '.$this->WorkoutDetails('2').'
                                </div>   
                                <div id="tab2"> 
    <div class="ui-grid-c">
    <div class="ui-block-a"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#3f2b44" value="Weight" readonly="readonly"/></div>
    <div class="ui-block-b"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#66486e" value="Height" readonly="readonly"/></div>
    <div class="ui-block-c"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#6f747a" value="Distance" readonly="readonly"/></div>
    <div class="ui-block-d"><input type="text" data-role="none" style="width:80%;color:black;font-weight:bold;background-color:#ccff66" value="Reps" readonly="readonly"/></div>
    </div>                                
                                '.$this->WorkoutDetails('4').'
                                </div>';                
		}	
	
            return $WODdata;
	}
    
	function MemberGym()
	{
            $Model = new MygymModel;
            $MemberGym = $Model->getMemberGym();	
            return $MemberGym;
	}
        
 	function MyGymFeed()
	{
            $Html='';
            $Model = new MygymModel;
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
        
  	function WorkoutDetails($type)
	{
            $html='';
            $Model = new MygymModel;
            $WodDetails = $Model->getWODDetails($type);
            if(count($WodDetails) == 0){
                $html='No data from your gym today';
            }else{
                //$this->getTopSelection();
	$Clock = '';
	$Bhtml = '';
	$Chtml = '';
	$html.='<form name="form" id="wodform" action="index.php">
            <input type="hidden" name="form" value="submitted"/>  
            <input type="hidden" name="WorkoutId" value="'.$WodDetails[0]->WodId.'"/>'; 
        $html.='<input type="checkbox" name="baseline" value="yes" data-role="none"/>';
        $html.='Make this my baseline';
        $html.='<p>'.$WodDetails[0]->Notes.'</p>';
        $html.='<div class="ui-grid-b">';
        $ThisRound = '';
		$ThisExercise = '';
                //var_dump($WodDetails);
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
			if($this->SystemOfMeasure() != 'Metric'){
                            $AttributeValue = round($Detail->AttributeValue * $Detail->ConversionFactor, 2);                                             
                        }else{
                            $AttributeValue = $Detail->AttributeValue;
                        }	
				if($Detail->Attribute == 'Distance'){
                                    $Style='style="float:left;width:50%;color:white;font-weight:bold;background-color:#6f747a"';
                                // * 1.09                                              
				}		
				else if($Detail->Attribute == 'Weight'){
                                    $Style='style="float:left;width:50%;color:white;font-weight:bold;background-color:#3f2b44"';
                                //2.20
				}
				else if($Detail->Attribute == 'Height'){
                                    $Style='style="float:left;width:50%;color:white;font-weight:bold;background-color:#66486e"';
                                //0.39
				}

				$Bhtml.='<div class="ui-block-b">';
				$Bhtml.='<input data-role="none" '.$Style.' type="number" data-inline="true" name="'.$RoundNo.'___'.$Detail->ExerciseId.'___'.$Detail->Attribute.'" value="'.$AttributeValue.'"/><span style="float:left">'.$Detail->UOM.'</span>';
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
            }

            return $html;
	}       
        
        function MyGymWOD()
        {
            $Html='';
            $Model = new MygymModel;
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
            $Model = new MygymModel;
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
        if(isset($_REQUEST['0___63___TimeToComplete'])){
            $TimeToComplete = $_REQUEST['0___63___TimeToComplete'];
            if($TimeToComplete != '00:00:0')
                $StartStopButton = 'Stop';
        }
	$Html ='<br/><input type="text" id="clock" name="0___63___TimeToComplete" value="'.$TimeToComplete.'" readonly/>';
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