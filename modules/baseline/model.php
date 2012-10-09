<?php
class BaselineModel extends Model
{
    var $Message;
    function __construct()
    {
        mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
        @mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
    }
    
    function Log()
    {
        if($this->UserIsSubscribed()){
        if($_REQUEST['newcount'] > 0){
            $this->SaveNewActivities();
        }
        
        $ActivityFields=$this->getActivityFields();
        if($this->Message == ''){
        //var_dump($ActivityFields);
        $WorkoutTypeId = $this->getWorkoutTypeId($_REQUEST['BaselineType']);
        $WorkoutId = $_REQUEST['WorkoutId'];
        foreach($ActivityFields AS $Activity)
        {
            $AttributeValue = '';
            //check to see if we must convert back to metric first for data storage
            if($Activity->Attribute == 'Height' || $Activity->Attribute == 'Distance' || $Activity->Attribute == 'Weight'){
                            
            if($Activity->Attribute == 'Distance'){
                if($this->getSystemOfMeasure() != 'Metric'){
                    $AttributeValue = round($Activity->AttributeValue * 1.61, 2);
                }
            }		
            else if($Activity->Attribute == 'Weight'){
                if($this->getSystemOfMeasure() != 'Metric'){
                    $AttributeValue = round($Activity->AttributeValue * 0.45, 2);
                }
            }
            else if($Activity->Attribute == 'Height'){
                if($this->getSystemOfMeasure() != 'Metric'){
                    $AttributeValue = round($Activity->AttributeValue * 2.54, 2);
                }
            }
            }   
            if($AttributeValue == ''){
                $AttributeValue = $Activity->AttributeValue;
            }
            
            //First Store the values incase they changed
            $SQL = 'UPDATE MemberBaseline 
            SET AttributeValue = "'.$Activity->AttributeValue.'" 
            WHERE MemberId = "'.$_SESSION['UID'].'" 
            AND ExerciseId = "'.$Activity->ExerciseId.'"
            AND AttributeId = "'.$Activity->Attribute.'"';
            mysql_query($SQL);
            
            $SQL = 'INSERT INTO BaselineLog(MemberId, BaselineTypeId, WorkoutId, ExerciseId, AttributeId, AttributeValue) 
            VALUES("'.$_SESSION['UID'].'", "'.$WorkoutTypeId.'", "'.$WorkoutId.'", "'.$Activity->ExerciseId.'", "'.$Activity->Attribute.'", "'.$Activity->AttributeValue.'")';
            mysql_query($SQL);
			
            $SQL = 'INSERT INTO WODLog(MemberId, WODTypeId, WorkoutId, ExerciseId, AttributeId, AttributeValue) 
            VALUES("'.$_SESSION['UID'].'", "'.$WorkoutTypeId.'", "'.$WorkoutId.'", "'.$Activity->ExerciseId.'", "'.$Activity->Attribute.'", "'.$Activity->AttributeValue.'")';
            mysql_query($SQL);
            $this->Message = 'Success';
        }
        }
            }else{
                $this->Message = 'You are not subscribed!';
            }
        return $this->Message;
        /*
        $SQL = 'SELECT recid, Attribute FROM Attributes';
        $Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
        {
            if(isset($_REQUEST[''.$Row['Attribute'].''])){
                $AttributeValue = $_REQUEST[''.$Row['Attribute'].''];
                $SQL = 'INSERT INTO BaselineLog(MemberId, ExerciseTypeId, ExerciseId, AttributeId, AttributeValue) 
                VALUES("'.$_SESSION['UID'].'", "'.$ExerciseTypeId.'", "'.$_REQUEST['exercise'].'", "'.$Row['recid'].'", "'.$AttributeValue.'")';
                mysql_query($SQL);	
            }
        }
        */
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
                    $this->Message .= 'Invalid value for '.$Attribute.'!';
                }else{
                $Query='SELECT recid AS ExerciseId, (SELECT recid FROM Attributes WHERE Attribute = "'.$Attribute.'") AS Attribute, "'.$val.'" AS AttributeValue, "'.$RoundNo.'" AS RoundNo
                FROM Exercises
                WHERE recid = "'.$ExerciseId.'"';
                $Result = mysql_query($Query); 
                $Row = mysql_fetch_assoc($Result);
                array_push($Activities, new BaselineObject($Row));
                }
            }
            else{
                   if($val == '00:00:0' || $val == $key){
                        $this->Message .= 'Invalid value for '.$key.'!';
                }else{
                $SQL = 'SELECT recid FROM Attributes WHERE Attribute = "'.$key.'"';
                $Result = mysql_query($SQL);
                $numrows = mysql_num_rows($Result);
                if($numrows == 1){
                    $Row = mysql_fetch_assoc($Result);
                    $Attribute = $Row['recid'];
                    array_push($Activities, new BaselineObject(array('recid'=>'0','Attribute'=>''.$Attribute.'','AttributeValue'=>''.$val.'','RoundNo'=>''.$RoundNo.'')));
                }
                }
            }
        }
        return $Activities;
    }
    
    function MemberBaselineExists()
    {
        $SQL = 'SELECT count(MemberId) AS MemberRecord FROM MemberBaseline WHERE MemberId = "'.$_SESSION['UID'].'"';
        $Result = mysql_query($SQL); 
        $Row = mysql_fetch_assoc($Result);
        if($Row['MemberRecord'] > 0)
            return true;
        else
            return false;
    }
    
    function SaveNewBaseline()
	{
        $DefaultActivities=array('Row'=>'0.5','Squats'=>'40','Sit-Ups'=>'30','Push-Ups'=>'20','Pull-Ups'=>'10','Timed'=>'00:00:0');
        
        foreach($DefaultActivities AS $key=>$val)
        {
            $Query='SELECT E.recid AS ExerciseId, A.recid AS AttributeId, "'.$val.'" AS AttributeValue
            FROM Attributes A
            JOIN ExerciseAttributes EA ON EA.AttributeId = A.recid
            JOIN Exercises E ON EA.ExerciseId = E.recid
            WHERE E.Exercise = "'.$key.'"
            AND (A.Attribute = "Distance"
                 OR A.Attribute = "Reps"
                 OR A.Attribute = "TimeToComplete")'; 
            $Result = mysql_query($Query);        
            $Row = mysql_fetch_assoc($Result);
            
            $BaselineTypeId = '1';
            $WorkoutId = '0';
            $ExerciseId = $Row['ExerciseId'];
            $AttributeId = $Row['AttributeId'];
            $AttributeValue = $Row['AttributeValue'];
             $SQL = 'INSERT INTO MemberBaseline(MemberId, BaselineTypeId, WorkoutId, ExerciseId, AttributeId, AttributeValue) VALUES("'.$_SESSION['UID'].'", "'.$BaselineTypeId.'", "'.$WorkoutId.'", "'.$ExerciseId.'", "'.$AttributeId.'", "'.$AttributeValue.'")';
             mysql_query($SQL);  
        }
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
			array_push($Options, new BaselineObject($Row));
		}
		
		return $Options;        
    }
	
	function getMemberBaselines()
	{
            $Baselines=array();
            $SQL = 'SELECT MB.recid, 
                MB.WorkoutId,
                BT.BaselineType
                FROM MemberBaseline MB
                JOIN WorkoutTypes BT ON BT.recid = MB.BaselineTypeId
                WHERE MB.MemberId = "'.$_SESSION['UID'].'"';
		$Result = mysql_query($SQL);	
        
		while($Row = mysql_fetch_assoc($Result))
        {
            if($Row['BaselineType'] == 'Benchmark'){
                $NewQuery = 'SELECT MB.recid, 
                    BW.WorkoutName AS ActivityName,
                    FROM MemberBaseline MB 
                    JOIN BenchmarkWorkouts BW ON MB.ExerciseId = BW.recid
                    WHERE BW.recid = '.$Row['WorkoutId'].'';
            }
            else if($Row['BaselineType'] == 'Custom'){
                $NewQuery = 'SELECT MB.recid, 
                CE.ActivityName AS ActivityName
                FROM MemberBaseline MB
                JOIN CustomExercises CE ON CE.recid = MB.ExerciseId
                WHERE CE.recid = '.$Row['WorkoutId'].'';               
            }

            $NewResult = mysql_query($NewQuery);
            $NewRow = mysql_fetch_assoc($NewResult);
            array_push($Baselines, new BaselineObject($NewRow));
        }
		
		return $Baselines;
	}		
    
    function setMemberBaseline()
    {
        if(isset($_REQUEST['benchmark']))
        {
            $WorkoutId = $_REQUEST['benchmark'];
            $BaselineTypeId=$this->getWorkoutTypeId('Benchmark');
        }
        else if(isset($_REQUEST['custom']))
        {
            $WorkoutId = $_REQUEST['custom'];
            $BaselineTypeId=$this->getWorkoutTypeId('Custom');
        }
        $SQL='INSERT INTO MemberBaseline(MemberId, WorkoutId, BaselineTypeId) VALUES("'.$_SESSION['UID'].'", "'.$WorkoutId.'", "'.$BaselineTypeId.'")';
        $Result = mysql_query($SQL);
        $InsertId = mysql_insert_id();
        return $InsertId;
    }
    
    function getWorkoutTypeId($BaselineType)
    {
        $SQL='SELECT recid FROM WorkoutTypes WHERE WorkoutType = "'.$BaselineType.'"';
        $Result = mysql_query($SQL); 
        $Row = mysql_fetch_assoc($Result);
        return $Row['recid'];
    }
                       
    function getBaselineDetails()
    {
        $SQL = 'SELECT DISTINCT MB.WorkoutId, 
            BT.WorkoutType AS BaselineType
            FROM MemberBaseline MB 
            LEFT JOIN WorkoutTypes BT ON BT.recid = MB.BaselineTypeId
            WHERE MB.MemberId = "'.$_SESSION['UID'].'"'; 

        $Result = mysql_query($SQL);
        $Row = mysql_fetch_assoc($Result);
        if($Row['BaselineType'] == 'Custom'){
            $BaselineObject = $this->getCustomBaseline($Row['WorkoutId']);
        }
        else if($Row['BaselineType'] == 'Benchmark'){
            $BaselineObject = $this->getBenchmarkBaseline($Row['WorkoutId']);
        }     
        else if($Row['BaselineType'] == 'Baseline'){
            $BaselineObject = $this->getDefaultBaseline();          
        }    
        else{
            $this->SaveNewBaseline();
            $BaselineObject = $this->getDefaultBaseline();      
        }
        return $BaselineObject;
    } 
    
    function getBenchmarkBaseline($Id)
    {
            $WorkoutDetails = array();

        if($this->getGender() == 'M'){
            $DescriptionField = 'MaleWorkoutDescription';
            $AttributeValue = 'AttributeValueMale';
            $InputFields = 'MaleInput';
        } else {
            $DescriptionField = 'FemaleWorkoutDescription';
            $AttributeValue = 'AttributeValueFemale';
            $InputFields = 'FemaleInput';
		}
		//$SQL = 'SELECT WorkoutName, '.$DescriptionField.' AS WorkoutDescription, '.$InputFields.' AS InputFields, VideoId FROM BenchmarkWorkouts WHERE recid = '.$Id.'';
		
		$SQL = 'SELECT BW.WorkoutName, 
                        E.Exercise, 
                        E.Acronym, 
                        BW.'.$DescriptionField.' AS WorkoutDescription,
                        E.recid AS ExerciseId, 
                        A.Attribute, 
                        BD.'.$AttributeValue.' AS AttributeValue,  
                        RoundNo,
                        (SELECT MAX(RoundNo) FROM BenchmarkDetails WHERE BenchmarkId = "'.$Id.'") AS TotalRounds
			FROM BenchmarkDetails BD
			LEFT JOIN BenchmarkWorkouts BW ON BW.recid = BD.BenchmarkId
			LEFT JOIN Exercises E ON E.recid = BD.ExerciseId
			LEFT JOIN Attributes A ON A.recid = BD.AttributeId
			WHERE BD.BenchmarkId = '.$Id.'
			ORDER BY RoundNo, OrderBy, Attribute';
		$Result = mysql_query($SQL);	
            while($Row = mysql_fetch_assoc($Result))
            {
		array_push($WorkoutDetails, new BaselineObject($Row));  
            }
            return $WorkoutDetails;       
    }
    
    function getCustomBaseline($Id)
    {
            $CustomDetails = array();

		$SQL = 'SELECT CW.WorkoutName, 
                        E.Exercise, 
                        E.Acronym, 
                        "'.$this->getCustomDescription($Id).'" AS WorkoutDescription,
                        E.recid AS ExerciseId, 
                        A.Attribute, 
                        CD.AttributeValue,  
                        RoundNo,
                        (SELECT MAX(RoundNo) FROM CustomDetails WHERE CustomId = "'.$Id.'") AS TotalRounds
			FROM CustomDetails CD
			LEFT JOIN CustomWorkouts CW ON CW.recid = CD.CustomId
			LEFT JOIN Exercises E ON E.recid = CD.ExerciseId
			LEFT JOIN Attributes A ON A.recid = CD.AttributeId
			WHERE CD.CustomId = '.$Id.'
			ORDER BY RoundNo, Attribute';
		$Result = mysql_query($SQL);	
            while($Row = mysql_fetch_assoc($Result))
            {
                array_push($CustomDetails, new BaselineObject($Row));  
            }
            return $CustomDetails;       
    }
    
    function getDefaultBaseline()
    {
        $MemberActivities = array();

        $SQL = 'SELECT "0" AS WorkoutId, 
            "Default" AS WorkoutName, 
            "Baseline" AS BaselineType, 
            MB.ExerciseId AS ExerciseId, 
            E.Exercise AS Exercise, 
            E.Acronym AS Acronym,
            A.Attribute, MB.AttributeValue,
            "1" AS TotalRounds
            FROM MemberBaseline MB
            JOIN Exercises E ON E.recid = MB.ExerciseId
            JOIN Attributes A ON A.recid = MB.AttributeId
            WHERE MB.MemberId = "'.$_SESSION['UID'].'"';
        //echo $SQL;
        $Result = mysql_query($SQL);
        while($Row = mysql_fetch_assoc($Result))
        {
            array_push($MemberActivities, new BaselineObject($Row));  
        }
        return $MemberActivities;
    } 
    
            function getCustomDescription($Id)
        {
            $Description = '';
            $SQL = 'SELECT E.Exercise, 
                E.Acronym, 
                A.Attribute, 
                CD.AttributeValue, 
                WT.WorkoutType 
                FROM CustomDetails CD
                LEFT JOIN Exercises E ON E.recid = CD.ExerciseId
                LEFT JOIN Attributes A ON A.recid = CD.AttributeId
                LEFT JOIN CustomWorkouts CW ON CW.recid = CD.CustomId
                LEFT JOIN WorkoutTypes WT ON WT.recid = CW.WorkoutTypeId
                WHERE CD.CustomId = "'.$Id.'"
                ORDER BY Exercise';
            $Result = mysql_query($SQL);
            $Exercise = '';
            while($Row = mysql_fetch_assoc($Result))
            {
                if($Exercise != $Row['Exercise']){
                    if($Description == '')
                        $WorkoutType = $Row['WorkoutType'];
                    else
                        $Description .= ' | ';
                    if($Row['Exercise'] != 'Timed')
                        $Description .= $Row['Exercise'];
                    $Exercise = $Row['Exercise'];
                }
                if($Row['Attribute'] == 'Reps'){
                    $Description .= ' ';
                    $Description .= $Row['AttributeValue'];
                    $Description .= ' ';
                    $Description .= $Row['Attribute'];
                }else if($Row['Attribute'] == 'Weight'){
                    $Description .= ' ';
                    $Description .= $Row['AttributeValue'];
                    if($this->getSystemOfMeasure() == 'Metric')
                        $Description .= 'kg';
                    else if($this->getSystemOfMeasure() == 'Imperial')
                        $Description .= 'lbs';
                }else if($Row['Attribute'] == 'Height'){
                    
                }else if($Row['Attribute'] == 'Distance'){
                    
                }else if($Row['Attribute'] == 'TimeToComplete'){
                    
                }else if($Row['Attribute'] == 'CountDown'){
                    
                }else if($Row['Attribute'] == 'Rounds'){
                    
                }else if($Row['Attribute'] == 'Calories'){
                    
                }
            }
            $Description .= $WorkoutType;
            return $Description;           
        }
}

