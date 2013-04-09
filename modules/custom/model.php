<?php
class CustomModel extends Model
{
function __construct()
{
            parent::__construct();	
}

        function CheckCustomNameExists()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL='SELECT WorkoutName FROM CustomWorkouts WHERE MemberId = "'.$_COOKIE['UID'].'" AND WorkoutName = "'.trim($_REQUEST['CustomName']).'"';
            $db->setQuery($SQL);
            $db->Query();
            if($db->getNumRows() > 0)
                return true;
            else 
                return false;            
        }
        
         function CheckExerciseNameExists()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL='SELECT Exercise FROM Exercises WHERE CustomOption = "'.$_COOKIE['UID'].'" AND Exercise = "'.trim($_REQUEST['NewExercise']).'"';
            $db->setQuery($SQL);
            $db->Query();
            if($db->getNumRows() > 0)
                return true;
            else 
                return false;            
        }       
    
    function Save()
{
            if($this->UserIsSubscribed()){
                if(isset($_REQUEST['CustomName']) && $_REQUEST['CustomName'] == ''){
                    $this->Message = "Error - Name for WOD required!";
                }else if($_REQUEST['WodDate'] == '' || $_REQUEST['WodDate'] < date('Y-m-d')){
                    $this->Message = 'Error - Invalid Date!';                   
                }else if($_REQUEST['WodDate'] > date('Y-m-d', strtotime("+30 days"))){
                    $this->Message = 'Error - Date too far ahead!';     
                }else if($this->CheckCustomNameExists()){
                    $this->Message = "Error - WOD Name already exists!";
                }else{    
                $ActivityFields = $this->getActivityFields();
                if($this->Message == ''){
                    $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
                $WorkoutTypeId = $this->getCustomTypeId();
                $WorkoutRoutineTypeId = $this->getWorkoutRoutineTypeId($_REQUEST['workouttype']);
                $CustomWorkoutId = 0;

                if($CustomWorkoutId == 0){
                    
                
                     $SQL = 'INSERT INTO CustomWorkouts(MemberId, WorkoutName, WorkoutRoutineTypeId, Notes, WorkoutDateTime)
VALUES("'.$_COOKIE['UID'].'", "'.$_REQUEST['CustomName'].'", "'.$WorkoutRoutineTypeId.'", "'.$_REQUEST['descr'].'", "'.$_REQUEST['WodDate'].'")';
                    $db->setQuery($SQL);
                    $db->Query();
                    $CustomWorkoutId = $db->insertid();
                }
            
        foreach($ActivityFields AS $ActivityField)
        {
            $SQL = 'INSERT INTO CustomDetails(CustomWorkoutId, ExerciseId, AttributeId, AttributeValue, UnitOfMeasureId, RoutineNo, RoundNo, OrderBy)
VALUES("'.$CustomWorkoutId.'", "'.$ActivityField->ExerciseId.'", "'.$ActivityField->AttributeId.'", "'.$ActivityField->DetailsAttributeValue.'", "'.$ActivityField->UnitOfMeasureId.'", "'.$ActivityField->RoutineNo.'","'.$ActivityField->RoundNo.'", "'.$ActivityField->OrderBy.'")';
            $db->setQuery($SQL);
            $db->Query();
}
                $this->Message = $CustomWorkoutId;
            }
                }
            }else{
                $this->Message = 'Error - You are not subscribed!';
            }
        return $this->Message;
}
        
        function SaveNewExercise()
        {
            if($this->CheckExerciseNameExists()){
                $Message = "Error - Exercise already exists!";
            }else{  
                if($this->UserIsSubscribed()){
                    $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
                $SQL = 'INSERT INTO Exercises(Exercise, Acronym, CustomOption)
VALUES("'.$_REQUEST['NewExercise'].'", "'.$_REQUEST['Acronym'].'", "'.$_COOKIE['UID'].'")';
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
            }
            return $Message;
        }
    
    function MemberActivityExists()
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $SQL = 'SELECT count(MemberId) AS MemberRecord FROM MemberBaseline WHERE MemberId = "'.$_COOKIE['UID'].'"';
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
WHERE MB.MemberId = "'.$_COOKIE['UID'].'"';
$db->setQuery($SQL);

return $db->loadObjectList();
    }
}
?>