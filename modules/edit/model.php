<?php
class EditModel extends Model
{
	var $MemberDetails;
	
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
	}
	
	function getCredentials($UserId)
	{
		$sql='SELECT 
			UserId,
			FirstName,
			LastName,
			Cell,
			Email,
			UserName,
			PassWord,
			SkillLevel,
			Gender,
			DOB,
			Weight,
			Height,
			BMI,
			RestHR,
			RecHR
			FROM Members M JOIN MemberDetails MD ON MD.MemberId = M.UserId WHERE M.UserId = '.$UserId.'';				
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		$this->MemberDetails=new MemberObject($row);
	}
	
	function setCredentials()
	{
		$this->MemberDetails=new MemberObject($_REQUEST);
	}
	
	function MemberDetails()
	{
		return $this->MemberDetails;
	}
	
	function Save(&$Credentials)
	{
		$Details = &$Credentials;
			$sql="UPDATE Members SET 
				FirstName = '".$Details->FirstName."',
				LastName = '".$Details->LastName."',
				Cell = '".$Details->Cell."',
				Email = '".$Details->Email."',
				UserName = '".$Details->UserName."',
				PassWord = '".$Details->PassWord."'
				WHERE UserId = ".$Details->UserId."";

			mysql_query($sql);
			
			$BMI = round($Details->Weight / ($Details->Height * $Details->Height), 2);
			
			$sql="UPDATE MemberDetails SET 
				DOB = '".$Details->Year."-".$Details->Month."-".$Details->Day."',
				Weight = '".$Details->Weight."',
				Height = '".$Details->Height."',
				Gender = '".$Details->Gender."',
				BMI = '".$BMI."'		
				WHERE MemberId = ".$Details->UserId."";

			mysql_query($sql);				
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
}

class MemberObject
{
	var $UserId;
	var $FirstName;
	var $LastName;
	var $Cell;
	var $Email;
	var $UserName;
	var $PassWord;
	var $SkillLevel;
	var $Gender;
	var $Year;
	var $Month;
	var $Day;
	var $Weight;
	var $Height;
	var $BMI;
	var $RestHR;
	var $RecHR;
	
	function __construct($Row)
	{
		$this->UserId = $Row['UserId'];
		$this->FirstName = $Row['FirstName'];
		$this->LastName = $Row['LastName'];
		$this->Cell = $Row['Cell'];
		$this->Email = $Row['Email'];
		$this->UserName = $Row['UserName'];
		$this->PassWord = $Row['PassWord'];
		$this->SkillLevel = $Row['SkillLevel'];
		$this->Gender = $Row['Gender'];
	
		if(isset($Row['DOB'])){
			$DOB = explode("-",$Row['DOB']);
			$this->Year = $DOB[0];
			$this->Month = $DOB[1];
			$this->Day = $DOB[2];
		}
		else{
			$this->Year = $Row['Year'];
			$this->Month = $Row['Month'];
			$this->Day = $Row['Day'];
		}
		$this->Weight = $Row['Weight'];
		$this->Height = $Row['Height'];
		$this->BMI = $Row['BMI'];
		$this->RestHR = $Row['RestHR'];
		$this->RecHR = $Row['RecHR'];	
	}
}
?>