<?php
class UploadModel extends Model
{    
    var $Message;
    
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
	}
    
    function Save()
	{
            if($this->UserIsSubscribed()){
            $ActivityFields = $this->getActivityFields();
            //var_dump($ActivityFields);
            if($this->Message == ''){
      
            $SQL = 'INSERT INTO WodWorkouts(GymId, WorkoutName, WorkoutTypeId) 
                VALUES("'.$_SESSION['GID'].'", "'.$_REQUEST['WorkoutName'].'", "'.$this->getWorkoutTypeId($_REQUEST['workouttype']).'")';
            mysql_query($SQL);
            $WodId = mysql_insert_id();
            
        foreach($ActivityFields AS $ActivityField)
        {
            $SQL = 'INSERT INTO WodDetails(WodId, ExerciseId, AttributeId, AttributeValue, RoundNo) 
            VALUES("'.$WodId.'", "'.$ActivityField->recid.'", "'.$ActivityField->Attribute.'", "'.$ActivityField->AttributeValue.'", "'.$ActivityField->RoundNo.'")';
            mysql_query($SQL);
		}
                $this->Message = 'Success';
            }

        return $this->Message;
	}
        }
        
        function SaveNewExercise()
	{
            if($this->UserIsSubscribed()){
                $SQL = 'INSERT INTO Exercises(Exercise, Acronym) 
                    VALUES("'.$_REQUEST['NewExercise'].'", "'.$_REQUEST['Acronym'].'")';
                mysql_query($SQL);
                $ExerciseId = mysql_insert_id();
                foreach($_REQUEST['ExerciseAttributes'] AS $Attribute){
                    $SQL = 'INSERT INTO ExerciseAttributes(ExerciseId, AttributeId) 
                        VALUES("'.$ExerciseId.'","'.$this->getAttributeId($Attribute).'")';
                    mysql_query($SQL);               
                }
                $Message = 'Exercise Successfully Added!';               
            }else{
                $Message = 'You are not subscribed!';
            }
            return $Message;  
        }
        
	function getAttributes()
	{
            $Attributes = array();
            $Query = 'SELECT recid, Attribute FROM Attributes';
            $Result = mysql_query($Query);	
            while($Row = mysql_fetch_assoc($Result))
            {
		array_push($Attributes, new CustomObject($Row));
            }
		
            return $Attributes; 
	}
        
        function getExerciseName($ExerciseId)
        {
            $Query = 'SELECT Exercise FROM Exercises WHERE recid = '.$ExerciseId.'';
            $Result = mysql_query($Query);
            $Row = mysql_fetch_assoc($Result);
            return $Row['Exercise'];
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
                if($val == '00:00:0')
                    $this->Message .= 'Invalid value for Stopwatch!';
                else if($val == '' || $val == '0' || $val == $Attribute){
                    $this->Message .= 'Invalid value for '.$ExerciseName.' '.$Attribute.'!';
                }else{
                $Query='SELECT recid, (SELECT recid FROM Attributes WHERE Attribute = "'.$Attribute.'") AS Attribute, "'.$val.'" AS AttributeValue, "'.$RoundNo.'" AS RoundNo 
                FROM Exercises
                WHERE recid = "'.$ExerciseId.'"';
                $Result = mysql_query($Query); 
                $Row = mysql_fetch_assoc($Result);
                array_push($Activities, new CustomObject($Row));
                }
            }
            else{
                if($val == '00:00:0' || $val == '' || $val == $key){
                    $this->Message .= 'Invalid value for '.$key.'!';
                }else{

                $SQL = 'SELECT recid FROM Attributes WHERE Attribute = "'.$key.'"';
                $Result = mysql_query($SQL);
                $numrows = mysql_num_rows($Result);
                if($numrows == 1){
                    $Row = mysql_fetch_assoc($Result);
                    $Attribute = $Row['recid'];
                    array_push($Activities, new CustomObject(array('recid'=>'0','Attribute'=>''.$Attribute.'','AttributeValue'=>''.$val.'','RoundNo'=>''.$RoundNo.'')));
                
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
    
    function getWorkoutTypes()
    {
		$CustomTypes = array();
		$SQL = 'SELECT recid, WorkoutType as ActivityType 
                    FROM WorkoutRoutineTypes 
                    ORDER BY ActivityType';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($CustomTypes, new CustomObject($Row));
		}
		
		return $CustomTypes;        
    }
	
	function getWorkoutTypeId($type)
	{
		$Query = 'SELECT recid FROM WorkoutTypes WHERE WorkoutType = "'.$type.'"';
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
            array_push($MemberActivities, new CustomObject($Row));  
        }
        return $MemberActivities;
    }
	
	function getExercises()
	{
        $Exercises = array();
        $SQL = 'SELECT DISTINCT E.recid, 
            "Activities" AS OptionGroup,
            E.Exercise AS ActivityName,
            E.Acronym
            FROM Exercises E
            LEFT JOIN ExerciseAttributes EA ON EA.ExerciseId = E.recid
            UNION
            SELECT DISTINCT recid,
            "Benchmarks" AS OptionGroup,
            WorkoutName AS ActivityName,
            "" AS Acronym
            FROM BenchmarkWorkouts
            ORDER BY OptionGroup,ActivityName';
        $Result = mysql_query($SQL);
        while($Row = mysql_fetch_assoc($Result))
        {
            array_push($Exercises, new CustomObject($Row));  
        }
        return $Exercises;	
	}    

	function getExerciseAttributes($Exercise)
	{
        $Attributes = array();

        $SQL = 'SELECT BenchmarkId
		FROM Exercises
		WHERE Exercise = "'.$Exercise.'"';
        $Result = mysql_query($SQL);
		$Row = mysql_fetch_assoc($Result);
		$BenchmarkId = $Row['BenchmarkId'];
		if($BenchmarkId == 0){
                    $SQL = 'SELECT DISTINCT E.recid, 
			E.Exercise AS ActivityName,
                        E.Acronym, 
			A.Attribute
			FROM ExerciseAttributes EA
			LEFT JOIN Attributes A ON EA.AttributeId = A.recid
			LEFT JOIN Exercises E ON EA.ExerciseId = E.recid
			WHERE E.Exercise = "'.$Exercise.'"
			ORDER BY ActivityName, Attribute';
		}
		else{
                            if($Exercise == 'Baseline'){

        $SQL = 'SELECT MB.ExerciseId AS recid, 
            E.Exercise AS ActivityName, 
            E.Acronym, 
            A.Attribute, MB.AttributeValue 
            FROM MemberBaseline MB
            JOIN Exercises E ON E.recid = MB.ExerciseId
            JOIN Attributes A ON A.recid = MB.AttributeId
            WHERE MB.MemberId = "'.$_SESSION['UID'].'"';

        }else{

        if($this->getGender() == 'M'){
            $AttributeValue = 'AttributeValueMale';
			$InputFields = 'MaleInput';
        } else {
            $AttributeValue = 'AttributeValueFemale';
			$InputFields = 'FemaleInput';
		}
		//$SQL = 'SELECT WorkoutName, '.$DescriptionField.' AS WorkoutDescription, '.$InputFields.' AS InputFields, VideoId FROM BenchmarkWorkouts WHERE recid = '.$Id.'';
		
		$SQL = 'SELECT E.recid, 
                    E.Exercise AS ActivityName, 
                    E.Acronym, 
                    BD.BenchmarkId, 
                    A.Attribute, 
                    BD.'.$AttributeValue.' AS AttributeValue, 
                    RoundNo
                    FROM BenchmarkDetails BD
                    LEFT JOIN BenchmarkWorkouts BW ON BW.recid = BD.BenchmarkId
                    LEFT JOIN Exercises E ON E.recid = BD.ExerciseId
                    LEFT JOIN Attributes A ON A.recid = BD.AttributeId
                    WHERE BD.BenchmarkId = '.$BenchmarkId.'
                    ORDER BY RoundNo, ActivityName, Attribute';
		}
                }
        $Result = mysql_query($SQL);
        while($Row = mysql_fetch_assoc($Result))
        {
            array_push($Attributes, new CustomObject($Row));  
        }
        if($Exercise == 'Baseline')
        {
            $Array = array('recid'=>'63', 'ActivityName'=>'Timed', 'Attribute'=>'TimeToComplete', 'AttributeValue'=>'00:00:0', 'RoundNo'=>'0');
            array_push($Attributes, new CustomObject($Array));  
        }
        return $Attributes;	
	}	
}

class CustomObject
{
    var $recid;
    var $OptionGroup;
    var $ActivityName;
    var $InputFieldName;
    var $ActivityType;
    var $Attribute;
    var $AttributeValue;
    var $RoundNo;

    function __construct($Row)
    {
	$this->recid = isset($Row['recid']) ? $Row['recid'] : "";
        $this->OptionGroup = isset($Row['OptionGroup']) ? $Row['OptionGroup'] : "";
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