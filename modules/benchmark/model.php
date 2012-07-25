<?php
class BenchmarkModel extends Model
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
	
	function getCategories()
	{
		$Categories=array();
		$SQL = 'SELECT recid, Category, Image, Banner FROM BenchmarkCategories';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Categories, new CategoryObject($Row));
		}
		return $Categories;
	}
	
	function getCategory($Id)
	{
		$SQL = 'SELECT Category FROM BenchmarkCategories WHERE recid = '.$Id.'';
		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
		return $Row['Category'];
	}	
	
	function GetBMWS($Filter)
	{
        $SQL = 'SELECT Gender FROM MemberDetails WHERE MemberId = "'.$_SESSION['UID'].'"';
 		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
        if($Row['Gender'] == 'M')
            $DescriptionField = 'MaleWorkoutDescription';
        else
            $DescriptionField = 'FemaleWorkoutDescription';
		$SQL = 'SELECT recid, Banner, WorkoutName, '.$DescriptionField.' AS WorkoutDescription, VideoId 
		FROM BenchmarkWorkouts WHERE '; 	
		if(!is_int($Filter)){
			$SQL .= 'CategoryId = '.$Filter.'';
		}
		else{
			$SQL .= 'WorkoutName LIKE "'.$Filter.'%"';
		}
		$Workouts = array();
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Workouts, new BenchmarkObject($Row));
		}
		return $Workouts;
	}	
	
	function GetWorkoutDetails($Id)
	{   
        $SQL = 'SELECT Gender FROM MemberDetails WHERE MemberId = "'.$_SESSION['UID'].'"';
 		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
        if($Row['Gender'] == 'M')
            $DescriptionField = 'MaleWorkoutDescription';
        else
            $DescriptionField = 'FemaleWorkoutDescription';
		$SQL = 'SELECT WorkoutName, '.$DescriptionField.' AS WorkoutDescription, VideoId FROM BenchmarkWorkouts WHERE recid = '.$Id.'';
		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
		$Workout = new BenchmarkObject($Row);
		
		return $Workout;
	}	

	function Log()
	{
        $SQL = 'SELECT recid, Attribute FROM Attributes';
        $Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
        {
            if(isset($_REQUEST[''.$Row['Attribute'].''])){
                $AttributeValue = $_REQUEST[''.$Row['Attribute'].''];
				/*
                $SQL = 'INSERT INTO BenchmarkLog(MemberId, BenchmarkId, AttributeId, AttributeValue) 
                VALUES("'.$_SESSION['UID'].'", "'.$_REQUEST['benchmarkId'].'", "'.$Row['recid'].'", "'.$AttributeValue.'")';
                mysql_query($SQL);	
				*/
				$SQL = 'INSERT INTO WODLog(MemberId, ExerciseId, WODTypeId, AttributeId, AttributeValue) 
                VALUES("'.$_SESSION['UID'].'", "'.$_REQUEST['benchmarkId'].'", "'.$_REQUEST['wodtype'].'", "'.$Row['recid'].'", "'.$AttributeValue.'")';
                mysql_query($SQL);	
            }
        }        
	}	
	
	function Log2($Details)
	{
		$Success = false;
		$BenchmarkId = $Details['benchmarkId'];
		
		$Sql = 'SELECT recid FROM Exercises WHERE BenchMarkId = '.$BenchmarkId.'';
		$Result = mysql_query($Sql);
		$Row = mysql_fetch_assoc($Result);		
		$ExerciseId = $Row['recid'];
		
		$Sql = 'SELECT ExerciseTypeId FROM SkillsLevel 
		WHERE ExerciseId = '.$ExerciseId.'';
		$Result = mysql_query($Sql);
		$Row = mysql_fetch_assoc($Result);
		
		$UID = $Details['UID'];
		$ExerciseTypeId = $Row['ExerciseTypeId'];
		$TimeToComplete = $Details['clock'];

		$this->LevelAchieved = $this->ExerciseLevelAchieved();
		$Fields .= ', LevelAchieved';
		$Values .= ', "'.$this->LevelAchieved.'"';	

		$Sql = 'INSERT INTO ExerciseLog(MemberId, ExerciseId, ExerciseTypeId, TimeToComplete)
			VALUES('.$Values.')';

		$Success = mysql_query($Sql);

		$this->OverallLevelAchieved = $this->OverallLevelAchieved();

		$Sql = 'SELECT Gender, Height, SkillLevel FROM MemberDetails WHERE MemberId = '.$this->UID.'';
		$Result = mysql_query($Sql);
		$Row = mysql_fetch_assoc($Result);
		$MemberHeight = $Row['Height'];
		$this->Gender = $Row['Gender'];
		//not sure how we gonna use bodyweight yet:
		if($this->BodyWeight != $Details['bodyweight']){
			$BMI = round($Details['bodyweight'] / ($MemberHeight * $MemberHeight), 2);
			$Sql = 'UPDATE MemberDetails SET Weight = "'.$Details['bodyweight'].'", BMI = '.$BMI.' WHERE MemberId = '.$this->UID.'';
			$Success = mysql_query($Sql);
		}
		if($Row['SkillLevel'] < $this->OverallLevelAchieved){
			$Sql = 'UPDATE MemberDetails SET SkillLevel = '.$this->OverallLevelAchieved.' WHERE MemberId = '.$this->UID.'';
			$Success = mysql_query($Sql);
		}	
		return $Success;
	}	
	
	function ExerciseLevelAchieved()
	{
		$Level = 0;

		$Sql = 'SELECT Weight, Height, TimeToComplete, Duration, Reps, Description
			FROM SkillsLevel4 SL JOIN SkillsLevel SE ON SL.recid = SE.LevelFourId
			WHERE SE.ExerciseId = '.$this->ExerciseId.' AND (Gender = "U" OR Gender = "'.$this->Gender.'")';
		$Result = mysql_query($Sql);
		if(mysql_num_rows($Result) > 0){
			$Level = $this->Evaluate(mysql_fetch_assoc($Result),4);
		}

		if($Level == 0){
			$Sql = 'SELECT Weight, Height, TimeToComplete, Duration, Reps, Description
				FROM SkillsLevel3 SL JOIN SkillsLevel SE ON SL.recid = SE.LevelThreeId
				WHERE SE.ExerciseId = '.$this->ExerciseId.' AND (Gender = "U" OR Gender = "'.$this->Gender.'")';
			$Result = mysql_query($Sql);
			if(mysql_num_rows($Result) > 0){
				$Level = $this->Evaluate(mysql_fetch_assoc($Result),3);
			}
		}

		if($Level == 0){
			$Sql = 'SELECT Weight, Height, TimeToComplete, Duration, Reps, Description
				FROM SkillsLevel2 SL JOIN SkillsLevel SE ON SL.recid = SE.LevelTwoId
				WHERE SE.ExerciseId = '.$this->ExerciseId.' AND (Gender = "U" OR Gender = "'.$this->Gender.'")';
			$Result = mysql_query($Sql);
			if(mysql_num_rows($Result) > 0){
				$Level = $this->Evaluate(mysql_fetch_assoc($Result),2);
			}
		}

		if($Level == 0){
			$Sql = 'SELECT Weight, Height, TimeToComplete, Duration, Reps, Description
				FROM SkillsLevel1 SL JOIN SkillsLevel SE ON SL.recid = SE.LevelOneId
				WHERE SE.ExerciseId = '.$this->ExerciseId.' AND (Gender = "U" OR Gender = "'.$this->Gender.'")';
			$Result = mysql_query($Sql);
			if(mysql_num_rows($Result) > 0){
				$Level = $this->Evaluate(mysql_fetch_assoc($Result),1);
			}
		}

		return $Level;
	}	
	function Evaluate($Row, $EvalLevel)
	{
		if($Row['Weight'] == null || $Row['Weight'] == '' || $Row['Weight'] <= $this->Weight
		|| $Row['Height'] == null || $Row['Height'] == '' || $Row['Height'] <= $this->Height
		|| $Row['TimeToComplete'] == null || $Row['TimeToComplete'] == '' || $Row['TimeToComplete'] >= $this->TimeToComplete
		|| $Row['Duration'] == null || $Row['Duration'] == '' || $Row['Duration'] <= $this->Duration
		|| $Row['Reps'] == null || $Row['Reps'] == '' || $Row['Reps'] <= $this->Reps)
			$ReturnLevel = $EvalLevel;
		else
			$ReturnLevel = 0;
		return $ReturnLevel;
	}

	function OverallLevelAchieved()
	{
		$Level = 4;
		$CompletedExercises = array();
		$Sql = 'SELECT ExerciseId, MAX(LevelAchieved) FROM ExerciseLog WHERE MemberId = '.$this->UID.' GROUP BY ExerciseId';
		$Result = mysql_query($Sql);
		while($Row = mysql_fetch_assoc($Result))
		{
			if($Row['LevelAchieved'] < $Level)
				$Level = $Row['LevelAchieved'];
			array_push($CompletedExercises,$Row['ExerciseId']);
		}

		$PendingExercises=array();
		$AllExercises = $this->getExercises();
		foreach($AllExercises AS $Exercise)
		{
			if(!in_array($Exercise->Id, $CompletedExercises))
				array_push($PendingExercises,$Exercise->Id);
		}
		if(count($PendingExercises) == 0)
			return $Level;
		else
			return 0;
	}	
	
	function getHistory()
	{
		$Data = array();
		$Sql = 'SELECT B.recid, B.WorkoutName, A.Attribute, L.AttributeValue, L.TimeCreated 
		FROM WODLog L 
        LEFT JOIN BenchmarkWorkouts B ON B.recid = L.ExerciseId 
        LEFT JOIN Attributes A ON A.recid = L.AttributeId
		WHERE L.MemberId = '.$_SESSION['UID'].' AND L.WODTypeId = 3';
		$Result = mysql_query($Sql);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Data,new BenchmarkObject($Row));
		}	
		return $Data; 
	}
}

