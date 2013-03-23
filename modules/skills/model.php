<?php
class SkillsModel extends Model
{
	var $ExerciseId;
	var $UID;
	var $ExerciseType;
	var $TimeToComplete;
	var $Duration;
	var $Reps;
	var $Weight;
	var $BodyWeight;
	var $Height;
	var $Gender;
	var $LevelAchieved;
	var $OverallLevelAchieved;
	
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
	}
	
	function Log()
	{
		$Success = false;
		$this->ExerciseId = $_REQUEST['exercise'];
		$Sql = 'SELECT ExerciseTypeId FROM SkillsLevel WHERE ExerciseId = '.$this->ExerciseId.'';
		$Result = mysql_query($Sql);
		$Row = mysql_fetch_assoc($Result);
		
		$this->UID = $_REQUEST['UID'];
		$this->ExerciseTypeId = $Row['ExerciseTypeId'];
		$this->TimeToComplete = ''.$_REQUEST['thours'].':'.$_REQUEST['tminutes'].':'.$_REQUEST['tseconds'].'';
		$Fields = 'MemberId, ExerciseId, ExerciseTypeId, TimeToComplete';
		$Values = '"'.$this->UID.'", "'.$this->ExerciseId.'", "'.$this->ExerciseTypeId.'", "'.$this->TimeToComplete.'"';

		if((isset($_REQUEST['dhours']) && $_REQUEST['dhours'] != '00') || (isset($_REQUEST['dminutes']) && $_REQUEST['dminutes'] != '00') || (isset($_REQUEST['dseconds']) && $_REQUEST['dseconds'] != '00')){
			$this->Duration = ''.$_REQUEST['dhours'].':'.$_REQUEST['dminutes'].':'.$_REQUEST['dseconds'].'';
			$Fields .= ', Duration';
			$Values .= ', "'.$this->Duration.'"';			
		}	
		if($_REQUEST['reps'] != ""){
			$this->Reps = $_REQUEST['reps'];
			$Fields .= ', Reps';
			$Values .= ', "'.$this->Reps.'"';
		}
		if($_REQUEST['weight'] != ""){
			$this->Weight = $_REQUEST['weight'];
			$Fields .= ', Weight';
			$Values .= ', "'.$this->Weight.'"';			
		}
		if($this->BodyWeight != $_REQUEST['bodyweight']){
			$BodyWeight = $_REQUEST['bodyweight'];
			$Fields .= ', BodyWeight';
			$Values .= ', "'.$BodyWeight.'"';			
		}		
		if($_REQUEST['height'] != ""){
			$this->Height = $_REQUEST['height'];
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
		if($this->BodyWeight != $_REQUEST['bodyweight']){
			$BMI = round($_REQUEST['bodyweight'] / ($MemberHeight * $MemberHeight), 2);
			$Sql = 'UPDATE MemberDetails SET Weight = "'.$_REQUEST['bodyweight'].'", BMI = '.$BMI.' WHERE MemberId = '.$this->UID.'';
			$Success = mysql_query($Sql);
		}
		if($Row['SkillLevel'] < $this->OverallLevelAchieved){
			$Sql = 'UPDATE MemberDetails SET SkillLevel = '.$this->OverallLevelAchieved.' WHERE MemberId = '.$this->UID.'';
			$Success = mysql_query($Sql);
		}	
		return $Success;
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
		$Sql = 'SELECT DISTINCT S.ExerciseId AS recid, E.Exercise 
                    FROM SkillsLevels S
                    LEFT JOIN Exercises E ON E.recid = S.ExerciseId
                    ORDER BY Exercise';
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
		WHERE M.UserId = '.$_COOKIE['UID'].'';
		$Result = mysql_query($Sql);
		$Row = mysql_fetch_assoc($Result);
		$Unit = 'Kg';
		$this->BodyWeight = $Row['Weight'];
		if($Row['SystemOfMeasure'] == 'Imperial'){
			$Unit = 'lbs';
			$Weight = ceil($Row['Weight'] * 2.22);
		}
		$Html ='<'.$this->Wall.'input type="text" name="bodyweight" value="'.$this->BodyWeight.'"/>'.$Unit.'';
		
		return $Html;
	}
        
        function Gender()
        {
            $SQL = 'SELECT Gender FROM MemberDetails WHERE MemberId = "'.$_COOKIE['UID'].'"';
            $Result = mysql_query($SQL);	
            $Row = mysql_fetch_assoc($Result);
            return $Row['Gender'];
        }
	
	function getExercise()
	{
            $Sql = 'SELECT DISTINCT S.LinkingId,
                S.ExerciseId, 
                E.Exercise, 
                S.SkillsLevel,
                A.Attribute,
                S.AttributeValue,
                "0" AS CurrentSkillsLevel
                FROM SkillsLevels S
                LEFT JOIN Attributes A ON A.recid = S.AttributeId
                LEFT JOIN Exercises E ON E.recid = S.ExerciseId
                WHERE E.Exercise = "'.$_REQUEST['exercise'].'"
                AND (
                S.Gender = "'.$this->Gender().'"
                OR S.Gender = "U"
                )
                ORDER BY S.LinkingId, Attribute, SkillsLevel';
            $Result = mysql_query($Sql);
            $Data = array();
            $NewArray = array();
            $i = 0;
            while($Row = mysql_fetch_assoc($Result))
            {
                if($i == 0){
                   $NewArray = $Row;
                }
                
                if($Row['Attribute'] != $Attribute && $i > 0){
                    array_push($Data, new ExercisesObject($NewArray));
                    $NewArray = $Row;                   
                }
                
                if($Row['SkillsLevel'] == 1){
                    $NewArray['LevelOneValue'] = $Row['AttributeValue'];
                }else if($Row['SkillsLevel'] == 2){
                    $NewArray['LevelTwoValue'] = $Row['AttributeValue'];
                }else if($Row['SkillsLevel'] == 3){
                    $NewArray['LevelThreeValue'] = $Row['AttributeValue'];
                }else if($Row['SkillsLevel'] == 4){
                    $NewArray['LevelFourValue'] = $Row['AttributeValue'];
                }                 
                
                $i++;

                $Attribute = $Row['Attribute'];
            }
		array_push($Data, new ExercisesObject($NewArray));
            return $Data;	
	}    
	
	function getExerciseAttributes($Exercise)
	{
        $Attributes = array();

        $SQL = 'SELECT BenchmarkId
		FROM Exercises
		WHERE Exercise = "'.$Exercise.'"';
        $Result = mysql_query($SQL);
		$Row = mysql_fetch_assoc($Result);
		$BenchmarkId = $Row['BenchmarkId'];
		if($BenchmarkId == 0){
			$SQL = 'SELECT DISTINCT E.recid, 
			E.Exercise AS ActivityName,
			A.Attribute
			FROM ExerciseAttributes EA
			LEFT JOIN Attributes A ON EA.AttributeId = A.recid
			LEFT JOIN Exercises E ON EA.ExerciseId = E.recid
			WHERE E.Exercise = "'.$Exercise.'"
			ORDER BY ActivityName, Attribute';
		}
		else{
                            if($Exercise == 'Baseline'){

        $SQL = 'SELECT MB.ExerciseId AS recid, E.Exercise AS ActivityName, A.Attribute, MB.AttributeValue 
        FROM MemberBaseline MB
        JOIN Exercises E ON E.recid = MB.ExerciseId
        JOIN Attributes A ON A.recid = MB.AttributeId
        WHERE MB.MemberId = "'.$_COOKIE['UID'].'"';

        }else{
        $SQL = 'SELECT Gender FROM MemberDetails WHERE MemberId = "'.$_COOKIE['UID'].'"';
 		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
        if($Row['Gender'] == 'M'){
            $AttributeValue = 'AttributeValueMale';
			$InputFields = 'MaleInput';
        } else {
            $AttributeValue = 'AttributeValueFemale';
			$InputFields = 'FemaleInput';
		}
		//$SQL = 'SELECT WorkoutName, '.$DescriptionField.' AS WorkoutDescription, '.$InputFields.' AS InputFields, VideoId FROM BenchmarkWorkouts WHERE recid = '.$Id.'';
		
		$SQL = 'SELECT E.Exercise AS ActivityName, E.recid, BD.BenchmarkId, A.Attribute, BD.'.$AttributeValue.' AS AttributeValue, RoundNo
			FROM BenchmarkDetails BD
			LEFT JOIN BenchmarkWorkouts BW ON BW.recid = BD.BenchmarkId
			LEFT JOIN Exercises E ON E.recid = BD.ExerciseId
			LEFT JOIN Attributes A ON A.recid = BD.AttributeId
			WHERE BD.BenchmarkId = '.$BenchmarkId.'
			ORDER BY RoundNo, ActivityName, Attribute';
		}
                }
        $Result = mysql_query($SQL);
        while($Row = mysql_fetch_assoc($Result))
        {
            array_push($Attributes, new AttributesObject($Row));  
        }
        if($Exercise == 'Baseline')
        {
            $Array = array('recid'=>'63', 'ActivityName'=>'Timed', 'Attribute'=>'TimeToComplete', 'AttributeValue'=>'00:00:0', 'RoundNo'=>'0');
            array_push($Attributes, new AttributesObject($Array));  
        }
        return $Attributes;	
	}	
	
}

