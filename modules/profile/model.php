<?php
class ProfileModel extends Model
{
	var $MemberDetails;
	
	function __construct()
	{
		//mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		//@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
	}
	
	function getMemberDetails($Id)
	{
        mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
        $Sql='SELECT M.*, MD.*
        FROM Members M 
        LEFT JOIN MemberDetails MD ON MD.MemberId = M.UserId 
        WHERE M.UserId = "'.$Id.'"';
		$Result = mysql_query($Sql);
		$Row = mysql_fetch_assoc($Result);
		$MemberDetails=new MemberObject($Row);
		return $MemberDetails;
	}
    
    function getPostedDetails()
	{
		$MemberDetails=new MemberObject($_REQUEST);
		return $MemberDetails;
	}
    
	function Register()
	{
        mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
		$sql='SELECT UserId FROM Members WHERE UserName = "'.$_REQUEST['UserName'].'" AND PassWord = "'.$_REQUEST['PassWord'].'"';
        
		$result = mysql_query($sql);
		if(mysql_num_rows($result) > 0){
			return false;
		}
		else{
			$sql="INSERT INTO Members(FirstName,
            LastName,
            Cell,
            Email,
            UserName,
            PassWord) 
            VALUES('".$_REQUEST['FirstName']."',
                   '".$_REQUEST['LastName']."',
                   '".$_REQUEST['Cell']."',
                   '".$_REQUEST['Email']."',
                   '".$_REQUEST['UserName']."',
                   '".$_REQUEST['PassWord']."')";
            
			mysql_query($sql);
            
			$NewId = mysql_insert_id();
			
			if($_REQUEST['system'] == 'Imperial'){
                //convert to metric for storage in db. Displaying of values will be converted back.
				$Weight = round($_REQUEST['Weight'] * 0.45, 2);
				$Height = floor($_REQUEST['Height'] * 2.54);
			}
			else{
				$Weight = $_REQUEST['Weight'];
				$Height = $_REQUEST['Height'];			
			}
			$HeightInMeters = $Height / 100;
			$BMI = floor($Weight / ($HeightInMeters * $HeightInMeters));
			$DOB = date('Y-m-d',strtotime($_REQUEST['DOB']));
			$sql="INSERT INTO MemberDetails(
            MemberId,
            DOB,
            Weight,
            Height,
            Gender,
            SystemOfMeasure,
            BMI) 
            VALUES('".$NewId."',
                   '".$DOB."',
                   '".$Weight."',
                   '".$Height."',
                   '".$_REQUEST['Gender']."',
                   '".$_REQUEST['system']."',
                   '".$BMI."')";
            
			mysql_query($sql);
            
            $_SESSION['UID'] = $NewId;
            $_SESSION['FirstName'] = $_REQUEST['FirstName'];
		}
	}    
	
	function Update($Id)
	{
        try{
            mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
            @mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
			$Sql="UPDATE Members SET 
				FirstName = '".$_REQUEST['FirstName']."',
				LastName = '".$_REQUEST['LastName']."',
				Cell = '".$_REQUEST['Cell']."',
				Email = '".$_REQUEST['Email']."'
				WHERE UserId = '".$Id."'";
			mysql_query($Sql);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
			
			if($_REQUEST['system'] == 'Imperial'){
			//convert to metric for storage in db. Displaying of values will be converted back.
				$Weight = round($_REQUEST['Weight'] * 0.45, 2);
				$Height = floor($_REQUEST['Height'] * 2.54);
			}
			else{
				$Weight = $_REQUEST['Weight'];
				$Height = $_REQUEST['Height'];			
			}
			$HeightInMeters = $Height / 100;
			$BMI = floor($Weight / ($HeightInMeters * $HeightInMeters));
            $DOB = date('Y-m-d',strtotime($_REQUEST['DOB']));
		try{
            mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
            @mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
			$Sql="UPDATE MemberDetails SET 
				DOB = '".$DOB."',
				Weight = '".$Weight."',
				Height = '".$Height."',
				SystemOfMeasure = '".$_REQUEST['system']."',
				Gender = '".$_REQUEST['Gender']."',
				BMI = '".$BMI."'		
				WHERE MemberId = '".$Id."'";
			mysql_query($Sql);
            if(!isset($_SESSION['UID'])){
                $_SESSION['UID'] = $Id;
                $_SESSION['FirstName'] = $_REQUEST['FirstName'];
            }
            
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
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
        /*
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
         */
        $this->Weight = $Row['Weight'];
        $this->Height = $Row['Height'];       
		$this->BMI = $Row['BMI'];
		$this->RestHR = $Row['RestHR'];
		$this->RecHR = $Row['RecHR'];	
	}
}
?>