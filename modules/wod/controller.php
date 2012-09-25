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
            if($_REQUEST['topselection'] == 'mygym'){
                $Gym = $this->MemberGym();
                $Html.='<li>My Gym: '.$Gym->GymName.'</li>';
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
            $Model = new WodModel;

            if($_REQUEST['wod'] == 'display'){//my gym
                //check for registered gym
                $Gym = $this->MemberGym();
                if(!$Gym){//must register gym
                    header('location: index.php?module=registergym');	
		}
		else{//show details:
                    $WODdata .='<h2>Workout for '.date('d M Y').'</h2>';
                    $WODdata .= $this->getMyGymWOD();
		}	
            }		
            return $WODdata;
	}
    
	function MemberGym()
	{
            $Model = new WodModel;
            $MemberGym = $Model->getMemberGym();	
            return $MemberGym;
	}
        
        function getMyGymWOD()
        {
            $Html='';
            $Model = new WodModel;
            $DataObject = $Model->getMyGymWOD();
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