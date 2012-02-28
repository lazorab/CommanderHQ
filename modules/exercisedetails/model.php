<?php
class ExercisedetailsModel extends Model
{
	
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
	}
	
	function getExercise($Id, $Gender)
	{
		$Exercise=array();
		$Sql = 'SELECT E.Exercise,
			S.Gender AS Gender,
			SK1.Weight AS SK1Weight,
			SK1.Height AS SK1Height,
			SK1.Duration AS SK1Duration,
			SK1.Reps AS SK1Reps,
			SK1.Description AS SK1Description,
			SK2.Weight AS SK2Weight,
			SK2.Height AS SK2Height,
			SK2.Duration AS SK2Duration,
			SK2.Reps AS SK2Reps,
			SK2.Description AS SK2Description,
			SK3.Weight AS SK3Weight,
			SK3.Height AS SK3Height,
			SK3.Duration AS SK3Duration,
			SK3.Reps AS SK3Reps,
			SK3.Description AS SK3Description,
			SK4.Weight AS SK4Weight,
			SK4.Height AS SK4Height,
			SK4.Duration AS SK4Duration,
			SK4.Reps AS SK4Reps,
			SK4.Description AS SK4Description
			FROM SkillsLevel S 
			JOIN Exercises E ON S.ExerciseId = E.recid 
			LEFT JOIN SkillsLevel1 SK1 ON SK1.recid = S.LevelOneId
			LEFT JOIN SkillsLevel2 SK2 ON SK2.recid = S.LevelTwoId
			LEFT JOIN SkillsLevel3 SK3 ON SK3.recid = S.LevelThreeId
			LEFT JOIN SkillsLevel4 SK4 ON SK4.recid = S.LevelFourId
			WHERE S.ExerciseId = '.$Id.'';
		$Result = mysql_query($Sql);	
		while($Row=mysql_fetch_assoc($Result))
		{
			if($Row['Gender'] == 'U' || $Row['Gender'] == ''.$Gender.'')
				$Detail = new ExerciseObject($Row);
		}
		return $Detail;
	}
}

class ExerciseObject
{
	var $Exercise;
	var $SK1Weight;
	var $SK1Height;
	var $SK1Duration;
	var $SK1Reps;
	var $SK1Description;
	var $SK2Weight;
	var $SK2Height;
	var $SK2Duration;
	var $SK2Reps;
	var $SK2Description;
	var $SK3Weight;
	var $SK3Height;
	var $SK3Duration;
	var $SK3Reps;
	var $SK3Description;
	var $SK4Weight;
	var $SK4Height;
	var $SK4Duration;
	var $SK4Reps;
	var $SK4Description;
	
	function __construct($Row)
	{
		$this->Exercise = $Row['Exercise'];
		$this->SK1Weight = $Row['SK1Weight'];
		$this->SK1Height = $Row['SK1Height'];
		$this->SK1Duration = $Row['SK1Duration'];
		$this->SK1Reps = $Row['SK1Reps'];
		$this->SK1Description = $Row['SK1Description'];
		$this->SK2Weight = $Row['SK2Weight'];
		$this->SK2Height = $Row['SK2Height'];
		$this->SK2Duration = $Row['SK2Duration'];
		$this->SK2Reps = $Row['SK2Reps'];
		$this->SK2Description = $Row['SK2Description'];
		$this->SK3Weight = $Row['SK3Weight'];
		$this->SK3Height = $Row['SK3Height'];
		$this->SK3Duration = $Row['SK3Duration'];
		$this->SK3Reps = $Row['SK3Reps'];
		$this->SK3Description = $Row['SK3Description'];
		$this->SK4Weight = $Row['SK4Weight'];
		$this->SK4Height = $Row['SK4Height'];
		$this->SK4Duration = $Row['SK4Duration'];
		$this->SK4Reps = $Row['SK4Reps'];
		$this->SK4Description = $Row['SK4Description'];	
	}
}
?>