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

            if($_REQUEST['level'] == 1){
                $Html = '<img '.$RENDER->NewImage('AthleticLevel1.png').' src="'.IMAGE_RENDER_PATH.'AthleticLevel1.png"/><br/><br/>';
                }else if($_REQUEST['level'] == 2){
                $Html = '<img '.$RENDER->NewImage('AthleticLevel2.png').' src="'.IMAGE_RENDER_PATH.'AthleticLevel2.png"/><br/><br/>';
                }else if($_REQUEST['level'] == 3){
                $Html = '<img '.$RENDER->NewImage('AthleticLevel3.png').' src="'.IMAGE_RENDER_PATH.'AthleticLevel3.png"/><br/><br/>';
                }else if($_REQUEST['level'] == 4){
                $Html = '<img '.$RENDER->NewImage('AthleticLevel4.png').' src="'.IMAGE_RENDER_PATH.'AthleticLevel4.png"/><br/><br/>';
            }else{
                $Html ='<div style="padding:2%">
                <ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="getSkills(\'1\');"><div style="height:26px;width:1px;float:left"></div>Level I<br/><span style="font-size:small"></span></a></li>             
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="getSkills(\'2\');"><div style="height:26px;width:1px;float:left"></div>Level II<br/><span style="font-size:small"></span></a></li>
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="getSkills(\'3\');"><div style="height:26px;width:1px;float:left"></div>Level III<br/><span style="font-size:small"></span></a></li>            
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="getSkills(\'4\');"><div style="height:26px;width:1px;float:left"></div>Level IV<br/><span style="font-size:small"></span></a></li>
                </ul>
                </div>';
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