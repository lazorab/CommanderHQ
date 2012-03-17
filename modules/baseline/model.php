<?php
class BaselineModel extends Model
{
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
	}
	
	function UpdateBaseline($Baseline)
	{
		$SQL = 'UPDATE BenchmarkWorkouts SET WorkoutDescription="'.$Baseline.'" WHERE WorkoutName = "Baseline"';
		$Success = mysql_query($SQL);
		return $Success;
	}
	
	function GetBaseline()
	{
		$SQL = 'SELECT recid, WorkoutName, WorkoutDescription FROM BenchmarkWorkouts WHERE WorkoutName = "Baseline"';
		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
		$Baseline = new BaselineObject($Row);
		
		return $Baseline;
	}		
}

class BaselineObject
{
	var $Id;
	var $Baseline;
	var $Description;

	function __construct($Row)
	{
		$this->Id = $Row['recid'];
		$this->Baseline = $Row['WorkoutName'];
		$this->Description = $Row['WorkoutDescription'];
	}
}
?>