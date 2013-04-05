<?php
class PersonalModel extends Model
{
	function __construct()
	{
            parent::__construct();	
	}
	
        function getDescription($Id)
        {
            //$Filter = '';
            //if($Id != ''){
            //   $Filter = ' AND CW.recid = "'.$Id.'"'; 
            //}
            $SQL = 'SELECT CW.WorkoutName, 
                E.Exercise, 
                E.Acronym, 
                A.Attribute, 
                CD.AttributeValue, 
                CD.RoundNo,
                CD.OrderBy,
                (SELECT MAX(RoundNo) FROM CustomDetails WHERE CustomWorkoutId = "'.$Id.'") AS TotalRounds,
                WT.WorkoutType,
                CW.Notes
                FROM CustomDetails CD
                LEFT JOIN CustomWorkouts CW ON CW.recid = CD.CustomWorkoutId
                LEFT JOIN Exercises E ON E.recid = CD.ExerciseId
                LEFT JOIN Attributes A ON A.recid = CD.AttributeId
                LEFT JOIN WorkoutRoutineTypes WT ON WT.recid = CW.WorkoutRoutineTypeId
                WHERE CW.MemberId = "'.$_COOKIE['UID'].'"
                AND CW.recid = "'.$Id.'"
                ORDER BY RoundNo, OrderBy, Exercise, Attribute';
            return $this->MakeDescription($SQL);
        }      
        
