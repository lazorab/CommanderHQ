<?php
class BaselineModel extends Model
{
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
	}
    
    function Log()
	{
        if($_REQUEST['newcount'] > 0){
            $this->SaveNewActivities();
        }
        $ExerciseTypeId = $this->getExerciseTypeId();
        $ActivityFields=$this->getActivityFields();
        //var_dump($ActivityFields);
        foreach($ActivityFields AS $Activity)
        {
            //First Store the values incase they changed
            $SQL = 'UPDATE MemberBaseline 
            SET AttributeValue = "'.$Activity->AttributeValue.'" 
            WHERE MemberId = "'.$_SESSION['UID'].'" 
            AND ExerciseId = "'.$Activity->recid.'"
            AND AttributeId = "'.$Activity->Attribute.'"';
            mysql_query($SQL);
            $SQL = 'INSERT INTO BaselineLog(MemberId, ExerciseTypeId, ExerciseId, AttributeId, AttributeValue) 
            VALUES("'.$_SESSION['UID'].'", "'.$ExerciseTypeId.'", "'.$Activity->recid.'", "'.$Activity->Attribute.'", "'.$Activity->AttributeValue.'")';
            mysql_query($SQL);
        }
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
                $ExerciseId = $ExplodedKey[0];
                $Attribute = $ExplodedKey[1];
                $Query='SELECT recid, (SELECT recid FROM Attributes WHERE Attribute = "'.$Attribute.'") AS Attribute, "'.$val.'" AS AttributeValue 
                FROM Exercises
                WHERE recid = "'.$ExerciseId.'"';
                $Result = mysql_query($Query); 
                $Row = mysql_fetch_assoc($Result);
                array_push($Activities, new BaselineObject($Row));
            }
            else{
                $SQL = 'SELECT recid FROM Attributes WHERE Attribute = "'.$key.'"';
                $Result = mysql_query($SQL);
                $numrows = mysql_num_rows($Result);
                if($numrows == 1){
                    $Row = mysql_fetch_assoc($Result);
                    $Attribute = $Row['recid'];
                    array_push($Activities, new BaselineObject(array('recid'=>'0','Attribute'=>''.$Attribute.'','AttributeValue'=>''.$val.'')));
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
    
    function getExerciseTypeId()
    {
        $SQL = 'SELECT recid FROM ExerciseTypes WHERE ExerciseType = "'.$_REQUEST['baseline'].'"';
        $Result = mysql_query($SQL);        
        $Row = mysql_fetch_assoc($Result);
        return $Row['recid'];
    }
    
    function SaveNewBaseline()
	{
        $DefaultActivities=array('Row'=>'500','Squats'=>'40','Sit Ups'=>'30','Push Ups'=>'20','Pull Ups'=>'10');
        
        foreach($DefaultActivities AS $key=>$val)
        {
            $Query='SELECT E.recid AS ExerciseId, A.recid AS AttributeId, "'.$val.'" AS AttributeValue
            FROM Attributes A
            JOIN ExerciseAttributes EA ON EA.AttributeId = A.recid
            JOIN Exercises E ON EA.ExerciseId = E.recid
            WHERE E.Exercise = "'.$key.'"
            AND (A.Attribute = "Distance"
                 OR A.Attribute = "Reps")'; 
            $Result = mysql_query($Query);        
            $Row = mysql_fetch_assoc($Result);
            $ExerciseId = $Row['ExerciseId'];
            $AttributeId = $Row['AttributeId'];
            $AttributeValue = $Row['AttributeValue'];
             $SQL = 'INSERT INTO MemberBaseline(MemberId, ExerciseId, AttributeId, AttributeValue) VALUES("'.$_SESSION['UID'].'", "'.$ExerciseId.'", "'.$AttributeId.'", "'.$AttributeValue.'")';
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
    
    function getCustomTypes()
    {
		$CustomTypes = array();
		$SQL = 'SELECT recid, CustomType as Description FROM CustomTypes';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($CustomTypes, new BaselineObject($Row));
		}
		
		return $CustomTypes;        
    }
    
    function getMemberCustomExercises()
    {
		$Exercises = array();
		$SQL = 'SELECT recid, ExerciseName AS ActivityName, ExerciseDescription AS Description FROM CustomExercises WHERE MemberId = "'.$_SESSION['UID'].'"';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Exercises, new BaselineObject($Row));
		}
		
		return $Exercises;        
    }
    
    function getCustomDetails($Id)
    {
		$SQL = 'SELECT CE.recid, CE.ActivityName AS ActivityName, ExerciseDescription AS Description, CT.CustomType AS ActivityType, A.Attribute, CMAV.AttributeValue
        FROM CustomExercises CE
        LEFT JOIN CustomTypes CT ON CT.recid = CE.CustomTypeId
        LEFT JOIN CustomTypeAttributes CTA ON CTA.CustomTypeId = CT.recid
        LEFT JOIN Attributes A ON A.recid = CTA.AttributeId
        LEFT JOIN CustomMemberAttributeValues CMAV ON CMAV.AttributeId = CTA.AttributeId
        WHERE CE.recid = '.$Id.'';
		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
		$Details = new BaselineObject($Row);
		
		return $Details;       
    }
    
    function SaveCustom()
    {
        $SQL = 'INSERT INTO CustomExercises(MemberId, ActivityName, ExerciseDescription, CustomTypeId) 
        VALUES("'.$_SESSION['UID'].'", "'.$_REQUEST['newcustom'].'", "'.$_REQUEST['customdescription'].'", "'.$_REQUEST['customtype'].'")';
		$Result = mysql_query($SQL);
        
		return mysql_insert_id();
    }
	
	function getGender()
	{
        $SQL = 'SELECT Gender FROM MemberDetails WHERE MemberId = "'.$_SESSION['UID'].'"';
 		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
        
		return $Row['Gender'];
	}
    
	function getBenchmark($Id)
	{   
        if($this->getGender() == 'M')
            $DescriptionField = 'MaleWorkoutDescription';
        else
            $DescriptionField = 'FemaleWorkoutDescription';
		$SQL = 'SELECT WorkoutName as ActivityName, '.$DescriptionField.' as Description FROM BenchmarkWorkouts WHERE recid = '.$Id.'';
		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
		$Workout = new BaselineObject($Row);
		
		return $Workout;
	}	
	
	function getBenchmarks()
	{
		$Benchmarks = array();
        if($this->getGender() == 'M')
            $DescriptionField = 'MaleWorkoutDescription';
        else
            $DescriptionField = 'FemaleWorkoutDescription';		
		$SQL = 'SELECT recid, WorkoutName as ActivityName, '.$DescriptionField.' as Description FROM BenchmarkWorkouts';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Benchmarks, new BaselineObject($Row));
		}
		
		return $Benchmarks;
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
		$SQL = 'SELECT mb.recid, 
        mb.ExerciseId,
        et.ExerciseType
        FROM MemberBaseline mb
        JOIN ExerciseTypes et ON et.recid = mb.ExerciseTypeId
        WHERE mb.MemberId = "'.$_SESSION['UID'].'"';
		$Result = mysql_query($SQL);	
        
		while($Row = mysql_fetch_assoc($Result))
        {
            if($Row['ExerciseType'] == 'Benchmark'){
                $NewQuery = 'SELECT MB.recid, BW.WorkoutName AS ActivityName
                    FROM MemberBaseline MB 
                    JOIN BenchmarkWorkouts BW ON MB.ExerciseId = BW.recid
                    WHERE BW.recid = '.$Row['ExerciseId'].'';
            }
            else if($Row['ExerciseType'] == 'Custom'){
                $NewQuery = 'SELECT MB.recid, CE.ActivityName AS ActivityName
                FROM MemberBaseline MB
                JOIN CustomExercises CE ON CE.recid = MB.ExerciseId
                WHERE CE.recid = '.$Row['ExerciseId'].'';               
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
            $Id = $_REQUEST['benchmark'];
            $type='8';
        }
        $SQL='INSERT INTO MemberBaseline(MemberId, ExerciseId, ExerciseTypeId) VALUES("'.$_SESSION['UID'].'", "'.$Id.'", "'.$type.'")';
        $Result = mysql_query($SQL);
        $InsertId = mysql_insert_id();
        return $InsertId;
    }
                       
    function getBaselineDetails($Id)
    {
        $SQL = 'SELECT ET.ExerciseType
        FROM MemberBaseline MB JOIN ExerciseTypes ET ON ET.recid = MB.ExerciseTypeId
        WHERE MB.recid = '.$Id.''; 

        $Result = mysql_query($SQL);
        $Row = mysql_fetch_assoc($Result);
        if($Row['ExerciseType'] == 'Custom'){
            $SQL = 'SELECT MB.recid, A.Attribute, CE.ActivityName AS ActivityName, ExerciseDescription AS Description
            FROM CustomExercises CE
            JOIN MemberBaseline MB ON MB.ExerciseId = CE.recid
            JOIN CustomTypeAttributes CA ON CA.CustomTypeId = CE.CustomTypeId
            JOIN Attributes A ON CA.AttributeId = A.recid 
            WHERE MB.recid = '.$Id.'';

        }
        else if($Row['ExerciseType'] == 'Benchmark'){
            $SQL = 'SELECT Gender FROM MemberDetails WHERE MemberId = "'.$_SESSION['UID'].'"';
            $Result = mysql_query($SQL);	
            $Row = mysql_fetch_assoc($Result);
            if($Row['Gender'] == 'M')
                $DescriptionField = 'MaleWorkoutDescription';
            else
                $DescriptionField = 'FemaleWorkoutDescription';
            $SQL = 'SELECT MB.recid, "TimeToComplete" AS Attribute, BW.WorkoutName AS ActivityName, BW.'.$DescriptionField.' AS Description
            FROM BenchmarkWorkouts BW
            JOIN MemberBaseline MB ON MB.ExerciseId = BW.recid
            WHERE MB.recid = '.$Id.'';
        }          
        $Result = mysql_query($SQL);	
        $Row = mysql_fetch_assoc($Result);               
        $BaselineDetail = new BaselineObject($Row);
                                  
        return $BaselineDetail;
    }   
    
    function getMemberBaselineActivities()
    {
        $MemberActivities = array();
        if(!$this->MemberBaselineExists())
            $this->SaveNewBaseline();
        $SQL = 'SELECT MB.ExerciseId AS recid, E.Exercise AS ActivityName, A.Attribute, MB.AttributeValue 
        FROM MemberBaseline MB
        JOIN Exercises E ON E.recid = MB.ExerciseId
        JOIN Attributes A ON A.recid = MB.AttributeId
        WHERE MB.MemberId = "'.$_SESSION['UID'].'"';
        $Result = mysql_query($SQL);
        while($Row = mysql_fetch_assoc($Result))
        {
            array_push($MemberActivities, new BaselineObject($Row));  
        }
        return $MemberActivities;
    }
                       
}

class BaselineObject
{
	var $recid;
	var $ActivityName;
	var $ActivityType;
	var $Description;
	var $Attribute;
	var $AttributeValue;

	function __construct($Row)
	{
		$this->recid = isset($Row['recid']) ? $Row['recid'] : "";
		$this->ActivityName = isset($Row['ActivityName']) ? $Row['ActivityName'] : "";
		$this->ActivityType = isset($Row['ActivityType']) ? $Row['ActivityType'] : "";
		$this->Description = isset($Row['Description']) ? $Row['Description'] : "";
		$this->Attribute = isset($Row['Attribute']) ? $Row['Attribute'] : "";
		$this->AttributeValue = isset($Row['AttributeValue']) ? $Row['AttributeValue'] : "";
	}
}
?>