class BaselineObject
{
    var $ExerciseId;
    var $WorkoutId;
    var $WorkoutName;
    var $BaselineType;
    var $Exercise;
    var $InputFieldName;   
    var $WorkoutDescription;
    var $Attribute;
    var $AttributeValue;
    var $RoundNo;
    var $TotalRounds;

    function __construct($Row)
    {
	$this->ExerciseId = isset($Row['ExerciseId']) ? $Row['ExerciseId'] : "";
        $this->WorkoutId = isset($Row['WorkoutId']) ? $Row['WorkoutId'] : "";
        $this->WorkoutName = isset($Row['WorkoutName']) ? $Row['WorkoutName'] : "";
	$this->BaselineType = isset($Row['BaselineType']) ? $Row['BaselineType'] : "";
        $this->Exercise = isset($Row['Exercise']) ? $Row['Exercise'] : "";
        if(isset($Row['Acronym']) && $Row['Acronym'] != '')
            $this->InputFieldName = $Row['Acronym'];
        else
            $this->InputFieldName = $this->Exercise;
        $this->WorkoutDescription = isset($Row['WorkoutDescription']) ? $Row['WorkoutDescription'] : "";
	$this->Attribute = isset($Row['Attribute']) ? $Row['Attribute'] : "";
	$this->AttributeValue = isset($Row['AttributeValue']) ? $Row['AttributeValue'] : "";
        $this->RoundNo = isset($Row['RoundNo']) ? $Row['RoundNo'] : "";
        $this->TotalRounds = isset($Row['TotalRounds']) ? $Row['TotalRounds'] : "";
    }
}
?>