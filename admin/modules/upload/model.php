<?php
class UploadModel extends Model
{    
    var $Message;
    
	function __construct()
	{
	
	}
    
    function Save()
	{

                if(!isset($_REQUEST['benchmarkId'])){
                    $Activities = $this->getActivityFields();
                    $WodTypeId = $this->getWodTypeId('Custom');
                    $WorkoutRoutineTypeId = $this->getWorkoutTypeId($_REQUEST['workouttype']);
                }else{
                    $Activities = null;
                    $WodTypeId = $this->getWodTypeId('Benchmark');
                    $WorkoutRoutineTypeId = $_REQUEST['benchmarkId'];
                }
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
        $this->Message = '';
        $Activities = array();
        foreach($_REQUEST AS $key=>$val)
        {
            $ExerciseId = 0;
            $Attribute = '';
            $ExplodedKey = explode('___', $key);
            if(sizeof($ExplodedKey) > 1)
            {
                $RoundNo = $ExplodedKey[0];
                $ExerciseId = $ExplodedKey[1];
                $ExerciseName = $this->getExerciseName($ExerciseId);
                $Attribute = $ExplodedKey[2];
                /*
                if($val == '00:00:0')
                    $this->Message .= 'Invalid value for Stopwatch!';
                 * 
                 */
                if($val == '' || $val == '0' || $val == $Attribute){
                    $this->Message .= 'Invalid value for '.$ExerciseName.' '.$Attribute.'!';
                }else{
                $Query='SELECT recid, (SELECT recid FROM Attributes WHERE Attribute = "'.$Attribute.'") AS Attribute, "'.$val.'" AS AttributeValue, "'.$RoundNo.'" AS RoundNo 
                FROM Exercises
                WHERE recid = "'.$ExerciseId.'"';
                $Result = mysql_query($Query); 
                $Row = mysql_fetch_assoc($Result);
                array_push($Activities, new UploadObject($Row));
                }
            }
            else{
                if($val == '' || $val == $key){
                    $this->Message .= 'Invalid value for '.$key.'!';
                }else{

                $SQL = 'SELECT recid FROM Attributes WHERE Attribute = "'.$key.'"';
                $Result = mysql_query($SQL);
                $numrows = mysql_num_rows($Result);
                if($numrows == 1){
                    $Row = mysql_fetch_assoc($Result);
                    $Attribute = $Row['recid'];
                    array_push($Activities, new UploadObject(array('recid'=>'0','Attribute'=>''.$Attribute.'','AttributeValue'=>''.$val.'','RoundNo'=>''.$RoundNo.'')));
                
                    }
                }
            }
        }
        return $Activities;
    }
    
    function MemberActivityExists()
    {
        $SQL = 'SELECT count(MemberId) AS MemberRecord FROM MemberBaseline WHERE MemberId = "'.$_SESSION['UID'].'"';
        $Result = mysql_query($SQL); 
        $Row = mysql_fetch_assoc($Result);
        if($Row['MemberRecord'] > 0)
            return true;
        else
            return false;
    }
    
    function getCustomTypeId()
    {
        $SQL = 'SELECT recid FROM WorkoutTypes WHERE WorkoutType = "Custom"';
        $Result = mysql_query($SQL);        
        $Row = mysql_fetch_assoc($Result);
        return $Row['recid'];
    }
    
    function SaveNewActivities()
    {        
        for($i=1; $i<$_REQUEST['newcount']; $i++)
        {
            $Query='SELECT recid FROM Exercises WHERE Exercise = "'.$_REQUEST['newattribute_\'.$i.\''].'"';
            $Result = mysql_query($SQL); 
            if(!empty($Result)){
                $Row = mysql_fetch_assoc($Result);
                $ExerciseId = $Row['recid'];
            }
            else{
                $SQL = 'INSERT INTO Exercises(Exercise) VALUES("'.$_REQUEST['newattribute_\'.$i.\''].'")';
                mysql_query($SQL);
                $ExerciseId = mysql_insert_id();
            }
            $SQL = 'INSERT INTO MemberBaseline(MemberId, ExerciseId) VALUES("'.$_SESSION['UID'].'", '.$ExerciseId.')';
            mysql_query($SQL);
        }
	}  
        
	function getWodTypeId($type)
	{
		$Query = 'SELECT recid FROM WorkoutTypes WHERE WorkoutType = "'.$type.'"';
		$Result = mysql_query($Query);
		$Row = mysql_fetch_assoc($Result);
		return $Row['recid'];
	}      
        
    function getWorkoutTypes()
    {
		$CustomTypes = array();
		$SQL = 'SELECT recid, WorkoutType as ActivityType 
                    FROM WorkoutRoutineTypes 
                    ORDER BY ActivityType';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($CustomTypes, new UploadObject($Row));
		}
		
