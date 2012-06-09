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
			SystemOfMeasure,
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
				Email = '".$Details->Email."'
				WHERE UserId = ".$Details->UserId."";

			mysql_query($sql);
			
			if($Details->SystemOfMeasure == 'Imperial'){
			//convert to metric for storage in db. Displaying of values will be converted back.
				$Weight = round($Details->Weight * 0.45, 2);
				$Height = floor($Details->Height * 2.54);
			}
			else{
				$Weight = $Details->Weight;
				$Height = $Details->Height;			
			}
			$HeightInMeters = $Height / 100;
			$BMI = floor($Weight / ($HeightInMeters * $HeightInMeters));
			
			$sql="UPDATE MemberDetails SET 
				DOB = '".$Details->DOB."',
				Weight = '".$Weight."',
				Height = '".$Height."',
				SystemOfMeasure = '".$Details->SystemOfMeasure."',
				Gender = '".$Details->Gender."',
				BMI = '".$BMI."'		
				WHERE MemberId = ".$Details->UserId."";

			mysql_query($sql);				
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
	var $DOB;
	var $Weight;
	var $Height;
	var $SystemOfMeasure;
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
		$this->DOB = $Row['DOB'];

		$this->SystemOfMeasure = $Row['SystemOfMeasure'];
		if(isset($Row['system']) && $Row['system'] != $Row['SystemOfMeasure']){	
			if($Row['system'] == 'Imperial'){
				//convert to metric for storage in db. Displaying of values will be converted back.
				$this->Weight = ceil($Row['Weight'] * 2.22);
				$this->Height = ceil($Row['Height'] * 0.39);
			}else{
				$this->Weight = round($Row['Weight'] * 0.45, 2);
				$this->Height = floor($Row['Height'] * 2.54);
			}
		}else{
			$this->Weight = $Row['Weight'];
			$this->Height = $Row['Height'];		
		}

		$this->BMI = $Row['BMI'];
		$this->RestHR = $Row['RestHR'];
		$this->RecHR = $Row['RecHR'];	
	}
}
?>