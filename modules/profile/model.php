<?php
class ProfileModel extends Model
{
    var $MemberDetails;
	
    function __construct()
    {
        parent::__construct();	
    }       
	
	function Update($Id)
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            
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
                                Anon = '".$_REQUEST['Anon']."',
				Gender = '".$_REQUEST['Gender']."',
				BMI = '".$BMI."'		
				WHERE MemberId = '".$Id."'";
                        $db->setQuery($SQL);
                        $db->Query();
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
        var $Anon;
	var $BMI;
	var $RestHR;
	var $RecHR;
	
	function __construct($Row)
	{
		$this->UserId = $Row['UserId'];

                $this->FirstName = $Row['FirstName'];
                $this->LastName = $Row['LastName'];
                $this->UserName = $Row['UserName'];
                $this->PassWord = $Row['PassWord'];
                $this->Cell = $Row['Cell'];
                $this->Email = $Row['Email'];                    

                $this->LoginType = isset($Row['oauth_provider']) ? $Row['oauth_provider'] : "";
		$this->SkillLevel = $Row['SkillLevel'];
		$this->Gender = $Row['Gender'];
		$this->DOB = $Row['DOB'];
                $this->SystemOfMeasure = $Row['SystemOfMeasure'];
                $this->Anon = $Row['Anon'];
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