<?php
class ExerciselogModel extends Model
{
	var $Wall='';
	var $ExerciseId;
	var $WorkoutId;
	var $UID;
	var $ExerciseType;
	var $Duration;
	var $Reps;
	var $Weight;
	var $Height;
	var $Gender;
	var $LevelAchieved;
	var $OverallLevelAchieved;
	
	function __construct()
	{
		if($Display->Environment == 'mobile' || $Display->Environment == 'legacy')
			$this->Wall = 'wall:';
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
	}
	
	function Log($Details)
	{
		$Success = false;
		$this->UID = $Details['UID'];
		$this->Reps = $Details['reps'];
		$this->Weight = $Details['weight'];
		$this->Height = $Details['height'];
		$this->Duration = ''.$Details['hours'].':'.$Details['minutes'].':'.$Details['seconds'].'';

		if(isset($Details['exercise']) && $Details['exercise'] != ''){
			$this->ExerciseId = $Details['exercise'];
		}
		elseif(isset($Details['workout']) && $Details['workout'] != ''){
			$this->ExerciseId = $Details['workout'];
		}

		$Sql = 'SELECT ExerciseTypeId FROM SkillsLevel WHERE ExerciseId = '.$this->ExerciseId.'';
		$Result = mysql_query($Sql);
		$Row = mysql_fetch_assoc($Result);
		$this->ExerciseTypeId = $Row['ExerciseTypeId'];

		$this->LevelAchieved = $this->ExerciseLevelAchieved();

		$Sql = 'INSERT INTO ExerciseLog(MemberId, ExerciseId, ExerciseTypeId, Duration, Reps, Weight, Height, LevelAchieved)
			VALUES("'.$this->UID.'", "'.$this->ExerciseId.'", "'.$this->ExerciseTypeId.'", "'.$this->Duration.'","'.$this->Reps.'","'.$this->Weight.'", "'.$this->Height.'", "'.$this->LevelAchieved.'")';
			$Success = mysql_query($Sql);

		$this->OverallLevelAchieved = $this->OverallLevelAchieved();

		$Sql = 'SELECT Gender, Height, SkillLevel FROM MemberDetails WHERE MemberId = '.$this->UID.'';
		$Result = mysql_query($Sql);
		$Row = mysql_fetch_assoc($Result);
		$MemberHeight = $Row['Height'];
		$this->Gender = $Row['Gender'];
		$BMI = round($Details['membersweight'] / ($MemberHeight * $MemberHeight), 2);

		if($Details['membersweight'] > 0){
			$Sql = 'UPDATE MemberDetails SET Weight = "'.$Details['membersweight'].'", BMI = '.$BMI.' WHERE MemberId = '.$this->UID.'';
			$Success = mysql_query($Sql);
		}
		if($Row['SkillLevel'] < $this->OverallLevelAchieved){
			$Sql = 'UPDATE MemberDetails SET SkillLevel = '.$this->OverallLevelAchieved.' WHERE MemberId = '.$this->UID.'';
			$Success = mysql_query($Sql);
		}	
		return $Success;
	}
	
	function DayOptions($SelectedValue='')
	{
		$Options = '<'.$this->Wall.'option value="">Day</'.$this->Wall.'option>';
		for($i=1;$i<32;$i++)
		{
			$Options .= '<'.$this->Wall.'option value="'.$i.'"';
			if($SelectedValue == $i)
				$Options .=' selected="selected"';
			$Options .='>'.$i.'</'.$this->Wall.'option>';
		}

		return $Options;
	}
	
	function MonthOptions($SelectedValue='')
	{
		$Options = '<'.$this->Wall.'option value="">Month</'.$this->Wall.'option>';
		$Options .= '<'.$this->Wall.'option value="01"';
		if($SelectedValue == "01")
			$Options .=' selected="selected"';		
		$Options .= '>January</'.$this->Wall.'option>';
		$Options .= '<'.$this->Wall.'option value="02"';
		if($SelectedValue == "02")
			$Options .=' selected="selected"';		
		$Options .= '>February</'.$this->Wall.'option>';
		$Options .= '<'.$this->Wall.'option value="03"';
		if($SelectedValue == "03")
			$Options .=' selected="selected"';		
		$Options .= '>March</'.$this->Wall.'option>';
		$Options .= '<'.$this->Wall.'option value="04"';
		if($SelectedValue == "04")
			$Options .=' selected="selected"';		
		$Options .= '>April</'.$this->Wall.'option>';
		$Options .= '<'.$this->Wall.'option value="05"';
		if($SelectedValue == "05")
			$Options .=' selected="selected"';		
		$Options .= '>May</'.$this->Wall.'option>';
		$Options .= '<'.$this->Wall.'option value="06"';
		if($SelectedValue == "06")
			$Options .=' selected="selected"';		
		$Options .= '>June</'.$this->Wall.'option>';
		$Options .= '<'.$this->Wall.'option value="07"';
		if($SelectedValue == "07")
			$Options .=' selected="selected"';		
		$Options .= '>July</'.$this->Wall.'option>';
		$Options .= '<'.$this->Wall.'option value="08"';
		if($SelectedValue == "08")
			$Options .=' selected="selected"';		
		$Options .= '>August</'.$this->Wall.'option>';
		$Options .= '<'.$this->Wall.'option value="09"';
		if($SelectedValue == "09")
			$Options .=' selected="selected"';		
		$Options .= '>September</'.$this->Wall.'option>';
		$Options .= '<'.$this->Wall.'option value="10"';
		if($SelectedValue == "10")
			$Options .=' selected="selected"';	
		$Options .= '>October</'.$this->Wall.'option>';
		$Options .= '<'.$this->Wall.'option value="11"';
		if($SelectedValue == "11")
			$Options .=' selected="selected"';		
		$Options .= '>November</'.$this->Wall.'option>';
		$Options .= '<'.$this->Wall.'option value="12"';
		if($SelectedValue == "12")
			$Options .=' selected="selected"';		
		$Options .= '>December</'.$this->Wall.'option>';

		return $Options;
	}

