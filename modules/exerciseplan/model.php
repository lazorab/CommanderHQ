<?php
class ExerciseplanModel extends Model
{

	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
	}
	
	function getGoals($MemberId)
	{
		$Goals = array();
		$SQL = 'SELECT recid, GoalTitle, GoalDescription, Achieved, SetDate, AchieveDate FROM MemberGoals WHERE MemberId = '.$MemberId.'';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Goals, new GoalsObject($Row));
		}
		return $Goals;
	}	
	
	function getGoal($Id)
	{
		$SQL = 'SELECT recid, GoalTitle, GoalDescription, Achieved, SetDate, AchieveDate FROM MemberGoals WHERE recid = '.$Id.'';
		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
		$Goal = new GoalsObject($Row);

		return $Goal;
	}
	
	function Save($Details)
	{
		$SQL = 'INSERT INTO MemberGoals(MemberId, GoalTitle, GoalDescription, Achieved, SetDate, AchieveDate) VALUES("'.$Details['UID'].'", "'.$Details['title'].'", "'.$Details['description'].'", "0", NOW(), "")';
		$Result = mysql_query($SQL);	
		return $Result;	
	}
	
	function Update($Details)
	{
		$Status=true;
		foreach($Details['Goals'] AS $Key=>$Val)
		{
			if($Status){
				$SQL = 'UPDATE MemberGoals SET Achieved = 1, AchieveDate = NOW() WHERE Achieved = 0 AND recid = '.$Val.'';
				$Status = mysql_query($SQL);
			}
		}
		return $Status;
	}	
}

class GoalsObject
{
	var $Id;
	var $Title;
	var $Description;
	var $Achieved;
	var $SetDate;
	var $AchieveDate;

	function __construct($Row)
	{
		$this->Id = $Row['recid'];
		$this->Title = $Row['GoalTitle'];
		$this->Description = $Row['GoalDescription'];
		$this->Achieved = $Row['Achieved'];
		$this->SetDate = $Row['SetDate'];
		$this->AchieveDate = $Row['AchieveDate'];
	}
}
?>