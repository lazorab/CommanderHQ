<?php
class WodModel extends Model
{
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
	}
	
	function InsertWOD($_DETAILS)
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
		$SQL = 'INSERT INTO WOD('.$FIELDS.') VALUES('.$VALUES.')';
		mysql_query($SQL);	
	}
	
	function Log()
	{
		$SQL = 'INSERT INTO WODLog(MemberId, ExerciseId, WODTypeId, TimeToComplete) VALUES("'.$_SESSION['UID'].'", "'.$_REQUEST['exercise'].'", "'.$_REQUEST['wodtype'].'", "'.$_REQUEST['clock'].'")';
		mysql_query($SQL);	
	}
	
	function getWOD($type, $date)
	{
		$SQL = 'SELECT ActivityName, ActivityType, Description, Repetitions, Duration, WODate FROM WOD WHERE WODate = DATE_FORMAT("'.$date.'", "%Y-%m-%d") LIMIT 1';
		//$Result = mysql_query($SQL);	
		//$Row = mysql_fetch_assoc($Result);
		//$WOD = new WODObject($Row);
		
		return $SQL;
	}

	function getBenchmark($Id)
	{
		$SQL = 'SELECT WorkoutName as ActivityName, WorkoutDescription as Description FROM BenchmarkWorkouts WHERE recid = '.$Id.'';
		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
		$Workout = new WODObject($Row);
		
		return $Workout;
	}	
	
	function getBenchmarks()
	{
		$Benchmarks = array();
		$SQL = 'SELECT recid, WorkoutName as ActivityName FROM BenchmarkWorkouts';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Benchmarks, new WODObject($Row));
		}
		
		return $Benchmarks;
	}	
}

class WODObject
{
	var $recid;
	var $ActivityName;
	var $ActivityType;
	var $Description;
	var $Repetitions;
	var $Duration;
	var $WODate;

	function __construct($Row)
	{
		$this->recid = isset($Row['recid']) ? $Row['recid'] : "";
		$this->ActivityName = isset($Row['ActivityName']) ? $Row['ActivityName'] : "";
		$this->ActivityType = isset($Row['ActivityType']) ? $Row['ActivityType'] : "";
		$this->Description = isset($Row['Description']) ? $Row['Description'] : "";
		$this->Repetitions = isset($Row['Repetitions']) ? $Row['Repetitions'] : "";
		$this->Duration = isset($Row['Duration']) ? $Row['Duration'] : "";
		$this->WODate = isset($Row['WODate']) ? $Row['WODate'] : "";
	}
}
?>