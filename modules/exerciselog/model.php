<?php
class ExerciselogModel extends Model
{
	var $Wall='';
	
	function __construct()
	{
		if($Display->Environment == 'mobile' || $Display->Environment == 'legacy')
			$this->Wall = 'wall:';
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
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
	
	function ExerciseOptions($SelectedValue='')
	{
		$SQL = 'SELECT recid, Exercise FROM Exercises ORDER BY Exercise';
		$Result = mysql_query($SQL);
		$Options = '<'.$this->Wall.'option value="">Exercise</'.$this->Wall.'option>';
		while($Row = mysql_fetch_assoc($Result))
		{
			$Options .= '<'.$this->Wall.'option value="'.$Row['recid'].'"';
			if($SelectedValue == $Row['recid'])
				$Options .=' selected="selected"';		
			$Options .= '>'.$Row['Exercise'].'</'.$this->Wall.'option>';
		}
		return $Options;
	}	
	
	function WorkoutOptions($SelectedValue='')
	{
		$SQL = 'SELECT recid, WorkoutName FROM BenchmarkWorkouts ORDER BY WorkoutName';
		$Result = mysql_query($SQL);
		$Options = '<'.$this->Wall.'option value="">Workout</'.$this->Wall.'option>';
		while($Row = mysql_fetch_assoc($Result))
		{
			$Options .= '<'.$this->Wall.'option value="'.$Row['recid'].'"';
			if($SelectedValue == $Row['recid'])
				$Options .=' selected="selected"';		
			$Options .= '>'.$Row['WorkoutName'].'</'.$this->Wall.'option>';
		}
		return $Options;
	}	
}
?>