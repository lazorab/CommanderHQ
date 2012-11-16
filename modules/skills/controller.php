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
        $Html = '<form name="skillsform" id="skillsform" action="index.php" method="post">
                <input type="hidden" name="module" value="skills"/>
                <select id="exerciseselect" name="exercise" class="select" onchange="getImages(this.value);">
                <option value="">Select Exercise</option>';

        $Selected = '';

        foreach($Exercises as $Exercise){
            if($_REQUEST['exercise'] == $Exercise->Id)
                $Selected =' selected="selected"';
            $Html .= '<option value="'.$Exercise->Exercise.'"'.$Selected.'>'.$Exercise->Exercise.'</option>';
        } 
        $Html .= '</select></form><br/>';   
        return $Html;
    }
    
     function getExerciseTypes()
    {
        $Html = '<form name="skillsform" id="skillsform" action="index.php" method="post">
                <input type="hidden" name="module" value="skills"/>
                <select id="exerciseselect" name="exercisetype" class="select" onchange="getImages(this.value);">
                <option value="">Select Exercise Type</option>';
            $Selected ='';
            if($_REQUEST['exercisetype'] == 'Core')
                $Selected =' selected="selected"';
            $Html .= '<option value="Core"'.$Selected.'>Core</option>';
             $Selected ='';
            if($_REQUEST['exercisetype'] == 'Hips')
                $Selected =' selected="selected"';           
            $Html .= '<option value="Hips"'.$Selected.'>Hips</option>';
             $Selected ='';
            if($_REQUEST['exercisetype'] == 'Pull')
                $Selected =' selected="selected"';           
            $Html .= '<option value="Pull"'.$Selected.'>Pull</option>';
             $Selected ='';
            if($_REQUEST['exercisetype'] == 'Push')
                $Selected =' selected="selected"';           
            $Html .= '<option value="Push"'.$Selected.'>Push</option>';
             $Selected ='';
            if($_REQUEST['exercisetype'] == 'Speed')
                $Selected =' selected="selected"';           
            $Html .= '<option value="Speed"'.$Selected.'>Speed</option>';
             $Selected ='';
            if($_REQUEST['exercisetype'] == 'Work')
                $Selected =' selected="selected"';           
            $Html .= '<option value="Work"'.$Selected.'>Work</option>';
         
        $Html .= '</select></form><br/>';   
        return $Html;
    }   
	
	function Output()
	{
            $RENDER = new Image();
            $Html=$this->getExerciseTypes();
            if(isset($_REQUEST['exercisetype'])){
                
                 $Level1Image = ''.$RENDER->NewImage('Level 1 '.$_REQUEST['exercisetype'].'.png').' src="'.IMAGE_RENDER_PATH.'Level 1 '.$_REQUEST['exercisetype'].'.png"';
                $Level2Image = ''.$RENDER->NewImage('Level 2 '.$_REQUEST['exercisetype'].'.png').' src="'.IMAGE_RENDER_PATH.'Level 2 '.$_REQUEST['exercisetype'].'.png"';
                $Level3Image = ''.$RENDER->NewImage('Level 3 '.$_REQUEST['exercisetype'].'.png').' src="'.IMAGE_RENDER_PATH.'Level 3 '.$_REQUEST['exercisetype'].'.png"';
                $Level4Image = ''.$RENDER->NewImage('Level 4 '.$_REQUEST['exercisetype'].'.png').' src="'.IMAGE_RENDER_PATH.'Level 4 '.$_REQUEST['exercisetype'].'.png"';
      $Html.='<div id="slides">';
      $Html.='  <div class="slides_container">';
       $Html.='     <div class="slide">';
        $Html.='        <img alt="Level1" '.$Level1Image.'/>';
        $Html.='    </div>';
        $Html.='    <div class="slide">';
        $Html.='        <img alt="Level2" '.$Level2Image.'/>';
        $Html.='    </div>';
        $Html.='    <div class="slide">';
         $Html.='       <img alt="Level3" '.$Level3Image.'/>';
          $Html.='  </div>';
         $Html.='   <div class="slide">';
         $Html.='       <img alt="Level4" '.$Level4Image.'/>';
          $Html.='  </div>  ';         
       $Html.=' </div>';
       $Html.=' <a href="#" class="prev"><img src="'.IMAGE_RENDER_PATH.'arrow-next.png" width="36" height="36" alt="Arrow Prev"></a>';
        $Html.='<a href="#" class="next"><img src="'.IMAGE_RENDER_PATH.'arrow-prev.png" width="36" height="36" alt="Arrow Next"></a>';
    $Html.='</div>';             
            }

            return $Html;
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