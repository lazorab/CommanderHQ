<?php
class TabataModel extends Model
{	
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
	}
	
	function Log($Details, $Count)
	{
		$Success = false;

		$UID = $Details['UID'];
		$TabataId = $this->getTabataId($UID);
		if($Count == 1)
			$TabataId++;
		$ExerciseId = $Details['exercise'];
		$Reps = $Details['reps'];
		$Fields = 'TabataId, MemberId, ExerciseId, Reps';
		$Values = '"'.$TabataId.'", "'.$UID.'", "'.$ExerciseId.'", "'.$Reps.'"';	

		$Sql = 'INSERT INTO TabataLog('.$Fields.')
			VALUES('.$Values.')';

		$Success = mysql_query($Sql);
	
		return $Success;
	}	
	
	private function SelectedExercise($ExerciseId)
	{
		$SQL = 'SELECT Exercise FROM TabataExercises WHERE recid = "'.$ExerciseId.'"';
		$Result = mysql_query($SQL);
		$Row = mysql_fetch_assoc($Result);
		
		return $Row['Exercise'];	
	}	
	
	function ExerciseOptions($SelectedValue='')
	{
		$ExerciseOptions = array();

		$SQL = 'SELECT recid, Exercise FROM TabataExercises ORDER BY Exercise';
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
	
	function RepOptions($SelectedValue='')
	{
		$Options = '<'.$this->Wall.'option value="">Select Number</'.$this->Wall.'option>';
		for($i=1;$i<100;$i++)
		{
			$FormattedNumber = sprintf("%02d",$i);
			$Options .= '<'.$this->Wall.'option value="'.$i.'"';
			if($SelectedValue == $i)
				$Options .=' selected="selected"';
			$Options .='>'.$FormattedNumber.'</'.$this->Wall.'option>';
		}

		return $Options;
	}
	
	function getExercises()
	{
		$Exercises=array();
		$Sql = 'SELECT recid, Exercise FROM TabataExercises';
		$Result = mysql_query($Sql);
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Exercises, new TabataObject($Row));
		}
		return $Exercises;
	}
	
	function getHtml()
	{

		$this->Html ='
			<'.$this->Wall.'br/>
			Completed Exercise:
			<'.$this->Wall.'br/>
			<'.$this->Wall.'select name="exercise">
			'.$this->ExerciseOptions($_REQUEST['exercise']).'
			</'.$this->Wall.'select>
			<'.$this->Wall.'br/>
			<'.$this->Wall.'br/>		
			Reps<'.$this->Wall.'br/>
			<'.$this->Wall.'select name="reps">
			'.$this->RepOptions($_REQUEST['reps']).'
			</'.$this->Wall.'select>			
			<'.$this->Wall.'br/>
			<'.$this->Wall.'br/>
			<'.$this->Wall.'input type="submit" name="submit" value="Log"/><'.$this->Wall.'br/><'.$this->Wall.'br/>';

		return $this->Html;	
	}	
	
	function defaultHtml()
	{
		$this->Html.='
		<'.$this->Wall.'br/>
		Which Exercise did you Complete?<'.$this->Wall.'br/>
		<'.$this->Wall.'select name="exercise">
			'.$this->ExerciseOptions($_REQUEST['exercise']).'
		</'.$this->Wall.'select><'.$this->Wall.'br/>
		<'.$this->Wall.'br/>
		<'.$this->Wall.'br/>
		<'.$this->Wall.'input type="submit" name="next" value="Next"/><'.$this->Wall.'br/><'.$this->Wall.'br/>';

		return $this->Html;
	}
	
	function getTabataId($MemberId)
	{
		$SQL='SELECT MAX(TabataId) AS LastId FROM TabataLog WHERE MemberId = '.$MemberId.'';
		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
		if($Row['LastId'] == null)
			$TabataId = 0;
		else
			$TabataId = $Row['LastId'];
			
		return $TabataId;
	}	
	
}

class TabataObject
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