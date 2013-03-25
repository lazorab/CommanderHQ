<?php
class ProfileModel extends Model
{
    var $MemberDetails;
	
    function __construct()
    {
        parent::__construct();	
    }
    
    function CheckInvitationCode($Code)
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $SQL='SELECT InvitationCode FROM MemberInvites WHERE InvitationCode = "'.$Code.'"';
        $db->setQuery($SQL);
	$db->Query();
	if($db->getNumRows() > 0)
            return true;
        else 
            return false;       
    }
        
    function CheckUserNameExists($UserName)
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $SQL='SELECT UserId FROM Members WHERE UserName = "'.$UserName.'"';
        $db->setQuery($SQL);
	$db->Query();
	if($db->getNumRows() > 0)
            return true;
        else 
            return false; 
    }
    
    function CheckEmailExists($Email)
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $SQL='SELECT UserId FROM Members WHERE Email = "'.$Email.'"';
        $db->setQuery($SQL);
	$db->Query();
	if($db->getNumRows() > 0)
            return true;
        else 
            return false;
    }
	
    function getMemberDetails($Id)
    {
        if($Id > 0){
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
 		$SQL='SELECT M.UserId,
		M.FirstName,
		M.LastName,
		M.Cell,
		M.Email,
		M.UserName,
		M.PassWord,
                M.oauth_provider AS LoginType,
		MD.SkillLevel,
                MD.GymId,
		MD.Gender,
		MD.DOB,
                MD.SystemOfMeasure,
		MD.CustomWorkouts,
                MD.Height,
                MD.Weight,
                MD.BMI,
                MD.RestHR,
                MD.RecHR
                FROM Members M 
                LEFT JOIN MemberDetails MD ON MD.MemberId = M.UserId 
                WHERE M.UserId = "'.$Id.'"';           

            $db->setQuery($SQL);
		
            $MemberDetails = $db->loadObject();   
            if($MemberDetails->SystemOfMeasure == 'Imperial'){
                //convert to metric for storage in db. Displaying of values will be converted back.
                $MemberDetails->Weight = ceil($MemberDetails->Weight * 2.22);
                $MemberDetails->Height = ceil($MemberDetails->Height * 0.39);
            }          
        }
        else{
            $MemberDetails=new MemberObject($_REQUEST);
        }   
	return $MemberDetails;
    }
    
    function Register()
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);

            $SQL="INSERT INTO Members(FirstName,
                LastName,
                Cell,
                Email,
                UserName,
                PassWord) 
                VALUES('".trim($_REQUEST['FirstName'])."',
                   '".trim($_REQUEST['LastName'])."',
                   '".trim($_REQUEST['Cell'])."',
                   '".trim($_REQUEST['Email'])."',
                   '".trim($_REQUEST['UserName'])."',
                   '".trim($_REQUEST['PassWord'])."')";
                    $db->setQuery($SQL);
                    $db->Query();
            
		$NewId = $db->insertid();
			
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
                    $SQL="INSERT INTO MemberDetails(
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
                        '".trim($_REQUEST['AffiliateId'])."',
                        '".$DOB."',
                        '".trim($Weight)."',
                        '".trim($Height)."',
                        '".trim($_REQUEST['Gender'])."',
                        '".trim($_REQUEST['SystemOfMeasure'])."',
                        '".trim($_REQUEST['CustomWorkouts'])."',
                        '".$BMI."')";
                    $db->setQuery($SQL);
                    $db->Query();
                
            $SQL='SELECT MemberId FROM MemberInvites WHERE InvitationCode = "'.trim($_REQUEST['InvCode']).'"';
            $db->setQuery($SQL);
            
            $MemberId = $db->loadResult();
            $SQL = 'UPDATE MemberInvites SET NewMemberId = '.$NewId.' WHERE MemberId = '.$MemberId.' AND InvitationCode = "'.trim($_REQUEST['InvCode']).'"';
            $db->setQuery($SQL);
            $db->Query();
            setcookie('UID', $NewId, time() + (20 * 365 * 24 * 60 * 60), '/', THIS_DOMAIN, false, false);
            $_SESSION['NEW_USER'] = $NewId;
            $this->SendEmail(trim($_REQUEST['FirstName']), trim($_REQUEST['Email']), trim($_REQUEST['UserName']), trim($_REQUEST['PassWord']));
	}    
	
	function Update($Id)
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            
            if(isset($_REQUEST['InvCode'])){
                $SQL='SELECT MemberId FROM MemberInvites WHERE InvitationCode = "'.$_REQUEST['InvCode'].'"';
                $db->setQuery($SQL);
            
            $MemberId = $db->loadResult();
            $SQL = 'UPDATE MemberInvites SET NewMemberId = '.$Id.' WHERE MemberId = '.$MemberId.' AND InvitationCode = "'.$_REQUEST['InvCode'].'"';
            $db->setQuery($SQL);
            $db->Query();              
            }
            
			$SQL="UPDATE Members SET 
				FirstName = '".$_REQUEST['FirstName']."',
				LastName = '".$_REQUEST['LastName']."',
				Cell = '".$_REQUEST['Cell']."',
				Email = '".$_REQUEST['Email']."'
				WHERE UserId = '".$Id."'";
                        $db->setQuery($SQL);
                        $db->Query();

			
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

			$SQL="UPDATE MemberDetails SET 
                                GymId = '".$_REQUEST['AffiliateId']."',
				DOB = '".$DOB."',    
				Weight = '".$Weight."',
				Height = '".$Height."',
				SystemOfMeasure = '".$_REQUEST['SystemOfMeasure']."',
                                CustomWorkouts = '".$_REQUEST['CustomWorkouts']."',
				Gender = '".$_REQUEST['Gender']."',
				BMI = '".$BMI."'		
				WHERE MemberId = '".$Id."'";
                        $db->setQuery($SQL);
                        $db->Query();
            if(!isset($_COOKIE['UID'])){
                setcookie('UID', $Id, time() + (20 * 365 * 24 * 60 * 60), '/', THIS_DOMAIN, false, false);
            }
            
	}
        
        function getAffiliates() {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT AffiliateId,
            GymName
            FROM Affiliates
            WHERE GymName <> ""
            ORDER BY GymName';
	$db->setQuery($SQL);
		
	return $db->loadObjectList();
    }
    
        function SendEmail($Name, $Email, $UserName, $Password)
        {
            $message = 'Welcome to Commander HQ '.$Name.'<br/>
                Your Username is '.$UserName.'<br/>
                Password is '.$Password.'<br/>';
		$mail = new Rmail();
		$mail->setFrom('Commander HQ<info@be-mobile.co.za>');
		$mail->setSubject('Welcome Commander HQ');
		$mail->setPriority('normal');
		$mail->setHTML($message);
                $mail->send(array($Email));
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