<?php
class GoalsController extends Controller
{
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_SESSION['UID']))
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
        else{
            return 'Default';
        }
        return $Html;
	}    
	
    function getActiveGoals()
    {
        $Html='';
        $Model = new GoalsModel();
        $Goals=$Model->getActiveGoals();
        foreach($Goals as $Goal){
            $Html.='<a href="?module=goals&id='.$Goal->recid.'">'.$Goal->GoalTitle.'</a><br/>';
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
    
    function getGoal($Id)
    {
        $Model = new GoalsModel();
        $Goal=$Model->getGoal($Id);
        $Html='
		<form action="index.php" method="post">
        <input type="hidden" name="module" value="goals"/>
        <input type="hidden" name="id" value="'.$Goal->recid.'"/><br/>
        Goal:<br/>
        <input type="text" name="GoalTitle" value="'.$Goal->GoalTitle.'"/><br/>
        <textarea name="GoalDescription" cols="10" rows="5">'.$Goal->GoalDescription.'</textarea><br/>
        Achieved?<br/>
        Yes<input type="radio" name="Achieved" value="1"';
        if($Goal->Achieved == 1)
            $Html.=' checked="checked"';
        $Html.='/>No<input type="radio" name="Achieved" value="0"';
        if($Goal->Achieved == 0)
            $Html.=' checked="checked"';
        $Html.='/><br/>
        Achieve By:<br/>
        <input type="text" id="dateselect" name="AchieveByDate" value="'.$Goal->AchieveByDate.'"/><br/>
        <input type="submit" name="action" value="Update"/>
        </form>';
        return $Html;        
    }
    
    function getGoalForm()
    {
        $Html='<form action="index.php" method="post">
        <input type="hidden" name="module" value="goals"/><br/>
        Goal:<br/>
        <input type="text" name="GoalTitle" value=""/><br/>
        <textarea name="GoalDescription" cols="10" rows="5"></textarea><br/>
        Achieved?<br/>
        Yes<input type="radio" name="Achieved" value="1"/>No<input type="radio" name="Achieved" value="0" checked="checked"/><br/>
        Achieve By:<br/>
        <input type="text" class="datetime" name="AchieveByDate" value=""/><br/>
        <input type="submit" name="action" value="Save"/>
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