<?php
class CompletedModel extends Model
{
	function __construct()
	{
            parent::__construct();	
	}
        
	function getCompletedWorkouts()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL="SELECT DISTINCT CW.recid AS WodId, 
CW.WorkoutName AS WodName,
(SELECT recid FROM WorkoutTypes WHERE WorkoutType = 'Custom') AS WodTypeId,
WL.TimeCreated
FROM WODLog WL
JOIN CustomWorkouts CW ON CW.recid = WL.WorkoutId
JOIN WorkoutTypes WT ON WT.recid = WL.WODTypeId
WHERE WL.MemberId = 1 AND WT.WorkoutType = 'Custom'
UNION
SELECT DISTINCT BW.recid AS WodId, 
BW.WorkoutName AS WodName,
(SELECT recid FROM WorkoutTypes WHERE WorkoutType = 'Benchmark') AS WodTypeId,
WL.TimeCreated
FROM WODLog WL
JOIN BenchmarkWorkouts BW ON BW.recid = WL.WorkoutId
JOIN WorkoutTypes WT ON WT.recid = WL.WODTypeId
WHERE WL.MemberId = 1 AND WT.WorkoutType = 'Benchmark'
UNION
SELECT DISTINCT WW.recid AS WodId, 
WW.WorkoutName AS WodName,
(SELECT recid FROM WorkoutTypes WHERE WorkoutType = 'My Gym') AS WodTypeId,
WL.TimeCreated
FROM WODLog WL
JOIN WodWorkouts WW ON WW.recid = WL.WorkoutId
JOIN WorkoutTypes WT ON WT.recid = WL.WODTypeId
WHERE WL.MemberId = 1 AND WT.WorkoutType = 'My Gym'
ORDER BY TimeCreated DESC LIMIT 30";
              
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