<?php
class ReportsModel extends Model
{
	
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
	}
	
	function getDetails()
	{
		$SQL = 'SELECT M.SystemOfMeasure, MD.SkillLevel, MG.GoalTitle, MG.GoalDescription 
		FROM MemberGoals MG 
		JOIN Members M ON M.UserId = MG.MemberId
		JOIN MemberDetails MD ON MD.MemberID = MG.MemberId
		WHERE MG.MemberId = '.$_SESSION['UID'].' AND MG.Achieved = 0';
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
			WHERE L.MemberId = '.$_SESSION['UID'].' 
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
		FROM ExerciseLog L LEFT JOIN Exercises E on E.recid = L.ExerciseId LEFT JOIN ExerciseTypes T ON T.recid = L.ExerciseTypeId
		WHERE L.MemberId = '.$_SESSION['UID'].' AND L.ExerciseId = '.$ExerciseId.'';
		$Result = mysql_query($Sql);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Data,new ReportObject($Row));
		}	
		return $Data;	
	}
    
    function getWODExercises()
    {
		$Data = array();
		$Sql = 'SELECT recid as ExerciseId, WorkoutName	as Exercise	FROM WOD';
		$Result = mysql_query($Sql);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Data,new ReportObject($Row));
		}	
		return $Data;       
    }
    
    function getWODHistory()
    {
		$Data = array();
		$Sql = 'SELECT L.ExerciseId, W.WorkoutName, A.Attribute, L.AttributeValue, L.TimeCreated 
		FROM WODLog L 
        LEFT JOIN WOD W on W.recid = L.ExerciseId 
        LEFT JOIN Attributes A ON A.recid = L.AttributeId
		WHERE L.MemberId = '.$_SESSION['UID'].' AND L.ExerciseId = '.$_REQUEST['WODId'].'';
		$Result = mysql_query($Sql);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Data,new ReportObject($Row));
		}	
		return $Data;       
    }
	
    function getBaselineExercises()
    {
		$Data = array();
		$Sql = 'SELECT recid as ExerciseId, ExerciseName as Exercise FROM BaselineExercises';
		$Result = mysql_query($Sql);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Data,new ReportObject($Row));
		}	
		return $Data;       
    }   
    
    function getBaselineHistory()
    {
		$Data = array();
		$Sql = 'SELECT L.ExerciseId as ExerciseId, B.ExerciseName as Exercise, A.Attribute as Attribute, L.AttributeValue as AttributeValue, L.TimeCreated 
		FROM BaselineLog L 
        LEFT JOIN BaselineExercises B on B.recid = L.ExerciseId 
        LEFT JOIN Attributes A ON A.recid = L.AttributeId
		WHERE L.MemberId = '.$_SESSION['UID'].' AND L.ExerciseId = '.$_REQUEST['BaselineId'].'';
		$Result = mysql_query($Sql);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Data,new ReportObject($Row));
		}	
		return $Data;       
    }
    
    function getBenchmarkExercises()
    {
		$Data = array();
		$Sql = 'SELECT recid as ExerciseId, WorkoutName as Exercise FROM BenchmarkWorkouts';
		$Result = mysql_query($Sql);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Data,new ReportObject($Row));
		}	
		return $Data;       
    }    
    
    function getBenchmarkHistory()
    {
		$Data = array();
		$Sql = 'SELECT L.BenchmarkId as ExerciseId, B.WorkoutName as Exercise, A.Attribute as Attribute, L.AttributeValue as AttributeValue, L.TimeCreated 
		FROM BenchmarkLog L 
        LEFT JOIN BenchmarkWorkouts B on B.recid = L.BenchmarkId 
        LEFT JOIN Attributes A ON A.recid = L.AttributeId
		WHERE L.MemberId = '.$_SESSION['UID'].' AND L.BenchmarkId = '.$_REQUEST['BenchmarkId'].'';
		$Result = mysql_query($Sql);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Data,new ReportObject($Row));
		}	
		return $Data;       
    }
    
	function getWeightHistory()
	{
		$Data = array();
		$Sql = 'SELECT BodyWeight as Weight, TimeCreated 
		FROM ExerciseLog
		WHERE MemberId = '.$_SESSION['UID'].' AND BodyWeight <> ""';
		$Result = mysql_query($Sql);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Data,new WeightObject($Row));
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
		$Sql = 'SELECT recid as ExerciseId, Exercise FROM Exercises';
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
	var $SystemOfMeasure;
	var $SkillLevel;
	var $GoalTitle;
	var $GoalDescription;

	function __construct($Row)
	{
		$this->SystemOfMeasure = $Row['SystemOfMeasure'];
		$this->SkillLevel = $Row['SkillLevel'];
		$this->GoalTitle = $Row['GoalTitle'];
		$this->GoalDescription = $Row['GoalDescription'];
	}
}


class ReportObject
{
	var $ExerciseId;
	var $Exercise;
	var $ExerciseType;
	var $Duration;
	var $Reps;
	var $Weight;
	var $Height;
    var $TimeToComplete;
	var $LevelAchieved;
	var $TimeCreated;
	
	function __construct($Row)
	{
		$this->ExerciseId = isset($Row['ExerciseId']) ? $Row['ExerciseId'] : "";
		$this->Exercise = isset($Row['Exercise']) ? $Row['Exercise'] : "";
		$this->ExerciseType = isset($Row['ExerciseType']) ? $Row['ExerciseType'] : "";
        if(isset($Row['Attribute'])){
            $this->Duration = $Row['Attribute'] == 'Duration' ? $Row['AttributeValue'] : "";
            $this->Reps = $Row['Attribute'] == 'Reps' ? $Row['AttributeValue'] : "";
            $this->Weight = $Row['Attribute'] == 'Weight' ? $Row['AttributeValue'] : "";
            $this->Height = $Row['Attribute'] == 'Height' ? $Row['AttributeValue'] : "";
            $this->TimeToComplete = $Row['Attribute'] == 'TimeToComplete' ? $Row['AttributeValue'] : "";
            $this->LevelAchieved = $Row['Attribute'] == 'LevelAchieved' ? $Row['AttributeValue'] : "";
        }
        else{
            $this->Duration = "";
            $this->Reps = "";
            $this->Weight = "";
            $this->Height = "";
            $this->TimeToComplete = "";
            $this->LevelAchieved = "";           
        }
		$this->TimeCreated = isset($Row['TimeCreated']) ? $Row['TimeCreated'] : "";
	}
}

?>