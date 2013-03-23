<?php
class ReportsModel extends Model
{
	
	function __construct()
	{
	
	}
	
	function getDetails()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
		$SQL = 'SELECT MD.SystemOfMeasure, MD.SkillLevel, MG.GoalTitle, MG.GoalDescription 
		FROM MemberGoals MG 
		JOIN Members M ON M.UserId = MG.MemberId
		JOIN MemberDetails MD ON MD.MemberID = MG.MemberId
		WHERE MG.MemberId = '.$_COOKIE['UID'].' AND MG.Achieved = 0';
            $db->setQuery($SQL);
		
            return $db->loadObject();
	}
	
	function getPerformanceHistory($ExerciseId)
	{
		$db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
		$SQL = 'SELECT L.ExerciseId, 
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
                    WHERE L.MemberId = '.$_COOKIE['UID'].' 
                    AND L.ActivityId = '.$ExerciseId.'';
            $db->setQuery($SQL);
		
            return $db->loadObjectList();	
	}
    
    function getCompletedExercises()
    {
	$db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
	$SQL = 'SELECT DISTINCT E.recid AS ExerciseId,
                E.Exercise
                FROM WODLog L
                LEFT JOIN Exercises E ON E.recid = L.ExerciseId
                WHERE L.MemberId = "'.$_COOKIE['UID'].'"
                ORDER BY Exercise';
        $db->setQuery($SQL);
		
        return $db->loadObjectList();        
    }
    
    function getBenchmarks()
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
	$SQL = 'SELECT DISTINCT B.recid AS ExerciseId, 
        B.WorkoutName
        FROM WODLog L
        LEFT JOIN BenchmarkWorkouts B ON B.recid = L.WorkoutId
        LEFT JOIN WorkoutTypes WT ON WT.recid = L.WODTypeId
        WHERE L.MemberId = '.$_COOKIE['UID'].'
        AND WT.WorkoutType = "Benchmark"
        ORDER BY WorkoutName';
        $db->setQuery($SQL);
		
        return $db->loadObjectList();        
    }
    
    function getWODs()
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
	$SQL = 'SELECT DISTINCT B.recid AS WodId,
        B.WodTypeId, 
        B.WorkoutName
        FROM WODLog L
        LEFT JOIN WodWorkouts B ON B.recid = L.WorkoutId
        LEFT JOIN WorkoutTypes WT ON WT.recid = L.WODTypeId
        WHERE L.MemberId = '.$_COOKIE['UID'].'
        AND WT.WorkoutType <> "Benchmark"
        ORDER BY WorkoutName';
        $db->setQuery($SQL);
		
        return $db->loadObjectList();        
    }
    
    function getWODHistory($WorkoutId, $WorkoutTypeId)
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
	$SQL = 'SELECT WT.WODType,
            CASE WHEN WODType = "Custom" 
            THEN (SELECT WorkoutName FROM CustomWorkouts WHERE recid = L.WorkoutId)           
            ELSE
            (SELECT WorkoutName FROM WodWorkouts WHERE recid = L.WorkoutId) 
            END
            AS WorkoutName,
            E.Exercise, 
            A.Attribute AS Attribute, L.AttributeValue AS AttributeValue, L.TimeCreated 
            FROM WODLog L 
            LEFT JOIN WODTypes WT ON WT.recid = L.WODTypeId
            LEFT JOIN Exercises E ON E.recid = L.ExerciseId
            LEFT JOIN Attributes A ON A.recid = L.AttributeId
            WHERE L.MemberId = '.$_COOKIE['UID'].'
            AND L.WorkoutId = '.$WorkoutId.'
            AND L.WODTypeId = '.$WorkoutTypeId.'  
            ORDER BY TimeCreated';// AND L.ExerciseId = '.$_REQUEST['WODId'].'';
        $db->setQuery($SQL);
		
        return $db->loadObjectList();       
    }
    
        function getBenchmarkHistory($Id)
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
	$SQL = 'SELECT WT.WorkoutType,
            B.WorkoutName AS WorkoutName,
            A.Attribute AS Attribute, L.AttributeValue AS AttributeValue, L.TimeCreated 
            FROM WODLog L 
            LEFT JOIN WorkoutTypes WT ON WT.recid = L.WODTypeId
            LEFT JOIN BenchmarkWorkouts B ON B.recid = L.WorkoutId
            LEFT JOIN Attributes A ON A.recid = L.AttributeId
            WHERE L.MemberId = '.$_COOKIE['UID'].'
            AND WorkoutType = "Benchmark"
            AND L.WorkoutId = '.$Id.'
            ORDER BY TimeCreated';// AND L.ExerciseId = '.$_REQUEST['WODId'].'';
        $db->setQuery($SQL);
		
        return $db->loadObjectList();       
    }
	
    function getBaselineExercises()
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
	$SQL = 'SELECT DISTINCT MB.recid, 
        MB.ExerciseId,
        WT.WorkoutType
        FROM MemberBaseline MB
        JOIN WorkoutTypes WT ON WT.recid = MB.ExerciseTypeId
        LEFT JOIN BaselineLog L ON L.ExerciseId = MB.recid
        WHERE L.MemberId = "'.$_COOKIE['UID'].'"';
        $db->setQuery($SQL);
		
        $Rows = $db->loadObjectList();	
        $Baselines = array();
	foreach($Rows as $Row)
        {
            if($Row->WorkoutType == 'Benchmark'){
                $SQL = 'SELECT MB.recid as ExerciseId, BW.WorkoutName AS Exercise
                FROM MemberBaseline MB 
                JOIN BenchmarkWorkouts BW ON MB.ExerciseId = BW.recid
                WHERE BW.recid = '.$Row->ExerciseId.'';
            }
            else if($Row->WorkoutType == 'Custom'){
                $SQL = 'SELECT MB.recid as ExerciseId, CE.ExerciseName AS Exercise
                FROM MemberBaseline MB
                JOIN CustomWorkouts CW ON CW.recid = MB.ExerciseId
                WHERE CW.recid = '.$Row->ExerciseId.'';               
            }
            
            $db->setQuery($SQL);

            array_push($Baselines, $db->loadObject());
        }	
	return $Baselines;       
    }   
    
    function getBaselineHistory()
    {
	$db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
	$SQL = 'SELECT WT.WorkoutType,
        CASE WHEN WorkoutType = "Benchmark"
        THEN (SELECT WorkoutName FROM BenchmarkWorkouts WHERE recid = L.ExerciseId)
        ELSE
        WorkoutType
        END
        AS WorkoutName,
        E.Exercise, 
        A.Attribute AS Attribute, L.AttributeValue AS AttributeValue, L.TimeCreated 
	FROM BaselineLog L 
        LEFT JOIN MemberBaseline B ON B.ExerciseId = L.ExerciseId 
        LEFT JOIN WorkoutTypes WT ON WT.recid = L.BaselineTypeId
        LEFT JOIN Exercises E ON E.recid = L.ExerciseId
        LEFT JOIN Attributes A ON A.recid = L.AttributeId
	WHERE L.MemberId = '.$_COOKIE['UID'].'
        GROUP BY Exercise, TimeCreated
	ORDER BY WorkoutType, TimeCreated';// AND L.ExerciseId = '.$_REQUEST['BaselineId'].'';
        $db->setQuery($SQL);
		
        return $db->loadObjectList();       
    }    
    
	function getWeightHistory()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT BodyWeight as Weight, TimeCreated 
		FROM ExerciseLog
		WHERE MemberId = '.$_COOKIE['UID'].' AND BodyWeight <> ""';
            $db->setQuery($SQL);
		
            return $db->loadObjectList();	
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
}

?>