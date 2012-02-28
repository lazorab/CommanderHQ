<?php
class TravelworkoutsModel extends Model
{
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
	}
	
	function getWorkouts()
	{
		$Workouts = array();
		$SQL = 'SELECT recid, Description FROM TravelWorkouts';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Workouts, new TravelWorkoutObject($Row));
		}
		return $Workouts;		
	}	
}

class TravelWorkoutObject
{
	var $Id;
	var $Description;

	function __construct($Row)
	{
		$this->Id = $Row['recid'];
		$this->Description = $Row['Description'];
	}
}
?>