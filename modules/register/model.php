<?php
class RegisterModel extends Model
{
	var $ReturnValue;
	var $Wall='';
	
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
	}
	
	function Register($Credentials)
	{
		$sql='SELECT UserId FROM Members WHERE UserName = "'.$Credentials['UserName'].'" AND PassWord = "'.$Credentials['PassWord'].'"';			
		$result = mysql_query($sql);
		if(mysql_num_rows($result) > 0){
			$this->ReturnValue = false;
		}
		else{
			$sql="INSERT INTO Members(FirstName,
				LastName,
				Cell,
				Email,
				UserName,
				PassWord,
				SystemOfMeasure) 
				VALUES('".$Credentials['FirstName']."',
				'".$Credentials['LastName']."',
				'".$Credentials['Cell']."',
				'".$Credentials['Email']."',
				'".$Credentials['UserName']."',
				'".$Credentials['PassWord']."',
				'".$Credentials['SystemOfMeasure']."')";

			mysql_query($sql);
		
			$this->ReturnValue = mysql_insert_id();
			
			if($Credentials['SystemOfMeasure'] == 'Imperial'){
			//convert to metric for storage in db. Displaying of values will be converted back.
				$Weight = round($Credentials['Weight'] * 0.45, 2);
				$Height = floor($Credentials['Height'] * 2.54);
			}
			else{
				$Weight = $Credentials['Weight'];
				$Height = $Credentials['Height'];			
			}
			$HeightInMeters = $Height / 100;
			$BMI = floor($Weight / ($HeightInMeters * $HeightInMeters));
			
			$sql="INSERT INTO MemberDetails(
				MemberId,
				DOB,
				Weight,
				Height,
				Gender,
				BMI) 
				VALUES('".$this->ReturnValue."',
				'".$Credentials['DOB']."',
				'".$Weight."',
				'".$Height."',
				'".$Credentials['Gender']."',
				'".$BMI."')";

			mysql_query($sql);				
		}
	}
	
	function ReturnValue()
	{
		return $this->ReturnValue;
	}
	
	function DayOptions($SelectedValue='')
	{
		$Options = '<'.$this->Wall.'option value="">Day</'.$this->Wall.'option>';
		for($i=1;$i<32;$i++)
		{
			$FormattedNumber = sprintf("%02d",$i);
			$Options .= '<'.$this->Wall.'option value="'.$i.'"';
			if($SelectedValue == $i)
				$Options .=' selected="selected"';
			$Options .='>'.$FormattedNumber.'</'.$this->Wall.'option>';
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
		for($i=2012;$i>=1940;$i--)
		{
			$Options .= '<'.$this->Wall.'option value="'.$i.'"';
			if($SelectedValue == $i)
				$Options .=' selected="selected"';
			$Options .='>'.$i.'</'.$this->Wall.'option>';
		}
		return $Options;
	}	
}
?>