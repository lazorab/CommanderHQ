<?php
class SkillsController extends Controller
{
	var $Message='';
	
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_COOKIE['UID']))
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
            if(isset($_REQUEST['category'])){
                $Html = '<h2>Skills Level '.$_REQUEST['level'].'</h2>';
                $Html .= '<h2>'.$_REQUEST['category'].'</h2>';
                if($_REQUEST['category'] == 'Hips'){
                    $Html.= $this->getHips($_REQUEST['level']);
                }else if($_REQUEST['category'] == 'Push'){
                    $Html.= $this->getPush($_REQUEST['level']);
                }else if($_REQUEST['category'] == 'Pull'){
                    $Html.= $this->getPull($_REQUEST['level']);
                }else if($_REQUEST['category'] == 'Core'){
                    $Html.= $this->getCore($_REQUEST['level']);
                }else if($_REQUEST['category'] == 'Work'){
                    $Html.= $this->getWork($_REQUEST['level']);
                }else if($_REQUEST['category'] == 'Speed'){
                    $Html.= $this->getSpeed($_REQUEST['level']);
                }
                }else if(isset($_REQUEST['level'])){
                $Html = '<h2>Skills Level '.$_REQUEST['level'].'</h2>';
                $Html .= '<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="getSkills(\'Hips\', \''.$_REQUEST['level'].'\');"><div style="height:26px;width:1px;float:left"></div>Hips<br/><span style="font-size:small"></span></a></li>             
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="getSkills(\'Push\', \''.$_REQUEST['level'].'\');"><div style="height:26px;width:1px;float:left"></div>Push<br/><span style="font-size:small"></span></a></li>
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="getSkills(\'Pull\', \''.$_REQUEST['level'].'\');"><div style="height:26px;width:1px;float:left"></div>Pull<br/><span style="font-size:small"></span></a></li>            
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="getSkills(\'Core\', \''.$_REQUEST['level'].'\');"><div style="height:26px;width:1px;float:left"></div>Core<br/><span style="font-size:small"></span></a></li>
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="getSkills(\'Work\', \''.$_REQUEST['level'].'\');"><div style="height:26px;width:1px;float:left"></div>Work<br/><span style="font-size:small"></span></a></li>            
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="getSkills(\'Speed\', \''.$_REQUEST['level'].'\');"><div style="height:26px;width:1px;float:left"></div>Speed<br/><span style="font-size:small"></span></a></li>
                </ul>';
                }else{
                $Html ='<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="getCategories(\'1\');"><div style="height:26px;width:1px;float:left"></div>Level I<br/><span style="font-size:small"></span></a></li>             
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="getCategories(\'2\');"><div style="height:26px;width:1px;float:left"></div>Level II<br/><span style="font-size:small"></span></a></li>
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="getCategories(\'3\');"><div style="height:26px;width:1px;float:left"></div>Level III<br/><span style="font-size:small"></span></a></li>            
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="getCategories(\'4\');"><div style="height:26px;width:1px;float:left"></div>Level IV<br/><span style="font-size:small"></span></a></li>
                </ul>';
            }

            return $Html;
	}
        
        function getHips($level)
        {
            $Model = new SkillsModel();
            $Html='<div data-role="collapsible-set" data-iconpos="right">';
            if($level == 1){
                $Activity = 'Air Squats';
                $Attributes['Reps'] = ($Model->getGender() == 'M') ? "50" : "50";  
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Deadlift';
                $Attributes['Weight'] = "Bodyweight";  
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Box Jump';
                $Attributes['Reps'] = "1";
                if($Model->getGender() == 'M'){
                    if($Model->getSystemOfMeasure() == 'Metric'){
                        $Attributes['Height'] = "60";
                    }else{
                        $Attributes['Height'] = "24";
                    }
                }else{
                    if($Model->getSystemOfMeasure() == 'Metric'){
                        $Attributes['Height'] = "40";
                    }else{
                        $Attributes['Height'] = "16";
                    }                   
                }       
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
            }else if($level == 2){
                $Activity = 'Air Squats';
                $Attributes['Reps'] = "100";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Squats';
                $Attributes['Reps'] = "1";
                $Attributes['Weight'] = "Bodyweight";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Deadlift';
                $Attributes['Reps'] = "1";
                $Attributes['Weight'] = "Bodyweight";  
                $Html .= $this->DrawActivity($Activity, $Attributes); 
                $Attributes = array();
                $Activity = 'Box Jump';
                $Attributes['Reps'] = "15";
                if($Model->getGender() == 'M'){
                    if($Model->getSystemOfMeasure() == 'Metric'){
                        $Attributes['Height'] = "60";
                    }else{
                        $Attributes['Height'] = "24";
                    }
                }else{
                    if($Model->getSystemOfMeasure() == 'Metric'){
                        $Attributes['Height'] = "40";
                    }else{
                        $Attributes['Height'] = "16";
                    }                   
                }       
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
            }else if($level == 3){
                $Activity = 'Pistols';
                $Attributes['Reps'] = "10";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Squats';
                $Attributes['Reps'] = "1";
                $Attributes['Weight'] = "Bodyweight";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Deadlift';
                $Attributes['Reps'] = "1";
                $Attributes['Weight'] = "2xBodyweight";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Box Jump';
                $Attributes['Reps'] = "25";
                if($Model->getGender() == 'M'){
                    if($Model->getSystemOfMeasure() == 'Metric'){
                        $Attributes['Height'] = "60";
                    }else{
                        $Attributes['Height'] = "24";
                    }
                }else{
                    if($Model->getSystemOfMeasure() == 'Metric'){
                        $Attributes['Height'] = "40";
                    }else{
                        $Attributes['Height'] = "16";
                    }                   
                }       
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
            }else if($level == 4){
                $Activity = 'Pistols';
                $Attributes['Reps'] = "25";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Squats';
                $Attributes['Reps'] = "1";
                $Attributes['Weight'] = "2xBodyweight";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Deadlift';
                $Attributes['Reps'] = "1";
                $Attributes['Weight'] = "2xBodyweight";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Box Jump';
                $Attributes['Reps'] = "30";
                if($Model->getGender() == 'M'){
                    if($Model->getSystemOfMeasure() == 'Metric'){
                        $Attributes['Height'] = "60";
                    }else{
                        $Attributes['Height'] = "24";
                    }
                }else{
                    if($Model->getSystemOfMeasure() == 'Metric'){
                        $Attributes['Height'] = "40";
                    }else{
                        $Attributes['Height'] = "16";
                    }                   
                }       
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
            }   
            $Html.='</div>';
            return $Html;
        }
        
        function getPush($level)
        {
            $Model = new SkillsModel();
            $Html='<div data-role="collapsible-set" data-iconpos="right">';
            if($level == 1){
                $Activity = 'Push-Ups';
                $Attributes['Reps'] = "10";  
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Dips';
                if($Model->getGender() == 'M'){
                $Attributes['Reps'] = "3";  
                }else{
                $Attributes['Reps'] = "1"; 
                }
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Press';
                $Attributes['Reps'] = "1";
                $Attributes['Weight'] = "Bodyweight";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
            }else if($level == 2){
                $Activity = 'Push-Ups';
                if($Model->getGender() == 'M'){
                $Attributes['Reps'] = "30";  
                }else{
                $Attributes['Reps'] = "20"; 
                }
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Dips';
                if($Model->getGender() == 'M'){
                $Attributes['Reps'] = "20";  
                }else{
                $Attributes['Reps'] = "10"; 
                }
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Handstand Hold';
                $Attributes['Reps'] = "1";  
                $Html .= $this->DrawActivity($Activity, $Attributes); 
                $Attributes = array();
                $Activity = 'Press Bench';
                $Attributes['Reps'] = "1";
                $Attributes['Weight'] = "Bodyweight";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Press';
                $Attributes['Reps'] = "1";
                $Attributes['Weight'] = "Bodyweight";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();  
                $Activity = 'Dips';
                $Attributes['Reps'] = "1";
                $Attributes['Weight'] = "1/3xBodyweight";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();               
            }else if($level == 3){
                $Activity = 'Push-Ups Ring';
                if($Model->getGender() == 'M'){
                $Attributes['Reps'] = "40";  
                }else{
                $Attributes['Reps'] = "25"; 
                }
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Push-Ups Handstand';
                if($Model->getGender() == 'M'){
                $Attributes['Reps'] = "10";  
                }else{
                $Attributes['Reps'] = "5"; 
                }
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Dips Ring';
                if($Model->getGender() == 'M'){
                $Attributes['Reps'] = "30";  
                }else{
                $Attributes['Reps'] = "20"; 
                }  
                $Html .= $this->DrawActivity($Activity, $Attributes); 
                $Attributes = array();
                $Activity = 'Press Bench';
                $Attributes['Reps'] = "1";
                $Attributes['Weight'] = "Bodyweight";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Press';
                $Attributes['Reps'] = "1";
                $Attributes['Weight'] = "Bodyweight";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();  
                $Activity = 'Dips';
                $Attributes['Reps'] = "1";
                $Attributes['Weight'] = "1xBodyweight";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
            }else if($level == 4){
                $Activity = 'Push-Ups Ring';
                if($Model->getGender() == 'M'){
                $Attributes['Reps'] = "60";  
                }else{
                $Attributes['Reps'] = "40"; 
                }
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Push-Ups Handstand';
                if($Model->getGender() == 'M'){
                $Attributes['Reps'] = "20";  
                }else{
                $Attributes['Reps'] = "10"; 
                }
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Dips Ring';
                if($Model->getGender() == 'M'){
                $Attributes['Reps'] = "50";  
                }else{
                $Attributes['Reps'] = "30"; 
                }  
                $Html .= $this->DrawActivity($Activity, $Attributes); 
                $Attributes = array();
                $Activity = 'Press Bench';
                $Attributes['Reps'] = "1";
                $Attributes['Weight'] = "Bodyweight";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Press';
                $Attributes['Reps'] = "1";
                $Attributes['Weight'] = "Bodyweight";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();  
                $Activity = 'Dips';
                $Attributes['Reps'] = "1";
                $Attributes['Weight'] = "1xBodyweight";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
            }   
            $Html.='</div>';
            return $Html;            
        }
        
        function getPull($level)
        {
            $Model = new SkillsModel();
            $Html='<div data-role="collapsible-set" data-iconpos="right">';
            if($level == 1){
                $Activity = 'Static Hang';
                $Attributes['Duration'] = "00:03:0";  
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Pull-Ups';
                if($Model->getGender() == 'M'){
                    $Attributes['Reps'] = "3"; 
                }else{
                    $Attributes['Reps'] = "1";
                }
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'SDHP';
                $Attributes['Reps'] = "10";
                if($Model->getGender() == 'M'){
                    if($Model->getSystemOfMeasure() == 'Metric'){
                        $Attributes['Weight'] = "33";
                    }else{
                        $Attributes['Height'] = "73";
                    }
                }else{
                    if($Model->getSystemOfMeasure() == 'Metric'){
                        $Attributes['Height'] = "24";
                    }else{
                        $Attributes['Height'] = "53";
                    }                   
                }       
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
            }else if($level == 2){
                $Activity = 'Rope Climb';
                $Attributes['Reps'] = "2";
                $Attributes['Height'] = "3";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Cleans';
                $Attributes['Reps'] = "1";
                $Attributes['Weight'] = "Bodyweight";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Pull-Ups';
                $Attributes['Reps'] = "1";
                $Attributes['Weight'] = "1/3xBodyweight";  
                $Html .= $this->DrawActivity($Activity, $Attributes); 
                $Attributes = array();
                $Activity = 'Pull-Ups';
                if($Model->getGender() == 'M'){
                    $Attributes['Reps'] = "20"; 
                }else{
                    $Attributes['Reps'] = "15";
                }       
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Muscle Ups';
                $Attributes['Reps'] = "1";  
                $Html .= $this->DrawActivity($Activity, $Attributes); 
                $Attributes = array();               
            }else if($level == 3){
                $Activity = 'Pull-Ups';
                if($Model->getGender() == 'M'){
                    $Attributes['Reps'] = "40"; 
                }else{
                    $Attributes['Reps'] = "30";
                }
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Muscle Ups';
                $Attributes['Reps'] = "10";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Rope Climb';
                $Attributes['Reps'] = "2";
                $Attributes['Height'] = "3";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Cleans';
                $Attributes['Reps'] = "1";
                $Attributes['Weight'] = "Bodyweight";      
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Pull-Ups';
                $Attributes['Reps'] = "1";
                $Attributes['Weight'] = "Bodyweight";  
                $Html .= $this->DrawActivity($Activity, $Attributes); 
                $Attributes = array();               
            }else if($level == 4){
                $Activity = 'Pull-Ups';
                if($Model->getGender() == 'M'){
                    $Attributes['Reps'] = "40"; 
                }else{
                    $Attributes['Reps'] = "30";
                }
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Muscle Ups';
                $Attributes['Reps'] = "15";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Rope Climb';
                $Attributes['Reps'] = "4";
                $Attributes['Height'] = "3";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Cleans';
                $Attributes['Reps'] = "1";
                $Attributes['Weight'] = "Bodyweight";      
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Pull-Ups';
                $Attributes['Reps'] = "1";
                $Attributes['Weight'] = "Bodyweight";  
                $Html .= $this->DrawActivity($Activity, $Attributes); 
                $Attributes = array();
            }   
            $Html.='</div>';
            return $Html;            
        }
        
        function getCore($level)
        {
           
        }
        
        function getWork($level)
        {
            
        }
        
        function getSpeed($level)
        {
            
        }        
	
        function DrawActivity($Activity, $Attributes){
            $Model = new SkillsModel();
            $ExerciseId = $Model->getExerciseId($Activity);
            
            $Html='<div data-role="collapsible">';
            $Html.='<h2>'.$Activity.'<br/>';
            $i=0;
            foreach($Attributes as $Attribute=>$Val){
                if($i > 0){
                   $Html.=' | '; 
                }
                if(substr($Val, -10) != 'Bodyweight')
                $UOM = $Model->getUserUnitOfMeasure($Attribute);
                $UnitOfMeasureId = $Model->getUnitOfMeasureId($Attribute);
                if($UnitOfMeasureId == '')
                    $UnitOfMeasureId = 0;
                $Html.=''.$Attribute.' : <span id="1_'.$ExerciseId.'_'.$Attribute.'_html">'.$Val.''.$UOM.'</span>';
                $Html.='<input type="hidden" id="1_'.$ExerciseId.'_'.$Attribute.'" name="1_'.$ExerciseId.'_'.$Attribute.'_'.$UnitOfMeasureId.'_1" value=""/>';
                $i++;
            }
            $Html.='</h2>';
            $j=0;
            $Html .= '<div class="ActivityAttributes"><form id="1_1_1_'.$ExerciseId.'" name="1_1_1_'.$ExerciseId.'">';
            //var_dump($Attributes);
            foreach($Attributes as $Attribute=>$Val){
                $UOM = $Model->getUserUnitOfMeasure($Attribute);
                $UnitOfMeasureId = $Model->getUnitOfMeasureId($Attribute);
                if($UnitOfMeasureId == '')
                    $UnitOfMeasureId = 0;   
                if($j > 0)
                    $TheseAttributes.='_';
                $TheseAttributes.=$Attribute;
                $Html .= '<div style="float:left;margin:0 25px 0 25px"">'.$Attribute.'';
                if($UOM != '')
                $Html .= '('.$UOM.')';
                $Html .= '<br/><input ';
                if($Val == 'Max')
                    $Html .= 'value="" placeholder="'.$Val.'"'; 
                else      
                    $Html .= 'value="'.$Val.'"'; 
                $Html .= ' style="width:60px" type="number" id="1_1_'.$ExerciseId.'_'.$Attribute.'_new" name="1_1_'.$ExerciseId.'_'.$Attribute.'_'.$UnitOfMeasureId.'_1"/></div>';
                $j++;
            }
            
            $Html .= '<input type="hidden" id="1_1_'.$ExerciseId.'_TimeToComplete_0_1" name="1_1_'.$ExerciseId.'_TimeToComplete_0_1" value=""/>';
            $Html .= '<div class="clear"></div>';
            $Html .= '<div style="width:100%">';
            $Html .= '<div style="float:left;margin:10px 0 10px 20px"><input class="buttongroup" data-mini="true" type="button" id="" name="timebtn" onClick="EnterActivityTime(\'1_1_'.$ExerciseId.'_TimeToComplete_0_1\');" value="Add Time"/></div>';
            $Html .= '<div style="float:right;margin:10px 20px 10px 0"><input class="buttongroup" type="button" id="" name="btn" data-mini="true" onClick="SaveTheseResults(\'0_0\', \'1_1_1_'.$ExerciseId.'\');" value="Add Results"/></div>';
            $Html .= '</div>';
            $Html .= '</form></div>';            
            $Html.='</div>';
            $Html .= '<div class="clear"></div>';  
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