        function MakeDescription($SQL)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $db->setQuery($SQL);
            $Result = $db->loadObjectList();
            //var_dump($SQL);
            $Description = '';
            $Exercise = '';
            $TotalRounds = '';
            $WorkoutType = '';
            foreach($Result AS $Row)
            {
                if($Exercise != $Row->Exercise){
                    if($Description == ''){
                        if($Row->TotalRounds > 1){
                            $TotalRounds = ''.$Row->TotalRounds.' Rounds | ';
                        }
                        if($Row->WorkoutType == 'Timed')
                            $WorkoutType = 'For Time | ';    
                        else if($Row->WorkoutType != 'AMRAP Rounds')
                            $WorkoutType = ''.$Row->WorkoutType.' | ';
                    }

                    $Exercise = $Row->Exercise;
                }
                if($Row->Attribute == 'Reps' && $Row->AttributeValue > 0){
                    $Description .= ''.$Row->AttributeValue.' '.$Row->Exercise.' | ';
                }else if($Row->Exercise != 'Timed'){
                        $Description .= ''.$Row->Exercise.' | ';                   
                }else if($Row->Attribute == 'Weight'){

                }else if($Row->Attribute == 'Height'){
                    
                }else if($Row->Attribute == 'Distance'){
                    
                }else if($Row->Attribute == 'TimeToComplete'){
                    
                }else if($Row->Attribute == 'CountDown'){
                    
                }else if($Row->Attribute == 'Rounds'){
                    
                }else if($Row->Attribute == 'Calories'){
                    
                }else if($Row->Attribute == 'TimeLimit')
                    $WorkoutType = 'AMRAP In '.$Row->AttributeValue.' | ';                
            }
            //$Description .= $TotalRounds.$WorkoutType;
            return $TotalRounds.$WorkoutType.$Description;           
        }
        
	function getPersonalWorkouts()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
		$SQL = 'SELECT recid AS Id, 
                    WorkoutName,
                    Notes
                    FROM CustomWorkouts
                    WHERE MemberId = "'.$_COOKIE['UID'].'"
                    ORDER BY WorkoutdateTime DESC';
             /*   
                $SQL="SELECT DISTINCT CW.recid AS WodId, 
CW.WorkoutName AS WodName,
'Custom' AS WodType,
WL.TimeCreated
FROM WODLog WL
JOIN CustomWorkouts CW ON CW.recid = WL.WorkoutId
JOIN WorkoutTypes WT ON WT.recid = WL.WODTypeId
WHERE WL.MemberId = 1 AND WT.WorkoutType = 'Custom'
UNION
SELECT DISTINCT BW.recid AS WodId, 
BW.WorkoutName AS WodName,
'Benchmark' AS WodType,
WL.TimeCreated
FROM WODLog WL
JOIN BenchmarkWorkouts BW ON BW.recid = WL.WorkoutId
JOIN WorkoutTypes WT ON WT.recid = WL.WODTypeId
WHERE WL.MemberId = 1 AND WT.WorkoutType = 'Benchmark'
UNION
SELECT DISTINCT WW.recid AS WodId, 
WW.WorkoutName AS WodName,
'My Gym' AS WodType,
WL.TimeCreated
FROM WODLog WL
JOIN WodWorkouts WW ON WW.recid = WL.WorkoutId
JOIN WorkoutTypes WT ON WT.recid = WL.WODTypeId
WHERE WL.MemberId = 1 AND WT.WorkoutType = 'My Gym'
ORDER BY TimeCreated DESC LIMIT 30";
              
              */
            $db->setQuery($SQL);
		
            return $db->loadObjectList();
	}	
	
	function getWorkoutDetails($Id)
	{   
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);

        if($this->getGender() == 'M'){
            $AttributeValue = 'AttributeValueMale';
        } else {
            $AttributeValue = 'AttributeValueFemale';
		}
		//$SQL = 'SELECT WorkoutName, '.$DescriptionField.' AS WorkoutDescription, '.$InputFields.' AS InputFields, VideoId FROM BenchmarkWorkouts WHERE recid = '.$Id.'';
		
		$SQL = 'SELECT BW.recid AS Id,
                        BW.WorkoutName, 
                        E.Exercise,
                        E.recid AS ExerciseId, 
                        CASE 
                            WHEN E.Acronym <> ""
                            THEN E.Acronym
                            ELSE E.Exercise
                        END
                        AS InputFieldName,
                        A.Attribute, 
                        BD.'.$AttributeValue.' AS AttributeValue, 
                        UOM.UnitOfMeasure,
                        UOM.ConversionFactor,    
                        VideoId, 
                        RoundNo,
                        (SELECT MAX(RoundNo) FROM CustomDetails WHERE CustomWorkoutId = "'.$Id.'") AS TotalRounds
			FROM CustomDetails BD
			LEFT JOIN CustomWorkouts BW ON BW.recid = BD.CustomWorkoutId
			LEFT JOIN Exercises E ON E.recid = BD.ExerciseId
			LEFT JOIN Attributes A ON A.recid = BD.AttributeId
                        LEFT JOIN UnitsOfMeasure UOM ON UOM.AttributeId = A.recid AND BD.UnitOfMeasureId = UOM.recid
			WHERE BD.CustomWorkoutId = '.$Id.'
                        AND (Attribute = "Reps" OR SystemOfMeasure = "Metric")    
			ORDER BY RoundNo, OrderBy, Exercise, Attribute';
            $db->setQuery($SQL);
		
            return $db->loadObjectList(); 
	}	
        
        function getCustomDetails($Id)
	{   
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT CW.WorkoutName, 
                        E.Exercise, 
                        E.recid AS ExerciseId, 
                        CASE 
                            WHEN E.Acronym <> ""
                            THEN E.Acronym
                            ELSE E.Exercise
                        END
                        AS InputFieldName,
                        CW.Notes,
                        E.recid AS ExerciseId, 
                        A.Attribute, 
                        CD.AttributeValue,
                        CD.UnitOfMeasureId,
                        UOM.UnitOfMeasure,
                        UOM.ConversionFactor,
                        CD.RoutineNo,
                        CD.RoundNo,
                        CD.OrderBy,
                        (SELECT MAX(RoundNo) FROM CustomDetails WHERE CustomWorkoutId = "'.$Id.'") AS TotalRounds
			FROM CustomDetails CD
                        LEFT JOIN CustomWorkouts CW ON CW.recid = CD.CustomWorkoutId
			LEFT JOIN Exercises E ON E.recid = CD.ExerciseId
			LEFT JOIN Attributes A ON A.recid = CD.AttributeId
                        LEFT JOIN UnitsOfMeasure UOM ON UOM.AttributeId = A.recid AND CD.UnitOfMeasureId = UOM.recid
			WHERE CW.MemberId = "'.$_COOKIE['UID'].'"
                        AND CW.recid = "'.$Id.'"
			ORDER BY RoutineNo, RoundNo, OrderBy, Exercise, Attribute';
            //return $SQL;
            $db->setQuery($SQL);
		
            return $db->loadObjectList();
	}	
        
        function getMyGymDetails($Id)
	{   
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
             if($this->getGender() == 'M'){
                $AttributeValue = 'AttributeValueMale';
            } else {
                $AttributeValue = 'AttributeValueFemale';
            }  

		$SQL = 'SELECT WW.recid AS Id,
                        WW.WorkoutName, 
                        E.Exercise, 
                        E.recid AS ExerciseId, 
                        CASE 
                            WHEN E.Acronym <> ""
                            THEN E.Acronym
                            ELSE E.Exercise
                        END
                        AS InputFieldName,  
                        A.Attribute, 
                       '.$AttributeValue.' AS AttributeValue,
                        WD.UnitOfMeasureId,   
                        UOM.UnitOfMeasure,
                        UOM.ConversionFactor,
                        WD.RoutineNo,
                        WD.RoundNo,
                        WD.OrderBy,
                        (SELECT MAX(RoundNo) FROM WodDetails WHERE WodId = Id AND RoutineNo = WD.RoutineNo) AS TotalRounds,
                        WW.WorkoutRoutineTypeId,
                        WW.WodDate,
                        WW.Notes
			FROM WodDetails WD
			LEFT JOIN WodWorkouts WW ON WW.recid = WD.WodId
			LEFT JOIN Exercises E ON E.recid = WD.ExerciseId
			LEFT JOIN Attributes A ON A.recid = WD.AttributeId
                        LEFT JOIN UnitsOfMeasure UOM ON UOM.recid = WD.UnitOfMeasureId
			WHERE WW.recid = '.$Id.'
			UNION
                        SELECT WW.recid AS Id,
                        BW.WorkoutName, 
                        E.Exercise,
                        E.recid AS ExerciseId, 
                        CASE 
                            WHEN E.Acronym <> ""
                            THEN E.Acronym
                            ELSE E.Exercise
                        END
                        AS InputFieldName,
                        A.Attribute, 
                        '.$AttributeValue.' AS AttributeValue, 
                        BD.UnitOfMeasureId,    
                        UOM.UnitOfMeasure,
                        UOM.ConversionFactor,    
                        WW.RoutineNo, 
                        BD.RoundNo,
                        BD.OrderBy,
                        (SELECT MAX(RoundNo) FROM BenchmarkDetails WHERE BenchmarkId = WW.WorkoutName) AS TotalRounds,
                        WW.WorkoutRoutineTypeId,
                        WW.WodDate,
                        WW.Notes                        
			FROM BenchmarkDetails BD
			LEFT JOIN BenchmarkWorkouts BW ON BW.recid = BD.BenchmarkId
			LEFT JOIN WodWorkouts WW ON WW.WorkoutName = BD.BenchmarkId
			LEFT JOIN Exercises E ON E.recid = BD.ExerciseId
			LEFT JOIN Attributes A ON A.recid = BD.AttributeId
                        LEFT JOIN UnitsOfMeasure UOM ON UOM.AttributeId = A.recid AND BD.UnitOfMeasureId = UOM.recid
			WHERE WW.recid = '.$Id.'
                        AND (Attribute = "Reps" OR SystemOfMeasure = "'.$this->getSystemOfMeasure().'")			
			ORDER BY RoutineNo, RoundNo, OrderBy, Exercise, Attribute';
            //return $SQL;
            $db->setQuery($SQL);
		
            return $db->loadObjectList();
	}        
	
    function Log()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SetBaseline = false;
            if($this->UserIsSubscribed()){
            $ActivityFields = $this->getActivityFields();
            //var_dump($ActivityFields);
            if($this->Message == ''){
                if($_REQUEST['WorkoutId'] != ''){
                    $ThisId = $_REQUEST['WorkoutId'];
                    $WorkoutTypeId = $this->getWorkoutTypeId('Custom');
                }

                if($_REQUEST['baseline'] == 'yes'){
                    $SetBaseline = true;
                    $SQL = 'DELETE FROM MemberBaseline WHERE MemberId = "'.$_COOKIE['UID'].'"';
                    $db->setQuery($SQL);
                    $db->Query();
                }
                foreach($ActivityFields AS $ActivityField)
                {
                    $AttributeValue = '';
                    //check to see if we must convert back to metric first for data storage
                         if($ActivityField->Attribute == 'Height' || $ActivityField->Attribute == 'Distance' || $ActivityField->Attribute == 'Weight'){
                            
				if($ActivityField->Attribute == 'Distance'){
					if($this->getSystemOfMeasure() != 'Metric'){
                                            $AttributeValue = round($ActivityField->AttributeValue * 1.61, 2);
                                        }
				}		
				else if($ActivityField->Attribute == 'Weight'){
					if($this->getSystemOfMeasure() != 'Metric'){
                                            $AttributeValue = round($ActivityField->AttributeValue * 0.45, 2);
                                        }
				}
				else if($ActivityField->Attribute == 'Height'){
					if($this->getSystemOfMeasure() != 'Metric'){
                                            $AttributeValue = round($ActivityField->AttributeValue * 2.54, 2);
                                        }
                                }
			}   
                    if($AttributeValue == ''){
                        $AttributeValue = $ActivityField->AttributeValue;
                    }
                    if($SetBaseline){
                        $SQL = 'INSERT INTO MemberBaseline(MemberId, BaselineTypeId, WorkoutId, ExerciseId, AttributeId, AttributeValue) 
                            VALUES("'.$_COOKIE['UID'].'", "'.$WorkoutTypeId.'", "'.$ThisId.'", "'.$ActivityField->ExerciseId.'", "'.$ActivityField->AttributeId.'", "'.$AttributeValue.'")';
                        $db->setQuery($SQL);
                        $db->Query();
                    }
                    if($_REQUEST['origin'] == 'baseline'){
                        $SQL = 'INSERT INTO BaselineLog(MemberId, BaselineTypeId, ExerciseId, RoundNo, ActivityId, AttributeId, AttributeValue) 
				VALUES("'.$_COOKIE['UID'].'", "'.$WorkoutTypeId.'", "'.$ThisId.'", "'.$ActivityField->RoundNo.'", "'.$ActivityField->ExerciseId.'", "'.$ActivityField->AttributeId.'", "'.$AttributeValue.'")';
                        $db->setQuery($SQL);
                        $db->Query();
                    }
                    // ExerciseId only applies for benchmarks so we need it here!
                    $SQL = 'INSERT INTO WODLog(MemberId, WorkoutId, WodTypeId, RoundNo, ExerciseId, AttributeId, AttributeValue, UnitOfMeasureId, OrderBy) 
			VALUES("'.$_COOKIE['UID'].'", "'.$ThisId.'", "'.$WorkoutTypeId.'", "'.$ActivityField->RoundNo.'", "'.$ActivityField->ExerciseId.'", "'.$ActivityField->AttributeId.'", "'.$AttributeValue.'", "'.$ActivityField->UnitOfMeasureId.'", "'.$ActivityField->OrderBy.'")';
                        $db->setQuery($SQL);
                        $db->Query();
                        //var_dump($SQL);
                    $this->Message = 'Success';
		}
            }
            }else{
                $this->Message = 'You are not subscribed!';
            }
            return $this->Message;
	}
    
 	function LevelAchieved($ExerciseObject)
	{
            $Level = 0;
            $Sql = 'SELECT SL.AttributeValue, SL.SkillsLevel
                    FROM SkillsLevels SL 
                    LEFT JOIN Attributes A ON A.recid = SL.AttributeId
                    LEFT JOIN Exercises E ON E.recid = SL.ExerciseId
                    WHERE A.Attribute = "'.$ExerciseObject->Attribute.'"
                    AND E.Exercise = "'.$ExerciseObject->Exercise.'"
                    AND (SL.Gender = "U" OR SL.Gender = "'.$this->getGender().'")
                    ORDER BY SkillsLevel';
    
            $Result = mysql_query($Sql);
            while($Row = mysql_fetch_assoc($Result))
            {
                if($ExerciseObject->Attribute == 'TimeToComplete'){
                    $ExplodedTime = explode(':', $ExerciseObject->AttributeValue);
                    $SecondsToComplete = ($ExplodedTime[0] * 60) + $ExplodedTime[1];   
                    $ExplodedTime = explode(':', $Row['AttributeValue']);
                    $SecondsToCompare = ($ExplodedTime[0] * 60) + $ExplodedTime[1];
                    if($SecondsToComplete < $SecondsToCompare)
                        $Level = $Row['SkillsLevel'];
                }
                else{
                    if($ExerciseObject->AttributeValue > $Row['AttributeValue'])
                        $Level = $Row['SkillsLevel'];
                }
            }
        }
		

	function OverallLevelAchieved()
	{
		$Level = 4;
		$CompletedExercises = array();
		$Sql = 'SELECT ExerciseId, MAX(LevelAchieved) FROM ExerciseLog WHERE MemberId = '.$this->UID.' GROUP BY ExerciseId';
		$Result = mysql_query($Sql);
		while($Row = mysql_fetch_assoc($Result))
		{
			if($Row['LevelAchieved'] < $Level)
				$Level = $Row['LevelAchieved'];
			array_push($CompletedExercises,$Row['ExerciseId']);
		}

		$PendingExercises=array();
		$AllExercises = $this->getExercises();
		foreach($AllExercises AS $Exercise)
		{
			if(!in_array($Exercise->Id, $CompletedExercises))
				array_push($PendingExercises,$Exercise->Id);
		}
		if(count($PendingExercises) == 0)
			return $Level;
		else
			return 0;
	}	
	
	function getHistory()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT B.recid, B.WorkoutName, A.Attribute, L.AttributeValue, L.TimeCreated 
		FROM WODLog L 
                LEFT JOIN CustomWorkouts B ON B.recid = L.ExerciseId 
                LEFT JOIN Attributes A ON A.recid = L.AttributeId
                LEFT JOIN WorkoutTypes ET ON ET.recid = L.WODTypeId
                WHERE L.MemberId = '.$_COOKIE['UID'].' 
                AND ET.WorkoutType = "Custom"
                AND A.Attribute = "TimeToComplete"
                ORDER BY TimeCreated';
            $db->setQuery($SQL);
		
            return $db->loadObjectList(); 
	}
}

?>