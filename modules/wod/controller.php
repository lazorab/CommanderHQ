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
		else if($_REQUEST['wodtype'] == 1){//custom
/*		
		    $WODdata .= '
                <form action="index.php" id="test" name="form">
                <input type="hidden" name="module" value="wod"/>
                <input type="hidden" name="wodtype" value="1"/>';
*/				
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
/*				
                <select id="customexercises" name="customexercise" class="select" onchange="document.form.submit();">
                <option value="">Available Exercises</option>
				<option value="new"';
				if($_REQUEST['customexercise'] == 'new')
				$WODdata .= ' selected="selected"';
				$WODdata .= '>Create New</option>';
                foreach($MemberCustomExercises AS $Exercise){
                    $WODdata .= '<option value="'.$Exercise->recid.'"';
					if($_REQUEST['customexercise'] == $Exercise->recid)
						$WODdata .= ' selected="selected"';
					$WODdata .= '>'.$Exercise->ActivityName.'</option>';
                }
                $WODdata .= '</select><br/><br/>';
*/
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
/*
                $WODdata .= '
				<input type="hidden" name="action" value="savecustom"/>
                <input type="text" name="newcustom" placeholder="Exercise Name"/><br/>
                    <select id="customselect" name="customtype" class="select" onchange="document.form.submit();">
                    <option value="">Type</option>';
                    foreach($CustomTypes AS $Type){
                        $WODdata .= '<option value="'.$Type->recid.'">'.$Type->ActivityType.'</option>';
                    }
                $WODdata .= '</select>';    
*/				
            }
/*			
			$WODdata .= '</form><br/><br/>'; 
*/
		}
		else if($_REQUEST['wodtype'] == 2){//my gym
		
		}
		else if($_REQUEST['wodtype'] == 3){//benchmarks
			$Benchmarks = $Model->getBenchmarks();	
/*
            $ImageSize = $RENDER->NewImage('BM_Select.png', $this->Device->GetScreenWidth());
            $explode = explode('"',$ImageSize);
            $height = $explode[1];
			foreach($Benchmarks as $WOD)
			{
                $WODdata.='<div class="benchmark" style="height:'.$height.'px;">
                    <div style="width:70%;margin:4% 0 0 4%;float:left;font-size:large;background-color:#fff;">';
                $WODdata.=''.$WOD->ActivityName.'';
                $WODdata.='</div>
                    <div style="width:15%;margin:0 0.5% 1% 0;background-color:#fff;float:right">';
                $WODdata.='<img onclick="getBenchmark(\''.$WOD->recid.'\');" '.$ImageSize.' alt="'.$WOD->ActivityName.'" src="'.ImagePath.'BM_Select.png"/>';
                $WODdata.='</div>
                    </div>
                    <div class="clear"></div>';
            }
            $WODdata.='<br/>';
*/
               $WODdata .= '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d" data-icon="none">';
                foreach($Benchmarks AS $Exercise){
					$Description = str_replace('{br}',' | ',$Exercise->Description);
					$WODdata .= '<li><a href="" onclick="Benchmark('.$Exercise->recid.');">'.$Exercise->ActivityName.':<br/>'.$Description.'</a></li>';
                }	
				$WODdata .= '</ul><br/>';

		}
		else if(isset($_REQUEST['benchmark'])){
			$WOD = $Model->getBenchmark($_REQUEST['benchmark']);
            $WODdata.='<div id="bmdescription">';
            $WODdata.= $WOD->Description;
            $WODdata.='</div>';
            $WODdata.= $this->StopWatch(3, $_REQUEST['benchmark']);        
		}		
		return $WODdata;	
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
    
    function getStopWatch($exerciseId)
    {
        $RENDER = new Image(SITE_ID);
        $Start = $RENDER->NewImage('start.png', $this->Device->GetScreenWidth());
        $Stop = $RENDER->NewImage('stop.png', $this->Device->GetScreenWidth());
        $Reset = $RENDER->NewImage('report.png', $this->Device->GetScreenWidth());
        $Save = $RENDER->NewImage('save.png', $this->Device->GetScreenWidth());
        $WODdata='<form name="clockform" action="index.php">
        <input type="hidden" name="module" value="wod"/>
        <input type="hidden" name="wodtype" value="'.$_REQUEST['wodtype'].'"/>
        <input type="hidden" name="exercise" value="'.$exerciseId.'"/>
        <input type="hidden" name="action" value="save"/>
        <input id="clock" name="TimeToComplete" value="00:00:0"/>
        </form>	
        <div style="margin:0 30% 0 30%; width:50%">
        <img alt="Start" '.$Start.' src="'.ImagePath.'start.png" onclick="start()"/>&nbsp;&nbsp;
        <img alt="Stop" '.$Stop.' src="'.ImagePath.'stop.png" onclick="stop()"/><br/><br/>
        <img alt="Reset" '.$Reset.' src="'.ImagePath.'reset.png" onclick="reset()"/>&nbsp;&nbsp;
        <img alt="Save" '.$Save.' src="'.ImagePath.'save.png" onclick="document.clockform.submit();"/>
        </div><br/><br/>';
        
        return $WODdata;
    }
    
    function getWeight($exerciseId)
    {
		$RENDER = new Image(SITE_ID);
		$Save = $RENDER->NewImage('save.png', $this->Device->GetScreenWidth());
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
		$RENDER = new Image(SITE_ID);
		$Save = $RENDER->NewImage('save.png', $this->Device->GetScreenWidth());
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
        $RENDER = new Image(SITE_ID);
        $Start = $RENDER->NewImage('start.png', $this->Device->GetScreenWidth());
        $Stop = $RENDER->NewImage('stop.png', $this->Device->GetScreenWidth());
        $Reset = $RENDER->NewImage('report.png', $this->Device->GetScreenWidth());
        $Save = $RENDER->NewImage('save.png', $this->Device->GetScreenWidth());
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