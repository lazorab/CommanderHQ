<?php
class SkillsController extends Controller
{
	var $Message='';
	
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_SESSION['UID']))
			header('location: index.php?module=login');
	}
    
    function getExercises()
    {
		$Model = new SkillsModel;
        $Exercises = $Model->getExercises();
        return $Exercises;
    }
	
	function Output()
	{
		$Model = new SkillsModel;

            $html='';
		if(isset($_REQUEST['exercise']))
		{	
            $ChosenExercise = $Model->getExercise();
			//var_dump($ChosenExercise);
            $html .= 'Current Skills Level: '.$ChosenExercise[0]->CurrentSkillsLevel.'<'.$this->Wall.'br/>';

            //$ExerciseAttributes = $Model->getExerciseAttributes($_REQUEST['exercise']);

            $clock = '';
            $LevelOneHtml = '<div class="ui-block-a">Level 1:</div><div class="ui-block-b">';
            $LevelTwoHtml = '<div class="ui-block-a">Level 2:</div><div class="ui-block-b">';
            $LevelThreeHtml = '<div class="ui-block-a">Level 3:</div><div class="ui-block-b">';
            $LevelFourHtml = '<div class="ui-block-a">Level 4:</div><div class="ui-block-b">';
            foreach($ChosenExercise as $Exercise){
                
                if($Exercise->Attribute == 'TimeToComplete'){
                    $Attribute = 'Time';
                }else{
                    $Attribute = $Exercise->Attribute;
                }
                if($Exercise->Attribute == 'Weight' && $Exercise->LevelOneValue == '0.00'){
                    $html .= 'Body Weight';
                }else if($Exercise->Attribute == 'Weight' && $Exercise->LevelTwoValue == '0.00'){
                    $html .= 'Body Weight';
                }else if($Exercise->Attribute == 'Weight' && $Exercise->LevelThreeValue == '0.00'){
                    $html .= 'Body Weight';
                }else if($Exercise->Attribute == 'Weight' && $Exercise->LevelFourValue == '0.00'){
                    $html .= 'Body Weight';
                }else{
                    if($Exercise->LevelOneValue != null){
                        $LevelOneHtml .= ''.$Attribute.':</div><div class="ui-block-c">'.$Exercise->LevelOneValue.'</div><div class="ui-block-a"></div><div class="ui-block-b">';
                    }
                    if($Exercise->LevelTwoValue != null){
                        $LevelTwoHtml .= ''.$Attribute.':</div><div class="ui-block-c">'.$Exercise->LevelTwoValue.'</div><div class="ui-block-a"></div><div class="ui-block-b">';
                    }
                    if($Exercise->LevelThreeValue != null){
                        $LevelThreeHtml .= ''.$Attribute.':</div><div class="ui-block-c">'.$Exercise->LevelThreeValue.'</div><div class="ui-block-a"></div><div class="ui-block-b">';	
                    }
                    if($Exercise->LevelFourValue != null){
                        $LevelFourHtml .= ''.$Attribute.':</div><div class="ui-block-c">'.$Exercise->LevelFourValue.'</div><div class="ui-block-a"></div><div class="ui-block-b">';
                    }
                }
                
			
		}
		$html .= '<div class="ui-grid-b">'.$LevelOneHtml.'</div>'.$LevelTwoHtml.'</div>'.$LevelThreeHtml.'</div>'.$LevelFourHtml.'</div></div>';
}
else{
    $html = 'Select an exercise to view the breakdown of suggested skills levels';
}
        return $html;
	}
	
	function getStopWatch()
    {
		$Html.='<input type="text" id="clock" name="TimeToComplete" value="00:00:0"/>';
		$Html.='<input class="buttongroup" type="button" onclick="startstop();" value="Start/Stop"/>';
		$Html.='<input class="buttongroup" type="button" onclick="reset();" value="Reset"/>';
		$Html.='<input class="buttongroup" type="button" onclick="skillssubmit();" value="Save"/>';
        
        return $Html;
    }	
	
    function getCountDown()
    {
        $Html='<input type="text" id="clock" name="CountDown" value=""/>';
		$Html.='<input class="buttongroup" type="button" onclick="startstop()" value="Start/Stop"/>';
		$Html.='<input class="buttongroup" type="button" onclick="reset()" value="Reset"/>';
		
        return $Html;
    }	
	
	function Message()
	{
		return $this->Message;
	}
}
?>