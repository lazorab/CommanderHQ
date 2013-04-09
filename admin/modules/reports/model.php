<?php
class ReportsModel extends Model
{    
	function __construct()
	{
	
	}
        
        function getRegisteredAthletes()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT M.UserId, M.FirstName, M.LastName
                FROM Members M JOIN MemberDetails MD ON MD.MemberId = M.UserId
                WHERE MD.GymId = "'.$_COOKIE['GID'].'"
                ORDER BY LastName';
            $db->setQuery($SQL);
            return $db->loadObjectList();           
        }
        
        function getRegisteredAthleteCount()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT COUNT(*)
                FROM Members M JOIN MemberDetails MD ON MD.MemberId = M.UserId
                WHERE MD.GymId = "'.$_COOKIE['GID'].'"';
            $db->setQuery($SQL);
            return $db->loadResult();           
        }
        
        function getCompletedWods($AthleteId)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT DISTINCT CW.recid AS WodId, 
CW.WorkoutName AS WodName,
(SELECT recid FROM WorkoutTypes WHERE WorkoutType = "Custom") AS WodTypeId
FROM WODLog WL
JOIN CustomWorkouts CW ON CW.recid = WL.WorkoutId
JOIN WorkoutTypes WT ON WT.recid = WL.WODTypeId
WHERE WL.MemberId = "'.$AthleteId.'"
AND WT.WorkoutType = "Custom"
UNION
SELECT DISTINCT BW.recid AS WodId, 
BW.WorkoutName AS WodName,
(SELECT recid FROM WorkoutTypes WHERE WorkoutType = "Benchmark") AS WodTypeId
FROM WODLog WL
JOIN BenchmarkWorkouts BW ON BW.recid = WL.WorkoutId
JOIN WorkoutTypes WT ON WT.recid = WL.WODTypeId
WHERE WL.MemberId = "'.$AthleteId.'"
AND WT.WorkoutType = "Benchmark"
UNION
SELECT DISTINCT WW.recid AS WodId, 
WW.WorkoutName AS WodName,
(SELECT recid FROM WorkoutTypes WHERE WorkoutType = "My Gym") AS WodTypeId
FROM WODLog WL
JOIN WodWorkouts WW ON WW.recid = WL.WorkoutId
JOIN WorkoutTypes WT ON WT.recid = WL.WODTypeId
WHERE WL.MemberId = "'.$AthleteId.'"
AND WT.WorkoutType = "My Gym"';
            $db->setQuery($SQL);
            return $db->loadObjectList();             
        }
        
        function getRecordedWodResult($AthleteId, $WodId)
        {
            
        }
        
        function getRecordedActivityResult($AthleteId, $ActivityId)
        {
            
        }
        
        function getTopResultsWod()
        {
            
        }
        
        function getTopResultsActivity()
        {
            
        }
}
?>
