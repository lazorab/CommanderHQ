<?php
class Model
{  
    var $Message;
    
	function __construct()
	{
	
	}
        
    function CheckUserNameExists($UserName)
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $SQL='SELECT UserId FROM Members WHERE UserName = "'.$UserName.'"';
        $db->setQuery($SQL);
	$db->Query();
	if($db->getNumRows() > 0)
            return true;
        else 
            return false; 
    }
    
    function CheckEmailExists($Email)
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $SQL='SELECT UserId FROM Members WHERE Email = "'.$Email.'"';
        $db->setQuery($SQL);
	$db->Query();
	if($db->getNumRows() > 0)
            return true;
        else 
            return false;
    }
    
     function CheckCellExists($Cell)
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $SQL='SELECT UserId FROM Members WHERE Cell = "'.$Cell.'"';
        $db->setQuery($SQL);
	$db->Query();
	if($db->getNumRows() > 0)
            return true;
        else 
            return false;
    }        
    
    function getUsersName(){
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT FirstName, LastName FROM Members WHERE UserId = "'.$_COOKIE['UID'].'"';
            $db->setQuery($SQL);
            $Member = $db->loadObject(); 
            $Name = ''.$Member->FirstName.' '.$Member->LastName.'';
            return $Name;
    }
	
	function getRandomMessage()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $Message = '';
            if(isset($_COOKIE['UID'])){
                $SQL = 'SELECT FirstName FROM Members WHERE UserId = "'.$_COOKIE['UID'].'"';
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
            $SQL = 'SELECT Gender FROM MemberDetails WHERE MemberId = "'.$_COOKIE['UID'].'"';
            $db->setQuery($SQL);
            
            return $db->loadResult();
        }
        
        function getSystemOfMeasure()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT SystemOfMeasure FROM MemberDetails WHERE MemberId = "'.$_COOKIE['UID'].'"';
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
        
        function getUnitOfMeasureId($Attribute)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);  
                
            $SQL = 'SELECT UM.recid 
                FROM UnitsOfMeasure UM JOIN Attributes A ON A.recid = UM.AttributeId
                WHERE Attribute = "'.$Attribute.'" 
                AND SystemOfMeasure = "'.$this->getSystemOfMeasure().'"';
            $db->setQuery($SQL);
            
            return $db->loadResult();
        }         
        
        function getUserUnitOfMeasure($Attribute)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);  
                
            $SQL = 'SELECT UM.UnitOfMeasure 
                FROM UnitsOfMeasure UM JOIN Attributes A ON A.recid = UM.AttributeId
                WHERE Attribute = "'.$Attribute.'" 
                AND SystemOfMeasure = "'.$this->getSystemOfMeasure().'"';
            $db->setQuery($SQL);
            
            return $db->loadResult();
        }        
        
        function UserIsSubscribed()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $Status = false;
            if(SUBSCRIPTION){
                $SQL = 'SELECT Subscribed FROM MemberDetails WHERE MemberId = "'.$_COOKIE['UID'].'"';
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
    
    function getWorkoutType($TypeId)
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $SQL = 'SELECT WorkoutType FROM WorkoutTypes WHERE recid = "'.$TypeId.'"';
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
        
        function getMemberAgreeToTerms() 
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT TermsAccepted FROM Members WHERE UserId = "'.$_COOKIE['UID'].'"';
            $db->setQuery($SQL);
            return $db->loadResult();
        }
        
        function getAffiliates($Search = '') {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT AffiliateId,
            GymName
            FROM Affiliates
            WHERE GymName <> ""';
            if($Search != '')
                $SQL .= ' AND GymName LIKE "'.$Search.'%"';
            $SQL .= ' ORDER BY GymName';
            if($Search != '')
                $SQL .= ' LIMIT 30';            
	$db->setQuery($SQL);
		
	return $db->loadObjectList();
    }        
    
    	function getMemberGym()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT RG.AffiliateId, RG.GymName, RG.City, RG.Region, RG.URL
		FROM Affiliates RG
		JOIN MemberDetails MD ON MD.GymId = RG.AffiliateId
		WHERE MD.MemberId = "'.$_COOKIE['UID'].'"';
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
        
        function getExerciseId($Exercise)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT recid FROM Exercises WHERE Exercise  = "'.$Exercise.'"';
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
        
        function getExercises($Search = '')
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);

            $SQL = 'SELECT DISTINCT E.recid AS ExerciseId, 
                    E.Exercise AS ActivityName,
                    E.Acronym
                    FROM Exercises E
                    LEFT JOIN ExerciseAttributes EA ON EA.ExerciseId = E.recid
                    WHERE recid > 0
                    AND (CustomOption = 0
                    OR CustomOption = "'.$_COOKIE['UID'].'"
                    OR GymOption = "'.$this->getMemberGym()->AffiliateId.'")';
            if($Search != ''){
                $SQL .= ' AND Exercise LIKE "'.$Search.'%"';                
            }
            $SQL .= ' ORDER BY ActivityName';
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
        
     function getActivityFields()
    {
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
            if(count($ExplodedKey) > 5)
            {
                if($ExplodedKey[5] != 'UOM'){
                //eg. 1_1_8_Height_0_1
                $RoutineNo = $ExplodedKey[0];
                $RoundNo = $ExplodedKey[1];
                $ExerciseId = $ExplodedKey[2];
                $ExerciseName = $this->getExerciseName($ExerciseId);
                $Attribute = $ExplodedKey[3];
                $UOMId = $ExplodedKey[4];
                $OrderBy = $ExplodedKey[5];
                if($Attribute != 'TimeToComplete' && $Value == '')
                    $Value = 'Max';
                $DetailsValue=$Value;
                if(array_key_exists('6', $ExplodedKey))
                    $DetailsValue='Max';
                if(($Attribute == 'Distance' || $Attribute == 'Height') && isset($_REQUEST[''.$RoutineNo.'_'.$RoundNo.'_'.$OrderBy.'_'.$ExerciseId.'_'.$Attribute.'_UOM'])){
                    //eg. 1_1_1_8_Height_UOM
                    //var_dump(''.$RoutineNo.'_'.$RoundNo.'_'.$OrderBy.'_'.$ExerciseId.'_'.$Attribute.'_UOM');
                    $UOMId = $_REQUEST[''.$RoutineNo.'_'.$RoundNo.'_'.$OrderBy.'_'.$ExerciseId.'_'.$Attribute.'_UOM'];
                }
                $UOM = $this->getUnitOfMeasure($UOMId);
                /*No validation required according to Hans...
                if($Value == '' || $Value == '0' || $Value == $Attribute || $Value == 'Max'){
                    if($Validate == true)
                        $this->Message = 'Error - Invalid Value for '.$ExerciseName.' '.$Attribute.'!';
                }
                */
                if($this->Message == '' && $Value != ''){
                $SQL='SELECT recid AS ExerciseId,
                        "'.$ExerciseName.'" AS Exercise,
                        (SELECT recid FROM Attributes WHERE Attribute = "'.$Attribute.'") AS AttributeId,
                        "'.$Attribute.'" AS Attribute,    
                        "'.$Value.'" AS AttributeValue,  
                        "'.$DetailsValue.'" AS DetailsAttributeValue,     
                        "'.$UOMId.'" AS UnitOfMeasureId,
                        "'.$UOM.'" AS UnitOfMeasure, 
                        "'.$RoutineNo.'" AS RoutineNo,    
                        "'.$RoundNo.'" AS RoundNo,
                        "'.$OrderBy.'" AS OrderBy     
                        FROM Exercises
                        WHERE recid = "'.$ExerciseId.'"';
                //var_dump($SQL);
                $db->setQuery($SQL);
                $Row = $db->loadObject();
                if(is_object($Row))
                    array_push($Activities, $Row);
                } }     
            }else if(count($ExplodedKey) > 4){
                if($ExplodedKey[3] != 'UOM'){
                $RoundNo = $ExplodedKey[0];
                $ExerciseId = $ExplodedKey[1];
                $ExerciseName = $this->getExerciseName($ExerciseId);
                $Attribute = $ExplodedKey[2];
                $UOMId = $ExplodedKey[3];
                $OrderBy = $ExplodedKey[4];
                $DetailsValue=$Value;
                if(array_key_exists('5', $ExplodedKey))
                    $DetailsValue='Max';
                if($Attribute == 'Distance' || $Attribute == 'Height')
                    $UOMId = $_REQUEST[''.$RoundNo.'_'.$ExerciseId.'_'.$Attribute.'_UOM'];
                $UOM = $this->getUnitOfMeasure($UOMId);
                /*No validation required according to Hans...
                if($Value == '' || $Value == '0' || $Value == $Attribute || $Value == 'Max'){
                    if($Validate == true)
                        $this->Message = 'Error - Invalid Value for '.$Attribute.'!';
                }
                 */
                if($this->Message == '' && $Value != ''){
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
                if(is_object($Row))
                    array_push($Activities, $Row);
                }  }              
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
            $LastThreeRecords = '';
            $SQL='SELECT DISTINCT TimeCreated AS ListItem
                FROM WODLog 
                WHERE ExerciseId = '.$Id.'
                AND MemberId = "'.$_COOKIE['UID'].'" 
                ORDER BY TimeCreated DESC LIMIT 3';
            $db->setQuery($SQL);
             $db->Query();
            if($db->getNumRows() > 0){           
                $LastThreeRecords = $db->loadList();
            }
            if($LastThreeRecords != ''){
            $SQL='SELECT E.Exercise, 
                A.Attribute, 
                WL.AttributeValue, 
                UOM.UnitOfMeasure,
                WL.RoundNo,
                WL.OrderBy,
                TimeCreated,
                (SELECT MAX(TimeCreated) FROM WODLog WL WHERE WL.ExerciseId = '.$Id.'
                AND (Attribute = "Reps" OR SystemOfMeasure = "'.$this->getSystemOfMeasure().'")    
                AND MemberId = "'.$_COOKIE['UID'].'") AS LastRecord
                FROM WODLog WL 
                LEFT JOIN Attributes A ON A.recid = WL.AttributeId
                LEFT JOIN UnitsOfMeasure UOM ON UOM.recid = WL.UnitOfMeasureId
                LEFT JOIN Exercises E ON E.recid = WL.ExerciseId
                WHERE WL.ExerciseId = '.$Id.'
                AND (Attribute = "Reps" OR SystemOfMeasure = "'.$this->getSystemOfMeasure().'")    
                AND MemberId = "'.$_COOKIE['UID'].'"
                AND TimeCreated IN '.$LastThreeRecords.' 
                ORDER BY TimeCreated, RoundNo, OrderBy, Attribute';
            //var_dump($SQL);
            $db->setQuery($SQL);
            return $db->loadObjectList();
            }
        }
        
	function getBenchmarks()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT BW.recid AS Id, 
                    BW.WorkoutName, 
                    BW.VideoId, 
                    BC.Category 
                    FROM BenchmarkWorkouts BW
                    JOIN BenchmarkCategories BC ON BC.recid = BW.CategoryId
                    ORDER BY Category, WorkoutName';
            $db->setQuery($SQL);
		
            return $db->loadObjectList();
	}  
        
	function getBenchmarkDetails($Id)
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
                        "2" AS WodTypeId,
                        E.recid AS ExerciseId, 
                        CASE 
                            WHEN E.Acronym <> ""
                            THEN E.Acronym
                            ELSE E.Exercise
                        END
                        AS InputFieldName,
                        A.Attribute, 
                        BD.'.$AttributeValue.' AS AttributeValue, 
                        BD.UnitOfMeasureId,    
                        UOM.UnitOfMeasure,
                        UOM.ConversionFactor,    
                        VideoId, 
                        "1" AS RoutineNo,
                        RoundNo,
                        OrderBy,
                        (SELECT MAX(RoundNo) FROM BenchmarkDetails WHERE BenchmarkId = "'.$Id.'") AS TotalRounds
			FROM BenchmarkDetails BD
			LEFT JOIN BenchmarkWorkouts BW ON BW.recid = BD.BenchmarkId
			LEFT JOIN Exercises E ON E.recid = BD.ExerciseId
			LEFT JOIN Attributes A ON A.recid = BD.AttributeId
                        LEFT JOIN UnitsOfMeasure UOM ON UOM.AttributeId = A.recid AND BD.UnitOfMeasureId = UOM.recid
			WHERE BD.BenchmarkId = '.$Id.'
                        AND (Attribute = "Reps" OR SystemOfMeasure = "'.$this->getSystemOfMeasure().'")    
			ORDER BY RoutineNo, RoundNo, OrderBy, Exercise, Attribute';
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
        
        function SaveRoutineTime($TimeFieldName)
        {
            $ExplodedDetails = explode('_',$TimeFieldName);
            $WODTypeId = $ExplodedDetails[0];
            $WorkoutId = $ExplodedDetails[1];
            $RoutineNo = $ExplodedDetails[2];
            $AttributeId = $this->getAttributeId('TimeToComplete');
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL='INSERT INTO WODLog(MemberId, WODTypeId, WorkoutId, RoutineNo, ExerciseId, AttributeId, AttributeValue) 
                VALUES("'.$_COOKIE['UID'].'", "'.$WODTypeId.'", "'.$WorkoutId.'", "'.$RoutineNo.'", "0", "'.$AttributeId.'","'.$_REQUEST['RoutineTime'].'")';
            $db->setQuery($SQL);
            $db->Query();
            
            return 'Success';
        }
        
        function ClearBaseline()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'DELETE FROM MemberBaseline WHERE MemberId = "'.$_COOKIE['UID'].'"';
            $db->setQuery($SQL);
            $db->Query();           
        }
        
        function MakeBaseline($ThisId, $WorkoutTypeId)
        {
            $this->ClearBaseline();
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
                    
            $SQL = 'INSERT INTO MemberBaseline(MemberId, BaselineTypeId, WorkoutId) 
                  VALUES("'.$_COOKIE['UID'].'", "'.$WorkoutTypeId.'", "'.$ThisId.'")';
            $db->setQuery($SQL); 
            $db->Query();  
        }     
        
        function NewFontSize($MasterSize)
        {
            if(LAYOUT_WIDTH > SCREENWIDTH)
            {
                $ratio = SCREENWIDTH / LAYOUT_WIDTH;
            }
            else if(SCREENWIDTH > LAYOUT_WIDTH)
            {
                $ratio = LAYOUT_WIDTH / SCREENWIDTH;
            }
            else
                $ratio = 1;
     
            $FontSize = ceil($MasterSize * $ratio);

            return 'font-size:'.$FontSize.'px';
        } 
        
        function NewLineHeight($MasterSize)
        {
            if(LAYOUT_WIDTH > SCREENWIDTH)
            {
                $ratio = SCREENWIDTH / LAYOUT_WIDTH;
            }
            else if(SCREENWIDTH > LAYOUT_WIDTH)
            {
                $ratio = LAYOUT_WIDTH / SCREENWIDTH;
            }
            else
                $ratio = 1;
     
            $NewSize = ceil($MasterSize * $ratio);

            return 'height:'.$NewSize.'px; line-height:'.$NewSize.'px';
        } 
        
    function getMemberDetails($Id)
    {
        if($Id > 0){
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
 		$SQL='SELECT M.UserId,
		M.FirstName,
		M.LastName,
		M.Cell,
		M.Email,
		M.UserName,
		M.PassWord,
                M.oauth_provider AS LoginType,
		MD.SkillLevel,
                MD.GymId,
                A.GymName,
		MD.Gender,
		MD.DOB,
                MD.SystemOfMeasure,
		MD.Anon,
                MD.Height,
                MD.Weight,
                MD.BMI,
                MD.RestHR,
                MD.RecHR
                FROM Members M 
                LEFT JOIN MemberDetails MD ON MD.MemberId = M.UserId 
                LEFT JOIN Affiliates A ON MD.GymId = A.AffiliateId
                WHERE M.UserId = "'.$Id.'"';           

            $db->setQuery($SQL);
		
            $MemberDetails = $db->loadObject();   
            if($MemberDetails->SystemOfMeasure == 'Imperial'){
                //convert to metric for storage in db. Displaying of values will be converted back.
                $MemberDetails->Weight = ceil($MemberDetails->Weight * 2.22);
                $MemberDetails->Height = ceil($MemberDetails->Height * 0.39);
            }          
        }
        else{
            $MemberDetails=new MemberObject($_REQUEST);
        }   
	return $MemberDetails;
    }        
}
?>