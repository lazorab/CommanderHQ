<?php
class BenchmarkModel extends Model
{
    var $Message;
    function __construct()
    {
	mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
	@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
    }
	
    function InsertBMW($_DETAILS)
    {
	$FIELDS = '';
	$VALUES = '';
	$i = 0;
	foreach($_DETAILS AS $key=>$val) 
	{
            if($i > 0)
            {
		$FIELDS .= ',';
		$VALUES .= ',';
            }
		$FIELDS .= $key;
		$VALUES .= '"'.$val.'"';
		$i++;
            }
            $SQL = 'INSERT INTO BenchmarkWorkouts('.$FIELDS.') VALUES('.$VALUES.')';
            mysql_query($SQL);	
	}
        
        function Gender()
        {
            $SQL = 'SELECT Gender FROM MemberDetails WHERE MemberId = "'.$_SESSION['UID'].'"';
            $Result = mysql_query($SQL);	
            $Row = mysql_fetch_assoc($Result);
            return $Row['Gender'];
        }
        
        function SystemOfMeasure()
        {
            $SQL = 'SELECT SystemOfMeasure FROM MemberDetails WHERE MemberId = "'.$_SESSION['UID'].'"';
            $Result = mysql_query($SQL);	
            $Row = mysql_fetch_assoc($Result);
            return $Row['SystemOfMeasure'];
        }
	
