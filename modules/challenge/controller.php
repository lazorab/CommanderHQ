<?php
class ChallengeController extends Controller
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
                $Display = 'Challenges';
            }
            $Html='<li>'.$Display.'</li>';
            return $Html;
	}
        
        function getTopSelection()
        {
            $Html='';
            $Model = new ChallengeModel;
            $ChallengeDetails = $Model->getTopSelection();
            if(count($ChallengeDetails) == 0){
            $Gym = $this->MemberGym();
            $Html = $Gym->GymName;
            }else{
            $Description = $Model->ChallengeDescription($ChallengeDetails[0]->ChallengeId);
            $Html .= 'Challenge For '.date("D d M Y", strtotime($ChallengeDetails[0]->ChallengeDate)).':<br/><span style="font-size:small">'.$Description.'</span>';
            }
            return $Html;           
        }
	
	function ChallengeDetails()
	{
            $Model = new ChallengeModel;
            $Challenge = $Model->getChallengeDetails();
            return $Challenge;
	}
        
        function Message()
        {
            $Model = new ChallengeModel;
            $Message = $Model->Log();

            return $Message;
        }
	
	function Output()
	{
                //check for registered gym
                $Gym = $this->MemberGym();
                if(!$Gym){//must register gym
                    $ChallengeData = 'Must First Register Gym!';
		}else{
                    $ChallengeData=$this->WorkoutDetails();  
		}	
	
            return $ChallengeData;
	}
    
	function MemberGym()
	{
            $Model = new ChallengeModel;
            $MemberGym = $Model->getMemberGym();	
            return $MemberGym;
	}
        
 	function MyGymFeed()
	{
            $Html='';
            $Model = new ChallengeModel;
            $GymFeed = $Model->getMyGymFeed();
            $i = 0;
            foreach($GymFeed AS $Item)
            {
                if($i > 0)
                    $Html.='<a href="#" onClick="getDetails(\''.urlencode($Item->ChallengeDate).'\')">'.$Item->ChallengeDate.'</a><br/><br/>';
                $i++;
            }
            return $Html;
	}      
        
  	function WorkoutDetails()
	{
            $html='';
            $Model = new ChallengeModel;
            $ChallengeDetails = $Model->getChallengeDetails();
            
            if(count($ChallengeDetails) == 0){
                $html='No challenges at present';
            }else{
                //$this->getTopSelection();
            //var_dump($ChallengeDetails);
	$html='<form name="form" id="challengeform" action="index.php">';
        $html.='<input type="hidden" name="form" value="submitted"/>';
        $html.='<input type="hidden" name="ChallengeId" value="'.$ChallengeDetails[0]->Id.'"/>'; 
        $html.='<p>'.$ChallengeDetails[0]->Notes.'</p>';
        $html .= '<div data-role="collapsible-set" data-iconpos="right">';
        $i = 0;
        $ThisRound = '';
	$ThisExerciseId = 0;
        //var_dump($this->Workout);
	foreach($ChallengeDetails as $Detail){
            if($Detail->UnitOfMeasureId == null){
                $UnitOfMeasureId = 0;
                $ConversionFactor = 1;
            }else{
                $UnitOfMeasureId = $Detail->UnitOfMeasureId;
                $ConversionFactor = $Detail->ConversionFactor;
            }
            if($Detail->AttributeValue == ''){
                $AttributeValue = 'Max ';
            }else{
                $AttributeValue = $Detail->AttributeValue * $ConversionFactor;
            }
		if($Detail->Attribute != 'TimeToComplete'){
			
			if($Detail->TotalRounds > 1 && $Detail->RoundNo > 0 && $ThisRound != $Detail->RoundNo){
                            if($ThisExerciseId != null && $i > 0){
                                $html.='</h2><p style="color:red">'.$this->getExerciseHistory("".$ThisRound."_".$ThisExerciseId."").'</p></div><br/><br/>';
                            }                           	
                            $html.= '<h2>Round '.$Detail->RoundNo.'</h2>';
                            $html.= '<div data-role="collapsible">';
                            $html.= '<h2>'.$Detail->Exercise.'<br/>';             
			}
			else if($ThisExerciseId != $Detail->ExerciseId){

                            if($ThisExerciseId != null && $i > 0){
                                $html.='</h2><p style="color:red">'.$this->getExerciseHistory("".$ThisRound."_".$ThisExerciseId."").'</p></div>';
                            }       
                            $html.= '<div data-role="collapsible">';
                            $html.= '<h2>'.$Detail->Exercise.'<br/>';                           
                        }else{
                            $html.=' | ';
                        }
                        $html.=''.$Detail->Attribute.' : <span id="'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_'.$Detail->Attribute.'_html">'.$AttributeValue.'</span>'.$Detail->UnitOfMeasure.'';
                        $html.='<input type="hidden" id="'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_'.$Detail->Attribute.'" name="'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_'.$Detail->Attribute.'_'.$UnitOfMeasureId.'_'.$Detail->OrderBy.'"';
                        if($AttributeValue == 'Max '){
                            $html.='placeholder="'.$AttributeValue.'" value="">';
                        }else{
                            $html.='value="'.$AttributeValue.'">';
                        }                       
                }
	$ThisRound = $Detail->RoundNo;
	$ThisExerciseId = $Detail->ExerciseId;
        $i++;
	}
                            if($ThisExerciseId != null && $i > 0){
                                $html.='</h2><p style="color:red">'.$this->getExerciseHistory("".$ThisRound."_".$ThisExerciseId."").'</p></div>';
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
            $Model = new ChallengeModel;
            $ExerciseHistory = $Model->getExerciseHistory($ThisExerciseId);
            //var_dump($ExerciseHistory);
            if(count($ExerciseHistory) == 0){
                $Html.='No History for activity';
            }
            $i=0;
            $j=0;
            $TheseAttributes='';
            $Attributes = $Model->getExerciseIdAttributes($ThisExerciseId);
            $NumAttributes = count($Attributes);
            foreach($ExerciseHistory as $Detail){
                if($i < 3){
                    $Html.=''.$Detail->Attribute.' : '.$Detail->AttributeValue.''.$Detail->UnitOfMeasure.'';
                    $j++;
                    if($j == $NumAttributes){
                        $Html.='<br/>';
                        $j = 0;
                        $i++;
                    }else{
                        $Html.=' | ';
                    }
                }
            }
            $i=0;
            $Html .= '<div class="ActivityAttributes">';
            foreach($Attributes as $Attribute){
                if($i > 0)
                    $TheseAttributes.='_';
                $TheseAttributes.=$Attribute->Attribute;
                $Html .= '<div style="float:left;margin:0 10px 0 10px"">'.$Attribute->Attribute.'<input size="9" type="number" id="'.$ThisExercise.'_'.$Attribute->Attribute.'_new" name="" placeholder="'.$Attribute->UOM.'"/></div>';
                $i++;
            }

            $Html .= '<div style="float:right;margin:10px 20px 10px 0"><input class="buttongroup" type="button" id="" name="btn" onClick="UpdateActivity(\''.$ThisExercise.'\', \''.$TheseAttributes.'\');" value="Update"/></div>';
            $Html .= '</div><div class="clear"></div>';
            
            return $Html;
        }         
        
        function MyGymChallenge()
        {
            $Html='';
            $Model = new ChallengeModel;
            $DataObject = $Model->getGymChallengeWorkouts();
            if(count($DataObject) == 0){
                $Html='No data from your gym today';
            }else{
            foreach($DataObject as $Item){
                $Html.='<a href="#" onClick="getDetails(\''.$Item->ChallengeId.'\',\''.$Item->ChallengeType.'\')">Workout for '.date('d F Y',strtotime($Item->ChallengeDate)).'</a><br/><br/>';
            }
            }
            return $Html;
        }
        
         function getMyGymFeed()
        {
            $Html='';
            $Model = new ChallengeModel;
            $DataObject = $Model->getMyGymFeed();
            foreach($DataObject as $Data){
                $Html .= '';
            }
            return $Html;
        }       
    
    function getWeight($exerciseId)
    {
		$RENDER = new Image();
		$Save = $RENDER->NewImage('save.png', SCREENWIDTH);
        $Html='<form name="form" action="index.php">
        <input type="hidden" name="module" value="challenge"/>
		<input type="hidden" name="action" value="save"/>
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
        $Html.='<input class="buttongroup" type="button" onClick="challengesubmit();" value="Save"/>';
		
        return $Html;
    }
}
?>