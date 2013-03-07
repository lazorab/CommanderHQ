<?php
class UploadModel extends Model
{    
    var $Message;
    
	function __construct()
	{
	
	}
    
    function Save()
	{
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
    
        $RowCount = $_REQUEST['rowcount'];
        if($RowCount > 0){
        $WodTypeId = $_REQUEST['WodTypeId'];
        $WorkoutName = $_REQUEST['WodName'];
        $Routines = $_REQUEST['RoutineCounter'];
        for($i=1;$i<=$Routines;$i++){
            $TimingAttribute = 'TimeToComplete';
            $TimingVal = $_REQUEST[$i.'_Timing'];
            $TimingTypeVal = 1;//Timed
            $NotesVal = $_REQUEST[''.$i.'_Notes'];
            
            if($_REQUEST[''.$i.'_Benchmark'] != ''){
                $BenchmarkId = $_REQUEST[''.$i.'_Benchmark'];
                $SQL = 'INSERT INTO WodWorkouts(GymId, WorkoutName, WodTypeId, WorkoutRoutineTypeId, Notes, WodDate) 
                VALUES("'.$_SESSION['GID'].'", "'. $BenchmarkId .'", "'.$WodTypeId.'", "'.$TimingTypeVal.'", "'.$NotesVal.'", "'.$_REQUEST['WodDate'].'")';
                $db->setQuery($SQL);
                $db->Query();
            }else{
           
            $SQL = 'INSERT INTO WodWorkouts(GymId, WorkoutName, WodTypeId, WorkoutRoutineTypeId, Notes, WodDate) 
            VALUES("'.$_SESSION['GID'].'", "'. $WorkoutName .'", "'.$WodTypeId.'", "'.$TimingTypeVal.'", "'.$NotesVal.'", "'.$_REQUEST['WodDate'].'")';
            $db->setQuery($SQL);
            $db->Query();
            }
            $WodId = $db->insertid();

            //if (!empty($TimingVal))
            //{
            //    $SQL = 'INSERT INTO WodDetails(WodId, ExerciseId, AttributeId, AttributeValueMale, AttributeValueFemale, UnitOfMeasureId, RoutineNo, OrderBy) 
            //    VALUES("'.$WodId.'", 63, (SELECT recid FROM Attributes WHERE Attribute = "'.$TimingAttribute.'"), "'.$TimingVal.'", "'.$TimingVal.'")';
            //    $db->setQuery($SQL);
            //    $db->Query();
            //}
        }
            $ActivityFields = $this->getActivityFields();
            //var_dump($ActivityFields);
            if($ActivityFields != null){
                foreach($ActivityFields AS $ActivityField)
                {
                    $SQL = 'INSERT INTO WodDetails(WodId, ExerciseId, AttributeId, AttributeValueMale, AttributeValueFemale, UnitOfMeasureId, RoutineNo, RoundNo, OrderBy) 
                    VALUES("'.$WodId.'", 
                            "'.$ActivityField->recid.'", 
                            "'.$ActivityField->AttributeId.'", 
                            "'.$ActivityField->AttributeValueMale.'", 
                            "'.$ActivityField->AttributeValueFemale.'",
                            "'.$ActivityField->UOM.'", 
                            "'.$ActivityField->RoutineNo.'", 
                            "'.$ActivityField->RoundNo.'",     
                            "'.$ActivityField->OrderBy.'")';
                    $db->setQuery($SQL);
                    $db->Query();
                }
                    //$SQL = 'INSERT INTO WodDetails(WodId, ExerciseId, AttributeId, AttributeValueMale, AttributeValueFemale, UnitOfMeasureId, RoutineNo, OrderBy) 
                   // VALUES("'.$WodId.'", "63", "7", "00:00:0", "00:00:0", 0, 1, 1)';
                    //$db->setQuery($SQL);
                    //$db->Query();               
            }
        
        $this->Message = 'Success';
        }else{
                $this->Message = 'No Data Entered!';
            }

        return $this->Message;
    }
    
    function getUnitOfMeasure($UnitId){
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT UnitOfMeasure FROM UnitsOfMeasure WHERE recid = '.$UnitId.'';
            $db->setQuery($SQL);
		
            return $db->loadResult();        
    }
    
    function getUnitsOfMeasure($AttributeId){
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT recid, UnitDescription FROM UnitsOfMeasure WHERE AttributeId = '.$AttributeId.'';
            $db->setQuery($SQL);
		
            return $db->loadObjectList();       
    }
        
