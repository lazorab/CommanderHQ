<?php
class BaselineController extends Controller
{
	var $Baseline;
    var $SelectedBaseline;
	
	function __construct()
	{
		parent::__construct();
		session_start();
        if(!isset($_SESSION['UID'])){
            header('location: index.php?module=login');	
        }
        if($_REQUEST['save'] == 'workout'){
            $this->SaveWorkout();
        }
        if(isset($_REQUEST['baselineselect']))
            $this->SelectedBaseline = $_REQUEST['baselineselect'];
        else if($_REQUEST['save'] == 'newbaseline'){
            $this->SaveNewBaseline();
        }
	}
    
    function SaveWorkout()
	{
		$Model = new BaselineModel;
		$Save = $Model->Log();
	}
    
    function SaveNewBaseline()
	{
		$Model = new BaselineModel;
		$this->SelectedBaseline = $Model->SaveNewBaseline();
	}
    
    function TopSelection()
    {
 		$Model = new BaselineModel;
        $RENDER = new Image(SITE_ID);
		$html='';
		
        $Baselines = $Model->getMemberBaselines();
        if(count($Baselines) > 0)
        {
            $html.='<form name="selectform" action="index.php" method="post" id="selectform">
            <input type="hidden" name="module" value="baseline"/>
                    <select id="baselineselect" name="baselineselect" class="select" onchange="this.form.submit();">
                    <option value="">Select Baseline</option>
                    <option value="new"';
                    if($_REQUEST['baselineselect'] == 'new')
                        $html.=' selected="selected"';                   
                    $html.='>Create New</option>';
                    
            foreach($Baselines as $Baseline){//select form
                        $html.='<option value="'.$Baseline->Id.'"';

                if($this->SelectedBaseline == $Baseline->Id)
                    $html.=' selected="selected"';              
                $html.='>'.$Baseline->ExerciseName.'</option>';
            }
            $html.= '</select></form><br/>';
        }
        
        if($_REQUEST['save'] != 'newbaseline'){
        
        if(count($Baselines) == 0 || $_REQUEST['baselineselect'] == 'new'){
            $html.='
                <form name="baselinetype" action="index.php" method="post" id="baselinetype">
                <input type="hidden" name="module" value="baseline"/>
                <input type="hidden" name="baselineselect" value="new"/>
                    <select id="newbaseline" name="newbaseline" class="select" onchange="this.form.submit();">
                    <option value="">Baseline Type</option>
                    <option value="Benchmark"';
                if($_REQUEST['newbaseline'] == 'Benchmark')
                    $html.=' selected="selected"';
                $html.='>Benchmark Workout</option>
                        <option value="Custom"';
                if($_REQUEST['newbaseline'] == 'Custom')
                    $html.=' selected="selected"';               
                $html.='>Custom</option>
                </select></form><br/>';
        }
        if(isset($_REQUEST['newbaseline'])){
            $html.='<form name="newbaseline" action="index.php" method="post" id="newbaseline">
                <input type="hidden" name="module" value="baseline"/>
                <input type="hidden" name="save" value="newbaseline"/>
                <input type="hidden" name="newbaseline" value="'.$_REQUEST['newbaseline'].'"/>';
            
            
            
            if($_REQUEST['newbaseline'] == 'Benchmark'){
                $html.='<select id="benchmark" name="benchmark" class="select" onchange="this.form.submit();">
                        <option value="">Select Benchmark</option>';
                        $Benchmarks = $Model->getBenchmarks();
                    foreach($Benchmarks as $Benchmark){
                        $html.='<option value="'.$Benchmark->Id.'"';
                        if($_REQUEST['benchmark'] == $Benchmark->Id)
                            $html.=' selected="selected"';
                        $html.='>'.$Benchmark->ExerciseName.'</option>';
                    }
                    $html.= '</select></form>';
                }
            
            if($_REQUEST['newbaseline'] == 'Custom'){
                                        
                    $html.='<select id="customtype" name="customtype" class="select">
                    <option value="">Select Type</option>';
                    $CustomTypes = $Model->getCustomTypes();
                    foreach($CustomTypes as $CustomType){
                        $html.='<option value="'.$CustomType->Id.'"';
                        if($_REQUEST['customtype'] == $CustomType->Id)
                            $html.=' selected="selected"';
                        $html.='>'.$CustomType->Description.'</option>';
                    }
                    $html.= '</select><br/><br/>';    
                    
                    $html.='<input type="text" name="customname" value="" placeholder="Workout Name"/><br/><br/>
                        <textarea name="customdescription" rows="3" cols="15"></textarea><br/><br/>
                        <input type="submit" name="submit" value="Save"/></form>';

                    /*
                     Need to finalize this for custom attributes
                     
                    if($_REQUEST['customtype'] != ''){
                        $AttributeOptions = $Model->getAttributeOptions();

                    foreach($AttributeOptions as $Option){
                        $html.='<input type="checkbox" name="attribute" value="'.$Option->Attribute.'"/>'.$Option->Attribute.'<br/>';
                    } 
                    $html.='<h3><a href="#" id="addScnt">Add New Attribute</a></h3>
                    <div id="p_scents"></div>
                    <input type="hidden" name="newcount" id="newcount" value=""/>';
                    }
                     */
                    }
                }
            }
            $html.='<br/>';
            return $html;
    }
	
	function Output()
	{
		$Model = new BaselineModel;
        $RENDER = new Image(SITE_ID);
		$html='';
		if($this->SelectedBaseline != '' && $_REQUEST['baselineselect'] != 'new')
		{
            $Baseline = $Model->getBaselineDetails($this->SelectedBaseline);
            if($Baseline->Attribute == 'TimeToComplete'){
                $Start = $RENDER->Image('start.png', $this->Device->GetScreenWidth());
                $Stop = $RENDER->Image('stop.png', $this->Device->GetScreenWidth());
                $Reset = $RENDER->Image('reset.png', $this->Device->GetScreenWidth());
                $Save = $RENDER->Image('save.png', $this->Device->GetScreenWidth());
    
                $html.='<div id="bmdescription">';
                $html.= $Baseline->Description;
                $html.='</div>';
                $html.='<form name="clockform" action="index.php">
                <input type="hidden" name="module" value="baseline"/>
                <input type="hidden" name="BaselineId" value="'.$this->SelectedBaseline.'"/>
                <input type="hidden" name="save" value="workout"/>
                <input id="clock" name="TimeToComplete" value="00:00:0"/>
                </form>	
                <div style="margin:0 30% 0 30%; width:50%">
                <img alt="Start" src="'.$Start.'" onclick="start()"/>&nbsp;&nbsp;
                <img alt="Stop" src="'.$Stop.'" onclick="stop()"/><br/><br/>
                <img alt="Reset" src="'.$Reset.'" onclick="reset()"/>&nbsp;&nbsp;
                <img alt="Save" src="'.$Save.'" onclick="save()"/>
                </div><br/><br/>'; 
            }
            else if($Baseline->Attribute == ''){
                
            }
        }
		return $html;
	}
}
?>