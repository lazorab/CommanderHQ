<?php
class UploadModel extends Model
{    
    var $Message;
    
	function __construct()
	{
	
	}
        

    
    function Save()
	{
        $WodTypeId = $this->getWodTypeId('My Gym');
        
        $Routines = $_REQUEST['RoutineCounter'];
        for($i=1;$i<=$Routines;$i++){
            $TimingTypeVal = $_REQUEST[''.$i.'_TimingType'];
            $NotesVal = $_REQUEST[''.$i.'_Notes'];
        
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'INSERT INTO WodWorkouts(GymId, Routine, WodTypeId, WorkoutRoutineTypeId, Notes, WodDate) 
            VALUES("'.$_SESSION['GID'].'", "'.$i.'", "'.$WodTypeId.'", "'.$TimingTypeVal.'", "'.$NotesVal.'", "'.$_REQUEST['WodDate'].'")';
            $db->setQuery($SQL);
            $db->Query();
            $WodId = $db->insertid();
            $ActivityFields = $this->getActivityFields($i);
            if($ActivityFields != null){
                foreach($ActivityFields AS $ActivityField)
                {
                    $SQL = 'INSERT INTO WodDetails(WodId, ExerciseId, AttributeId, AttributeValueMale, AttributeValueFemale) 
                    VALUES("'.$WodId.'", "'.$ActivityField->recid.'", "'.$ActivityField->AttributeId.'", "'.$ActivityField->AttributeValueMale.'", "'.$ActivityField->AttributeValueFemale.'")';
                    $db->setQuery($SQL);
                    $db->Query();
                }

                $this->Message = 'Success';
            }
        }

        return $this->Message;
    }
        
        function SaveNewExercise()
	{
                $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
                $SQL = 'INSERT INTO Exercises(Exercise, Acronym) 
                    VALUES("'.$_REQUEST['NewExercise'].'", "'.$_REQUEST['Acronym'].'")';
                $db->setQuery($SQL);
                $db->Query();
                $ExerciseId = $db->insertid();
                foreach($_REQUEST['ExerciseAttributes'] AS $Attribute){
                    $SQL = 'INSERT INTO ExerciseAttributes(ExerciseId, AttributeId) 
                        VALUES("'.$ExerciseId.'","'.$this->getAttributeId($Attribute).'")';
                    $db->setQuery($SQL);
                    $db->Query();              
                }
                $Message = $ExerciseId;               

            return $Message;  
        }
        
	function getAttributes()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT recid, Attribute FROM Attributes';
            $db->setQuery($SQL);
		