        function SaveNewExercise()
	{
                $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
                $SQL = 'INSERT INTO Exercises(Exercise, Acronym, GymOption) 
                    VALUES("'.$_REQUEST['NewExercise'].'", "'.$_REQUEST['Acronym'].'", "'.$_SESSION['GID'].'")';
                $db->setQuery($SQL);
                $db->Query();
                $ExerciseId = $db->insertid();
                if(in_array('Weight', $_REQUEST['attributes'])){
                    $SQL = 'INSERT INTO ExerciseAttributes(ExerciseId, AttributeId) 
                        VALUES("'.$ExerciseId.'","'.$this->getAttributeId('Weight').'")';
                    $db->setQuery($SQL);
                    $db->Query(); 
                }
                if(in_array('Height', $_REQUEST['attributes'])){
                    $SQL = 'INSERT INTO ExerciseAttributes(ExerciseId, AttributeId) 
                        VALUES("'.$ExerciseId.'","'.$this->getAttributeId('Height').'")';
                    $db->setQuery($SQL);
                    $db->Query(); 
                }
                if(in_array('Distance', $_REQUEST['attributes'])){
                    $SQL = 'INSERT INTO ExerciseAttributes(ExerciseId, AttributeId) 
                        VALUES("'.$ExerciseId.'","'.$this->getAttributeId('Distance').'")';
                    $db->setQuery($SQL);
                    $db->Query(); 
                }
                if(in_array('Reps', $_REQUEST['attributes'])){
                    $SQL = 'INSERT INTO ExerciseAttributes(ExerciseId, AttributeId) 
                        VALUES("'.$ExerciseId.'","'.$this->getAttributeId('Reps').'")';
                    $db->setQuery($SQL);
                    $db->Query(); 
                }      

            return $this->AddExercise($ExerciseId);
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
        foreach($_REQUEST AS $Name=>$Value)
        {
            $ExplodedKey = explode('_', $Name);
            if(count($ExplodedKey) > 3){
                $RoutineNo = $ExplodedKey[0];
                $RoundNo = $ExplodedKey[1];
                $ExerciseId = $ExplodedKey[2];
                if($ExplodedKey[3] == 'Distance')
                    $DistanceVal = $_REQUEST[''.$Name.''];
                else if($ExplodedKey[3] == 'DUOM')
                    $DistanceUOM = $_REQUEST[''.$Name.''];
                else if($ExplodedKey[3] == 'mHeight')
                    $MHeightVal = $_REQUEST[''.$Name.''];               
                else if($ExplodedKey[3] == 'fHeight')
                    $FHeightVal = $_REQUEST[''.$Name.''];               
                else if($ExplodedKey[3] == 'HUOM')
                    $HeightUOM = $_REQUEST[''.$Name.''];    
                else if($ExplodedKey[3] == 'Rounds')
                    $RoundsVal = $_REQUEST[''.$Name.''];        
                else if($ExplodedKey[3] == 'fWeight')
                    $FWeightVal = $_REQUEST[''.$Name.''];      
                else if($ExplodedKey[3] == 'mWeight')
                    $MWeightVal = $_REQUEST[''.$Name.''];
                else if($ExplodedKey[3] == 'WUOM')
                    $WeightUOM = $_REQUEST[''.$Name.''];       
                else if($ExplodedKey[3] == 'Reps')
                    $RepsVal = $_REQUEST[''.$Name.''];  
                else if($ExplodedKey[3] == 'OrderBy')
                    $OrderBy = $_REQUEST[''.$Name.''];                

                $TimingTypeId = $_REQUEST[''.$RoutineNo.'_'.$RoundNo.'_TimingType'];
                if($TimingTypeId == '' || $TimingTypeId == 0)
                    $this->Message = 'Invalid Timing Type!';
                $TimingAttribute = 'TimeToComplete';
                $TimingVal = $_REQUEST[''.$RoutineNo.'_'.$RoundNo.'_Timing'];
                if($DistanceVal != ''){
                    $SQL='SELECT recid, 
                    (SELECT recid FROM Attributes WHERE Attribute = "Distance") AS AttributeId, 
                    "'.$DistanceVal.'" AS AttributeValueMale, 
                    "'.$DistanceVal.'" AS AttributeValueFemale,
                    "'.$DistanceUOM.'" AS UOM,
                    "'.$RoutineNo.'" AS RoutineNo,     
                    "'.$RoundNo.'" AS RoundNo,   
                    "'.$OrderBy.'" AS OrderBy  
                    FROM Exercises
                    WHERE recid = "'.$ExerciseId.'"';
                    $db->setQuery($SQL);
                    array_push($Activities,$db->loadObject());
                }
                if($MHeightVal != '' && $FHeightVal){
                    $SQL='SELECT recid, 
                    (SELECT recid FROM Attributes WHERE Attribute = "Height") AS AttributeId, 
                    "'.$MHeightVal.'" AS AttributeValueMale,
                    "'.$FHeightVal.'" AS AttributeValueFemale,
                    "'.$HeightUOM.'" AS UOM,
                    "'.$RoutineNo.'" AS RoutineNo,
                    "'.$RoundNo.'" AS RoundNo,                        
                    "'.$OrderBy.'" AS OrderBy      
                    FROM Exercises
                    WHERE recid = "'.$ExerciseId.'"';
                    $db->setQuery($SQL);
                    array_push($Activities,$db->loadObject());
                }                 
                if($RoundsVal != ''){
                    $SQL='SELECT recid, 
                    (SELECT recid FROM Attributes WHERE Attribute = "Rounds") AS AttributeId, 
                    "'.$RoundsVal.'" AS AttributeValueMale, 
                    "'.$RoundsVal.'" AS AttributeValueFemale,
                    "'.$RoutineNo.'" AS RoutineNo,
                    "'.$RoundNo.'" AS RoundNo,                        
                    "'.$OrderBy.'" AS OrderBy      
                    FROM Exercises
                    WHERE recid = "'.$ExerciseId.'"';
                    $db->setQuery($SQL);
                    array_push($Activities,$db->loadObject());
                }
                if($FWeightVal != '' && $MWeightVal != ''){
                    $SQL='SELECT recid, 
                    (SELECT recid FROM Attributes WHERE Attribute = "Weight") AS AttributeId, 
                    "'.$MWeightVal.'" AS AttributeValueMale, 
                    "'.$FWeightVal.'" AS AttributeValueFemale,
                    "'.$WeightUOM.'" AS UOM,
                    "'.$RoutineNo.'" AS RoutineNo,
                     "'.$RoundNo.'" AS RoundNo,                       
                    "'.$OrderBy.'" AS OrderBy        
                    FROM Exercises
                    WHERE recid = "'.$ExerciseId.'"';
                    $db->setQuery($SQL);
                    array_push($Activities,$db->loadObject());                    
                }
                if($RepsVal != ''){
                    $SQL='SELECT recid, 
                    (SELECT recid FROM Attributes WHERE Attribute = "Reps") AS AttributeId, 
                    "'.$RepsVal.'" AS AttributeValueMale, 
                    "'.$RepsVal.'" AS AttributeValueFemale,
                    "'.$RoutineNo.'" AS RoutineNo,
                    "'.$RoundNo.'" AS RoundNo,                        
                    "'.$OrderBy.'" AS OrderBy  
                    FROM Exercises
                    WHERE recid = "'.$ExerciseId.'"';
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
        
    function getWorkoutRoutineTypes()
    {
	$db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
	$SQL = 'SELECT recid, WorkoutType as ActivityType 
                    FROM WorkoutRoutineTypes 
                    ORDER BY ActivityType';
        $db->setQuery($SQL);
		
        return $db->loadObjectList();         
    }
	
	function getWorkoutRoutineTypeId($type)
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT recid FROM WorkoutRoutineTypes WHERE WorkoutType = "'.$type.'"';
            $db->setQuery($SQL);
		
            return $db->loadResult();
	}
        
	function getWorkoutTypeId($type)
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT recid FROM WorkoutTypes WHERE WorkoutType = "'.$type.'"';
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
            $SQL = 'SELECT DISTINCT recid AS Id,
            WorkoutName
            FROM BenchmarkWorkouts
            ORDER BY CategoryId, WorkoutName';
            $db->setQuery($SQL);
		
            return $db->loadObjectList();
        }
        
         function getBenchmarkDetails($Id)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT DISTINCT recid AS BenchmarkId,
            WorkoutName AS BenchmarkName
            FROM BenchmarkWorkouts
            WHERE recid = '.$Id.'';
            $db->setQuery($SQL);
		
            return $db->loadObject();
        }       

	function getExerciseAttributes($Id)
	{
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);

        $SQL = 'SELECT A.recid,
            A.Attribute
            FROM ExerciseAttributes EA
            LEFT JOIN Attributes A ON EA.AttributeId = A.recid
            LEFT JOIN Exercises E ON EA.ExerciseId = E.recid
            WHERE E.recid = "'.$Id.'"
            ORDER BY Attribute';
            $db->setQuery($SQL);
		
            return $db->loadObjectList();
        }
}
?>
