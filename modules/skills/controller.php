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
        
        function Message()
        {
            $Model = new SkillsModel;
            $Message = $Model->Log();

            return $Message;
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
                $Activity = 'Box Jumps';
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
                $Activity = 'Box Jumps';
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
                $Activity = 'Box Jumps';
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
                $Activity = 'Box Jumps';
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
                        $Attributes['Weight'] = "73";
                    }
                }else{
                    if($Model->getSystemOfMeasure() == 'Metric'){
                        $Attributes['Weight'] = "24";
                    }else{
                        $Attributes['Weight'] = "53";
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
            $Model = new SkillsModel();
            $Html='<div data-role="collapsible-set" data-iconpos="right">';
            if($level == 1){
                $Activity = 'Sit-Ups';
                $Attributes['Reps'] = "30";  
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Knees to Chest';
                $Attributes['Reps'] = "10";  
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Hold L';
                $Attributes['Duration'] = "00:10:0";      
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
            }else if($level == 2){
                $Activity = 'Knees to Elbow';
                $Attributes['Reps'] = "15";  
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Hold L';
                $Attributes['Duration'] = "00:30:0";  
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Squats Overhead';
                $Attributes['Reps'] = "15";   
                $Attribute['Weight'] = 'Bodyweight';
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
            }else if($level == 3){
                $Activity = 'Straight Leg Raise';
                $Attributes['Reps'] = "20";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Hold L';
                $Attributes['Duration'] = "01:00:0"; 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Squats Overhead';
                $Attributes['Reps'] = "15";   
                $Attribute['Weight'] = 'Bodyweight';
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
            }else if($level == 4){
                $Activity = 'Hold L';
                $Attributes['Duration'] = "01:30:0"; 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Squats Overhead';
                $Attributes['Reps'] = "15";   
                $Attribute['Weight'] = 'Bodyweight';
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Leg Lever';
                $Attributes['Reps'] = "1";
                $Attributes['Duration'] = "00:15:0"; 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
            }   
            $Html.='</div>';
            return $Html;           
        }
        
        function getWork($level)
        {
            $Model = new SkillsModel();
            $Html='<div data-role="collapsible-set" data-iconpos="right">';
            if($level == 1){
                $Activity = 'Cindy';
                $Attributes['Rounds'] = "7";  
                $Attributes['TimeToComplete'] = "20:00:0";  
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Baseline';
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "06:15:0"; 
                }else{
                    $Attributes['TimeToComplete'] = "07:30:0";
                }   
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Wall Ball';
                $Attributes['Reps'] = "25"; 
                if($Model->getGender() == 'M'){
                    if($Model->getSystemOfMeasure() == 'Metric'){
                        $Attributes['Weight'] = "6";
                    }else{
                        $Attributes['Weight'] = "13";
                    }
                }else{
                    if($Model->getSystemOfMeasure() == 'Metric'){
                        $Attributes['Weight'] = "3";
                    }else{
                        $Attributes['Weight'] = "7";
                    }                   
                } 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Kettlebell Swings';
                $Attributes['Reps'] = "25"; 
                if($Model->getGender() == 'M'){
                    if($Model->getSystemOfMeasure() == 'Metric'){
                        $Attributes['Weight'] = "24";
                    }else{
                        $Attributes['Weight'] = "53";
                    }
                }else{
                    if($Model->getSystemOfMeasure() == 'Metric'){
                        $Attributes['Weight'] = "16";
                    }else{
                        $Attributes['Weight'] = "35";
                    }                   
                } 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Row'; 
                if($Model->getSystemOfMeasure() == 'Metric'){
                    $Attributes['Distance'] = "2";
                }else{
                    $Attributes['Distance'] = "1.24";
                }
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "08:10:0";
                }else{
                    $Attributes['TimeToComplete'] = "09:30:0";                   
                } 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Run'; 
                if($Model->getSystemOfMeasure() == 'Metric'){
                    $Attributes['Distance'] = "5";
                }else{
                    $Attributes['Distance'] = "3.1";
                }
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "25:00:0";
                }else{
                    $Attributes['TimeToComplete'] = "28:00:0";                   
                } 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
            }else if($level == 2){
                $Activity = 'Jackie';  
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "12:00:0";
                }else{
                    $Attributes['TimeToComplete'] = "15:00:0";                   
                }   
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Baseline';
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "05:15:0"; 
                }else{
                    $Attributes['TimeToComplete'] = "06:30:0";
                }   
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Thrusters';
                $Attributes['Reps'] = "15"; 
                $Attributes['Weight'] = "Bodyweight"; 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Snatch Kettle Bell';
                $Attributes['Reps'] = "30"; 
                if($Model->getGender() == 'M'){
                    if($Model->getSystemOfMeasure() == 'Metric'){
                        $Attributes['Weight'] = "24";
                    }else{
                        $Attributes['Weight'] = "53";
                    }
                }else{
                    if($Model->getSystemOfMeasure() == 'Metric'){
                        $Attributes['Weight'] = "16";
                    }else{
                        $Attributes['Weight'] = "35";
                    }                   
                } 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Row'; 
                if($Model->getSystemOfMeasure() == 'Metric'){
                    $Attributes['Distance'] = "2";
                }else{
                    $Attributes['Distance'] = "1.24";
                }
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "07:30:0";
                }else{
                    $Attributes['TimeToComplete'] = "08:30:0";                   
                } 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Run'; 
                if($Model->getSystemOfMeasure() == 'Metric'){
                    $Attributes['Distance'] = "5";
                }else{
                    $Attributes['Distance'] = "3.1";
                }
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "22:30:0";
                }else{
                    $Attributes['TimeToComplete'] = "25:30:0";                   
                } 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
            }else if($level == 3){
                $Activity = 'Fran';  
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "05:00:0";
                }else{
                    $Attributes['TimeToComplete'] = "07:30:0";                   
                }   
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Baseline';
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "04:30:0"; 
                }else{
                    $Attributes['TimeToComplete'] = "05:35:0";
                }   
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Thrusters';
                $Attributes['Reps'] = "15"; 
                $Attributes['Weight'] = "Bodyweight"; 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Snatch Kettle Bell';
                $Attributes['Reps'] = "30"; 
                if($Model->getGender() == 'M'){
                    if($Model->getSystemOfMeasure() == 'Metric'){
                        $Attributes['Weight'] = "24";
                    }else{
                        $Attributes['Weight'] = "53";
                    }
                }else{
                    if($Model->getSystemOfMeasure() == 'Metric'){
                        $Attributes['Weight'] = "16";
                    }else{
                        $Attributes['Weight'] = "35";
                    }                   
                } 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Row'; 
                if($Model->getSystemOfMeasure() == 'Metric'){
                    $Attributes['Distance'] = "5";
                }else{
                    $Attributes['Distance'] = "3.1";
                }
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "19:00:0";
                }else{
                    $Attributes['TimeToComplete'] = "22:00:0";                   
                } 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Run'; 
                if($Model->getSystemOfMeasure() == 'Metric'){
                    $Attributes['Distance'] = "5";
                }else{
                    $Attributes['Distance'] = "3.1";
                }
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "19:00:0";
                }else{
                    $Attributes['TimeToComplete'] = "22:00:0";                   
                } 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
            }else if($level == 4){
                $Activity = 'Fran';  
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "03:00:0";
                }else{
                    $Attributes['TimeToComplete'] = "05:00:0";                   
                }   
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Baseline';
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "03:55:0"; 
                }else{
                    $Attributes['TimeToComplete'] = "04:40:0";
                }   
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Thrusters';
                $Attributes['Reps'] = "15"; 
                $Attributes['Weight'] = "Bodyweight"; 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Clean & Jerk';
                $Attributes['Reps'] = "150"; 
                if($Model->getGender() == 'M'){
                    if($Model->getSystemOfMeasure() == 'Metric'){
                        $Attributes['Weight'] = "24";
                    }else{
                        $Attributes['Weight'] = "53";
                    }
                }else{
                    if($Model->getSystemOfMeasure() == 'Metric'){
                        $Attributes['Weight'] = "16";
                    }else{
                        $Attributes['Weight'] = "35";
                    }                   
                } 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Row'; 
                if($Model->getSystemOfMeasure() == 'Metric'){
                    $Attributes['Distance'] = "5";
                }else{
                    $Attributes['Distance'] = "3.1";
                }
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "17:00:0";
                }else{
                    $Attributes['TimeToComplete'] = "20:00:0";                   
                } 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Run'; 
                if($Model->getSystemOfMeasure() == 'Metric'){
                    $Attributes['Distance'] = "5";
                }else{
                    $Attributes['Distance'] = "3.1";
                }
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "17:00:0";
                }else{
                    $Attributes['TimeToComplete'] = "20:00:0";                   
                } 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
            }   
            $Html.='</div>';
            return $Html;            
        }
        
        function getSpeed($level)
        {
            $Model = new SkillsModel();
            $Html='<div data-role="collapsible-set" data-iconpos="right">';
            if($level == 1){
                $Activity = 'Double Unders';
                $Attributes['Reps'] = "1";  
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Snatches';
                $Attributes['Reps'] = "10";  
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Run'; 
                if($Model->getSystemOfMeasure() == 'Metric'){
                    $Attributes['Distance'] = "400m";
                }else{
                    $Attributes['Distance'] = "437";
                }
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "02:04:0";
                }else{
                    $Attributes['TimeToComplete'] = "02:14:0";                   
                } 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Row'; 
                if($Model->getSystemOfMeasure() == 'Metric'){
                    $Attributes['Distance'] = "500m";
                }else{
                    $Attributes['Distance'] = "547";
                }
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "01:55:0";
                }else{
                    $Attributes['TimeToComplete'] = "02:20:0";                   
                } 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Rope Jump';
                $Attributes['Reps'] = "100";  
                $Attributes['TimeToComplete'] = "01:00:0";       
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
            }else if($level == 2){
                $Activity = 'Double Unders';
                $Attributes['Reps'] = "15";  
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Snatches';
                $Attributes['Reps'] = "10";  
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Run'; 
                if($Model->getSystemOfMeasure() == 'Metric'){
                    $Attributes['Distance'] = "400m";
                }else{
                    $Attributes['Distance'] = "437";
                }
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "01:34:0";
                }else{
                    $Attributes['TimeToComplete'] = "01:44:0";                   
                } 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Row'; 
                if($Model->getSystemOfMeasure() == 'Metric'){
                    $Attributes['Distance'] = "500m";
                }else{
                    $Attributes['Distance'] = "547";
                }
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "01:45:0";
                }else{
                    $Attributes['TimeToComplete'] = "02:00:0";                   
                } 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Snatches';
                $Attributes['Reps'] = "1";  
                $Attributes['Weight'] = "Bodyweight";     
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
            }else if($level == 3){
                $Activity = 'Double Unders';
                $Attributes['Reps'] = "50";  
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Run'; 
                if($Model->getSystemOfMeasure() == 'Metric'){
                    $Attributes['Distance'] = "400m";
                }else{
                    $Attributes['Distance'] = "437";
                }
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "01:19:0";
                }else{
                    $Attributes['TimeToComplete'] = "01:29:0";                   
                } 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Row'; 
                if($Model->getSystemOfMeasure() == 'Metric'){
                    $Attributes['Distance'] = "500m";
                }else{
                    $Attributes['Distance'] = "547";
                }
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "01:32:0";
                }else{
                    $Attributes['TimeToComplete'] = "01:50:0";                   
                } 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Snatches';
                $Attributes['Reps'] = "1";  
                $Attributes['Weight'] = "Bodyweight";     
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Rope Jump';
                $Attributes['Reps'] = "150";  
                $Attributes['TimeToComplete'] = "01:00:0";     
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
            }else if($level == 4){
                $Activity = 'Rope Jump Crossover';
                $Attributes['Reps'] = "120"; 
                $Attributes['TimeToComplete'] = "01:00:0";
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Run'; 
                if($Model->getSystemOfMeasure() == 'Metric'){
                    $Attributes['Distance'] = "400m";
                }else{
                    $Attributes['Distance'] = "437";
                }
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "01:04:0";
                }else{
                    $Attributes['TimeToComplete'] = "01:14:0";                   
                } 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Row'; 
                if($Model->getSystemOfMeasure() == 'Metric'){
                    $Attributes['Distance'] = "500m";
                }else{
                    $Attributes['Distance'] = "547";
                }
                if($Model->getGender() == 'M'){
                    $Attributes['TimeToComplete'] = "01:40:0";
                }else{
                    $Attributes['TimeToComplete'] = "01:25:0";                   
                } 
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Snatches';
                $Attributes['Reps'] = "1";  
                $Attributes['Weight'] = "Bodyweight";     
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
                $Activity = 'Double Unders Crossover';
                $Attributes['Reps'] = "50";       
                $Html .= $this->DrawActivity($Activity, $Attributes);
                $Attributes = array();
            }   
            $Html.='</div>';
            return $Html;            
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
                $UnitOfMeasureId = '';
                $UOM = '';
                if($Attribute == 'TimeToComplete'){$AttributeDisplay = 'Time';}else{$AttributeDisplay = $Attribute;}
                if(substr($Val, -1) == 'm'){
                $UOM = 'm';
                $Val = str_replace('m','',$Val);
                }else if(substr($Val, -10) != 'Bodyweight'){
                $UOM = $Model->getUserUnitOfMeasure($Attribute);
                }
                $UnitOfMeasureId = $Model->getUnitOfMeasureId($Attribute);
                if($UnitOfMeasureId == '')
                    $UnitOfMeasureId = 0;
                $Html.=''.$AttributeDisplay.' : <span id="1_'.$ExerciseId.'_'.$Attribute.'_html">'.$Val.''.$UOM.'</span>';
                $Html.='<input type="hidden" id="1_'.$ExerciseId.'_'.$Attribute.'" name="1_'.$ExerciseId.'_'.$Attribute.'_'.$UnitOfMeasureId.'_1" value=""/>';
                $i++;
            }
            $Html.='</h2>';
            $j=0;
            $Html .= '<div class="ActivityAttributes"><form id="1_1_1_'.$ExerciseId.'" name="1_1_1_'.$ExerciseId.'">';
            //var_dump($Attributes);
            foreach($Attributes as $Attribute=>$Val){
                $UnitOfMeasureId = '';
                $UOM = '';
                if($Attribute == 'TimeToComplete'){$AttributeDisplay = 'Time';}else{$AttributeDisplay = $Attribute;}
                if(substr($Val, -1) == 'm'){
                $UOM = 'm';
                $Val = str_replace('m','',$Val);
                }else if(substr($Val, -10) != 'Bodyweight'){
                $UOM = $Model->getUserUnitOfMeasure($Attribute);
                }
                $UnitOfMeasureId = $Model->getUnitOfMeasureId($Attribute);
                if($UnitOfMeasureId == '')
                    $UnitOfMeasureId = 0;   
                if($j > 0)
                    $TheseAttributes.='_';
                $TheseAttributes.=$Attribute;
                $Html .= '<div style="float:left;margin:0 25px 0 25px"">'.$AttributeDisplay.'';
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
            $Html .= '<div style="float:left;margin:10px 0 10px 20px"><input class="buttongroup" data-mini="true" type="button" id="" name="timebtn" onClick="EnterActivityTime(\'skills\', \'1_1_'.$ExerciseId.'_TimeToComplete_0_1\');" value="Add Time"/></div>';
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
}
?>