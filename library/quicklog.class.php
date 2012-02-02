<?php
/********************************************************
Class to log exercises
Copyright Be-Mobile

Created By   : Darren Hart
Created Date : 02 February 2012

Last Modified Date: 02 February 2012

*********************************************************/


class Quicklog
{
	function __construct($Details)
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
		
		$Sql = 'INSERT INTO ExerciseLog(MemberId, CompletedExercise, Duration, Reps, Weight) VALUES("'.$Details['UID'].'", "'.$Details['exercise'].'","'.$Details['hours'].':'.$Details['minutes'].':'.$Details['seconds'].'","'.$Details['reps'].'","'.$Details['weight'].'")';
		mysql_query($Sql);
    }
}
