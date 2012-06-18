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
		$SQL = 'SELECT recid, WorkoutName as ExerciseName, WorkoutDescription as ExerciseDescription FROM BenchmarkWorkouts WHERE recid = "'.$Id.'"';
		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
        $Benchmark = new BaselineObject($Row);
		
		return $Benchmark;        
    }
    
    function getCustomOptions()
    {
		$Options = array();
		$SQL = 'SELECT recid, Attribute FROM Attributes';
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
            array_push($Baselines, new BaselineObject($Row));
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
                       
    function getBaselineDetails(&$Baseline)
    {
        if($Baseline->ExerciseType == 'Custom'){
            $SQL = '';
        }
        else if($Baseline->ExerciseType == 'Benchmark'){
            $SQL = 'SELECT recid, WorkoutName AS ExerciseName,
                       WorkoutDescription AS ExerciseDescription
                       FROM BenchmarkWorkouts
                       WHERE recid = '.$Baseline->ExerciseId.'';           
        }

        $Result = mysql_query($SQL);	
                       
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