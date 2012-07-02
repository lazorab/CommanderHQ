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
        $SQL = 'SELECT recid, Attribute FROM Attributes';
        $Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
        {
            if(isset($_REQUEST[''.$Row['Attribute'].''])){
                $AttributeValue = $_REQUEST[''.$Row['Attribute'].''];
                $SQL = 'INSERT INTO BaselineLog(MemberId, ExerciseId, AttributeId, AttributeValue) 
                VALUES("'.$_SESSION['UID'].'", "'.$_REQUEST['BaselineId'].'", "'.$Row['recid'].'", "'.$AttributeValue.'")';
                mysql_query($SQL);	
            }
        }
	}
    
    function SaveNewBaseline()
	{
        $SQL = 'SELECT recid FROM ExerciseTypes WHERE ExerciseType = "'.$_REQUEST['newbaseline'].'"';
		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
        $ExerciseTypeId = $Row['recid'];
        
        if($_REQUEST['newbaseline'] == 'Benchmark'){
            $ExerciseId = $_REQUEST['benchmark'];            
        }
        else if($_REQUEST['newbaseline'] == 'Custom'){
            $SQL = 'INSERT INTO CustomExercises(MemberId, ExerciseName, ExerciseDescription, CustomTypeId) 
            VALUES("'.$_SESSION['UID'].'", "'.$_REQUEST['customname'].'", "'.$_REQUEST['customdescription'].'", "'.$_REQUEST['customtype'].'")';
            mysql_query($SQL);
            $ExerciseId = mysql_insert_id();
            /*
            foreach($_REQUEST['attribute'] AS $AttributeId)
            {
                
                
            }
            
            if($_REQUEST['newcount'] > 0){
                for($i=1; $i<$_REQUEST['newcount']; $i++)
                {
                    $SQL = 'INSERT INTO Attributes(Attribute) VALUES("'.$_REQUEST['newattribute_\'.$i.\''].'")';
                    mysql_query($SQL);
                    $AttributeId = mysql_insert_id();
                }
            } 
             */
        }
                
        $SQL = 'INSERT INTO MemberBaseline(MemberId, ExerciseId, ExerciseTypeId) VALUES("'.$_SESSION['UID'].'", '.$ExerciseId.', '.$ExerciseTypeId.')';

        mysql_query($SQL);
        $BaselineId = mysql_insert_id();
        return $BaselineId;
	}  
    
    function getCustomTypes()
    {
		$CustomTypes = array();
		$SQL = 'SELECT recid, CustomType as ExerciseDescription FROM CustomTypes';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($CustomTypes, new BaselineObject($Row));
		}
		
		return $CustomTypes;        
    }
    
    function getBenchmarks()
    {
		$Benchmarks = array();
		$SQL = 'SELECT recid, WorkoutName as ExerciseName FROM BenchmarkWorkouts';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Benchmarks, new BaselineObject($Row));
		}
		
		return $Benchmarks;        
    }
    
    function getBenchmarkDetails($Id)
    {
		$SQL = 'SELECT recid, WorkoutName as ExerciseName, WorkoutDescription as ExerciseDescription 
        FROM BenchmarkWorkouts 
        WHERE recid = "'.$Id.'"';
		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
        $Benchmark = new BaselineObject($Row);
		
		return $Benchmark;        
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
                $NewQuery = 'SELECT MB.recid, BW.WorkoutName AS ExerciseName
                    FROM MemberBaseline MB 
                    JOIN BenchmarkWorkouts BW ON MB.ExerciseId = BW.recid
                    WHERE BW.recid = '.$Row['ExerciseId'].'';
            }
            else if($Row['ExerciseType'] == 'Custom'){
                $NewQuery = 'SELECT MB.recid, CE.ExerciseName AS ExerciseName
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
            $SQL = 'SELECT MB.recid, A.Attribute, CE.ExerciseName AS ExerciseName, ExerciseDescription AS ExerciseDescription
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
            $SQL = 'SELECT MB.recid, "TimeToComplete" AS Attribute, BW.WorkoutName AS ExerciseName, BW.'.$DescriptionField.' AS ExerciseDescription
            FROM BenchmarkWorkouts BW
            JOIN MemberBaseline MB ON MB.ExerciseId = BW.recid
            WHERE MB.recid = '.$Id.'';
        }          
        $Result = mysql_query($SQL);	
        $Row = mysql_fetch_assoc($Result);               
        $BaselineDetail = new BaselineObject($Row);
                                  
        return $BaselineDetail;
    }                       
                       
}

class BaselineObject
{
	var $Id;
    var $Attribute;
    var $ExerciseId;
    var $ExerciseType;
	var $ExerciseName;
	var $Description;

	function __construct($Row)
	{
        $this->Id = isset($Row['recid']) ? $Row['recid'] : "";
        $this->Attribute = isset($Row['Attribute']) ? $Row['Attribute'] : "";
        $this->ExerciseId = isset($Row['ExerciseId']) ? $Row['ExerciseId'] : "";
        $this->ExerciseType = isset($Row['ExerciseType']) ? $Row['ExerciseType'] : "";
        $this->ExerciseName = isset($Row['ExerciseName']) ? $Row['ExerciseName'] : "";
        $this->Description = isset($Row['ExerciseDescription']) ? $Row['ExerciseDescription'] : "";
	}
}
?>