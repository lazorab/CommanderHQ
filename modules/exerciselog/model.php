<?php
class ExerciselogModel extends Model
{
	var $Wall='';
	var $ExerciseId;
	var $UID;
	var $ExerciseType;
	var $TimeToComplete;
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
		$this->ExerciseId = $Details['exercise'];
		$Sql = 'SELECT ExerciseTypeId FROM SkillsLevel WHERE ExerciseId = '.$this->ExerciseId.'';
		$Result = mysql_query($Sql);
		$Row = mysql_fetch_assoc($Result);
		
		$this->UID = $Details['UID'];
		$this->ExerciseTypeId = $Row['ExerciseTypeId'];
		$this->TimeToComplete = ''.$Details['thours'].':'.$Details['tminutes'].':'.$Details['tseconds'].'';
		$Fields = 'MemberId, ExerciseId, ExerciseTypeId, TimeToComplete';
		$Values = '"'.$this->UID.'", "'.$this->ExerciseId.'", "'.$this->ExerciseTypeId.'", "'.$this->TimeToComplete.'"';

		if((isset($Details['dhours']) && $Details['dhours'] != '00') || (isset($Details['dminutes']) && $Details['dminutes'] != '00') || (isset($Details['dseconds']) && $Details['dseconds'] != '00')){
			$this->Duration = ''.$Details['dhours'].':'.$Details['dminutes'].':'.$Details['dseconds'].'';
			$Fields .= ', Duration';
			$Values .= ', "'.$this->Duration.'"';			
		}	
		if($Details['reps'] != ""){
			$this->Reps = $Details['reps'];
			$Fields .= ', Reps';
			$Values .= ', "'.$this->Reps.'"';
		}
		if($Details['weight'] != ""){
			$this->Weight = $Details['weight'];
			$Fields .= ', Weight';
			$Values .= ', "'.$this->Weight.'"';			
		}
		if($Details['height'] != ""){
			$this->Height = $Details['height'];
			$Fields .= ', Height';
			$Values .= ', "'.$this->Height.'"';			
		}
		$this->LevelAchieved = $this->ExerciseLevelAchieved();
		$Fields .= ', LevelAchieved';
		$Values .= ', "'.$this->LevelAchieved.'"';	

		$Sql = 'INSERT INTO ExerciseLog('.$Fields.')
			VALUES('.$Values.')';

		$Success = mysql_query($Sql);

		$this->OverallLevelAchieved = $this->OverallLevelAchieved();

		$Sql = 'SELECT Gender, Height, SkillLevel FROM MemberDetails WHERE MemberId = '.$this->UID.'';
		$Result = mysql_query($Sql);
		$Row = mysql_fetch_assoc($Result);
		$MemberHeight = $Row['Height'];
		$this->Gender = $Row['Gender'];
		//not sure how we gonna use bodyweight yet:
		if($Details['bodyweight'] > 0){
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
	
	function Validate($ExerciseId)
	{
		if($_REQUEST['thours'] == '00' && $_REQUEST['tminutes'] == '00' && $_REQUEST['tseconds'] == '00')
			$this->Message = 'Must Enter Time to Complete';
		$Attributes = $this->getAttributes($ExerciseId);
		foreach($Attributes AS $Attribute)
		{		
			if($Attribute->Attribute == 'Duration' && ($_REQUEST['dhours'] == '00' && $_REQUEST['dminutes'] == '00' && $_REQUEST['dseconds'] == '00'))
				$this->Message = 'Must Enter Duration';	
				
			else if($Attribute->Attribute == 'Reps' && $_REQUEST['reps'] == '')
					$this->Message = 'Must Enter Number of Rounds/Reps';	

			else if($Attribute->Attribute == 'Weight' && $_REQUEST['weight'] == '')
				$this->Message = 'Must Enter Weight';	
				
			else if($Attribute->Attribute == 'Height' && $_REQUEST['height'] == '')
				$this->Message = 'Must Enter Height';	
		}
		return $this->Message;
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
	
	function getAttributes($ExerciseId)
	{
		$Attributes=array();
		$Sql = 'SELECT a.Attribute 
			FROM ExerciseAttributes ea 
			JOIN Attributes a ON ea.AttributeId = a.recid
			WHERE ea.ExerciseId = '.$ExerciseId.'';
		$Result = mysql_query($Sql);
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Attributes, new AttributesObject($Row));
		}
		return $Attributes;	
	}
	
