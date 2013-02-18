<?php
class BenchmarkModel extends Model
{
	function __construct()
	{
            parent::__construct();	
	}
	
	function getCategory($Id)
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT Category FROM BenchmarkCategories WHERE recid = '.$Id.'';
            $db->setQuery($SQL);
            
            return $db->loadResult();
	}	
        
        function getCustomMemberWorkouts()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT recid,
                DATE_FORMAT(TimeCreated, "%d %M %Y") AS WorkoutName,
                TimeCreated
                FROM CustomWorkouts
                WHERE MemberId = "'.$_SESSION['UID'].'"
                GROUP BY TimeCreated   
                ORDER BY TimeCreated';
            $db->setQuery($SQL);
		
            return $db->loadObjectList();
        }
        
        function getCustomPublicWorkouts()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT DATE_FORMAT(CD.TimeCreated, "%d %M %Y") AS CD.WorkoutName,
                DATE_FORMAT(CD.TimeCreated, "%Y-%m-%d") AS CD.TimeCreated
                FROM CustomDetails CD
                LEFT JOIN MemberDetails MD ON MD.MemberId = CD.MemberId
                WHERE MD.CustomWorkouts = "Public"
                AND CD.MemberId <> "'.$_SESSION['UID'].'"
                GROUP BY WorkoutName    
                ORDER BY WorkoutName';
            $db->setQuery($SQL);
		
            return $db->loadObjectList();
        }
	
        function getCustomDescription($Id)
        {
            $Filter = '';
            if($Id != ''){
               $Filter = ' AND CW.recid = "'.$Id.'"'; 
            }
            $SQL = 'SELECT DATE_FORMAT(CW.TimeCreated, "%d %M %Y") AS WorkoutName, E.Exercise, 
                E.Acronym, 
                A.Attribute, 
                CD.AttributeValue, 
                CD.RoundNo,
                WT.WorkoutType,
                CW.TimeCreated,
                CW.Notes
                FROM CustomDetails CD
                LEFT JOIN CustomWorkouts CW ON CW.recid = CD.CustomWorkoutId
                LEFT JOIN Exercises E ON E.recid = CD.ExerciseId
                LEFT JOIN Attributes A ON A.recid = CD.AttributeId
                LEFT JOIN WorkoutRoutineTypes WT ON WT.recid = CW.WorkoutRoutineTypeId
                WHERE CW.MemberId = "'.$_SESSION['UID'].'"
                    '.$Filter.'
                ORDER BY TimeCreated, RoundNo, Exercise';
            return $this->MakeDescription($SQL);
        }
        
        function getBenchmarkDescription($Id)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            if($this->getGender() == 'M'){
                $DescriptionField = 'DescriptionMale';
            } else {
                $DescriptionField = 'DescriptionFemale';
            }
             $SQL = 'SELECT '.$DescriptionField.' AS Description
                     FROM BenchmarkWorkouts BW
                     WHERE BW.recid = "'.$Id.'"'; 
            $db->setQuery($SQL);
		
            return $db->loadResult();
        }       
        
        function _getBenchmarkDescription($Id)
        {
            if($this->getGender() == 'M'){
                $AttributeValue = 'AttributeValueMale';
            } else {
                $AttributeValue = 'AttributeValueFemale';
            }
             $SQL = 'SELECT E.Exercise, 
                 E.Acronym, 
                 A.Attribute, 
                 '.$AttributeValue.' AS AttributeValue, 
                     WT.WorkoutType,
                     (SELECT MAX(RoundNo) FROM BenchmarkDetails WHERE BenchmarkId = "'.$Id.'") AS TotalRounds,
                     BD.RoundNo
                FROM BenchmarkDetails BD
                LEFT JOIN Exercises E ON E.recid = BD.ExerciseId
                LEFT JOIN Attributes A ON A.recid = BD.AttributeId
                LEFT JOIN BenchmarkWorkouts BW ON BW.recid = BD.BenchmarkId
                LEFT JOIN WorkoutRoutineTypes WT ON WT.recid = BW.WorkoutTypeId
                WHERE BD.BenchmarkId = "'.$Id.'"
                GROUP BY Exercise
                ORDER BY OrderBy'; 
             return $this->MakeDescription($SQL);
        }
        
        function MakeDescription($SQL)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $db->setQuery($SQL);
            $Result = $db->loadObjectList();
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
                    //$Description .= ' ';
                   // $Description .= $Row->AttributeValue;
                    //if($this->getSystemOfMeasure() == 'Metric')
                    //    $Description .= 'kg';
                    //else if($this->getSystemOfMeasure() == 'Imperial')
                    //    $Description .= 'lbs';
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
        
	function getBMWS($Category)
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
		$SQL = 'SELECT BW.recid AS Id, BW.WorkoutName, BW.VideoId, BC.Category 
                    FROM BenchmarkWorkouts BW
                    JOIN BenchmarkCategories BC ON BC.recid = BW.CategoryId
                    WHERE BC.Category = "'.$Category.'"
                    ORDER BY WorkoutName';
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
                        (SELECT MAX(RoundNo) FROM BenchmarkDetails WHERE BenchmarkId = "'.$Id.'") AS TotalRounds
			FROM BenchmarkDetails BD
			LEFT JOIN BenchmarkWorkouts BW ON BW.recid = BD.BenchmarkId
			LEFT JOIN Exercises E ON E.recid = BD.ExerciseId
			LEFT JOIN Attributes A ON A.recid = BD.AttributeId
                        LEFT JOIN UnitsOfMeasure UOM ON UOM.AttributeId = A.recid AND BD.UnitOfMeasureId = UOM.recid
			WHERE BD.BenchmarkId = '.$Id.'
                        AND (Attribute = "Reps" OR SystemOfMeasure = "Metric")    
			ORDER BY RoundNo, OrderBy, Exercise, Attribute';
            $db->setQuery($SQL);
		
            return $db->loadObjectList(); 
	}	
        
        function getCustomDetails($Id)
	{   
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT DATE_FORMAT(CW.TimeCreated, "%d %M %Y") AS WorkoutName, 
                        E.Exercise, 
                        E.recid AS ExerciseId, 
                        CASE 
                            WHEN E.Acronym <> ""
                            THEN E.Acronym
                            ELSE E.Exercise
                        END
                        AS InputFieldName,
                        CW.Notes,
                        "'.$this->getCustomDescription($Id).'" AS WorkoutDescription,
                        E.recid AS ExerciseId, 
                        A.Attribute, 
                        CD.AttributeValue,  
                        RoundNo
			FROM CustomDetails CD
                        LEFT JOIN CustomWorkouts CW ON CW.recid = CD.CustomWorkoutId
			LEFT JOIN Exercises E ON E.recid = CD.ExerciseId
			LEFT JOIN Attributes A ON A.recid = CD.AttributeId
			WHERE CW.MemberId = "'.$_SESSION['UID'].'"
                        AND CW.recid = "'.$Id.'"
			ORDER BY RoundNo, Attribute';
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
                $WorkoutTypeId = $this->getWorkoutTypeId('Benchmark');
                $TimeAttributeId = $this->getAttributeId('TimeToComplete');
                //Save the time
                $SQL = 'INSERT INTO WODLog(MemberId, WorkoutId, WodTypeId, RoundNo, ExerciseId, AttributeId, AttributeValue) 
                VALUES("'.$_SESSION['UID'].'", "'.$_REQUEST['benchmarkId'].'", "'.$WorkoutTypeId.'", "0", "0", "'.$TimeAttributeId.'", "'.$_REQUEST['TimeToComplete'].'")';
                $db->setQuery($SQL);
                $db->Query();                
                //$Attributes=$this->getAttributes();
                //var_dump($ActivityFields);
                if($_REQUEST['baseline'] == 'yes'){
                    $SetBaseline = true;
                    $SQL = 'DELETE FROM MemberBaseline WHERE MemberId = "'.$_SESSION['UID'].'"';
                    $db->setQuery($SQL);
                    $db->Query();
                }

        foreach($ActivityFields AS $ActivityField)
        {
            if($_REQUEST['origin'] == 'baseline'){
                $SQL = 'INSERT INTO BaselineLog(MemberId, BaselineTypeId, ExerciseId, RoundNo, ActivityId, AttributeId, AttributeValue) 
                VALUES("'.$_SESSION['UID'].'", "'.$WorkoutTypeId.'", "'.$_REQUEST['benchmarkId'].'", "'.$ActivityField->RoundNo.'", "'.$ActivityField->ExerciseId.'", "'.$ActivityField->AttributeId.'", "'.$ActivityField->AttributeValue.'")';
                $db->setQuery($SQL);
                $db->Query();
            }
            // ExerciseId only applies for benchmarks so we need it here!
            $SQL = 'INSERT INTO WODLog(MemberId, WorkoutId, WodTypeId, RoundNo, ExerciseId, AttributeId, AttributeValue, UnitOfMeasureId) 
            VALUES("'.$_SESSION['UID'].'", "'.$_REQUEST['benchmarkId'].'", "'.$WorkoutTypeId.'", "'.$ActivityField->RoundNo.'", "'.$ActivityField->ExerciseId.'", "'.$ActivityField->AttributeId.'", "'.$ActivityField->AttributeValue.'", "'.$ActivityField->UnitOfMeasureId.'")';
                $db->setQuery($SQL);
                $db->Query();
            
		}
                $this->Message = 'Success';
            }
            }else{
                $this->Message = 'Error - You are not subscribed!';
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
                LEFT JOIN BenchmarkWorkouts B ON B.recid = L.ExerciseId 
                LEFT JOIN Attributes A ON A.recid = L.AttributeId
                LEFT JOIN WorkoutTypes ET ON ET.recid = L.WODTypeId
                WHERE L.MemberId = '.$_SESSION['UID'].' 
                AND ET.WorkoutType = "Benchmark"
                AND A.Attribute = "TimeToComplete"
                ORDER BY TimeCreated';
            $db->setQuery($SQL);
		
            return $db->loadObjectList(); 
	}
}

?>