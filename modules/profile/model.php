<?php
class ProfileModel extends Model
{
    var $MemberDetails;
	
    function __construct()
    {
	mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
	@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
    }
    
    function CheckInvitationCode($Code)
    {
         mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
	@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
        $sql='SELECT InvitationCode FROM MemberInvites WHERE InvitationCode = "'.$Code.'"';
        
	$result = mysql_query($sql);
	if(mysql_num_rows($result) > 0)
            return true;
        else 
            return false;       
    }
        
    function CheckUserNameExists($UserName)
    {
        mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
	@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
        $sql='SELECT UserId FROM Members WHERE UserName = "'.$UserName.'"';
        
	$result = mysql_query($sql);
	if(mysql_num_rows($result) > 0)
            return true;
        else 
            return false;
    }
    
    function CheckEmailExists($Email)
    {
        mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
	@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
        $sql='SELECT UserId FROM Members WHERE Email = "'.$Email.'"';
        
	$result = mysql_query($sql);
	if(mysql_num_rows($result) > 0)
            return true;
        else 
            return false;
    }
	
    function getMemberDetails($Id)
    {
        if($Id > 0){
            mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
            @mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
            $Sql='SELECT M.*, MD.*
                FROM Members M 
                LEFT JOIN MemberDetails MD ON MD.MemberId = M.UserId 
                WHERE M.UserId = "'.$Id.'"';
            $Result = mysql_query($Sql);
            $Row = mysql_fetch_assoc($Result);
            $MemberDetails=new MemberObject($Row);    
        }
        else{
            $MemberDetails=new MemberObject($_REQUEST);
        }   
	return $MemberDetails;
    }
    
    function Register()
    {
        mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
	@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");

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
			
		if($_REQUEST['SystemOfMeasure'] == 'Imperial'){
                //convert to metric for storage in db. Displaying of values will be converted back.
                    $Weight = round($_REQUEST['Weight'] * 0.45, 2);
                    $Height = round($_REQUEST['Height'] * 2.54, 2);
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
                        GymId,
                        DOB,
                        Weight,
                        Height,
                        Gender,
                        SystemOfMeasure,
                        CustomWorkouts,
                        BMI) 
                    VALUES('".$NewId."',
                        '".$_REQUEST['AffiliateId']."',
                        '".$DOB."',
                        '".$Weight."',
                        '".$Height."',
                        '".$_REQUEST['Gender']."',
                        '".$_REQUEST['SystemOfMeasure']."',
                        '".$_REQUEST['CustomWorkouts']."',
                        '".$BMI."')";
            
                mysql_query($sql);
                
            $sql='SELECT MemberId FROM MemberInvites WHERE InvitationCode = "'.$_REQUEST['InvCode'].'"';
            $result = mysql_query($sql);  
            $row = mysql_fetch_assoc($result);
            $SQL = 'UPDATE MemberInvites SET NewMemberId = '.$NewId.' WHERE MemberId = '.$row['MemberId'].' AND InvitationCode = "'.$_REQUEST['InvCode'].'"';
            mysql_query($SQL);  
            $_SESSION['UID'] = $NewId;
            $_SESSION['NEW_USER'] = $NewId;
	}    
	
	function Update($Id)
	{
        try{
            mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
            @mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
            
            if(isset($_REQUEST['InvCode'])){
             $sql='SELECT MemberId FROM MemberInvites WHERE InvitationCode = "'.$_REQUEST['InvCode'].'"';
            $result = mysql_query($sql);  
            $row = mysql_fetch_assoc($result);
            $SQL = 'UPDATE MemberInvites SET NewMemberId = '.$Id.' WHERE MemberId = '.$row['MemberId'].' AND InvitationCode = "'.$_REQUEST['InvCode'].'"';
            mysql_query($SQL);               
            }
            
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
                                GymId = '".$_REQUEST['AffiliateId']."',
				DOB = '".$DOB."',    
				Weight = '".$Weight."',
				Height = '".$Height."',
				SystemOfMeasure = '".$_REQUEST['SystemOfMeasure']."',
                                CustomWorkouts = '".$_REQUEST['CustomWorkouts']."',
				Gender = '".$_REQUEST['Gender']."',
				BMI = '".$BMI."'		
				WHERE MemberId = '".$Id."'";
			mysql_query($Sql);
            if(!isset($_SESSION['UID'])){
                $_SESSION['UID'] = $Id;
            }
            
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
	}	
        function getAffiliates() {
            $Affiliates = array();
        
            $Query = 'SELECT AffiliateId,
            GymName
            FROM Affiliates
            WHERE GymName <> ""
            ORDER BY GymName';
            $Result = mysql_query($Query);
            while($Row = mysql_fetch_assoc($Result)){
                array_push($Affiliates, new Affiliate($Row));
            } 
            return $Affiliates;
    }
}

 class Affiliate {

    var $AffiliateId;
    var $GymName;
    var $URL;
    var $Address;
    var $City;
    var $Region;
    var $TelNo;
    var $Latitude;
    var $Longitude;

    function __construct($Row) {
        $this->AffiliateId = isset($Row['AffiliateId']) ? $Row['AffiliateId'] : "";
        $this->GymName = isset($Row['GymName']) ? $Row['GymName'] : "";
        $this->URL = isset($Row['URL']) ? $Row['URL'] : "";
        $this->Address = isset($Row['Address']) ? $Row['Address'] : "";
        $this->City = isset($Row['City']) ? $Row['City'] : "";
        $this->TelNo = isset($Row['TelNo']) ? $Row['TelNo'] : "";
        $this->Region = isset($Row['Region']) ? $Row['Region'] : "";
        $this->Latitude = isset($Row['Latitude']) ? $Row['Latitude'] : "";
        $this->Longitude = isset($Row['Longitude']) ? $Row['Longitude'] : "";
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
        var $LoginType;
	var $SkillLevel;
	var $Gender;
	var $DOB;
	var $Weight;
	var $Height;
	var $SystemOfMeasure;
        var $CustomWorkouts;
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
                $this->LoginType = isset($Row['oauth_provider']) ? $Row['oauth_provider'] : "";
		$this->SkillLevel = $Row['SkillLevel'];
		$this->Gender = $Row['Gender'];
		$this->DOB = $Row['DOB'];
                $this->SystemOfMeasure = $Row['SystemOfMeasure'];
		$this->CustomWorkouts = $Row['CustomWorkouts'];
		if($Row['SystemOfMeasure'] == 'Imperial'){
                    //convert to metric for storage in db. Displaying of values will be converted back.
                    $this->Weight = ceil($Row['Weight'] * 2.22);
                    $this->Height = ceil($Row['Height'] * 0.39);
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