	function TimeInput($type)
	{
		if($type == 'Duration'){
			$hours = 'dhours';
			$minutes = 'dminutes';
			$seconds = 'dseconds';
		}else{
			$hours = 'thours';
			$minutes = 'tminutes';
			$seconds = 'tseconds';
		}
		
		$Html='
			<'.$this->Wall.'select name="'.$hours.'">
				<'.$this->Wall.'option value="00">hh</'.$this->Wall.'option>';
				for($i=0;$i<25;$i++){ 
					$Html.='
						<'.$this->Wall.'option value="'.sprintf("%02d", $i).'"';
						if($_REQUEST[''.$hours.''] == sprintf("%02d", $i))
							$Html.=' selected="selected"';
					$Html.='>'.sprintf("%02d", $i).'</'.$this->Wall.'option>';
				} 
			$Html.='
			</'.$this->Wall.'select> :
			<'.$this->Wall.'select name="'.$minutes.'">
				<'.$this->Wall.'option value="00">mm</'.$this->Wall.'option>';
				for($i=0;$i<60;$i++){
					$Html.='
						<'.$this->Wall.'option value="'.sprintf("%02d", $i).'"';
						if($_REQUEST[''.$minutes.''] == sprintf("%02d", $i))
							$Html.=' selected="selected"';
					$Html.='>'.sprintf("%02d", $i).'</'.$this->Wall.'option>';
				} 
			$Html.='
			</'.$this->Wall.'select> :
			<'.$this->Wall.'select name="'.$seconds.'">
				<'.$this->Wall.'option value="00">ss</'.$this->Wall.'option>';
				for($i=0;$i<60;$i++){ 
					$Html.='
						<'.$this->Wall.'option value="'.sprintf("%02d", $i).'"';
						if($_REQUEST[''.$seconds.''] == sprintf("%02d", $i)) 
							$Html.=' selected="selected"';
					$Html.='>'.sprintf("%02d", $i).'</'.$this->Wall.'option>';
				}
			$Html.='
			</'.$this->Wall.'select><'.$this->Wall.'br/>';
			
		return $Html;
	}
	
	function BodyWeight()
	{
		$Sql = 'SELECT M.SystemOfMeasure, MD.Weight FROM Members M JOIN MemberDetails MD ON MD.MemberId = M.UserId
		WHERE M.UserId = '.$_SESSION['UID'].'';
		$Result = mysql_query($Sql);
		$Row = mysql_fetch_assoc($Result);
		$Unit = 'Kg';
		$Weight = $Row['Weight'];
		if($Row['SystemOfMeasure'] == 'Imperial'){
			$Unit = 'lbs';
			$Weight = ceil($Row['Weight'] * 2.22);
		}
		$Html ='<'.$this->Wall.'input type="text" name=weight" value="'.$Weight.'"/>'.$Unit.'';
		
		return $Html;
	}
	
	function getHtml($ExerciseId)
	{
		$this->Html ='
			<'.$this->Wall.'br/>
			Completed Exercise:
			'.$this->SelectedExercise($_REQUEST['exercise']).'
			<'.$this->Wall.'input type="hidden" name="exercise" value="'.$_REQUEST['exercise'].'"/>
			<'.$this->Wall.'br/>
			<'.$this->Wall.'br/>';
			$this->Html .= 'Time to Complete<'.$this->Wall.'br/>';
			$this->Html .= $this->TimeInput('Time');
			$this->Html .= '<'.$this->Wall.'br/>';
			$this->Html .= 'Update Weight?<'.$this->Wall.'br/>';
			$this->Html .= $this->BodyWeight();
			$this->Html .= '<'.$this->Wall.'br/>';			
		$Attributes = $this->getAttributes($ExerciseId);
		foreach($Attributes AS $Attribute)
		{	
			if($Attribute->Attribute == 'Duration'){
				$this->Html .= 'Duration<'.$this->Wall.'br/>';
				$this->Html .= $this->TimeInput('Duration');
				$this->Html .= '<'.$this->Wall.'br/>';
			}	
			if($Attribute->Attribute == 'Reps'){
				$this->Html .= 'Rounds/Reps<'.$this->Wall.'br/>
				<'.$this->Wall.'input type="text" name="reps" value="'.$_REQUEST['reps'].'"/>
				<'.$this->Wall.'br/>';
			}	
			if($Attribute->Attribute == 'Body Weight'){
				//not sure about this one
			}
			if($Attribute->Attribute == 'Weight'){
				$this->Html .= 'Weight Used<'.$this->Wall.'br/>
				<'.$this->Wall.'input type="text" name="weight" value="'.$_REQUEST['weight'].'"/><'.$this->Wall.'br/>
				<'.$this->Wall.'br/>';
			}	
			if($Attribute->Attribute == 'Height'){
				$this->Html .= 'Height Used/Reached<'.$this->Wall.'br/>
				<'.$this->Wall.'input type="text" name="height" value="'.$_REQUEST['height'].'"/><'.$this->Wall.'br/>
				<'.$this->Wall.'br/>';	
			}
		}
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

class AttributesObject
{
	var $Attribute;

	function __construct($Row)
	{
		$this->Attribute = $Row['Attribute'];
	}
}
?>