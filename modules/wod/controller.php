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
                    //$Model = new WodModel;
                    //$GymFeed = $Model->getMyGymFeed();
                   // $Html='<li>'.$GymFeed[0]->WodDate.'</li>';
                    $Gym = $this->MemberGym();
                    $Html='<li>'.$Gym->GymName.'</li>';
                }else{
                    $Html='<li>'.$_REQUEST['topselection'].'</li>';
                }
            }else{
                $Html='<li>Workout Of the Day</li>';                   
            }
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
            $WODdata = '';

            if($_REQUEST['wod'] == 'display'){//my gym
                //check for registered gym
                $Gym = $this->MemberGym();
                if(!$Gym){//must register gym
                    header('location: index.php?module=registergym');	
		}
		else{//show details:
                    //$WODdata .='<h2>Workout for '.date('d M Y').'</h2>';
                    $WODdata .= $this->MyGymWOD();
		}	
            }else if(isset($_REQUEST['Workout'])){
                $WODdata .= $this->WorkoutDetails();
            }else{
                $WODdata='
                <ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="OpenThisPage(\'?module=baseline&origin=wod&baseline=Baseline\')"><div style="height:26px;width:1px;float:left"></div>Baseline</a></li>
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="OpenThisPage(\'?module=benchmark&origin=wod\')"><div style="height:26px;width:1px;float:left"></div>Benchmarks</a></li>
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="OpenThisPage(\'?module=custom&origin=wod\')"><div style="height:26px;width:1px;float:left"></div>Custom</a></li>
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="getWOD();"><div style="height:26px;width:1px;float:left"></div>My Gym</a></li>                
                </ul><br/>';              
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
            $Html='';
            $Model = new WodModel;
            $WodDetails = $Model->getWODDetails();
            $Html.=$WodDetails[0]->WorkoutName;
            $Html.='<br/>';
            $Html.=$WodDetails[0]->WorkoutDescription;
            return $Html;
	}       
        
        function MyGymWOD()
        {
            $Html='';
            $Model = new WodModel;
            $DataObject = $Model->getGymWodWorkouts();
            foreach($DataObject as $Item){
                $Html.='<a href="#" onClick="getDetails(\''.$Item->WodId.'\')">Workout for '.date('d F Y',strtotime($Item->WodDate)).'</a><br/><br/>';
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

	function getStopWatch($ExerciseId)
    {
		$RoundNo = 0;
		$Html.='<form name="clockform" action="index.php">';
        $Html.='<input type="hidden" name="module" value="wod"/>';
        $Html.='<input type="hidden" name="wodtype" value="'.$_REQUEST['wodtype'].'"/>';
        $Html.='<input type="hidden" name="action" value="save"/>';
		$Html.='<input type="text" id="clock" name="'.$RoundNo.'___'.$ExerciseId.'___TimeToComplete" value="00:00:0"/>';
		$Html.='<input class="buttongroup" type="button" onclick="startstop()" value="Start/Stop"/>';
		$Html.='<input class="buttongroup" type="button" onclick="reset()" value="Reset"/>';
		$Html.='<input class="buttongroup" type="submit" value="Save"/>';
        
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
    
    function getCountDown($Details)
    {
        $RENDER = new Image();
        $Start = $RENDER->NewImage('start.png', SCREENWIDTH);
        $Stop = $RENDER->NewImage('stop.png', SCREENWIDTH);
        $Reset = $RENDER->NewImage('report.png', SCREENWIDTH);
        $Save = $RENDER->NewImage('save.png', SCREENWIDTH);
        $WODdata='<form name="clockform" action="index.php">
        <input type="hidden" name="module" value="wod"/>
        <input type="hidden" name="wodtype" value="'.$_REQUEST['wodtype'].'"/>
        <input type="hidden" name="exercise" value="'.$Details->recid.'"/>
        <input type="hidden" name="action" value="save"/>
		<input type="hidden" name="CountDown" value="'.$Details->AttributeValue.'"/>
		<input type="hidden" name="Rounds" id="rounds" value="0"/>
        <input id="clock" name="timer" value="'.$Details->AttributeValue.'"/>
        </form>	
        <div style="margin:0 30% 0 30%; width:50%">
        <img alt="Start" '.$Start.' src="'.ImagePath.'start.png" onclick="startcountdown(document.clockform.timer.value)"/>&nbsp;&nbsp;
        <img alt="Stop" '.$Stop.' src="'.ImagePath.'stop.png" onclick="stopcountdown()"/><br/><br/>
        <img alt="Reset" '.$Reset.' src="'.ImagePath.'reset.png" onclick="resetcountdown(\''.$Details->AttributeValue.'\')"/>&nbsp;&nbsp;
        <img alt="Save" '.$Save.' src="'.ImagePath.'save.png" onclick="save()"/>
        </div><br/>
		<ul data-role="listview" id="listview" data-inset="true">
			<li><a href="" onclick="countclicks();">+ Rounds <span class="ui-li-count">0</span></a></li>
		</ul>
		<br/>';
        
        return $WODdata;
    }
}
?>