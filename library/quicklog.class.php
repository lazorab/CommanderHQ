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
		
		if(isset($Details['exercise']) && $Details['exercise'] != ''){
			$Sql = 'SELECT ExerciseType FROM SkillsLevel WHERE ExerciseId = '.$Details['exercise'].'';
			$Result = mysql_query($Sql);	
			$Row = mysql_fetch_assoc($Result);
			$ExerciseType = $Row['ExerciseType'];
			$Exercise = $Details['exercise'];
		}
		elseif(isset($Details['workout']) && $Details['workout'] != ''){
			$ExerciseType = 'Workout';		
			$Exercise = $Details['workout'];
		}
			
		$Sql = 'INSERT INTO ExerciseLog(MemberId, ExerciseId, ExerciseType, Duration, Reps, Weight) VALUES("'.$Details['UID'].'", "'.$Exercise.'", "'.$ExerciseType.'", "'.$Details['hours'].':'.$Details['minutes'].':'.$Details['seconds'].'","'.$Details['reps'].'","'.$Details['weight'].'")';
		mysql_query($Sql);
		
		$Sql = 'SELECT Height FROM MemberDetails WHERE MemberId = '.$Details['UID'].'';
		$Result = mysql_query($Sql);	
		$Row = mysql_fetch_assoc($Result);
		$MemberHeight = $Row['Height'];
		
		$BMI = round($Details['Weight'] / ($MemberHeight * $MemberHeight), 2);
		
		$Sql = 'UPDATE MemberDetails SET Weight = "'.$Details['weight'].'", BMI = '.$BMI.' WHERE MemberId = '.$Details['UID'].'';
		mysql_query($Sql);		
    }
}