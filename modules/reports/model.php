<?php
class ReportsModel extends Model
{
	var $UID;
	
	function __construct($UID)
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
		$this->UID = $UID;
	}
	
	function getDetails()
	{
		$SQL = 'SELECT MD.SkillLevel, MG.GoalTitle, MG.GoalDescription 
		FROM MemberGoals MG JOIN MemberDetails MD ON MD.MemberID = MG.MemberId
		WHERE MG.MemberId = '.$this->UID.' AND MG.Achieved = 0';
		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
		$Details = new DetailsObject($Row);
		
		return $Details;
	}

	private function CompletedExercises()
	{
		$CompletedExercises = array();
		$Sql = 'SELECT ExerciseId, MAX(LevelAchieved) FROM ExerciseLog WHERE MemberId = '.$this->UID.' GROUP BY ExerciseId';
		$Result = mysql_query($Sql);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($CompletedExercises,$Row['ExerciseId']);
		}	
		return $CompletedExercises;
	}
	
	function getPendingExercises()
	{
		$PendingExercises=array();
		$AllExercises = $this->getExercises();
		foreach($AllExercises AS $Exercise)
		{
			if(!in_array($Exercise['recid'], $this->CompletedExercises()))
				array_push($PendingExercises,new PendingExercises($Exercise));
		}
		return $PendingExercises;
	}	
	
	private function getExercises()
	{
		$Exercises=array();
		$Sql = 'SELECT recid, Exercise FROM Exercises';
		$Result = mysql_query($Sql);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Exercises, $Row);
		}	
		return $Exercises;
	}
}

class DetailsObject
{
	var $SkillLevel;
	var $GoalTitle;
	var $GoalDescription;

	function __construct($Row)
	{
		$this->SkillLevel = $Row['SkillLevel'];
		$this->GoalTitle = $Row['GoalTitle'];
		$this->GoalDescription = $Row['GoalDescription'];
	}
}

class PendingExercises
{
	var $Id;
	var $Exercise;
	
	function __construct($Row)
	{
		$this->Id = $Row['recid'];
		$this->Exercise = $Row['Exercise'];
	}
}
?>