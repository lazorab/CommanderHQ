<?php
class Model
{
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
			CASE WHEN "'.$this->getSystemOfMeasure().'" = "Metric"
			THEN (SELECT recid FROM UnitsOfMeasure WHERE A.recid = AttributeId AND Metric = 1 HAVING COUNT(recid) = 1)
			ELSE (SELECT recid FROM UnitsOfMeasure WHERE A.recid = AttributeId AND Metric = 0 HAVING COUNT(recid) = 1)
			END
			AS UOMId,
			CASE WHEN "'.$this->getSystemOfMeasure().'" = "Metric"
			THEN (SELECT UnitOfMeasure FROM UnitsOfMeasure WHERE A.recid = AttributeId AND Metric = 1 HAVING COUNT(UnitOfMeasure) = 1)
			ELSE (SELECT UnitOfMeasure FROM UnitsOfMeasure WHERE A.recid = AttributeId AND Metric = 0 HAVING COUNT(UnitOfMeasure) = 1)
			END
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
            $SQL='SELECT E.Exercise, A.Attribute, WL.AttributeValue, UOM.UnitOfMeasure, TimeCreated
                FROM WODLog WL 
                LEFT JOIN Attributes A ON A.recid = WL.AttributeId
                LEFT JOIN UnitsOfMeasure UOM ON WL.UnitOfMeasureId = UOM.recid
                LEFT JOIN Exercises E ON E.recid = WL.ExerciseId
                WHERE WL.ExerciseId = '.$Id.'
                AND MemberId = "'.$_SESSION['UID'].'"
                ORDER BY TimeCreated DESC';
            //var_dump($SQL);
            $db->setQuery($SQL);
            return $db->loadObjectList();
        }
}
?>