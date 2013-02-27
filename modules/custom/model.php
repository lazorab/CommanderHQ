<?php
class CustomModel extends Model
{      
	function __construct()
	{
            parent::__construct();	
	}
    
    function Save()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            if($this->UserIsSubscribed()){
                if(isset($_REQUEST['CustomName']) && $_REQUEST['CustomName'] == ''){
                    $this->Message .= "Error - Name for WOD required!";
                }else{
                $ActivityFields = $this->getActivityFields();
                if($this->Message == ''){
                $WorkoutTypeId = $this->getCustomTypeId();
                $WorkoutRoutineTypeId = $this->getWorkoutRoutineTypeId($_REQUEST['workouttype']);
                $CustomWorkoutId = 0;
                if(isset($_REQUEST['TimeToComplete'])){
                    $SQL = 'INSERT INTO CustomWorkouts(MemberId, WorkoutName, WorkoutRoutineTypeId, Notes, WorkoutDateTime) 
                    VALUES("'.$_SESSION['UID'].'", "'.$_REQUEST['CustomName'].'", "'.$WorkoutRoutineTypeId.'", "'.$_REQUEST['descr'].'", "'.$_REQUEST['WodDate'].'")';
                    $db->setQuery($SQL);
                    $db->Query();
                    $CustomWorkoutId = $db->insertid();
                    $TimeAttributeId = $this->getAttributeId('TimeToComplete');
                    //Save the time
                    $SQL = 'INSERT INTO WODLog(MemberId, WorkoutId, WodTypeId, RoundNo, ExerciseId, AttributeId, AttributeValue) 
                    VALUES("'.$_SESSION['UID'].'", "'.$CustomWorkoutId.'", "'.$WorkoutTypeId.'", "0", "0", "'.$TimeAttributeId.'", "'.$_REQUEST['TimeToComplete'].'")';
                    $db->setQuery($SQL);
                    $db->Query();                 
                }

                if($CustomWorkoutId == 0){
                     $SQL = 'INSERT INTO CustomWorkouts(MemberId, WorkoutName, WorkoutRoutineTypeId, Notes, WorkoutDateTime) 
                    VALUES("'.$_SESSION['UID'].'", "'.$_REQUEST['CustomName'].'", "'.$WorkoutRoutineTypeId.'", "'.$_REQUEST['descr'].'", "'.$_REQUEST['WodDate'].'")';
                    $db->setQuery($SQL);
                    $db->Query();
                    $CustomWorkoutId = $db->insertid();                   
                }
            
        foreach($ActivityFields AS $ActivityField)
        {
            $SQL = 'INSERT INTO CustomDetails(CustomWorkoutId, ExerciseId, AttributeId, AttributeValue, UnitOfMeasureId, RoundNo, OrderBy) 
            VALUES("'.$CustomWorkoutId.'", "'.$ActivityField->ExerciseId.'", "'.$ActivityField->AttributeId.'", "'.$ActivityField->DetailsAttributeValue.'", "'.$ActivityField->UnitOfMeasureId.'", "'.$ActivityField->RoundNo.'", "'.$ActivityField->OrderBy.'")';
            $db->setQuery($SQL);
            $db->Query();

            if($_REQUEST['origin'] == 'baseline'){
                $SQL = 'INSERT INTO BaselineLog(MemberId, BaselineTypeId, ExerciseId, RoundNo, ActivityId, AttributeId, AttributeValue, UnitOfMeasureId) 
                VALUES("'.$_SESSION['UID'].'", "'.$WorkoutTypeId.'", "'.$CustomWorkoutId.'", "'.$ActivityField->RoundNo.'", "'.$ActivityField->ExerciseId.'", "'.$ActivityField->AttributeId.'", "'.$ActivityField->AttributeValue.'", "'.$ActivityField->UnitOfMeasureId.'")';
                $db->setQuery($SQL);
                $db->Query();
            }
            if($ActivityField->AttributeValue != 'Max'){
            $SQL = 'INSERT INTO WODLog(MemberId, WorkoutId, WodTypeId, RoundNo, ExerciseId, AttributeId, AttributeValue, UnitOfMeasureId) 
            VALUES("'.$_SESSION['UID'].'", "'.$CustomWorkoutId.'", "'.$WorkoutTypeId.'", "'.$ActivityField->RoundNo.'", "'.$ActivityField->ExerciseId.'", "'.$ActivityField->AttributeId.'", "'.$ActivityField->AttributeValue.'", "'.$ActivityField->UnitOfMeasureId.'")';
                $db->setQuery($SQL);
                $db->Query();
            }
		}
                $this->Message = 'Success';
            }
                }
            }else{
                $this->Message = 'Error - You are not subscribed!';
            }
        return $this->Message;
	}
        
        function SaveNewExercise()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            if($this->UserIsSubscribed()){
                $SQL = 'INSERT INTO Exercises(Exercise, Acronym, CustomOption) 
                    VALUES("'.$_REQUEST['NewExercise'].'", "'.$_REQUEST['Acronym'].'", "'.$_SESSION['UID'].'")';
                $db->setQuery($SQL);
                $db->Query();
                $ExerciseId = $db->insertid();

                if($_REQUEST['NewActivityWeight'] > 0){
                    $SQL = 'INSERT INTO ExerciseAttributes(ExerciseId, AttributeId) 
                        VALUES("'.$ExerciseId.'","'.$this->getAttributeId('Weight').'")';
                    $db->setQuery($SQL);
                    $db->Query();                   
                }
                 if($_REQUEST['NewActivityHeight'] > 0){
                    $SQL = 'INSERT INTO ExerciseAttributes(ExerciseId, AttributeId) 
                        VALUES("'.$ExerciseId.'","'.$this->getAttributeId('Height').'")';
                    $db->setQuery($SQL);
                    $db->Query();                   
                }
                if($_REQUEST['NewActivityDistance'] > 0){
                    $SQL = 'INSERT INTO ExerciseAttributes(ExerciseId, AttributeId) 
                        VALUES("'.$ExerciseId.'","'.$this->getAttributeId('Distance').'")';
                    $db->setQuery($SQL);
                    $db->Query();                   
                }
                if($_REQUEST['NewActivityReps'] > 0){
                    $SQL = 'INSERT INTO ExerciseAttributes(ExerciseId, AttributeId) 
                        VALUES("'.$ExerciseId.'","'.$this->getAttributeId('Reps').'")';
                    $db->setQuery($SQL);
                    $db->Query();                   
                }                
                $Message = $ExerciseId;               
            }else{
                $Message = 'Error - You are not subscribed!';
            }
            return $Message;  
        }
    
    function MemberActivityExists()
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $SQL = 'SELECT count(MemberId) AS MemberRecord FROM MemberBaseline WHERE MemberId = "'.$_SESSION['UID'].'"';
        $db->setQuery($SQL); 
        $MemberRecord = $db->loadResult();
        if($MemberRecord > 0)
            return true;
        else
            return false;
    }
    
    function getCustomTypeId()
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $SQL = 'SELECT recid FROM WorkoutTypes WHERE WorkoutType = "Custom"';
        $db->setQuery($SQL); 
        return $db->loadResult();
    }  
    
 
    
    function getMemberActivities()
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        if(!$this->MemberActivityExists())
            $this->SaveNewBaseline();
        $SQL = 'SELECT MB.ExerciseId AS ExerciseId, 
            E.Exercise AS ActivityName, 
            E.Acronym, 
            A.Attribute, MB.AttributeValue 
            FROM MemberBaseline MB
            JOIN Exercises E ON E.recid = MB.ExerciseId
            JOIN Attributes A ON A.recid = MB.AttributeId
            WHERE MB.MemberId = "'.$_SESSION['UID'].'"';
	$db->setQuery($SQL);
		
	return $db->loadObjectList();
    }
}
?>