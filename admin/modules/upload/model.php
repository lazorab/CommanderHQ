<?php
class UploadModel extends Model
{    
    var $Message;
    
	function __construct()
	{
	
	}
    
    function Save()
	{

            $Activities = $this->getActivityFields();

            //var_dump($ActivityFields);
            if($this->Message == ''){
                $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
                $SQL = 'INSERT INTO WodWorkouts(GymId, WorkoutName, WodTypeId, WorkoutRoutineTypeId, WodDate) 
                VALUES("'.$_SESSION['GID'].'", "'.$_REQUEST['WorkoutName'].'", "'.$WodTypeId.'", "'.$WorkoutRoutineTypeId.'", "'.$_REQUEST['WodDate'].'")';
                $db->setQuery($SQL);
                $db->Query();
                $WodId = $db->insertid();
            
            if($Activities != null){
            foreach($Activities AS $ActivityField)
            {
                $SQL = 'INSERT INTO WodDetails(WodId, ExerciseId, AttributeId, AttributeValue, RoundNo) 
                VALUES("'.$WodId.'", "'.$ActivityField->recid.'", "'.$ActivityField->Attribute.'", "'.$ActivityField->AttributeValue.'", "'.$ActivityField->RoundNo.'")';
                $db->setQuery($SQL);
                $db->Query();
		}
            }
                $this->Message = 'Success';
            }

        return $this->Message;
	
        }
        
        function SaveNewExercise()
	{
            if($this->UserIsSubscribed()){
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
                $Message = 'Exercise Successfully Added!';               
            }else{
                $Message = 'You are not subscribed!';
            }
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
    
    function getActivityFields()
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $this->Message = '';
        $Activities = array();
        $Routines = $_REQUEST['RoutineCounter'];
        for($i=1;$i<$Routines;$i++){
            $SelectedExercises=$_REQUEST['exercises_'.$i.''];
        foreach($SelectedExercises AS $key=>$val)
        {
            $ExerciseId = 0;
            $Attribute = '';
            $ExplodedKey = explode('___', $key);

            $RoutineNo = $ExplodedKey[0];
            $ExerciseId = $ExplodedKey[1];
            $ExerciseName = $this->getExerciseName($ExerciseId);
            $Attribute = $ExplodedKey[2];
            
            if($val != ''){
                if($Attribute == 'MWeight'){
                 $SQL='SELECT recid, 
                    (SELECT recid FROM Attributes WHERE Attribute = "Weight") AS Attribute, 
                    "'.$val.'" AS AttributeValueMale,  
                    "'.$RoutineNo.'" AS RoutineNo
                    FROM Exercises
                    WHERE recid = "'.$ExerciseId.'"';                   
                }else if($Attribute == 'FWeight'){
                 $SQL='SELECT recid, 
                    (SELECT recid FROM Attributes WHERE Attribute = "Weight") AS Attribute,  
                    "'.$val.'" AS AttributeValueFeMale, 
                    "'.$RoutineNo.'" AS RoutineNo
                    FROM Exercises
                    WHERE recid = "'.$ExerciseId.'"';                   
                }else{
                    
                
                    if($ExerciseId > 0){
                        $SQL='SELECT recid, 
                            (SELECT recid FROM Attributes WHERE Attribute = "'.$Attribute.'") AS Attribute, 
                            "'.$val.'" AS AttributeValueMale, 
                            "'.$val.'" AS AttributeValueFeMale, 
                            "'.$RoutineNo.'" AS RoutineNo
                            FROM Exercises
                            WHERE recid = "'.$ExerciseId.'"';
                    }
                    else{
                        $SQL='SELECT "'.$ExerciseId.'" AS recid,
                            recid AS Attribute,
                            "'.$val.'" AS AttributeValueMale, 
                            "'.$val.'" AS AttributeValueFeMale, 
                            "'.$RoutineNo.'" AS RoutineNo
                            FROM Attributes WHERE Attribute = "'.$Attribute.'"';
                    
                    }
                }
                $db->setQuery($SQL);
		
                array_push($Activities,$db->loadObject());
            }

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
        
	function getWodTypeId($type)
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT recid FROM WorkoutTypes WHERE WorkoutType = "'.$type.'"';
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