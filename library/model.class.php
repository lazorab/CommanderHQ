<?php
class Model
{  
    var $Message;
    
	function __construct()
	{
	
	}
	
	function getRandomMessage()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $Message = '';
            if(isset($_SESSION['UID'])){
                $SQL = 'SELECT FirstName FROM Members WHERE UserId = "'.$_SESSION['UID'].'"';
                $db->setQuery($SQL);
                $FirstName = $db->loadResult();

                $SQL = 'SELECT Message FROM RandomMessage WHERE recid = 1';
                $db->setQuery($SQL);

                $Message = str_replace('{NAME}',$FirstName,$db->loadResult());
            }
            else{
                $Message = 'Subscribe to get full use of Commander';
            }
		
            return $Message;	
	}
        
 	function getMessage()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT Message FROM ActionMessages WHERE recid = '.$_REQUEST['message'].'';
            $db->setQuery($SQL);
		
            return $db->loadResult();	
	}       
        
        function getGender()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT Gender FROM MemberDetails WHERE MemberId = "'.$_SESSION['UID'].'"';
            $db->setQuery($SQL);
            
            return $db->loadResult();
        }
        
        function getSystemOfMeasure()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT SystemOfMeasure FROM MemberDetails WHERE MemberId = "'.$_SESSION['UID'].'"';
            $db->setQuery($SQL);
            
            return $db->loadResult();
        }
        
        function getUnitOfMeasure($Id)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT UnitOfMeasure FROM UnitsOfMeasure WHERE recid = "'.$Id.'"';
            $db->setQuery($SQL);
            
            return $db->loadResult();
        }      
        
        function getUnitOfMeasureId($Unit)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);  
                
            $SQL = 'SELECT UM.recid 
                FROM UnitsOfMeasure UM JOIN Attributes A ON A.recid = UM.AttributeId
                WHERE Attribute = "'.$Unit.'" 
                AND SystemOfMeasure = "'.$this->getSystemOfMeasure().'"';
            $db->setQuery($SQL);
            
            return $db->loadResult();
        }         
        
        function getUserUnitOfMeasure($Unit)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);  
                
            $SQL = 'SELECT UM.UnitOfMeasure 
                FROM UnitsOfMeasure UM JOIN Attributes A ON A.recid = UM.AttributeId
                WHERE Attribute = "'.$Unit.'" 
                AND SystemOfMeasure = "'.$this->getSystemOfMeasure().'"';
            $db->setQuery($SQL);
            
            return $db->loadResult();
        }        
        
        function UserIsSubscribed()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $Status = false;
            if(SUBSCRIPTION){
                $SQL = 'SELECT Subscribed FROM MemberDetails WHERE MemberId = "'.$_SESSION['UID'].'"';
                $db->setQuery($SQL);
                $Status = $db->loadResult();
            }else{
                $Status = true;
            }
            return $Status;
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
    
    function getWorkoutTypeId($Type)
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $SQL = 'SELECT recid FROM WorkoutTypes WHERE WorkoutType = "'.$Type.'"';
        $db->setQuery($SQL);
            
        return $db->loadResult();
    }
    
	function getWODTypes()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT recid, WODType AS ActivityType FROM WODTypes';
            $db->setQuery($SQL);
            return $db->loadObjectList();
	}    
    
    	function getMemberGym()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT RG.AffiliateId, RG.GymName, RG.City, RG.Region, RG.URL
		FROM Affiliates RG
		JOIN MemberDetails MD ON MD.GymId = RG.AffiliateId
		WHERE MD.MemberId = "'.$_SESSION['UID'].'"';
            $db->setQuery($SQL);
            $db->Query();
            if($db->getNumRows() > 0){
		$MemberGym = $db->loadObject();
            }
            else{
		$MemberGym = false;
            }
            return $MemberGym;
	}
	
	function getWorkoutRoutineTypeId($type)
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT recid FROM WorkoutRoutineTypes WHERE WorkoutType = "'.$type.'"';
            $db->setQuery($SQL);
            
            return $db->loadResult();
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
	
	function getAttributeId($attribute)
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT recid FROM Attributes WHERE Attribute = "'.$attribute.'"';
            $db->setQuery($SQL);
            
            return $db->loadResult();	
	}         
        
        function getExercises()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);

        $SQL = 'SELECT DISTINCT E.recid AS ExerciseId, 
            E.Exercise AS ActivityName,
            E.Acronym
            FROM Exercises E
            LEFT JOIN ExerciseAttributes EA ON EA.ExerciseId = E.recid
            WHERE CustomOption = 0
            OR CustomOption = "'.$_SESSION['UID'].'"
            ORDER BY ActivityName';
            $db->setQuery($SQL);
		
            return $db->loadObjectList();	
	}  
        
 	function getExerciseIdAttributes($Id)
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT DISTINCT E.recid AS ExerciseId, 
			E.Exercise AS ActivityName,
                        CASE WHEN E.Acronym <> ""
                        THEN E.Acronym
                        ELSE E.Exercise
                        END
                        AS InputFieldName,
			A.Attribute,
			(SELECT recid FROM UnitsOfMeasure WHERE A.recid = AttributeId AND SystemOfMeasure = "'.$this->getSystemOfMeasure().'" LIMIT 1)
			AS UOMId,
			(SELECT UnitOfMeasure FROM UnitsOfMeasure WHERE A.recid = AttributeId AND SystemOfMeasure = "'.$this->getSystemOfMeasure().'" LIMIT 1)
			AS UOM
			FROM ExerciseAttributes EA
			LEFT JOIN Attributes A ON EA.AttributeId = A.recid
			LEFT JOIN Exercises E ON EA.ExerciseId = E.recid
			WHERE E.recid = "'.$Id.'"
                        AND A.Attribute <> "TimeToComplete"
                        AND A.Attribute <> "Rounds"
                        AND A.Attribute <> "Calories"
			ORDER BY ActivityName, Attribute';
            $db->setQuery($SQL);
            return $db->loadObjectList();	
	}   
        
     function getActivityFields($ValidateReps = true)
    {
        if(isset($_REQUEST['TimeToComplete']) && $_REQUEST['TimeToComplete'] == '00:00:0'){
                $this->Message = 'Error - Invalid Value for Stopwatch!';  
        }
        if($this->Message == ''){
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $Activities = array();
        //var_dump($_REQUEST);
        foreach($_REQUEST AS $Name=>$Value)
        {
            $RoundNo = 0;
            $ExerciseId = 0;
            $Attribute = '';
            $ExplodedKey = explode('_', $Name);
            if(count($ExplodedKey) > 3)
            {
                    $RoundNo = $ExplodedKey[0];
                    $ExerciseId = $ExplodedKey[1];
                    $ExerciseName = $this->getExerciseName($ExerciseId);
                    $Attribute = $ExplodedKey[2];
                    $UOMId = $ExplodedKey[3];
                    $OrderBy = $ExplodedKey[4];
                    $DetailsValue=$Value;
                    if(array_key_exists('5', $ExplodedKey))
                        $DetailsValue='Max';
                    if($UOMId == 0 && $Attribute == 'Distance')
                        $UOMId = $_REQUEST[''.$RoundNo.'_'.$ExerciseId.'_Distance_UOM'];
                    $UOM = $this->getUnitOfMeasure($UOMId);
                if($Value == '' || $Value == '0' || $Value == $Attribute){
                        if($Attribute == 'Reps' && $ValidateReps == true)
                            $this->Message = 'Error - Invalid Value for '.$Attribute.'!';
                }
                if($this->Message == ''){
                $SQL='SELECT recid AS ExerciseId,
                        "'.$ExerciseName.'" AS Exercise,
                        (SELECT recid FROM Attributes WHERE Attribute = "'.$Attribute.'") AS AttributeId,
                        "'.$Attribute.'" AS Attribute,    
                        "'.$Value.'" AS AttributeValue,  
                        "'.$DetailsValue.'" AS DetailsAttributeValue,     
                        "'.$UOMId.'" AS UnitOfMeasureId,
                        "'.$UOM.'" AS UnitOfMeasure,    
                        "'.$RoundNo.'" AS RoundNo,
                        "'.$OrderBy.'" AS OrderBy     
                        FROM Exercises
                        WHERE recid = "'.$ExerciseId.'"';
                $db->setQuery($SQL);
		
                $Row = $db->loadObject();
                array_push($Activities, $Row);
                }      
            }
        }
        return $Activities;
        }
    }       

	function getExerciseAttributes($Exercise)
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT DISTINCT E.recid AS ExerciseId, 
			E.Exercise AS ActivityName,
                        CASE WHEN E.Acronym <> ""
                        THEN E.Acronym
                        ELSE E.Exercise
                        END
                        AS InputFieldName,
			A.Attribute,
			(SELECT recid FROM UnitsOfMeasure WHERE A.recid = AttributeId AND SystemOfMeasure = "'.$this->getSystemOfMeasure().'" LIMIT 1)
			AS UOMId,
			(SELECT UnitOfMeasure FROM UnitsOfMeasure WHERE A.recid = AttributeId AND SystemOfMeasure = "'.$this->getSystemOfMeasure().'" LIMIT 1)
			AS UOM
			FROM ExerciseAttributes EA
			LEFT JOIN Attributes A ON EA.AttributeId = A.recid
			LEFT JOIN Exercises E ON EA.ExerciseId = E.recid
			WHERE E.Exercise = "'.$Exercise.'"
                        AND A.Attribute <> "TimeToComplete"
                        AND A.Attribute <> "Rounds"
                        AND A.Attribute <> "Calories"
			ORDER BY ActivityName, Attribute';
            $db->setQuery($SQL);
            return $db->loadObjectList();	
	}
        
        function getExerciseHistory($Id)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL='SELECT E.Exercise, 
                A.Attribute, 
                WL.AttributeValue, 
                UOM.UnitOfMeasure,
                WL.RoundNo,
                TimeCreated
                FROM WODLog WL 
                LEFT JOIN Attributes A ON A.recid = WL.AttributeId
                LEFT JOIN UnitsOfMeasure UOM ON WL.UnitOfMeasureId = UOM.recid
                LEFT JOIN Exercises E ON E.recid = WL.ExerciseId
                WHERE WL.ExerciseId = '.$Id.'
                AND MemberId = "'.$_SESSION['UID'].'"
                ORDER BY TimeCreated DESC, RoundNo, Attribute';
            //var_dump($SQL);
            $db->setQuery($SQL);
            return $db->loadObjectList();
        }
}
?>