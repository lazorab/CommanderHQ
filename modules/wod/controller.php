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
        if($_REQUEST['action'] == 'save'){
				$this->Save();
        }

		return $this->TopSelection();
		
		if(isset($_REQUEST['wodtype'])){
			return $this->Output();
		}
	}
	
	function TopSelection()
	{
		$Html='<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">';
		if($_REQUEST['wodtype'] == '2'){
			$Html.='<li>My Gym</li>';
		}else{
			$Html.='<li><a href="#" onclick="OpenThisPage(\'?module=baseline&origin=wod&baseline=Baseline\')">Baseline</a></li>
				<li><a href="#" onclick="OpenThisPage(\'?module=benchmark&origin=wod\')">Benchmarks</a></li>
				<li><a href="#" onclick="OpenThisPage(\'?module=custom&origin=wod\')">Custom</a></li>
				<li><a href="#" onclick="OpenThisPage(\'?module=wod&wodtype=2\')">My Gym</a></li>';
		}
		$Html.='</ul>';
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
		$RENDER = new Image(SITE_ID);
		$Model = new WodModel;
        if($_REQUEST['action'] == 'savecustom'){
		//validate
            $exerciseId = $Model->SaveCustom();
			$WODdata .= $this->CustomDetails($exerciseId);
        }
		else if($_REQUEST['wodtype'] == '1'){//custom
            $MemberCustomExercises = $Model->getMemberCustomExercises();
            if(isset($_REQUEST['customexercise']) && $_REQUEST['customexercise'] != 'new'){
                $WODdata .= $this->CustomDetails($_REQUEST['customexercise']);               
            }
            else if(count($MemberCustomExercises) > 0 && $_REQUEST['customexercise'] != 'new'){
               $WODdata .= '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
					<li><a href="" onclick="getCustomExercise(\'new\');">Create New Exercise</a></li>';
	
                foreach($MemberCustomExercises AS $Exercise){
					$WODdata .= '<li><a href="" onclick="getCustomExercise('.$Exercise->recid.');">'.$Exercise->ActivityName.':<br/>'.$Exercise->Description.'</a></li>';
                }	
				
				$WODdata .= '</ul>';

            }
            if(count($MemberCustomExercises) == 0 || $_REQUEST['customexercise'] == 'new'){
                $CustomTypes = $Model->getCustomTypes();
				$WODdata .= '<form action="index.php" id="test" name="form">
                <input type="hidden" name="module" value="wod"/>
                <input type="hidden" name="wodtype" value="1"/>
				<input type="hidden" name="action" value="savecustom"/>
				<input type="text" name="newcustom" placeholder="Exercise Name"/><br/><br/>
					<div data-role="controlgroup">';
                foreach($CustomTypes AS $Type){
					$WODdata .= '<input type="radio" name="customtype" id="radio-choice-'.$Type->recid.'" value="'.$Type->recid.'" />
								<label for="radio-choice-'.$Type->recid.'">'.$Type->ActivityType.'</label>';
                }	
				$WODdata .= '</div>
				<button type="submit" data-theme="b" name="submit" value="submit-value">Next</button>
				</form><br/>';
				
            }
		}
		else if($_REQUEST['wodtype'] == '2'){//my gym
			//check for registered gym
			$Gym = $this->MemberGym();
			if(!$Gym){//must register gym
				header('location: index.php?module=registergym');	
			}
			else{//show details:
				$WODdata .= 'Gym Name: '.$Gym->GymName.'<br/>';
				if($Gym->Country != '')
					$WODdata .= 'Country: '.$Gym->Country.'<br/>';
				if($Gym->Region != '')
					$WODdata .= 'Region: '.$Gym->Region.'<br/>';
				if($Gym->TelNo != '')
					$WODdata .= 'TelNo: '.$Gym->TelNo.'<br/>';
				if($Gym->Email != '')
					$WODdata .= 'Email: '.$Gym->Email.'<br/>';
				$WODdata .= 'URL: '.$Gym->URL.'<br/>';
			}	
		}
		else if($_REQUEST['wodtype'] == '3'){//benchmarks
		
			$Benchmarks = $Model->getBenchmarks();	

               $WODdata .= '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d" data-icon="none">';
                foreach($Benchmarks AS $Exercise){
					$Description = str_replace('{br}',' | ',$Exercise->Description);
					$WODdata .= '<li>
                        <a href="" onclick="getBenchmark('.$Exercise->recid.');">'.$Exercise->ActivityName.':<br/><span style="font-size:small">'.$Description.'</span></a>
                    </li>';
                }	
				$WODdata .= '</ul><br/>';

		}
		else if(isset($_REQUEST['benchmark'])){
			$Benchmark = $Model->getBenchmark($_REQUEST['benchmark']);
            $WODdata .='<div id="bmdescription">';
            $WODdata .= str_replace('{br}','<br/>',$Benchmark->Description);
            $WODdata .='</div>';
            $WODdata .= $this->getStopWatch($_REQUEST['benchmark']);        
		}		
		return $WODdata;
	}
    
	function MemberGym()
	{
        $Model = new WodModel;
        $MemberGym = $Model->getMemberGym();	
		return $MemberGym;
	}
	
    function CustomDetails($Id)
    {
        $Model = new WodModel;
        $Details = $Model->getCustomDetails($Id);
        $WODdata = '<div style="text-align:center"><h3>'.$Details->ActivityName.'</h3></div>';
        if($Details->ActivityType == 'Timed'){
            $WODdata.= $this->getStopWatch($Details->recid); 
        }
        else if($Details->ActivityType == 'AMRAP'){
			
            $WODdata .= $this->getCountDown($Details);
        }
        else if($Details->ActivityType == 'Weight'){
            $WODdata .= $this->getWeight($Details->recid);
        }
        else if($Details->ActivityType == 'Reps'){
            $WODdata .= $this->getReps($Details->recid);
        }
        else if($Details->ActivityType == 'Tabata'){
            $WODdata .= $this->getTabata($Details);
        }
        else if($Details->ActivityType == 'Other'){
            $WODdata .= '?';
        }
        return $WODdata;
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