	function YearOptions($SelectedValue='')
	{
		$Options = '<'.$this->Wall.'option value="">Year</'.$this->Wall.'option>';
		for($i=1940;$i<2012;$i++)
		{
			$Options .= '<'.$this->Wall.'option value="'.$i.'"';
			if($SelectedValue == $i)
				$Options .=' selected="selected"';
			$Options .='>'.$i.'</'.$this->Wall.'option>';
		}
		return $Options;
	}	
	
	private function SelectedExercise($ExerciseId)
	{
		$SQL = 'SELECT Exercise FROM Exercises WHERE recid = "'.$ExerciseId.'"';
		$Result = mysql_query($SQL);
		$Row = mysql_fetch_assoc($Result);
		
		return $Row['Exercise'];	
	}
	
	function isBaseline($ExerciseId)
	{
		$SQL = 'SELECT Exercise FROM Exercises WHERE recid = "'.$ExerciseId.'"';
		$Result = mysql_query($SQL);
		$Row = mysql_fetch_assoc($Result);
		if($Row['Exercise'] == 'Baseline')
			return true;
		else
			return false;
	}
	
	function isBenchMark($ExerciseId)
	{
		$SQL = 'SELECT recid, IsBenchMark FROM Exercises WHERE recid = "'.$ExerciseId.'"';
		$Result = mysql_query($SQL);
		$Row = mysql_fetch_assoc($Result);
		if($Row['IsBenchMark'] == 1)
			return true;
		else
			return false;
	}	
	
	function ExerciseOptions($SelectedValue='')
	{
		$ExerciseOptions = array();

		$SQL = 'SELECT recid, Exercise FROM Exercises ORDER BY Exercise';
		$Result = mysql_query($SQL);
		$Options = '<'.$this->Wall.'option value="">Select Exercise</'.$this->Wall.'option>';
		while($Row = mysql_fetch_assoc($Result))
		{
			$Options .= '<'.$this->Wall.'option value="'.$Row['recid'].'"';
			if($SelectedValue == $Row['recid'])
				$Options .=' selected="selected"';		
			$Options .= '>'.$Row['Exercise'].'</'.$this->Wall.'option>';
		}

		return $Options;
	}	
	
	function ExerciseLevelAchieved()
	{
		$Level = 0;

		$Sql = 'SELECT Weight, Height, Duration, Reps, Description
			FROM SkillsLevel4 SL JOIN SkillsLevel SE ON SL.recid = SE.LevelFourId
			WHERE SE.ExerciseId = '.$this->ExerciseId.' AND (Gender = "U" OR Gender = "'.$this->Gender.'")';
		$Result = mysql_query($Sql);
		if(mysql_num_rows($Result) > 0){
			$Level = $this->Evaluate(mysql_fetch_assoc($Result),4);
		}

		if($Level == 0){
			$Sql = 'SELECT Weight, Height, Duration, Reps, Description
				FROM SkillsLevel3 SL JOIN SkillsLevel SE ON SL.recid = SE.LevelThreeId
				WHERE SE.ExerciseId = '.$this->ExerciseId.' AND (Gender = "U" OR Gender = "'.$this->Gender.'")';
			$Result = mysql_query($Sql);
			if(mysql_num_rows($Result) > 0){
				$Level = $this->Evaluate(mysql_fetch_assoc($Result),3);
			}
		}

		if($Level == 0){
			$Sql = 'SELECT Weight, Height, Duration, Reps, Description
				FROM SkillsLevel2 SL JOIN SkillsLevel SE ON SL.recid = SE.LevelTwoId
				WHERE SE.ExerciseId = '.$this->ExerciseId.' AND (Gender = "U" OR Gender = "'.$this->Gender.'")';
			$Result = mysql_query($Sql);
			if(mysql_num_rows($Result) > 0){
				$Level = $this->Evaluate(mysql_fetch_assoc($Result),2);
			}
		}

		if($Level == 0){
			$Sql = 'SELECT Weight, Height, Duration, Reps, Description
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

	function getExercises()
	{
		$Exercises=array();
		$Sql = 'SELECT recid, Exercise FROM Exercises';
		$Result = mysql_query($Sql);
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Exercises, new ExercisesObject($Row));
		}
		return $Exercises;
	}
	