class BenchmarkObject
{
	var $Id;
	var $Name;
	var $Banner;
	var $Description;
	var $Video;
	var $SmartVideoLink;
	var $LegacyVideoLink;
	var $Attribute;
    var $AttributeValue;
	var $TimeCreated;

	function __construct($Row)
	{
		$this->Id = $Row['recid'];
		$this->Name = $Row['WorkoutName'];
		$this->Banner = $Row['Banner'];
		$this->Description = $Row['WorkoutDescription'];
		$this->Video = $Row['VideoId'];
		$this->SmartVideoLink = 'http://www.youtube.com/embed/'.$Row['VideoId'].'';
		$this->LegacyVideoLink = 'http://m.youtube.com/details?v='.$Row['VideoId'].'';
		$this->Attribute = isset($Row['Attribute']) ? $Row['Attribute'] : "";
        $this->AttributeValue = isset($Row['AttributeValue']) ? $Row['AttributeValue'] : "";
		$this->TimeCreated = isset($Row['TimeCreated']) ? $Row['TimeCreated'] : "";
	}
}

class CategoryObject
{
	var $Id;
	var $Name;
	var $Image;
	var $Banner;

	function __construct($Row)
	{
		$this->Id = $Row['recid'];
		$this->Name = $Row['Category'];
		$this->Image = $Row['Image'];
		$this->Banner = $Row['Banner'];
	}
}
?>