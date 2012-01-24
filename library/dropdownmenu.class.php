<?php
/********************************************************
Class to create dropdown menu options for use on mobisite
Copyright Be-Mobile

Created By   : Darren Hart
Created Date : 10 December 2011

Last Modified Date: 10 December 2011

*********************************************************/


class DropDownMenu
{
	
	function DayOptions($SelectedValue='')
	{
		$Options = '<wall:option value="">Day</wall:option>';
		for($i=1;$i<32;$i++)
		{
			$Options .= '<wall:option value="'.$i.'"';
			if($SelectedValue == $i)
				$Options .=' selected="selected"';
			$Options .='>'.$i.'</wall:option>';
		}

		return $Options;
	}
	
	function MonthOptions($SelectedValue='')
	{
		$Options = '<wall:option value="">Month</wall:option>';
		$Options .= '<wall:option value="01"';
		if($SelectedValue == "01")
			$Options .=' selected="selected"';		
		$Options .= '>January</wall:option>';
		$Options .= '<wall:option value="02"';
		if($SelectedValue == "02")
			$Options .=' selected="selected"';		
		$Options .= '>February</wall:option>';
		$Options .= '<wall:option value="03"';
		if($SelectedValue == "03")
			$Options .=' selected="selected"';		
		$Options .= '>March</wall:option>';
		$Options .= '<wall:option value="04"';
		if($SelectedValue == "04")
			$Options .=' selected="selected"';		
		$Options .= '>April</wall:option>';
		$Options .= '<wall:option value="05"';
		if($SelectedValue == "05")
			$Options .=' selected="selected"';		
		$Options .= '>May</wall:option>';
		$Options .= '<wall:option value="06"';
		if($SelectedValue == "06")
			$Options .=' selected="selected"';		
		$Options .= '>June</wall:option>';
		$Options .= '<wall:option value="07"';
		if($SelectedValue == "07")
			$Options .=' selected="selected"';		
		$Options .= '>July</wall:option>';
		$Options .= '<wall:option value="08"';
		if($SelectedValue == "08")
			$Options .=' selected="selected"';		
		$Options .= '>August</wall:option>';
		$Options .= '<wall:option value="09"';
		if($SelectedValue == "09")
			$Options .=' selected="selected"';		
		$Options .= '>September</wall:option>';
		$Options .= '<wall:option value="10"';
		if($SelectedValue == "10")
			$Options .=' selected="selected"';	
		$Options .= '>October</wall:option>';
		$Options .= '<wall:option value="11"';
		if($SelectedValue == "11")
			$Options .=' selected="selected"';		
		$Options .= '>November</wall:option>';
		$Options .= '<wall:option value="12"';
		if($SelectedValue == "12")
			$Options .=' selected="selected"';		
		$Options .= '>December</wall:option>';

		return $Options;
	}

	function YearOptions($SelectedValue='')
	{
		$Options = '<wall:option value="">Year</wall:option>';
		for($i=1940;$i<2012;$i++)
		{
			$Options .= '<wall:option value="'.$i.'"';
			if($SelectedValue == $i)
				$Options .=' selected="selected"';
			$Options .='>'.$i.'</wall:option>';
		}
		return $Options;
	}	
	
	function ExerciseOptions($SelectedValue='')
	{
		$Options = '<wall:option value="">Exercise Type</wall:option>';
		$Options .= '<wall:option value="01"';
		if($SelectedValue == "01")
			$Options .=' selected="selected"';		
		$Options .= '>Sit Ups</wall:option>';
		$Options .= '<wall:option value="02"';
		if($SelectedValue == "02")
			$Options .=' selected="selected"';		
		$Options .= '>Jogging</wall:option>';

		return $Options;
	}	
}
