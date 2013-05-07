<?php
class ReportsModel extends Model
{    
	function __construct()
	{
	
	}
        
        function getRegisteredAthletes()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT M.UserId, M.FirstName, M.LastName, MD.Anon
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
                (SELECT recid FROM WorkoutTypes WHERE WorkoutType = "My Gym") AS WodTypeId,
                DATE_FORMAT(TimeCreated,"%U") AS WeekNumber,
                DATE_FORMAT(TimeCreated,"%W") AS DayName
                FROM WODLog WL
                LEFT JOIN WodWorkouts WW ON WW.recid = WL.WorkoutId
                LEFT JOIN WorkoutTypes WT ON WT.recid = WL.WODTypeId
                LEFT JOIN MemberDetails MD ON MD.MemberId = WL.MemberId
                LEFT JOIN Affiliates A ON A.AffiliateId = MD.GymId
                WHERE A.AffiliateId = "'.$_COOKIE['GID'].'"
                AND WT.WorkoutType = "My Gym"
                GROUP BY DATE_FORMAT(TimeCreated,"%Y-%m-%d")
                ORDER BY TimeCreated';
            $db->setQuery($SQL);
            return $db->loadObjectList();            
        }
        
        function getCompletedWodCount($Id)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT COUNT(WW.WorkoutName) AS NumberCompleted
                FROM WODLog WL
                LEFT JOIN WodWorkouts WW ON WW.recid = WL.WorkoutId
                LEFT JOIN WorkoutTypes WT ON WT.recid = WL.WODTypeId
                LEFT JOIN MemberDetails MD ON MD.MemberId = WL.MemberId
                LEFT JOIN Affiliates A ON A.AffiliateId = MD.GymId
                WHERE A.AffiliateId = "'.$_COOKIE['GID'].'"
                AND WT.WorkoutType = "My Gym"
                AND WL.WorkoutId = "'.$Id.'"';
            $db->setQuery($SQL);
            return $db->loadResult();            
        }
        
        function getAverageWodTimes($WodId)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT WL.AttributeValue AS TimeToComplete
                FROM WODLog WL
                LEFT JOIN Attributes Att ON Att.recid = WL.AttributeId
                LEFT JOIN WodWorkouts WW ON WW.recid = WL.WorkoutId
                LEFT JOIN WorkoutTypes WT ON WT.recid = WL.WODTypeId
                LEFT JOIN MemberDetails MD ON MD.MemberId = WL.MemberId
                LEFT JOIN Affiliates A ON A.AffiliateId = MD.GymId
                WHERE A.AffiliateId = "'.$_COOKIE['GID'].'"
                AND WT.WorkoutType = "My Gym"
                AND WL.WorkoutId = "'.$WodId.'"
                AND Att.Attribute = "TimeToComplete"';
            $db->setQuery($SQL);
            return $db->loadObjectList();            
        }
        
        function getAverageActivityTimes($ActivityId)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT WL.AttributeValue AS TimeToComplete
                FROM WODLog WL
                LEFT JOIN Attributes Att ON Att.recid = WL.AttributeId
                LEFT JOIN WodDetails WD ON WD.WodId = WL.WorkoutId  
                LEFT JOIN WorkoutTypes WT ON WT.recid = WL.WODTypeId
                LEFT JOIN MemberDetails MD ON MD.MemberId = WL.MemberId
                LEFT JOIN Affiliates A ON A.AffiliateId = MD.GymId
                WHERE A.AffiliateId = "'.$_COOKIE['GID'].'"
                AND WT.WorkoutType = "My Gym"
                AND WL.ExerciseId = "'.$ActivityId.'"
                AND Att.Attribute = "TimeToComplete"';
            $db->setQuery($SQL);
            return $db->loadObjectList();            
        }
        
        function getAverageActivityReps($ActivityId)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT WL.AttributeValue AS Reps
                FROM WODLog WL
                LEFT JOIN Attributes Att ON Att.recid = WL.AttributeId
                LEFT JOIN WodDetails WD ON WD.WodId = WL.WorkoutId    
                LEFT JOIN WorkoutTypes WT ON WT.recid = WL.WODTypeId
                LEFT JOIN MemberDetails MD ON MD.MemberId = WL.MemberId
                LEFT JOIN Affiliates A ON A.AffiliateId = MD.GymId
                WHERE A.AffiliateId = "'.$_COOKIE['GID'].'"
                AND WT.WorkoutType = "My Gym"
                AND WL.ExerciseId = "'.$ActivityId.'"
                AND Att.Attribute = "Reps"';
            $db->setQuery($SQL);
            return $db->loadObjectList();            
        }
        
        function getAverageActivityWeight($ActivityId)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT WL.AttributeValue AS Weight
                FROM WODLog WL
                LEFT JOIN Attributes Att ON Att.recid = WL.AttributeId
                LEFT JOIN WodDetails WD ON WD.WodId = WL.WorkoutId      
                LEFT JOIN WorkoutTypes WT ON WT.recid = WL.WODTypeId
                LEFT JOIN MemberDetails MD ON MD.MemberId = WL.MemberId
                LEFT JOIN Affiliates A ON A.AffiliateId = MD.GymId
                WHERE A.AffiliateId = "'.$_COOKIE['GID'].'"
                AND WT.WorkoutType = "My Gym"
                AND WL.ExerciseId = "'.$ActivityId.'"
                AND Att.Attribute = "Weight"';
            $db->setQuery($SQL);
            return $db->loadObjectList();            
        }    
        
        function getTotalWeightLifted($AthleteId)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT CASE WHEN SUM(L.AttributeValue) > 0
                THEN SUM(L.AttributeValue)
                ELSE "0" END AS LoggedWeight,
                U.UnitOfMeasure
                FROM WODLog L 
                LEFT JOIN Attributes A ON A.recid = L.AttributeId
                LEFT JOIN UnitsOfMeasure U ON U.recid = L.UnitOfMeasureId
                LEFT JOIN WorkoutTypes WT ON WT.recid = L.WODTypeId
                WHERE A.Attribute = "Weight"
                AND WT.WorkoutType = "My Gym"
                AND L.MemberId = "'.$AthleteId.'"
                AND L.ExerciseId > 0
                AND L.AttributeValue != "Max"';
            $db->setQuery($SQL);
            return $db->loadObject();           
        }
        
        function getRecordedRepsCount($Id)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT SUM(L.AttributeValue) AS TotalReps
                FROM WODLog L 
                LEFT JOIN Attributes A ON A.recid = L.AttributeId
                LEFT JOIN WorkoutTypes WT ON WT.recid = L.WODTypeId
                WHERE A.Attribute = "Reps"
                AND WT.WorkoutType = "My Gym"
                AND L.MemberId = "'.$Id.'"
                AND L.ExerciseId > 0
                AND L.AttributeValue != "Max"';
            $db->setQuery($SQL);
            return $db->loadResult();            
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
            $SQL = 'SELECT DISTINCT WW.recid AS WodId, WL.TimeCreated,
                WW.WorkoutName AS WodName,
                (SELECT recid FROM WorkoutTypes WHERE WorkoutType = "My Gym") AS WodTypeId
                FROM WODLog WL
                LEFT JOIN WodWorkouts WW ON WW.recid = WL.WorkoutId
                LEFT JOIN WorkoutTypes WT ON WT.recid = WL.WODTypeId
                WHERE WL.MemberId = "'.$AthleteId.'"
                AND WT.WorkoutType = "My Gym"
                ORDER BY TimeCreated';
            $db->setQuery($SQL);
            return $db->loadObjectList();             
        }
        
        function getMemberBaselineTime($UserId)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT WL.AttributeValue AS TimeToComplete
                FROM WODLog WL
                LEFT JOIN Attributes Att ON Att.recid = WL.AttributeId
                LEFT JOIN WodDetails WD ON WD.WodId = WL.WorkoutId  
                LEFT JOIN WorkoutTypes WT ON WT.recid = WL.WODTypeId
                WHERE WL.MemberId = "'.$UserId.'"
                AND WT.WorkoutType = "Baseline"
                ORDER BY TimeCreated DESC LIMIT 1';
            $db->setQuery($SQL);
            return $db->loadResult();           
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
        
        function getWodDetails($Id)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);

		$SQL = 'SELECT WW.recid AS Id,
                        WW.WorkoutName AS WodName, 
                        E.Exercise, 
                        E.recid AS ExerciseId, 
                        CASE 
                            WHEN E.Acronym <> ""
                            THEN E.Acronym
                            ELSE E.Exercise
                        END
                        AS InputFieldName,  
                        A.Attribute, 
                        AttributeValueFemale,
                        AttributeValueMale,
                        WD.UnitOfMeasureId,   
                        UOM.UnitOfMeasure,
                        UOM.ConversionFactor,
                        WD.RoutineNo,
                        WD.RoundNo,
                        WD.OrderBy,
                        (SELECT MAX(RoundNo) FROM WodDetails WHERE WodId = Id AND RoutineNo = WD.RoutineNo) AS TotalRounds,
                        WW.WorkoutRoutineTypeId,
                        WW.WodDate,
                        WW.Notes AS Description
			FROM WodDetails WD
			LEFT JOIN WodWorkouts WW ON WW.recid = WD.WodId
			LEFT JOIN Exercises E ON E.recid = WD.ExerciseId
			LEFT JOIN Attributes A ON A.recid = WD.AttributeId
                        LEFT JOIN UnitsOfMeasure UOM ON UOM.recid = WD.UnitOfMeasureId
			WHERE WW.recid = '.$Id.'
			UNION
                        SELECT WW.recid AS Id,
                        BW.WorkoutName AS WodName, 
                        E.Exercise,
                        E.recid AS ExerciseId, 
                        CASE 
                            WHEN E.Acronym <> ""
                            THEN E.Acronym
                            ELSE E.Exercise
                        END
                        AS InputFieldName,
                        A.Attribute, 
                        AttributeValueFemale,
                        AttributeValueMale, 
                        BD.UnitOfMeasureId,    
                        UOM.UnitOfMeasure,
                        UOM.ConversionFactor,    
                        WW.RoutineNo, 
                        BD.RoundNo,
                        BD.OrderBy,
                        (SELECT MAX(RoundNo) FROM BenchmarkDetails WHERE BenchmarkId = WW.WorkoutName) AS TotalRounds,
                        WW.WorkoutRoutineTypeId,
                        WW.WodDate,
                        WW.Notes AS Description                      
			FROM BenchmarkDetails BD
			LEFT JOIN BenchmarkWorkouts BW ON BW.recid = BD.BenchmarkId
			LEFT JOIN WodWorkouts WW ON WW.WorkoutName = BD.BenchmarkId
			LEFT JOIN Exercises E ON E.recid = BD.ExerciseId
			LEFT JOIN Attributes A ON A.recid = BD.AttributeId
                        LEFT JOIN UnitsOfMeasure UOM ON UOM.AttributeId = A.recid AND BD.UnitOfMeasureId = UOM.recid
			WHERE WW.recid = '.$Id.'
                        AND (Attribute = "Reps" OR SystemOfMeasure = "Metric")			
			ORDER BY RoutineNo, RoundNo, OrderBy, Exercise, Attribute';
            //}
            //    var_dump($SQL);
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
