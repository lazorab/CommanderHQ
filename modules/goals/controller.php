<?php
class GoalsController extends Controller
{
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_COOKIE['UID']))
			header('location: index.php?module=login');		
	}
    
	function Output()
	{
        $Model = new GoalsModel();
        $Html = '';
        if($_REQUEST['action'] == 'active'){
            $Html.=$this->getActiveGoals();
        }
        else if($_REQUEST['action'] == 'achieved'){
            $Html.=$this->getAchievedGoals();
        }
        else if($_REQUEST['action'] == 'failed'){
            $Html.=$this->getFailedGoals();
        }  
         else if($_REQUEST['action'] == 'history'){
            $Html.=$this->getGoalHistory();
        }        
        else if($_REQUEST['action'] == 'new'){
            $Html.=$this->getGoalForm();
        }
        else if($_REQUEST['action'] == 'Save'){
            $Model->setGoal();
        }
        else if($_REQUEST['action'] == 'Update'){
            $Model->UpdateGoal($_REQUEST['id']);
        }
        else if(isset($_REQUEST['id'])){
            $Html.=$this->getGoal($_REQUEST['id']);
        }

        return $Html;
	}    
	
	function TopSelection()
	{
		$Html='';

	if($_REQUEST['topselection'] == 'new'){
		$Html.='<li>New Goal</li>';
	}
	else if($_REQUEST['topselection'] == 'active'){
		$Html.='<li>Active Goals</li>';
	}
	else if($_REQUEST['topselection'] == 'achieved'){
		$Html.='<li>Achieved Goals</li>';
	}
	else if($_REQUEST['topselection'] == 'failed'){
		$Html.='<li>Goals Not Achieved</li>';
	}
 	else if($_REQUEST['topselection'] == 'history'){
		$Html.='<li>Goal History</li>';
	}       
	else{
	    
        $Html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getContent(\'new\')"><div style="height:26px;width:1px;float:left"></div>Set New Goal</a></li>';
	$Html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getContent(\'active\')"><div style="height:26px;width:1px;float:left"></div>Active Goals</a></li>';
	//$Html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getContent(\'achieved\')"><div style="height:26px;width:1px;float:left"></div>Achieved Goals</a></li>';
	//$Html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getContent(\'failed\')"><div style="height:26px;width:1px;float:left"></div>Goals Not Achieved</a></li>';
        $Html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getContent(\'history\')"><div style="height:26px;width:1px;float:left"></div>Goal History</a></li>';             
        }	            

		return $Html;
	}
	
    function getActiveGoals()
    {
        $Html='';
        $Model = new GoalsModel();
        $Goals=$Model->getActiveGoals();
        if(count($Goals) > 0){
            foreach($Goals as $Goal){
                $Html.='<a style="color:#333" onClick="getActiveGoal('.$Goal->recid.');" href="#">'.$Goal->GoalTitle.'</a><br/>';
            }                     
        }else{
            $Html='No Active Goals';
        }
        return $Html;        
    }
    
    function getAchievedGoals()
    {
        $Html='';
        $Model = new GoalsModel();
        $Goals=$Model->getAchievedGoals();
        foreach($Goals as $Goal){
            $Html.='<a href="?module=goals&id='.$Goal->recid.'">'.$Goal->GoalTitle.'</a><br/>';
        }
        return $Html;        
    }
    
    function getFailedGoals()
    {
        $Html='';
        $Model = new GoalsModel();
        $Goals=$Model->getFailedGoals();
        foreach($Goals as $Goal){
            $Html.='<a href="?module=goals&id='.$Goal->recid.'">'.$Goal->GoalTitle.'</a><br/>';
        }
        return $Html;        
    }
    
    function getGoalHistory()
    {
        $Html='<div class="ui-grid-b">';
        $Html.='<div class="ui-block-a">Goal</div>
                <div class="ui-block-b">Achieve By Date</div>
                <div class="ui-block-c">Achieved?</div>';     
        $Model = new GoalsModel();
        $Goals=$Model->getGoalHistory();
        foreach($Goals as $Goal){
            $Html.='<div class="ui-block-a">
                <a style="color:#333" onClick="getGoal('.$Goal->recid.');" href="#">'.$Goal->GoalTitle.'</a></div>
                    <div class="ui-block-b">'.date("D M Y",strtotime($Goal->AchieveByDate)).'</div>
                <div class="ui-block-c">'.$Goal->Achieved.'</div>';
        }
        $Html.='</div>';
        return $Html;        
    }   
    
    function getGoal($Id)
    {
        $Model = new GoalsModel();
        $Goal=$Model->getGoal($Id);
        $Html='
		<form action="index.php" method="post">
        <input type="hidden" name="module" value="goals"/>
        <input type="hidden" name="id" value="'.$Goal->recid.'"/><br/>
        <input type="text" name="GoalTitle" value="'.$Goal->GoalTitle.'"/><br/>
        <textarea name="GoalDescription" cols="10" rows="5">'.$Goal->GoalDescription.'</textarea><br/>
        Achieved?<br/>
<fieldset class="controlgroup" data-role="controlgroup" data-type="horizontal">
<label for="yes">Yes</label>
<input class="radioinput" id="yes" type="radio" name="Achieved" value="1"';
        if($Goal->Achieved == 1)
            $Html.=' checked="checked"';
        $Html.='/>
<label for="no">No</label>
<input class="radioinput" id="no" type="radio" name="Achieved" value="0"';
         if($Goal->Achieved == 0)
            $Html.=' checked="checked"';
        $Html.='/>       
</fieldset><br/>       
        Achieve By:<br/>
        <input type="date" id="dateselect" name="AchieveByDate" value="'.$Goal->AchieveByDate.'"/><br/>
        <input type="submit" name="action" value="Update"/>
        </form>';
        return $Html;        
    }
    
    function getGoalForm()
    {
        $Html='<form action="index.php" method="post">
        <input type="hidden" name="module" value="goals"/><br/>
        <input class="textinput" type="text" name="GoalTitle" value="" placeholder="Title"/><br/>
        <textarea name="GoalDescription" cols="10" rows="5"></textarea><br/>
	Achieved?<br/>
<fieldset class="controlgroup" data-role="controlgroup" data-type="horizontal">
<label for="yes">Yes</label>
<input class="radioinput" id="yes" type="radio" name="Achieved" value="1"/>
<label for="no">No</label>
<input class="radioinput" id="no" type="radio" name="Achieved" value="0"/>
</fieldset><br/>
        Achieve By:<br/>
        <input type="date" class="datetime" name="AchieveByDate" value=""/><br/>
        <input class="buttongroup" type="submit" name="action" value="Save"/>
        </form>';
        return $Html;        
    }    
    
    function setGoal($Id)
    {
        $Model = new GoalsModel();
        $Success=$Model->setGoal($Id);
        
        $Html='';
        return $Html;        
    }
}
?>