		return $CustomTypes;        
    }
	
	function getWorkoutTypeId($type)
	{
		$Query = 'SELECT recid FROM WorkoutRoutineTypes WHERE WorkoutType = "'.$type.'"';
		$Result = mysql_query($Query);
		$Row = mysql_fetch_assoc($Result);
		return $Row['recid'];
	}
	
	function getAttributeId($attribute)
	{
		$Query = 'SELECT recid FROM Attributes WHERE Attribute = "'.$attribute.'"';
		$Result = mysql_query($Query);
		$Row = mysql_fetch_assoc($Result);
		return $Row['recid'];	
	}  
    
    function getMemberActivities()
    {
        $MemberActivities = array();
        if(!$this->MemberActivityExists())
            $this->SaveNewBaseline();
        $SQL = 'SELECT MB.ExerciseId AS recid, 
            E.Exercise AS ActivityName, 
            E.Acronym, 
            A.Attribute, MB.AttributeValue 
            FROM MemberBaseline MB
            JOIN Exercises E ON E.recid = MB.ExerciseId
            JOIN Attributes A ON A.recid = MB.AttributeId
            WHERE MB.MemberId = "'.$_SESSION['UID'].'"';
        $Result = mysql_query($SQL);
        while($Row = mysql_fetch_assoc($Result))
        {
            array_push($MemberActivities, new UploadObject($Row));  
        }
        return $MemberActivities;
    }
	
	function getActivities()
	{
        $Activities = array();
        $SQL = 'SELECT DISTINCT E.recid, 
            E.Exercise AS ActivityName,
            E.Acronym
            FROM Exercises E
            LEFT JOIN ExerciseAttributes EA ON EA.ExerciseId = E.recid
            ORDER BY ActivityName';
        $Result = mysql_query($SQL);
        while($Row = mysql_fetch_assoc($Result))
        {
            array_push($Activities, new UploadObject($Row));  
        }
        return $Activities;	
	}   
        
        function getBenchmarks()
        {
         $Benchmarks = array();
        $SQL = 'SELECT DISTINCT recid,
            WorkoutName
            FROM BenchmarkWorkouts
            ORDER BY WorkoutName';
        $Result = mysql_query($SQL);
        while($Row = mysql_fetch_assoc($Result))
        {
            array_push($Benchmarks, new UploadObject($Row));  
        }           
            return $Benchmarks;
        }
        
         function getBenchmarkDetails($Id)
        {

        $SQL = 'SELECT DISTINCT recid,
            WorkoutName
            FROM BenchmarkWorkouts
            WHERE recid = '.$Id.'';
        $Result = mysql_query($SQL);
        $Row = mysql_fetch_assoc($Result);
        $Benchmark = new UploadObject($Row);  
                  
            return $Benchmark;
        }       

	function getExerciseAttributes($Id)
	{
        $Attributes = array();

        $SQL = 'SELECT DISTINCT E.recid, 
			E.Exercise AS ActivityName,
                        E.Acronym, 
			A.Attribute
			FROM ExerciseAttributes EA
			LEFT JOIN Attributes A ON EA.AttributeId = A.recid
			LEFT JOIN Exercises E ON EA.ExerciseId = E.recid
			WHERE E.recid = "'.$Id.'"
			ORDER BY ActivityName, Attribute';

        $Result = mysql_query($SQL);
        while($Row = mysql_fetch_assoc($Result))
        {
            array_push($Attributes, new UploadObject($Row));  
        }
        return $Attributes;	
	}	
}

class UploadObject
{
    var $recid;
    var $WorkoutName;
    var $ActivityName;
    var $InputFieldName;
    var $ActivityType;
    var $Attribute;
    var $AttributeValue;
    var $RoundNo;

    function __construct($Row)
    {
	$this->recid = isset($Row['recid']) ? $Row['recid'] : "";
        $this->WorkoutName = isset($Row['WorkoutName']) ? $Row['WorkoutName'] : "";
	$this->ActivityName = isset($Row['ActivityName']) ? $Row['ActivityName'] : "";
        if($Row['Acronym'] != '')
            $this->InputFieldName = $Row['Acronym'];
        else
            $this->InputFieldName = $this->ActivityName;
	$this->ActivityType = isset($Row['ActivityType']) ? $Row['ActivityType'] : "";
	$this->Attribute = isset($Row['Attribute']) ? $Row['Attribute'] : "";
	$this->AttributeValue = isset($Row['AttributeValue']) ? $Row['AttributeValue'] : "";
	$this->RoundNo = isset($Row['RoundNo']) ? $Row['RoundNo'] : "1";
    }
}
?>