	function TimeInput()
	{
		$Html='<'.$this->Wall.'br/>
			Time to complete<'.$this->Wall.'br/>
			<'.$this->Wall.'select name="hours">
				<'.$this->Wall.'option value="00">hh</'.$this->Wall.'option>';
				for($i=0;$i<25;$i++){ 
					$Html.='
						<'.$this->Wall.'option value="'.$Number.'"';
						if($_REQUEST['hours'] == sprintf("%02d", $i))
							$this->Html.=' selected="selected"';
					$Html.='>'.sprintf("%02d", $i).'</'.$this->Wall.'option>';
				} 
			$Html.='
			</'.$this->Wall.'select> :
			<'.$this->Wall.'select name="minutes">
				<'.$this->Wall.'option value="00">mm</'.$this->Wall.'option>';
				for($i=0;$i<60;$i++){
					$Html.='
						<'.$this->Wall.'option value="'.sprintf("%02d", $i).'"';
						if($_REQUEST['minutes'] == sprintf("%02d", $i))
							$Html.=' selected="selected"';
					$Html.='>'.sprintf("%02d", $i).'</'.$this->Wall.'option>';
				} 
			$Html.='
			</'.$this->Wall.'select> :
			<'.$this->Wall.'select name="seconds">
				<'.$this->Wall.'option value="00">ss</'.$this->Wall.'option>';
				for($i=0;$i<60;$i++){ 
					$Html.='
						<'.$this->Wall.'option value="'.sprintf("%02d", $i).'"';
						if($_REQUEST['seconds'] == sprintf("%02d", $i)) 
							$Html.=' selected="selected"';
					$Html.='>'.sprintf("%02d", $i).'</'.$this->Wall.'option>';
				}
			$Html.='
			</'.$this->Wall.'select><'.$this->Wall.'br/>';
			
		return $Html;
	}
	
	function getExerciseHtml()
	{
		$this->Html.='
			<'.$this->Wall.'br/>
			Completed Exercise:
			'.$this->SelectedExercise($_REQUEST['exercise']).'
			<'.$this->Wall.'input type="hidden" name="exercise" value="'.$_REQUEST['exercise'].'"/>
			<'.$this->Wall.'br/>
			<'.$this->Wall.'br/>
			
			Weight Lifted<'.$this->Wall.'br/>
			<'.$this->Wall.'input type="text" name="weight" value="'.$_REQUEST['weight'].'"/><'.$this->Wall.'br/>
			<'.$this->Wall.'br/>
			Height Reached<'.$this->Wall.'br/>
			<'.$this->Wall.'input type="text" name="height" value="'.$_REQUEST['height'].'"/><'.$this->Wall.'br/>
			<'.$this->Wall.'br/>
			Reps<'.$this->Wall.'br/>
			<'.$this->Wall.'input type="text" name="reps" value="'.$_REQUEST['reps'].'"/><'.$this->Wall.'br/>
			
			'.$this->TimeInput().'';	

		return $this->Html;
	}
	
	function getWorkoutHtml()
	{
		$this->Html.='
			<'.$this->Wall.'br/>
			Completed Exercise:
			'.$this->SelectedExercise($_REQUEST['exercise']).'
			<'.$this->Wall.'input type="hidden" name="exercise" value="'.$_REQUEST['exercise'].'"/>
			<'.$this->Wall.'br/>';
		$this->Html.='
		
			'.$this->TimeInput().'
			
		<'.$this->Wall.'br/>
		Rounds<'.$this->Wall.'br/>
		<'.$this->Wall.'input type="text" name="reps" value="'.$_REQUEST['reps'].'"/><'.$this->Wall.'br/>
		<'.$this->Wall.'br/>';	
		
		return $this->Html;
	}	
	
	function defaultHtml()
	{
		$this->Html.='
		<'.$this->Wall.'br/><'.$this->Wall.'br/>
		Which Exercise did you Complete?<'.$this->Wall.'br/>
		<'.$this->Wall.'select name="exercise">
			'.$this->ExerciseOptions($_REQUEST['exercise']).'
		</'.$this->Wall.'select><'.$this->Wall.'br/>
		<'.$this->Wall.'br/>
		<'.$this->Wall.'br/>
		<'.$this->Wall.'input type="submit" name="next" value="Next"/><'.$this->Wall.'br/><'.$this->Wall.'br/>';

		return $this->Html;
	}
}

class ExercisesObject
{
	var $Id;
	var $Exercise;

	function __construct($Row)
	{
		$this->Id = $Row['recid'];
		$this->Exercise = $Row['Exercise'];
	}
}	
?>