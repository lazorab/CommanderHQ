<?php
class SkillsModel extends Model
{
	var $ExerciseId;
	var $UID;
	var $ExerciseType;
	var $TimeToComplete;
	var $Duration;
	var $Reps;
	var $Weight;
	var $BodyWeight;
	var $Height;
	var $Gender;
	var $LevelAchieved;
	var $OverallLevelAchieved;
	
	function __construct()
	{
	
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
                    $WorkoutTypeId = $_REQUEST['WodTypeId'];
                }                
                $WorkoutTypeId = $this->getWorkoutTypeId('Skills');
        if(count($ActivityFields) > 0){
        foreach($ActivityFields AS $ActivityField)
        {
            if($_REQUEST['origin'] == 'baseline'){
                $SQL = 'INSERT INTO BaselineLog(MemberId, BaselineTypeId, ExerciseId, RoundNo, ActivityId, AttributeId, AttributeValue) 
                VALUES("'.$_COOKIE['UID'].'", "'.$WorkoutTypeId.'", "'.$ThisId.'", "'.$ActivityField->RoundNo.'", "'.$ActivityField->ExerciseId.'", "'.$ActivityField->AttributeId.'", "'.$ActivityField->AttributeValue.'")';
                $db->setQuery($SQL);
                $db->Query();
            }
                $SQL = 'INSERT INTO WODLog(MemberId, WorkoutId, WodTypeId, RoutineNo, RoundNo, ExerciseId, AttributeId, AttributeValue, UnitOfMeasureId, OrderBy) 
                VALUES("'.$_COOKIE['UID'].'", "'.$ThisId.'", "'.$WorkoutTypeId.'", "'.$ActivityField->RoutineNo.'", "'.$ActivityField->RoundNo.'", "'.$ActivityField->ExerciseId.'", "'.$ActivityField->AttributeId.'", "'.$ActivityField->AttributeValue.'", "'.$ActivityField->UnitOfMeasureId.'", "'.$ActivityField->OrderBy.'")';
                $db->setQuery($SQL);
                $db->Query();
            
		}
            }else if(isset($_REQUEST['ActivityTime'])){
                $ExplodedKey = explode('_', $_REQUEST['ActivityId']);
                $ExerciseId = $ExplodedKey[2];
                $ActivityTime = $_REQUEST['ActivityTime'];
                $SQL = 'INSERT INTO WODLog(MemberId, ExerciseId, WodTypeId, AttributeId, AttributeValue) 
                VALUES("'.$_COOKIE['UID'].'", "'.$ExerciseId.'", "'.$WorkoutTypeId.'", "'.$this->getAttributeId('TimeToComplete').'", "'.$ActivityTime.'")';
                $db->setQuery($SQL);
                $db->Query();   
            }else if(isset($_REQUEST['TimeFieldName'])){
                //$WorkoutTypeId.'_'.$WorkoutId.'_'.$ThisRoutine_TimeToComplete
                $ExplodedKey = explode('_', $_REQUEST['TimeFieldName']);
                $WorkoutTypeId = $ExplodedKey[0];
                $ThisId = $ExplodedKey[1];
                $RoutineNo = $ExplodedKey[2];
                $RoutineTime = $_REQUEST['RoutineTime'];
                $SQL = 'INSERT INTO WODLog(MemberId, WorkoutId, WodTypeId, RoutineNo, AttributeId, AttributeValue) 
                VALUES("'.$_COOKIE['UID'].'", "'.$ThisId.'", "'.$WorkoutTypeId.'", "'.$RoutineNo.'", "'.$this->getAttributeId('TimeToComplete').'", "'.$RoutineTime.'")';
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
}
?>