class ExercisesObject
{
    var $Id;
    var $Exercise;
    var $Description;
    var $Attribute;
    var $CurrentSkillsLevel;
    var $LevelOneValue;
    var $LevelTwoValue;
    var $LevelThreeValue;
    var $LevelFourValue;

    function __construct($Row)
    {
        $this->Id = $Row['recid'];
	$this->Exercise = $Row['Exercise'];
        $this->Description = $Row['Description'];
        $this->Attribute = $Row['Attribute'];
        $this->CurrentSkillsLevel = $Row['CurrentSkillsLevel'];
        $this->LevelOneValue = $Row['LevelOneValue'];
        $this->LevelTwoValue = $Row['LevelTwoValue'];
        $this->LevelThreeValue = $Row['LevelThreeValue'];
        $this->LevelFourValue = $Row['LevelFourValue'];
    }
}	

class AttributesObject
{
	var $recid;
    var $BenchmarkId;
	var $ActivityName;
	var $ActivityType;
	var $Attribute;
	var $AttributeValue;
	var $RoundNo;

	function __construct($Row)
	{
		$this->recid = isset($Row['recid']) ? $Row['recid'] : "";
        $this->BenchmarkId = isset($Row['BenchmarkId']) ? $Row['BenchmarkId'] : "";
		$this->ActivityName = isset($Row['ActivityName']) ? $Row['ActivityName'] : "";
		$this->ActivityType = isset($Row['ActivityType']) ? $Row['ActivityType'] : "";
		$this->Attribute = isset($Row['Attribute']) ? $Row['Attribute'] : "";
		$this->AttributeValue = isset($Row['AttributeValue']) ? $Row['AttributeValue'] : $Row['Attribute'];
		$this->RoundNo = isset($Row['RoundNo']) ? $Row['RoundNo'] : "1";
	}
}
?>