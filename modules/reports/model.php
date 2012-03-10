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

	function getCompletedExercises()
	{
		$CompletedExercises = array();
		$Sql = 'SELECT E.recid, E.Exercise, MAX(L.LevelAchieved) 
			FROM ExerciseLog L JOIN Exercises E ON E.recid = L.ExerciseId
			WHERE L.MemberId = '.$this->UID.' 
			GROUP BY ExerciseId';
		$Result = mysql_query($Sql);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($CompletedExercises,new ExerciseObject($Row));
		}	
		return $CompletedExercises;
	}
	
	function getPerformanceHistory($ExerciseId)
	{
		$Data = array();
		$Sql = 'SELECT L.ExerciseId, E.Exercise, T.ExerciseType, L.Duration, L.Reps, L.Weight, L.Height, L.LevelAchieved, L.TimeCreated 
		FROM ExerciseLog L JOIN Exercises E on E.recid = L.ExerciseId JOIN ExerciseTypes T ON T.recid = L.ExerciseTypeId
		WHERE L.MemberId = '.$this->UID.' AND L.ExerciseId = '.$ExerciseId.'';
		$Result = mysql_query($Sql);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Data,new PerformanceObject($Row));
		}	
		return $Data;	
	}
	
	function getPendingExercises()
	{
		$PendingExercises=array();
		$AllExercises = $this->getExercises();
		foreach($AllExercises AS $Exercise)
		{
			if(!in_array($Exercise['Exercise'], $this->getCompletedExercises()))
				array_push($PendingExercises,new ExerciseObject($Exercise));
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

class ExerciseObject
{
	var $Id;
	var $Exercise;
	
	function __construct($Row)
	{
		$this->Id = $Row['recid'];
		$this->Exercise = $Row['Exercise'];
	}
}

class PerformanceObject
{
	var $ExerciseId;
	var $Exercise;
	var $ExerciseType;
	var $Duration;
	var $Reps;
	var $Weight;
	var $Height;
	var $LevelAchieved;
	var $TimeCreated;
	
	function __construct($Row)
	{
		$this->ExerciseId = $Row['ExerciseId'];
		$this->Exercise = $Row['Exercise'];
		$this->ExerciseType = $Row['ExerciseType'];
		$this->Duration = $Row['Duration'];
		$this->Reps = $Row['Reps'];
		$this->Weight = $Row['Weight'];
		$this->Height = $Row['Height'];
		$this->LevelAchieved = $Row['LevelAchieved'];
		$this->TimeCreated = $Row['TimeCreated'];
	}
}
?>