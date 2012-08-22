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
		$LevelOneHtml = '<'.$this->Wall.'br/>Level 1:<'.$this->Wall.'br/>';
		$LevelTwoHtml = '<'.$this->Wall.'br/>Level 2:<'.$this->Wall.'br/>';
        $LevelThreeHtml = '<'.$this->Wall.'br/>Level 3:<'.$this->Wall.'br/>';
		$LevelFourHtml = '<'.$this->Wall.'br/>Level 4:<'.$this->Wall.'br/>';
	foreach($ChosenExercise as $Exercise){

				if($Exercise->LevelOneValue != null){
					$LevelOneHtml .= ''.$Exercise->Attribute.': '.$Exercise->LevelOneValue.'<'.$this->Wall.'br/>';
				}
				if($Exercise->LevelTwoValue != null){
					$LevelTwoHtml .= ''.$Exercise->Attribute.': '.$Exercise->LevelTwoValue.'<'.$this->Wall.'br/>';
				}
				if($Exercise->LevelThreeValue != null){
					$LevelThreeHtml .= ''.$Exercise->Attribute.': '.$Exercise->LevelThreeValue.'<'.$this->Wall.'br/>';	
				}
				if($Exercise->LevelFourValue != null){
					$LevelFourHtml .= ''.$Exercise->Attribute.': '.$Exercise->LevelFourValue.'<'.$this->Wall.'br/>';
				}	
		}
		$html .= ''.$LevelOneHtml.''.$LevelTwoHtml.''.$LevelThreeHtml.''.$LevelFourHtml.'';
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