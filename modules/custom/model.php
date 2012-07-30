<?php
class CustomModel extends Model
{
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
	}
    
    function Log()
	{
		$ActivityFields = $this->getActivityFields();
		//var_dump($ActivityFields);
	
        $ExerciseTypeId = $this->getExerciseTypeId();
        //$Attributes=$this->getAttributes();
        //var_dump($ActivityFields);
        foreach($ActivityFields AS $ActivityField)
        {

				if($_REQUEST['origin'] == 'baseline'){
					$SQL = 'INSERT INTO BaselineLog(MemberId, ExerciseTypeId, ExerciseId, AttributeId, AttributeValue) 
					VALUES("'.$_SESSION['UID'].'", "'.$ExerciseTypeId.'", "'.$_REQUEST['exercise'].'", "'.$Attribute->recid.'", "'.$AttributeValue.'")';
					mysql_query($SQL);		
				}
				// ExerciseId only applies for benchmarks so we make it 0 here
				$SQL = 'INSERT INTO WODLog(MemberId, ExerciseId, WodTypeId, ActivityId, AttributeId, AttributeValue) 
					VALUES("'.$_SESSION['UID'].'", "0", "'.$ExerciseTypeId.'", "'.$ActivityField->recid.'", "'.$ActivityField->Attribute.'", "'.$ActivityField->AttributeValue.'")';
				mysql_query($SQL);
		}
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
    
    function getActivityFields()
    {
        $Activities = array();
        foreach($_REQUEST AS $key=>$val)
        {
            $ExerciseId = 0;
            $Attribute = '';
            $ExplodedKey = explode('___', $key);
            if(sizeof($ExplodedKey) > 1)
            {
                $ExerciseId = $ExplodedKey[0];
                $Attribute = $ExplodedKey[1];
                $Query='SELECT recid, (SELECT recid FROM Attributes WHERE Attribute = "'.$Attribute.'") AS Attribute, "'.$val.'" AS AttributeValue 
                FROM Exercises
                WHERE recid = "'.$ExerciseId.'"';
                $Result = mysql_query($Query); 
                $Row = mysql_fetch_assoc($Result);
                array_push($Activities, new CustomObject($Row));
            }
            else{
                $SQL = 'SELECT recid FROM Attributes WHERE Attribute = "'.$key.'"';
                $Result = mysql_query($SQL);
                $numrows = mysql_num_rows($Result);
                if($numrows == 1){
                    $Row = mysql_fetch_assoc($Result);
                    $Attribute = $Row['recid'];
                    array_push($Activities, new CustomObject(array('recid'=>'0','Attribute'=>''.$Attribute.'','AttributeValue'=>''.$val.'')));
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
    
    function getExerciseTypeId()
    {
        $SQL = 'SELECT recid FROM ExerciseTypes WHERE ExerciseType = "Custom"';
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
    
    function getCustomTypes()
    {
		$CustomTypes = array();
		$SQL = 'SELECT recid, CustomType as ActivityType FROM CustomTypes';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($CustomTypes, new CustomObject($Row));
		}
		
		return $CustomTypes;        
    }
    
    function getMemberCustomExercises()
    {
		$Exercises = array();
		$SQL = 'SELECT recid, ExerciseName AS ActivityName FROM CustomExercises WHERE MemberId = "'.$_SESSION['UID'].'"';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Exercises, new CustomObject($Row));
		}
		
		return $Exercises;        
    }
    
    function getCustomDetails($Id)
    {
		$Details=array();
		$SQL = 'SELECT CE.recid, CE.ExerciseName AS ActivityName, CT.CustomType AS ActivityType, A.Attribute, CD.AttributeValue
        FROM CustomExercises CE
        LEFT JOIN CustomDetail CD ON CD.ExerciseId = CE.recid
        LEFT JOIN CustomTypes CT ON CT.recid = CD.CustomTypeId
        LEFT JOIN Attributes A ON A.recid = CD.AttributeId
        WHERE CE.recid = '.$Id.'';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Details, new CustomObject($Row));
		}
		return $Details;       
    }
    
    function SaveCustom()
    {
        $SQL = 'INSERT INTO CustomExercises(MemberId, ExerciseName) 
        VALUES("'.$_SESSION['UID'].'", "'.$_REQUEST['newcustom'].'")';
		$Result = mysql_query($SQL);
        
		$CustomId = mysql_insert_id();
		
		for($i=1; $i<=$_REQUEST['fieldcount']; $i++){
			if(isset($_REQUEST['Timed_'.$i.''])){
				$CustomTypeId = $this->getCustomTypeId('Timed');
				$AttributeId = $this->getAttributeId('TimeToComplete');
				$AttributeValue = $_REQUEST['Timed_'.$i.''];
			
				$SQL = 'INSERT INTO CustomDetail(ExerciseId, CustomTypeId, AttributeId, AttributeValue) 
				VALUES("'.$CustomId.'", "'.$CustomTypeId.'", "'.$AttributeId.'", "'.$AttributeValue.'")';
				$Result = mysql_query($SQL);		
			}
			if(isset($_REQUEST['AMRAP_'.$i.''])){
				$CustomTypeId = $this->getCustomTypeId('AMRAP');
				$AttributeId = $this->getAttributeId('CountDown');
				$AttributeValue = ''.$_REQUEST['AMRAP_'.$i.''].':0';
			
				$SQL = 'INSERT INTO CustomDetail(ExerciseId, CustomTypeId, AttributeId, AttributeValue) 
				VALUES("'.$CustomId.'", "'.$CustomTypeId.'", "'.$AttributeId.'", "'.$AttributeValue.'")';
				$Result = mysql_query($SQL);		
			}	
			if(isset($_REQUEST['Weight_'.$i.''])){
				$CustomTypeId = $this->getCustomTypeId('Weight');
				$AttributeId = $this->getAttributeId('Weight');
				$AttributeValue = $_REQUEST['Weight_'.$i.''];
			
				$SQL = 'INSERT INTO CustomDetail(ExerciseId, CustomTypeId, AttributeId, AttributeValue) 
				VALUES("'.$CustomId.'", "'.$CustomTypeId.'", "'.$AttributeId.'", "'.$AttributeValue.'")';
				$Result = mysql_query($SQL);		
			}	
			if(isset($_REQUEST['Reps_'.$i.''])){
				$CustomTypeId = $this->getCustomTypeId('Reps');
				$AttributeId = $this->getAttributeId('Reps');
				$AttributeValue = $_REQUEST['Reps_'.$i.''];
			
				$SQL = 'INSERT INTO CustomDetail(ExerciseId, CustomTypeId, AttributeId, AttributeValue) 
				VALUES("'.$CustomId.'", "'.$CustomTypeId.'", "'.$AttributeId.'", "'.$AttributeValue.'")';
				$Result = mysql_query($SQL);		
			}			
		}
		return $CustomId;
    }
	
	function getCustomTypeId($type)
	{
		$Query = 'SELECT recid FROM CustomTypes WHERE CustomType = "'.$type.'"';
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
	
	function getGender()
	{
        $SQL = 'SELECT Gender FROM MemberDetails WHERE MemberId = "'.$_SESSION['UID'].'"';
 		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
        
		return $Row['Gender'];
	}
    
    function getAttributeOptions()
    {
		$Options = array();
		$SQL = 'SELECT A.recid, A.Attribute 
        FROM Attributes A
        JOIN CustomTypeAttributes CT ON CT.AttributeId = A.recid
        JOIN CustomExercises CE ON CE.CustomTypeId = CT.CustomTypeId
        WHERE CE.CustomTypeId = '.$_REQUEST['customtype'].'';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Options, new CustomObject($Row));
		}
		
		return $Options;        
    }  
    
    function getMemberActivities()
    {
        $MemberActivities = array();
        if(!$this->MemberActivityExists())
            $this->SaveNewBaseline();
        $SQL = 'SELECT MB.ExerciseId AS recid, E.Exercise AS ActivityName, A.Attribute, MB.AttributeValue 
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
        $SQL = 'SELECT recid, Exercise AS ActivityName FROM Exercises ORDER BY Exercise';
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
        $SQL = 'SELECT E.recid, 
		E.Exercise AS ActivityName,
		A.Attribute
		FROM Attributes A
		JOIN ExerciseAttributes EA ON EA.AttributeId = A.recid
		JOIN Exercises E ON EA.ExerciseId = E.recid
		WHERE E.Exercise = "'.$Exercise.'"';
        $Result = mysql_query($SQL);
        while($Row = mysql_fetch_assoc($Result))
        {
            array_push($Attributes, new CustomObject($Row));  
        }
        return $Attributes;	
	}	
}

class CustomObject
{
	var $recid;
	var $ActivityName;
	var $ActivityType;
	var $Attribute;
	var $AttributeValue;

	function __construct($Row)
	{
		$this->recid = isset($Row['recid']) ? $Row['recid'] : "";
		$this->ActivityName = isset($Row['ActivityName']) ? $Row['ActivityName'] : "";
		$this->ActivityType = isset($Row['ActivityType']) ? $Row['ActivityType'] : "";
		$this->Attribute = isset($Row['Attribute']) ? $Row['Attribute'] : "";
		$this->AttributeValue = isset($Row['AttributeValue']) ? $Row['AttributeValue'] : "";
	}
}
?>