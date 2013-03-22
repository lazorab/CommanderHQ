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
                <li style="width:48%"><a href="#" onClick="Tabs(\'1\');" class="ui-btn-active">Well Rounded</a></li>
                <li style="width:48%"><a href="#" onClick="Tabs(\'2\');">Advanced</a></li>
            </ul>
        </div><div id="tab1"> ';

         $WODdata .= '<div id="details1"></div>
                                </div>   
                                <div id="tab2"> ';

          $WODdata .= ' <div id="details2"></div>
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
        $i = 0;
	$html.='<form name="form" id="wodform" action="index.php">';
         $html.='<input type="hidden" name="WorkoutId" value="'.$WodDetails[0]->WodId.'"/>'; 
        //$html.='<input type="checkbox" name="baseline" value="yes" data-role="none"/>';
        //$html.='Make this my baseline';
        $html.='<p>'.$WodDetails[0]->Notes.'</p>';
        //$html.='<div class="ui-grid-b">';
        $html .= '<div data-role="collapsible-set" data-iconpos="right">';
        $ThisRoutine = '';
        $ThisRound = '';
        $ThisOrderBy = '';
	$ThisExerciseId = 0;
        //var_dump($WodDetails);
	foreach($WodDetails as $Detail){
            if($Detail->UnitOfMeasureId == null || $Detail->UnitOfMeasureId == 0){
                $UnitOfMeasureId = 0;
                $ConversionFactor = 1;
            }else{
                $UnitOfMeasureId = $Detail->UnitOfMeasureId;
                if($Detail->ConversionFactor == null || $Detail->ConversionFactor == 0){
                    $ConversionFactor = 1;
                }else{
                    $ConversionFactor = $Detail->ConversionFactor;
                }
            }
            if($Detail->AttributeValue == '' || $Detail->AttributeValue == 'Max'){
                $AttributeValue = '-';
            }else{
                $AttributeValue = $Detail->AttributeValue * $ConversionFactor;
            }            
		if($Detail->Attribute != 'TimeToComplete'){
			if($ThisRoutine != $Detail->RoutineNo){
                            if($ThisExerciseId != null && $i > 0){
                                $html.='</h2><p style="color:red">'.$this->getExerciseHistory("".$Detail->RoundNo."_".$ThisExerciseId."").'</p></div>';
                            }                           	
                            $html.= '<h2>Routine '.$Detail->RoutineNo.'</h2>';
                            if($Detail->TotalRounds > 1 && $Detail->RoundNo > 0){
                                $html.= '<h2>Round '.$Detail->RoundNo.'</h2>';
                            }
                            $html.= '<div data-role="collapsible">';
                            $html.= '<h2>'.$Detail->Exercise.'<br/>';             
			}
			else if($ThisRound != $Detail->RoundNo){
                            if($ThisExerciseId != null && $i > 0){
                                $html.='</h2><p style="color:red">'.$this->getExerciseHistory("".$Detail->RoundNo."_".$ThisExerciseId."").'</p></div>';
                            }     
                             if($Detail->TotalRounds > 1 && $Detail->RoundNo > 0){
                                $html.= '<h2>Round '.$Detail->RoundNo.'</h2>';
                            }                           
                            $html.= '<div data-role="collapsible">';
                            $html.= '<h2>'.$Detail->Exercise.'<br/>';             
			}
			else if($ThisExerciseId != $Detail->ExerciseId || $ThisOrderBy != $Detail->OrderBy){
                            if($ThisExerciseId != null && $i > 0){
                                $html.='</h2><p style="color:red">'.$this->getExerciseHistory("".$Detail->RoundNo."_".$ThisExerciseId."").'</p></div>';
                            }       
                            $html.= '<div data-role="collapsible">';
                            $html.= '<h2>'.$Detail->Exercise.'<br/>';                           
                        }else{
                            $html.=' | ';
                        }
                        $html.=''.$Detail->Attribute.' : <span id="'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_'.$Detail->Attribute.'_html">'.$AttributeValue.'</span>'.$Detail->UnitOfMeasure.'';
                        $html.='<input type="hidden" id="'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_'.$Detail->Attribute.'" name="'.$Detail->RoundNo.'_'.$Detail->ExerciseId.'_'.$Detail->Attribute.'_'.$UnitOfMeasureId.'_'.$Detail->OrderBy.'"';
                        if($AttributeValue == '-'){
                            $html.='placeholder="'.$AttributeValue.'" value="">';
                        }else{
                            $html.='value="'.$AttributeValue.'">';
                        }
                }
        $ThisRoutine = $Detail->RoutineNo;        
	$ThisRound = $Detail->RoundNo;
        $ThisOrderBy = $Detail->OrderBy;
	$ThisExerciseId = $Detail->ExerciseId;
        $i++;
	}
                            if($ThisExerciseId != null && $i > 0){
                                $html.='</h2><p style="color:red">'.$this->getExerciseHistory("".$Detail->RoundNo."_".$ThisExerciseId."").'</p></div>';
                            }             
    $html.='</div>';
    $html.=$this->getStopWatch();
    $html.='</form><br/><br/>';	
    $html.='<div class="clear"></div><br/>';
            }

            return $html;
	}    
        
        function getExerciseHistory($ThisExercise)
        {
            $Html='';
            $ExplodedExercise = explode('_',$ThisExercise);
            $ThisRoundNo = $ExplodedExercise[0];
            $ThisExerciseId = $ExplodedExercise[1];
            $Model = new MygymModel;
            $ExerciseHistory = $Model->getExerciseHistory($ThisExerciseId);
            //var_dump($ThisExerciseId);
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
                $Html .= '<div style="float:left;margin:0 25px 0 25px"">'.$Attribute->Attribute.'<br/><input style="width:80px" type="number" id="'.$ThisExercise.'_'.$Attribute->Attribute.'_new" name="" placeholder="'.$Attribute->UOM.'"/></div>';
                $i++;
            }

            $Html .= '<div style="float:right;margin:10px 30px 10px 0"><input class="buttongroup" type="button" id="" name="btn" onClick="UpdateActivity(\\\''.$ThisExercise.'\\\', \\\''.$TheseAttributes.'\\\');" value="Update"/></div>';
            $Html .= '</div><div class="clear"></div>';
            
            return $Html;
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
}
?>