	function getCategories()
	{
		$Categories=array();
		$SQL = 'SELECT recid, Category, Image, Banner FROM BenchmarkCategories';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Categories, new CategoryObject($Row));
		}
		return $Categories;
	}
	
	function getCategory($Id)
	{
		$SQL = 'SELECT Category FROM BenchmarkCategories WHERE recid = '.$Id.'';
		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
		return $Row['Category'];
	}	
	
	function GetBMWS($Filter)
	{
        $SQL = 'SELECT Gender FROM MemberDetails WHERE MemberId = "'.$_SESSION['UID'].'"';
 		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
        if($Row['Gender'] == 'M')
            $DescriptionField = 'MaleWorkoutDescription';
        else
            $DescriptionField = 'FemaleWorkoutDescription';
		$SQL = 'SELECT recid, Banner, WorkoutName, '.$DescriptionField.' AS WorkoutDescription, VideoId 
		FROM BenchmarkWorkouts WHERE '; 	
		if(!is_int($Filter)){
			$SQL .= 'CategoryId = '.$Filter.'';
		}
		else{
			$SQL .= 'WorkoutName LIKE "'.$Filter.'%"';
		}
		$Workouts = array();
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Workouts, new BenchmarkObject($Row));
		}
		return $Workouts;
	}	
	
	function GetWorkoutDetails($Id)
	{   
		$WorkoutDetails = array();
        $SQL = 'SELECT Gender FROM MemberDetails WHERE MemberId = "'.$_SESSION['UID'].'"';
 		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
        if($Row['Gender'] == 'M'){
            $AttributeValue = 'AttributeValueMale';
			$InputFields = 'MaleInput';
        } else {
            $AttributeValue = 'AttributeValueFemale';
			$InputFields = 'FemaleInput';
		}
		//$SQL = 'SELECT WorkoutName, '.$DescriptionField.' AS WorkoutDescription, '.$InputFields.' AS InputFields, VideoId FROM BenchmarkWorkouts WHERE recid = '.$Id.'';
		
		$SQL = 'SELECT BW.WorkoutName, E.Exercise, E.recid AS ExerciseId, A.Attribute, BD.'.$AttributeValue.' AS AttributeValue, VideoId, RoundNo
			FROM BenchmarkDetails BD
			LEFT JOIN BenchmarkWorkouts BW ON BW.recid = BD.BenchmarkId
			LEFT JOIN Exercises E ON E.recid = BD.ExerciseId
			LEFT JOIN Attributes A ON A.recid = BD.AttributeId
			WHERE BD.BenchmarkId = '.$Id.'
			ORDER BY RoundNo, OrderBy, Attribute';
		$Result = mysql_query($SQL);	
        while($Row = mysql_fetch_assoc($Result))
        {
		//$FormattedInputFields = $this->getFormattedInputFields($Row['InputFields']);
		//$Row['InputFields'] = $FormattedInputFields;
		array_push($WorkoutDetails, new BenchmarkObject($Row));  
		}
		return $WorkoutDetails;
	}	

	function getFormattedInputFields($InputFields)
	{
		$FormattedInputFields = $InputFields;
		$ExerciseAttributes = $this->getExerciseAttributes();
		foreach($ExerciseAttributes AS $ExerciseAttribute){
			$FormattedInputFields = str_replace('{'.$ExerciseAttribute->Name.'}', ''.$ExerciseAttribute->Id.'', $FormattedInputFields);
		}
		return $FormattedInputFields;
	}	
	
	function getExerciseAttributes()
	{
        $ExerciseAttributes = array();
        $SQL = 'SELECT E.recid, 
		E.Exercise AS WorkoutName,
		A.Attribute
		FROM Attributes A
		JOIN ExerciseAttributes EA ON EA.AttributeId = A.recid
		JOIN Exercises E ON EA.ExerciseId = E.recid';
        $Result = mysql_query($SQL);
        while($Row = mysql_fetch_assoc($Result))
        {
            array_push($ExerciseAttributes, new BenchmarkObject($Row));  
        }
        return $ExerciseAttributes;	
	}	
	
    function Log()
	{
            $ActivityFields = $this->getActivityFields();
            //var_dump($ActivityFields);
            if($this->Message == ''){
                $ExerciseTypeId = $this->getExerciseTypeId();
                //$Attributes=$this->getAttributes();
                //var_dump($ActivityFields);
                foreach($ActivityFields AS $ActivityField)
                {
                    $AttributeValue = '';
                    //check to see if we must convert back to metric first for data storage
                         if($ActivityField->Attribute == 'Height' || $ActivityField->Attribute == 'Distance' || $ActivityField->Attribute == 'Weight'){
                            
				if($ActivityField->Attribute == 'Distance'){
					if($this->SystemOfMeasure() != 'Metric'){
                                            $AttributeValue = round($ActivityField->AttributeValue * 1.61, 2);
                                        }
				}		
				else if($ActivityField->Attribute == 'Weight'){
					if($this->SystemOfMeasure() != 'Metric'){
                                            $AttributeValue = round($ActivityField->AttributeValue * 0.45, 2);
                                        }
				}
				else if($ActivityField->Attribute == 'Height'){
					if($this->SystemOfMeasure() != 'Metric'){
                                            $AttributeValue = round($ActivityField->AttributeValue * 2.54, 2);
                                        }
                                }
			}   
                    if($AttributeValue == ''){
                        $AttributeValue = $ActivityField->AttributeValue;
                    }
                    if($_REQUEST['origin'] == 'baseline'){
                        $SQL = 'INSERT INTO BaselineLog(MemberId, ExerciseTypeId, ExerciseId, RoundNo, ActivityId, AttributeId, AttributeValue) 
				VALUES("'.$_SESSION['UID'].'", "'.$ExerciseTypeId.'", "'.$_REQUEST['benchmarkId'].'", "'.$ActivityField->RoundNo.'", "'.$ActivityField->Id.'", "'.$ActivityField->Attribute.'", "'.$AttributeValue.'")';
			mysql_query($SQL);
                        //$this->Message = $SQL;
                    }
                    // ExerciseId only applies for benchmarks so we need it here!
                    $SQL = 'INSERT INTO WODLog(MemberId, ExerciseId, WodTypeId, RoundNo, ActivityId, AttributeId, AttributeValue, LevelAchieved) 
			VALUES("'.$_SESSION['UID'].'", "'.$_REQUEST['benchmarkId'].'", "'.$ExerciseTypeId.'", "'.$ActivityField->RoundNo.'", "'.$ActivityField->Id.'", "'.$ActivityField->Attribute.'", "'.$AttributeValue.'", "'.$this->LevelAchieved($ActivityField).'")';
                    mysql_query($SQL);
                    $this->Message = '<span style="color:green">Successfully Saved!</span>';
		}
            }
            return $this->Message;
	}
	
	function getAttributes()
	{
		$Attributes = array();
		$Query = 'SELECT recid, Attribute FROM Attributes';
		$Result = mysql_query($Query);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Attributes, new BenchmarkObject($Row));
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
                if(isset($_REQUEST['Rounds']))
                    $RoundNo = $_REQUEST['Rounds'];
                else
                    $RoundNo = $ExplodedKey[0];
                $ExerciseId = $ExplodedKey[1];
                $Attribute = $ExplodedKey[2];
                if($val == '00:00:0' || $val == '' || $val == '0' || $val == $Attribute){
                    $this->Message .= '<span style="color:red">Invalid value for '.$Attribute.'!</span><br/>';
                }else{
                $Query='SELECT recid, (SELECT recid FROM Attributes WHERE Attribute = "'.$Attribute.'") AS Attribute, "'.$val.'" AS AttributeValue, "'.$RoundNo.'" AS RoundNo 
                FROM Exercises
                WHERE recid = "'.$ExerciseId.'"';
                $Result = mysql_query($Query); 
                $Row = mysql_fetch_assoc($Result);
                array_push($Activities, new BenchmarkObject($Row));
                }
            }
            else{
                 if($val == $key){
                   $this->Message .= '<span style="color:red">Invalid value for '.$key.'!</span><br/>';
                }else{
                $SQL = 'SELECT recid FROM Attributes WHERE Attribute = "'.$key.'"';
                $Result = mysql_query($SQL);
                $numrows = mysql_num_rows($Result);
                if($numrows == 1){
                    $Row = mysql_fetch_assoc($Result);
                    $Attribute = $Row['recid'];
                    array_push($Activities, new BenchmarkObject(array('recid'=>'0','Attribute'=>''.$Attribute.'','AttributeValue'=>''.$val.'','RoundNo'=>''.$RoundNo.'')));
                }
                }
            }
        }
        return $Activities;
    }
    
 	function LevelAchieved($ExerciseObject)
	{
            $Level = 0;
            $Sql = 'SELECT SL.AttributeValue, SL.SkillsLevel
                    FROM SkillsLevels SL 
                    LEFT JOIN Attributes A ON A.recid = SL.AttributeId
                    LEFT JOIN Exercises E ON E.recid = SL.ExerciseId
                    WHERE A.Attribute = "'.$ExerciseObject->Attribute.'"
                    AND E.Exercise = "'.$ExerciseObject->Exercise.'"
                    AND (SL.Gender = "U" OR SL.Gender = "'.$this->Gender().'")
                    ORDER BY SkillsLevel';
    
            $Result = mysql_query($Sql);
            while($Row = mysql_fetch_assoc($Result))
            {
                if($ExerciseObject->Attribute == 'TimeToComplete'){
                    $ExplodedTime = explode(':', $ExerciseObject->AttributeValue);
                    $SecondsToComplete = ($ExplodedTime[0] * 60) + $ExplodedTime[1];   
                    $ExplodedTime = explode(':', $Row['AttributeValue']);
                    $SecondsToCompare = ($ExplodedTime[0] * 60) + $ExplodedTime[1];
                    if($SecondsToComplete < $SecondsToCompare)
                        $Level = $Row['SkillsLevel'];
                }
                else{
                    if($ExerciseObject->AttributeValue > $Row['AttributeValue'])
                        $Level = $Row['SkillsLevel'];
                }
            }
        }

    function getExerciseTypeId()
    {
        $SQL = 'SELECT recid FROM ExerciseTypes WHERE ExerciseType = "Benchmark"';
        $Result = mysql_query($SQL);        
        $Row = mysql_fetch_assoc($Result);
        return $Row['recid'];
    }		

	function OverallLevelAchieved()
	{
		$Level = 4;
		$CompletedExercises = array();
		$Sql = 'SELECT ExerciseId, MAX(LevelAchieved) FROM ExerciseLog WHERE MemberId = '.$this->UID.' GROUP BY ExerciseId';
		$Result = mysql_query($Sql);
		while($Row = mysql_fetch_assoc($Result))
		{
			if($Row['LevelAchieved'] < $Level)
				$Level = $Row['LevelAchieved'];
			array_push($CompletedExercises,$Row['ExerciseId']);
		}

		$PendingExercises=array();
		$AllExercises = $this->getExercises();
		foreach($AllExercises AS $Exercise)
		{
			if(!in_array($Exercise->Id, $CompletedExercises))
				array_push($PendingExercises,$Exercise->Id);
		}
		if(count($PendingExercises) == 0)
			return $Level;
		else
			return 0;
	}	
	
	function getHistory()
	{
            $Data = array();
            $Sql = 'SELECT B.recid, B.WorkoutName, A.Attribute, L.AttributeValue, L.TimeCreated 
		FROM WODLog L 
                LEFT JOIN BenchmarkWorkouts B ON B.recid = L.ExerciseId 
                LEFT JOIN Attributes A ON A.recid = L.AttributeId
                LEFT JOIN ExerciseTypes ET ON ET.recid = L.WODTypeId
                WHERE L.MemberId = '.$_SESSION['UID'].' 
                AND ET.ExerciseType = "Benchmark"
                AND A.Attribute = "TimeToComplete"
                ORDER BY TimeCreated';
		$Result = mysql_query($Sql);	
		while($Row = mysql_fetch_assoc($Result))
		{
                    array_push($Data,new BenchmarkObject($Row));
		}	
		return $Data; 
	}
}

