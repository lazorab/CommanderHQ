<?php
class GoalsModel extends Model
{
    function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
	}
    
    function getActiveGoals()
    {
        $Goals=array();
		$SQL = 'SELECT recid, GoalTitle, GoalDescription FROM MemberGoals WHERE AchieveByDate > NOW() AND Achieved <> 1';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
        {
            array_push($Goals, new GoalObject($Row)); 
        }
		return $Goals;        
    }
    
    function getAchievedGoals()
    {
        $Goals=array();
		$SQL = 'SELECT recid, GoalTitle, GoalDescription FROM MemberGoals WHERE Achieved = 1';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
        {
            array_push($Goals, new GoalObject($Row)); 
        }
		return $Goals;        
    }
    
    function getFailedGoals()
    {
        $Goals=array();
		$SQL = 'SELECT recid, GoalTitle, GoalDescription FROM MemberGoals WHERE AchieveByDate < NOW() AND Achieved = 0';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
        {
            array_push($Goals, new GoalObject($Row)); 
        }
		return $Goals;        
    }
    
    function getGoal($Id)
    {
		$SQL = 'SELECT recid, GoalTitle, GoalDescription, Achieved, SetDate,  AchievedDate,  AchieveByDate
        FROM MemberGoals WHERE recid = '.$Id.'';
		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
        $Goal = new GoalObject($Row); 
        
		return $Goal;        
    }
    
    function setGoal()
    {
		$SQL = 'INSERT INTO MemberGoals(MemberId, GoalTitle, GoalDescription, AchieveByDate)
        VALUES("'.$_SESSION['UID'].'", "'.$_REQUEST['GoalTitle'].'", "'.$_REQUEST['GoalDescription'].'", "'.$_REQUEST['AchieveByDate'].'")';
		mysql_query($SQL);        
    }
    
    function UpdateGoal($Id)
    {
        $Achieved = '';
        $SQL='SELECT Achieved FROM MemberGoals WHERE recid = '.$Id.'';
        $Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
        if($Row['Achieved'] == 0 && $_REQUEST['Achieved'] == 1)
            $Achieved = ' AchievedDate = NOW(),';
		$SQL = 'UPDATE MemberGoals 
        SET GoalTitle = "'.$_REQUEST['GoalTitle'].'", 
        GoalDescription = "'.$_REQUEST['GoalDescription'].'", 
        Achieved = "'.$_REQUEST['Achieved'].'",
        '.$Achieved.'
        AchieveByDate = "'.$_REQUEST['AchieveByDate'].'"
        WHERE recid = '.$Id.'';
		mysql_query($SQL);        
    }
}
    
class GoalObject
    {
        var $recid;
        var $GoalTitle;
        var $GoalDescription;
        var $Achieved;
        var $SetDate;
        var $AchieveByDate;
        var $AchievedDate;
        
        function __construct($Row)
        {
            $this->recid = isset($Row['recid']) ? $Row['recid'] : "";
            $this->GoalTitle = isset($Row['GoalTitle']) ? $Row['GoalTitle'] : "";
            $this->GoalDescription = isset($Row['GoalDescription']) ? $Row['GoalDescription'] : "";
            $this->Achieved = isset($Row['Achieved']) ? $Row['Achieved'] : "";
            $this->SetDate = isset($Row['SetDate']) ? $Row['SetDate'] : "";
            $this->AchieveByDate = isset($Row['AchieveByDate']) ? $Row['AchieveByDate'] : "";
            $this->AchievedDate = isset($Row['AchieveDate']) ? $Row['AchievedDate'] : "";            
        }
        
    }
?>