            return $db->loadObjectList(); 
	}
        
        function getExerciseName($ExerciseId)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT Exercise FROM Exercises WHERE recid = '.$ExerciseId.'';
            $db->setQuery($SQL);
		
            return $db->loadResult();
        }     
    
    function getActivityFields($RoutineNo)
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $this->Message = '';
        $Activities = array();

            foreach($_REQUEST['Routine_'.$RoutineNo.'_exercises'] as $ExerciseId){
                $DistanceVal = $_REQUEST[''.$RoutineNo.'_'.$ExerciseId.'_Distance'];               
                $HeightVal = $_REQUEST[''.$RoutineNo.'_'.$ExerciseId.'_Height'];               
                $RoundsVal = $_REQUEST[''.$RoutineNo.'_'.$ExerciseId.'_Rounds'];
                $FWeightVal = $_REQUEST[''.$RoutineNo.'_'.$ExerciseId.'_FWeight'];
                $MWeightVal = $_REQUEST[''.$RoutineNo.'_'.$ExerciseId.'_MWeight'];
                $RepsVal = $_REQUEST[''.$RoutineNo.'_'.$ExerciseId.'_Reps'];
                $TimingTypeId = $_REQUEST[''.$RoutineNo.'_TimingType'];
                $TimingAttribute = 'TimeToComplete';
                $TimingVal = $_REQUEST[''.$RoutineNo.'_Timing'];
                if($DistanceVal != ''){
                    $SQL='SELECT recid, 
                    (SELECT recid FROM Attributes WHERE Attribute = "Distance") AS AttributeId, 
                    "'.$DistanceVal.'" AS AttributeValueMale, 
                    "'.$DistanceVal.'" AS AttributeValueFemale
                    FROM Exercises
                    WHERE recid = "'.$ExerciseId.'"';
                    $db->setQuery($SQL);
                    array_push($Activities,$db->loadObject());
                }
                if($HeightVal != ''){
                    $SQL='SELECT recid, 
                    (SELECT recid FROM Attributes WHERE Attribute = "Height") AS AttributeId, 
                    "'.$HeightVal.'" AS AttributeValueMale, 
                    "'.$HeightVal.'" AS AttributeValueFemale
                    FROM Exercises
                    WHERE recid = "'.$ExerciseId.'"';
                    $db->setQuery($SQL);
                    array_push($Activities,$db->loadObject());
                }                
                if($RoundsVal != ''){
                    $SQL='SELECT recid, 
                    (SELECT recid FROM Attributes WHERE Attribute = "Rounds") AS AttributeId, 
                    "'.$RoundsVal.'" AS AttributeValueMale, 
                    "'.$RoundsVal.'" AS AttributeValueFemale
                    FROM Exercises
                    WHERE recid = "'.$ExerciseId.'"';
                    $db->setQuery($SQL);
                    array_push($Activities,$db->loadObject());
                }
                if($FWeightVal != '' && $MWeightVal != ''){
                    $SQL='SELECT recid, 
                    (SELECT recid FROM Attributes WHERE Attribute = "Weight") AS AttributeId, 
                    "'.$MWeightVal.'" AS AttributeValueMale, 
                    "'.$FWeightVal.'" AS AttributeValueFemale
                    FROM Exercises
                    WHERE recid = "'.$ExerciseId.'"';
                    $db->setQuery($SQL);
                    array_push($Activities,$db->loadObject());                    
                }
                if($RepsVal != ''){
                    $SQL='SELECT recid, 
                    (SELECT recid FROM Attributes WHERE Attribute = "Reps") AS AttributeId, 
                    "'.$RepsVal.'" AS AttributeValueMale, 
                    "'.$RepsVal.'" AS AttributeValueFemale
                    FROM Exercises
                    WHERE recid = "'.$ExerciseId.'"';
                    $db->setQuery($SQL);
                    array_push($Activities,$db->loadObject());                   
                }
            }
        return $Activities;
    }
    
    function MemberActivityExists()
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $SQL = 'SELECT MemberId AS MemberRecord FROM MemberBaseline WHERE MemberId = "'.$_SESSION['UID'].'"';
        $db->setQuery($SQL);
	$db->Query();
	if($db->getNumRows() > 0)
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
    
    function SaveNewActivities()
    {   
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        for($i=1; $i<$_REQUEST['newcount']; $i++)
        {
            $SQL='SELECT recid FROM Exercises WHERE Exercise = "'.$_REQUEST['newattribute_\'.$i.\''].'"';
            $db->setQuery($SQL);
            $db->Query();
            if($db->getNumRows() > 0){
                $ExerciseId = $db->loadResult();
            }
            else{
                $SQL = 'INSERT INTO Exercises(Exercise) VALUES("'.$_REQUEST['newattribute_\'.$i.\''].'")';
                $db->setQuery($SQL);
                $db->Query();
                $ExerciseId = $db->insertid();
            }
            $SQL = 'INSERT INTO MemberBaseline(MemberId, ExerciseId) VALUES("'.$_SESSION['UID'].'", '.$ExerciseId.')';
            $db->setQuery($SQL);
            $db->Query();
        }
    }  
        
	function getTimingTypeId($type)
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT recid FROM WorkoutTypes WHERE WorkoutType = "'.$type.'"';
            $db->setQuery($SQL);
		
            return $db->loadResult();
	}    
        
 	function getWodTypeId($type)
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT recid FROM WODTypes WHERE WODType = "'.$type.'"';
            $db->setQuery($SQL);
		
            return $db->loadResult();
	}       
        
    function getWorkoutTypes()
    {
	$db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
	$SQL = 'SELECT recid, WorkoutType as ActivityType 
                    FROM WorkoutRoutineTypes 
                    ORDER BY ActivityType';
        $db->setQuery($SQL);
		
        return $db->loadObjectList();         
    }
	
	function getWorkoutTypeId($type)
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT recid FROM WorkoutRoutineTypes WHERE WorkoutType = "'.$type.'"';
            $db->setQuery($SQL);
		
            return $db->loadResult();
	}
	
	function getAttributeId($attribute)
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT recid FROM Attributes WHERE Attribute = "'.$attribute.'"';
            $db->setQuery($SQL);
		
            return $db->loadResult();	
	}  
    
    function getMemberActivities()
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        if(!$this->MemberActivityExists())
            $this->SaveNewBaseline();
        $SQL = 'SELECT MB.ExerciseId AS recid, 
            E.Exercise AS ActivityName, 
            CASE 
            WHEN E.Acronym <> ""
            THEN E.Acronym
            ELSE E.Exercise
            END
            AS InputFieldName,
            A.Attribute, MB.AttributeValue 
            FROM MemberBaseline MB
            JOIN Exercises E ON E.recid = MB.ExerciseId
            JOIN Attributes A ON A.recid = MB.AttributeId
            WHERE MB.MemberId = "'.$_SESSION['UID'].'"';
            $db->setQuery($SQL);
		
            return $db->loadObjectList();
    }
	
	function getActivities()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT DISTINCT E.recid, 
            E.Exercise AS ActivityName,
            CASE 
            WHEN E.Acronym <> ""
            THEN E.Acronym
            ELSE E.Exercise
            END
            AS InputFieldName
            FROM Exercises E
            LEFT JOIN ExerciseAttributes EA ON EA.ExerciseId = E.recid
            WHERE recid > 0
            ORDER BY ActivityName';
            $db->setQuery($SQL);
		
            return $db->loadObjectList();	
	}   
        
        function getBenchmarks()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT DISTINCT recid,
            WorkoutName
            FROM BenchmarkWorkouts
            ORDER BY WorkoutName';
            $db->setQuery($SQL);
		
            return $db->loadObjectList();
        }
        
         function getBenchmarkDetails($Id)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT DISTINCT recid,
            WorkoutName
            FROM BenchmarkWorkouts
            WHERE recid = '.$Id.'';
            $db->setQuery($SQL);
		
            return $db->loadObject();
        }       

	function getExerciseAttributes($Id)
	{
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);

        $SQL = 'SELECT DISTINCT E.recid, 
            E.Exercise AS ActivityName,
            CASE 
            WHEN E.Acronym <> ""
            THEN E.Acronym
            ELSE E.Exercise
            END
            AS InputFieldName,
            A.Attribute
            FROM ExerciseAttributes EA
            LEFT JOIN Attributes A ON EA.AttributeId = A.recid
            LEFT JOIN Exercises E ON EA.ExerciseId = E.recid
            WHERE E.recid = "'.$Id.'"
            ORDER BY ActivityName, Attribute';
            $db->setQuery($SQL);
		
            return $db->loadObjectList();
        }
}
?>