class BenchmarkObject
{
	var $Id;
	var $Name;
	var $Banner;
	var $Exercise;
	var $ExerciseId;
	var $Description;
	var $InputFields;
	var $Video;
	//var $SmartVideoLink;
	//var $LegacyVideoLink;
	var $Attribute;
        var $AttributeValue;
	var $RoundNo;
	var $TimeCreated;

	function __construct($Row)
	{
		$this->Id = $Row['recid'];
		$this->Name = $Row['WorkoutName'];
		$this->Banner = $Row['Banner'];
		$this->Exercise = $Row['Exercise'];
		$this->ExerciseId = $Row['ExerciseId'];
		$this->Description = $Row['WorkoutDescription'];
		$this->InputFields = $Row['InputFields'];
		$this->Video = $Row['VideoId'];
		//$this->SmartVideoLink = 'http://www.youtube.com/embed/'.$Row['VideoId'].'';
		//$this->LegacyVideoLink = 'http://m.youtube.com/details?v='.$Row['VideoId'].'';
		$this->Attribute = isset($Row['Attribute']) ? $Row['Attribute'] : "";
        $this->AttributeValue = isset($Row['AttributeValue']) ? $Row['AttributeValue'] : "";
		$this->RoundNo = isset($Row['RoundNo']) ? $Row['RoundNo'] : "";
		$this->TimeCreated = isset($Row['TimeCreated']) ? $Row['TimeCreated'] : "";
	}
}

class CategoryObject
{
	var $Id;
	var $Name;
	var $Image;
	var $Banner;

	function __construct($Row)
	{
		$this->Id = $Row['recid'];
		$this->Name = $Row['Category'];
		$this->Image = $Row['Image'];
		$this->Banner = $Row['Banner'];
	}
}
?>