<?php
class BaselineController extends Controller
{
	var $Baseline;
	
	function __construct()
	{
		parent::__construct();
		session_start();
		if($_REQUEST['action'] == 'save')
			if(!isset($_SESSION['UID'])){
				header('location: index.php?module=login');	
			}else{
				$this->Save();
			}
	}
    
    function Save()
	{
		$Model = new BaselineModel;
		$Save = $Model->Log();
	}
	
	function Output()
	{
		$Model = new BaselineModel;
        $RENDER = new Image(SITE_ID);
		$html='<br/>
        <h3>Baseline Workout</h3>';
		
		if(isset($_REQUEST['id']))
		{
            $html.='details';
		}
		else
		{
           $Baselines = $Model->getMemberBaselines();
           if(count($Baselines) > 0)
           {
           $html.='<form id="selectform">
           <label for="baseline">Baseline</label>
           <select id="baselineselect" name="baselineselect"  onchange="getCustomContent(this.value);">
           <option value="">Please Select</option>';
                foreach($Baselines as $Baseline){//select form
                    $Detail = $Model->getBaselineDetails($Baseline);
                    $html.='<option value="'.$Detail->ExerciseId.'">'.$Detail->ExerciseName.'</option>';
                }
           $html.= '</select></form><br/><br/><br/>';
           }
           else{
            $html.='You have no baselines set<br/>
               <form name="baselinetype" action="index.php" method="post" id="selectform">
               <input type="hidden" name="module" value="baseline"/>
               <label for="baseline">New Baseline</label>
                   <select id="newbaseline" name="newbaseline" onchange="this.form.submit();">
                   <option value="">Please Select</option>
                   <option value="benchmark"';
                   if($_REQUEST['newbaseline'] == 'benchmark')
                       $html.=' selected="selected"';
                   $html.='>Benchmark Workout</option>
                   <option value="custom"';
               if($_REQUEST['custom'] == 'benchmark')
                   $html.=' selected="selected"';               
               $html.='>Custom</option>
                   </select></form><br/><br/><br/>';
           }
           if(isset($_REQUEST['newbaseline'])){
                if($_REQUEST['newbaseline'] == 'benchmark'){
                    $html.='<form name="benchmarkselect" action="index.php" method="post" id="selectform">
                    <input type="hidden" name="module" value="baseline"/>
                    <label for="benchmark">Benchmark</label>
                        <select id="benchmark" name="benchmark"  onchange="this.form.submit();">
                        <option value="">Please Select</option>';
                    $Benchmarks = $Model->getBenchmarks();
                    foreach($Benchmarks as $Benchmark){
                        $html.='<option value="'.$Benchmark->Id.'">'.$Benchmark->ExerciseName.'</option>';
                    }
                    $html.= '</select></form><br/><br/><br/>';
                }
                else if($_REQUEST['newbaseline'] == 'custom'){
                    $Options = $Model->getCustomOptions();
                    foreach($Options as $Option){
                        $html.=''.$Option->Attribute.'';
                    }                        
                }
            }
            else if(isset($_REQUEST['benchmark'])){
                $BaselineId = $Model->setMemberBaseline();
                $Benchmark = $Model->getBenchmarkDetails($_REQUEST['benchmark']);
                $Start = $RENDER->Image('start.png', SCREENWIDTH);
                $Stop = $RENDER->Image('stop.png', $this->Device->GetScreenWidth());
                $Reset = $RENDER->Image('report.png', $this->Device->GetScreenWidth());
                $Save = $RENDER->Image('save.png', $this->Device->GetScreenWidth());
    
                $html.='<div id="bmdescription">';
                $html.= $Benchmark->Description;
                $html.='</div>';
                $html.='<form name="clockform" action="index.php">
                <input type="hidden" name="module" value="baseline"/>
                <input type="hidden" name="BaselineId" value="'.$BaselineId.'"/>
                <input type="hidden" name="action" value="save"/>
                <input id="clock" name="TimeToComplete" value="00:00:0"/>
                </form>	
                <div style="margin:0 30% 0 30%; width:50%">
                <img alt="Start" src="'.$Start.'" onclick="start()"/>&nbsp;&nbsp;
                <img alt="Stop" src="'.$Stop.'" onclick="stop()"/><br/><br/>
                <img alt="Reset" src="'.$Reset.'" onclick="reset()"/>&nbsp;&nbsp;
                <img alt="Save" src="'.$Save.'" onclick="save()"/>
                </div><br/><br/>';                
            }
		}
				
		return $html;
	}
}
?>