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
		$SQL = 'SELECT MD.SystemOfMeasure, MD.SkillLevel, MG.GoalTitle, MG.GoalDescription 
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
			FROM WODLog L 
                        JOIN Exercises E ON E.recid = L.ExerciseId
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
		$Sql = 'SELECT L.ExerciseId, 
                    E.Exercise, 
                    WT.WorkoutType, 
                    A.Attribute, 
                    L.AttributeValue, 
                    L.LevelAchieved, 
                    L.TimeCreated 
                    FROM WODLog L 
                    LEFT JOIN Exercises E on E.recid = L.ActivityId 
                    LEFT JOIN Attributes A on A.recid = L.AttributeId 
                    LEFT JOIN WorkoutTypes WT ON WT.recid = L.WODTypeId
                    WHERE L.MemberId = '.$_SESSION['UID'].' 
                    AND L.ActivityId = '.$ExerciseId.'';

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

	$SQL = 'SELECT DISTINCT E.recid AS ExerciseId,
                E.Exercise
                FROM WODLog L
                LEFT JOIN Exercises E ON E.recid = L.ExerciseId
                WHERE L.MemberId = "'.$_SESSION['UID'].'"
                ORDER BY Exercise';
	$Result = mysql_query($SQL);	
	while($Row = mysql_fetch_assoc($Result))
	{
		array_push($Data,new ReportObject($Row));
	}	
	return $Data;        
    }
    
    function getBenchmarks()
    {
        $Data = array();
	$SQL = 'SELECT DISTINCT B.recid AS ExerciseId, 
        B.WorkoutName
        FROM WODLog L
        LEFT JOIN BenchmarkWorkouts B ON B.recid = L.WorkoutId
        WHERE L.MemberId = '.$_SESSION['UID'].'
        AND L.WODTypeId = 2
        ORDER BY WorkoutName';
	$Result = mysql_query($SQL);	
	while($Row = mysql_fetch_assoc($Result))
	{
            array_push($Data,new ReportObject($Row));
	}	
	return $Data;        
    }
    
    function getWODHistory()
    {
	$Data = array();
	$Sql = 'SELECT WT.WorkoutType,
            CASE WHEN WorkoutType = "Custom" 
            THEN (SELECT WorkoutName FROM CustomWorkouts WHERE recid = L.ExerciseId)
            WHEN WorkoutType = "Benchmark"
            THEN (SELECT WorkoutName FROM BenchmarkWorkouts WHERE recid = L.ExerciseId)
            ELSE
            E.Exercise 
            END
            AS WorkoutName,
            E.Exercise, 
            A.Attribute AS Attribute, L.AttributeValue AS AttributeValue, L.TimeCreated 
            FROM WODLog L 
            LEFT JOIN WorkoutTypes WT ON WT.recid = L.WODTypeId
            LEFT JOIN Exercises E ON E.recid = L.ExerciseId
            LEFT JOIN Attributes A ON A.recid = L.AttributeId
            WHERE L.MemberId = '.$_SESSION['UID'].'
            AND L.ExerciseId = '.$_REQUEST['WODId'].'
            ORDER BY TimeCreated';// AND L.ExerciseId = '.$_REQUEST['WODId'].'';
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
	$Sql = 'SELECT WT.WorkoutType,
            B.WorkoutName AS WorkoutName,
            A.Attribute AS Attribute, L.AttributeValue AS AttributeValue, L.TimeCreated 
            FROM WODLog L 
            LEFT JOIN WorkoutTypes WT ON WT.recid = L.WODTypeId
            LEFT JOIN BenchmarkWorkouts B ON B.recid = L.WorkoutId
            LEFT JOIN Attributes A ON A.recid = L.AttributeId
            WHERE L.MemberId = '.$_SESSION['UID'].'
            AND WorkoutType = "Benchmark"
            AND L.WorkoutId = '.$_REQUEST['BenchmarkId'].'
            ORDER BY TimeCreated';// AND L.ExerciseId = '.$_REQUEST['WODId'].'';
	$Result = mysql_query($Sql);	
        //echo $Sql;
	while($Row = mysql_fetch_assoc($Result))
	{
            array_push($Data,new ReportObject($Row));
	}	
        return $Data;       
    }
	
    function getBaselineExercises()
    {
	$Baselines = array();
	$SQL = 'SELECT DISTINCT MB.recid, 
        MB.ExerciseId,
        WT.WorkoutType
        FROM MemberBaseline MB
        JOIN WorkoutTypes WT ON WT.recid = MB.ExerciseTypeId
        LEFT JOIN BaselineLog L ON L.ExerciseId = MB.recid
        WHERE L.MemberId = "'.$_SESSION['UID'].'"';
		$Result = mysql_query($SQL);	
        
		while($Row = mysql_fetch_assoc($Result))
        {
            if($Row['WorkoutType'] == 'Benchmark'){
                $NewQuery = 'SELECT MB.recid as ExerciseId, BW.WorkoutName AS Exercise
                FROM MemberBaseline MB 
                JOIN BenchmarkWorkouts BW ON MB.ExerciseId = BW.recid
                WHERE BW.recid = '.$Row['ExerciseId'].'';
            }
            else if($Row['WorkoutType'] == 'Custom'){
                $NewQuery = 'SELECT MB.recid as ExerciseId, CE.ExerciseName AS Exercise
                FROM MemberBaseline MB
                JOIN CustomWorkouts CW ON CW.recid = MB.ExerciseId
                WHERE CW.recid = '.$Row['ExerciseId'].'';               
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
	$Sql = 'SELECT WT.WorkoutType AS ExerciseType,
        CASE WHEN WorkoutType = "Custom" 
        THEN (SELECT WorkoutName FROM CustomWorkouts WHERE recid = L.ExerciseId)
        WHEN WorkoutType = "Benchmark"
        THEN (SELECT WorkoutName FROM BenchmarkWorkouts WHERE recid = L.ExerciseId)
        ELSE
        E.Exercise 
        END
        AS WorkoutName,
        E.Exercise, 
        A.Attribute AS Attribute, L.AttributeValue AS AttributeValue, L.TimeCreated 
	FROM BaselineLog L 
        LEFT JOIN MemberBaseline B ON B.ExerciseId = L.ExerciseId 
        LEFT JOIN WorkoutTypes WT ON WT.recid = L.BaselineTypeId
        LEFT JOIN Exercises E ON E.recid = L.ExerciseId
        LEFT JOIN Attributes A ON A.recid = L.AttributeId
	WHERE L.MemberId = '.$_SESSION['UID'].'
	GROUP BY Exercise,TimeCreated
        ORDER BY TimeCreated';// AND L.ExerciseId = '.$_REQUEST['BaselineId'].'';
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
    var $ActivityId;
    var $Exercise;
    var $WorkoutType;
    var $WorkoutName;
    var $Attribute;
    var $AttributeValue;
    var $LevelAchieved;
    var $TimeCreated;
	
    function __construct($Row)
    {
	$this->ExerciseId = isset($Row['ExerciseId']) ? $Row['ExerciseId'] : "";
        $this->ActivityId = isset($Row['ActivityId']) ? $Row['ActivityId'] : "";
	$this->Exercise = isset($Row['Exercise']) ? $Row['Exercise'] : "";
	$this->WorkoutType = isset($Row['WorkoutType']) ? $Row['WorkoutType'] : "";
        $this->WorkoutName = isset($Row['WorkoutName']) ? $Row['WorkoutName'] : "";
        $this->Attribute = isset($Row['Attribute']) ? $Row['Attribute'] : "";
        $this->AttributeValue = isset($Row['AttributeValue']) ? $Row['AttributeValue'] : "";
        $this->LevelAchieved = isset($Row['LevelAchieved']) ? $Row['LevelAchieved'] : "";        
	$this->TimeCreated = isset($Row['TimeCreated']) ? $Row['TimeCreated'] : "";
    }
}

?>