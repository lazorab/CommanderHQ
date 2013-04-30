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
        
        function getCompletedWods()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT COUNT(WW.WorkoutName) AS NumberCompleted,
                WW.recid AS WodId, 
                WW.WorkoutName AS WodName,
                (SELECT recid FROM WorkoutTypes WHERE WorkoutType = "My Gym") AS WodTypeId
                FROM WODLog WL
                LEFT JOIN WodWorkouts WW ON WW.recid = WL.WorkoutId
                LEFT JOIN WorkoutTypes WT ON WT.recid = WL.WODTypeId
                LEFT JOIN MemberDetails MD ON MD.MemberId = WL.MemberId
                LEFT JOIN Affiliates A ON A.AffiliateId = MD.GymId
                WHERE A.AffiliateId = "'.$_COOKIE['GID'].'"
                AND WT.WorkoutType = "My Gym"
                GROUP BY WodId';
            $db->setQuery($SQL);
            return $db->loadObjectList();            
        }
        
        function getCompletedActivities()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT COUNT(E.Exercise) AS NumberCompleted,
                WL.ExerciseId AS ExerciseId, 
                E.Exercise AS Exercise,
                (SELECT recid FROM WorkoutTypes WHERE WorkoutType = "My Gym") AS WodTypeId
                FROM WODLog WL
                LEFT JOIN Exercises E ON WL.ExerciseId = E.recid
                LEFT JOIN WorkoutTypes WT ON WT.recid = WL.WODTypeId
                LEFT JOIN MemberDetails MD ON MD.MemberId = WL.MemberId
                LEFT JOIN Affiliates A ON A.AffiliateId = MD.GymId
                WHERE A.AffiliateId = "'.$_COOKIE['GID'].'"
                AND WT.WorkoutType = "My Gym"
                GROUP BY Exercise';
            $db->setQuery($SQL);
            return $db->loadObjectList();            
        }        
        
        function getCompletedMemberWods($AthleteId)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT DISTINCT WW.recid AS WodId, 
                WW.WorkoutName AS WodName,
                (SELECT recid FROM WorkoutTypes WHERE WorkoutType = "My Gym") AS WodTypeId
                FROM WODLog WL
                LEFT JOIN WodWorkouts WW ON WW.recid = WL.WorkoutId
                LEFT JOIN WorkoutTypes WT ON WT.recid = WL.WODTypeId
                WHERE WL.MemberId = "'.$AthleteId.'"
                AND WT.WorkoutType = "My Gym"';
            $db->setQuery($SQL);
            return $db->loadObjectList();             
        }
        
        function getCompletedGymWods($AthleteId)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT DISTINCT M.FirstName,
                M.LastName,
                WW.recid AS WodId, 
                WW.WorkoutName AS WodName,
                (SELECT recid FROM WorkoutTypes WHERE WorkoutType = "My Gym") AS WodTypeId,
                E.Exercise,
                A.Attribute,
                WL.AttributeValue,
                WL.TimeCreated
                FROM WODLog WL
                LEFT JOIN Members M ON M.UserId = WL.MemberId
                LEFT JOIN Exercises E ON WL.ExerciseId = E.recid
                LEFT JOIN WodWorkouts WW ON WW.recid = WL.WorkoutId
                LEFT JOIN WorkoutTypes WT ON WT.recid = WL.WODTypeId
                LEFT JOIN Attributes A ON A.recid = WL.AttributeId
                WHERE WT.WorkoutType = "My Gym"';
                if($AthleteId > 0)
                    $SQL .= ' AND WL.MemberId = "'.$AthleteId.'"'; 
                $SQL .= ' ORDER BY LastName, TimeCreated'; 
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
