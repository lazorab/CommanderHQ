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
         /*
		$Sql = 'SELECT recid as ExerciseId, WorkoutName	as Exercise	FROM WOD';
		$Result = mysql_query($Sql);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Data,new ReportObject($Row));
		}	
		return $Data; 
        */
		$SQL = 'SELECT DISTINCT mb.recid, 
        mb.ExerciseId,
        et.ExerciseType
        FROM WODLog L
        ExerciseTypes et ON et.recid = mb.ExerciseTypeId
        LEFT JOIN WODLog L ON L.ExerciseId = mb.recid
        WHERE L.MemberId = "'.$_SESSION['UID'].'"';
		$Result = mysql_query($SQL);	
        
		while($Row = mysql_fetch_assoc($Result))
        {
            if($Row['ExerciseType'] == 'Benchmark'){
                $NewQuery = 'SELECT MB.recid as ExerciseId, BW.WorkoutName AS Exercise
                FROM MemberBaseline MB 
                JOIN BenchmarkWorkouts BW ON MB.ExerciseId = BW.recid
                WHERE BW.recid = '.$Row['ExerciseId'].'';
            }
            else if($Row['ExerciseType'] == 'Custom'){
                $NewQuery = 'SELECT MB.recid as ExerciseId, CE.ExerciseName AS Exercise
                FROM MemberBaseline MB
                JOIN CustomExercises CE ON CE.recid = MB.ExerciseId
                WHERE CE.recid = '.$Row['ExerciseId'].'';               
            }
            
            $NewResult = mysql_query($NewQuery);
            $NewRow = mysql_fetch_assoc($NewResult);
            array_push($Baselines, new ReportObject($NewRow));
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
		$Baselines = array();
		$SQL = 'SELECT DISTINCT mb.recid, 
        mb.ExerciseId,
        et.ExerciseType
        FROM MemberBaseline mb
        JOIN ExerciseTypes et ON et.recid = mb.ExerciseTypeId
        LEFT JOIN BaselineLog L ON L.ExerciseId = mb.recid
        WHERE L.MemberId = "'.$_SESSION['UID'].'"';
		$Result = mysql_query($SQL);	
        
		while($Row = mysql_fetch_assoc($Result))
        {
            if($Row['ExerciseType'] == 'Benchmark'){
                $NewQuery = 'SELECT MB.recid as ExerciseId, BW.WorkoutName AS Exercise
                FROM MemberBaseline MB 
                JOIN BenchmarkWorkouts BW ON MB.ExerciseId = BW.recid
                WHERE BW.recid = '.$Row['ExerciseId'].'';
            }
            else if($Row['ExerciseType'] == 'Custom'){
                $NewQuery = 'SELECT MB.recid as ExerciseId, CE.ExerciseName AS Exercise
                FROM MemberBaseline MB
                JOIN CustomExercises CE ON CE.recid = MB.ExerciseId
                WHERE CE.recid = '.$Row['ExerciseId'].'';               
            }
            
            $NewResult = mysql_query($NewQuery);
            $NewRow = mysql_fetch_assoc($NewResult);
            array_push($Baselines, new ReportObject($NewRow));
        }	
		return $Baselines;       
    }   
    
    function getBaselineHistory()
    {
		$Data = array();
		$Sql = 'SELECT L.ExerciseId as ExerciseId, A.Attribute as Attribute, L.AttributeValue as AttributeValue, L.TimeCreated 
		FROM BaselineLog L 
        LEFT JOIN MemberBaseline B on B.recid = L.ExerciseId 
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
		$Sql = 'SELECT DISTINCT BM.recid as ExerciseId, BM.WorkoutName as Exercise 
        FROM BenchmarkWorkouts BM
        LEFT JOIN BenchmarkLog BL ON BL.BenchmarkId = BM.recid
        WHERE BL.MemberId = '.$_SESSION['UID'].'';
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
	var $Attribute;
    var $AttributeValue;
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
        $this->Attribute = isset($Row['Attribute']) ? $Row['Attribute'] : "";
        $this->AttributeValue = isset($Row['AttributeValue']) ? $Row['AttributeValue'] : "";
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