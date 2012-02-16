<?php
/********************************************************
Class to manage BenchMark Workouts
Copyright Be-Mobile

Created By   : Darren Hart
Created Date : 10 February 2012

Last Modified Date: 10 February 2012

*********************************************************/


class BMW
{
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
	
	function GetBMWS($_SEARCH)
	{
		$Workouts = array();
		$SQL = 'SELECT recid, WorkoutName, WorkoutDescription, VideoId FROM BenchmarkWorkouts';
		if(isset($_SEARCH['searchword']))
			$SQL .= 'WHERE WorkoutName LIKE "'.$_SEARCH['searchword'].'%"';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Workouts, new BMWObject($Row));
		}
		return $Workouts;
	}	
	
	function GetWorkoutDetails($Id)
	{
		$SQL = 'SELECT WorkoutName, WorkoutDescription, VideoId FROM BenchmarkWorkouts WHERE recid = '.$Id.'';
		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
		$Workout = new BMWObject($Row);
		
		return $Workout;
	}		
}

class BMWObject
{
	var $Id;
	var $WorkoutName;
	var $WorkoutDescription;
	var $SmartVideoLink;
	var $LegacyVideoLink;

	function __construct($Row)
	{
		$this->Id = $Row['recid'];
		$this->WorkoutName = $Row['WorkoutName'];
		$this->WorkoutDescription = $Row['WorkoutDescription'];
		$this->SmartVideoLink = 'http://www.youtube.com/embed/'.$Row['VideoId'].'';
		$this->LegacyVideoLink = 'http://m.youtube.com/details?v='.$Row['VideoId'].'';
	}
}