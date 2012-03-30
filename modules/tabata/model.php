<?php
class TabataModel extends Model
{	
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
	}
	
	function Log($Details)
	{
		$Success = false;

		$UID = $Details['UID'];
		$ExerciseId = $Details['exercise'];
		$Reps = $Details['reps'];
		$Fields = 'MemberId, ExerciseId, Reps';
		$Values = '"'.$UID.'", "'.$ExerciseId.'", "'.$Reps.'"';	

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
	
	function getHtml($ExerciseId)
	{
		$this->Html ='
			<'.$this->Wall.'br/><'.$this->Wall.'br/>
			Completed Exercise:
			'.$this->SelectedExercise($_REQUEST['exercise']).'
			<'.$this->Wall.'input type="hidden" name="exercise" value="'.$_REQUEST['exercise'].'"/>
			<'.$this->Wall.'br/>		
			Reps<'.$this->Wall.'br/>
			<'.$this->Wall.'input type="text" name="reps" value="'.$_REQUEST['reps'].'"/>
			<'.$this->Wall.'br/>
			<'.$this->Wall.'br/>
			<'.$this->Wall.'input type="submit" name="submit" value="Save"/><'.$this->Wall.'br/><'.$this->Wall.'br/>';

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