<?php
class ProfileController extends Controller
{
	var $Message;
	var $MemberDetails;
	var $Weight;
	var $Height;	
	var $System;
	var $AlternateSystem;
        var $UserId;
	
	function __construct()
	{
            parent::__construct();
            $Model = new ProfileModel;
            session_start();
            if(isset($_SESSION['NEW_USER'])){
                $this->UserId = $_SESSION['NEW_USER'];
            }else{
                $this->UserId = $_COOKIE['UID'];
            }
        }
        
        function Validate()
        {
            $Model = new ProfileModel;
            $Validate = new ValidationUtils;		
            $Message = 'Success';
            if($_REQUEST['FirstName'] == '')
                $Message = 'Error - Firstname Required';
            else if($_REQUEST['LastName'] == '')
                $Message = 'Error - Lastname Required';
            else if(!isset($_COOKIE['UID']) && $Model->CheckUserNameExists($_REQUEST['UserName']))
                $Message = 'Error - Username already exists. Please choose another.';
            else if($_REQUEST['UserName'] == '')
                $Message = 'Error - Invalid Username!';
            else if($_REQUEST['Password'] == '')
                $Message = 'Error - Invalid Password!';
            else if(trim($_REQUEST['PassWord']) != trim($_REQUEST['ConfirmPassWord']))
                $Message = 'Error - Passwords do not match!';
            else if($_REQUEST['Cell'] == '' && $_REQUEST['Email'] == '')
                $Message = 'Error - Either a Cell or Email Required';
            else if($_REQUEST['Cell'] == '' || !$Validate->CheckMobileNumber($_REQUEST['Cell']))
                $Message = 'Error - Cell number invalid!';
            else if($_REQUEST['Email'] != '' && !$Validate->CheckEmailAddress($_REQUEST['Email']))
                $Message = 'Error - Email Address invalid!';
            else if(!isset($_COOKIE['UID']) && $Model->CheckEmailExists($_REQUEST['Email']))
                $Message = 'Error - Email Address already exists!';
            else if($_REQUEST['DOB'] == '')
                $Message = 'Error - Date of Birth Required';				
            else if($_REQUEST['Weight'] == '')
                $Message = 'Error - Weight Required';
            else if(!is_int($_REQUEST['Weight']))
                $Message = 'Error - Invalid Weight';            
            else if($_REQUEST['Height'] == '')
                $Message = 'Error - Height Required';
            else if(!is_int($_REQUEST['Height']))
                $Message = 'Error - Invalid Height';            
            else if($_REQUEST['Gender'] == '')		
                $Message = 'Error - Select Gender';
            else if($_REQUEST['CustomWorkouts'] == '')		
                $Message = 'Error - Select access to your Custom Workouts';
		
            return $Message;	
	}
    
    function Message()
    {
        $Message = $this->Validate();
        if($Message == 'Success')
        {
            $Model = new ProfileModel; 
            if(isset($_COOKIE['UID'])){
                $this->UserId = $_COOKIE['UID'];
                $Model->Update($_COOKIE['UID']);
            }else if(isset($_SESSION['NEW_USER'])){
                $this->UserId = $_SESSION['NEW_USER'];
                $Model->Update($_SESSION['NEW_USER']);
            }else{
                $Model->Register();
                $this->UserId = $_COOKIE['UID'];
            }
        }
        return $Message;
    }
        
    function Output()
    {

        $Model = new ProfileModel;
        $Affiliates=$Model->getAffiliates();
        $Html = '';

        $MemberDetails = $Model->getMemberDetails($this->UserId);
        
        //var_dump($MemberDetails);
        $this->Height = $MemberDetails->Height;
        $this->Weight = $MemberDetails->Weight;

        $WeightUnit = 'kg';
        $HeightUnit = 'cm';
        
        if($MemberDetails->SystemOfMeasure == 'Imperial'){
            $WeightUnit = 'lbs';
            $HeightUnit = 'inches';
        }
        $Html.='
        <form action="index.php" method="post" id="profileform" name="profileform">
        <div data-role="fieldcontain">
        <input type="hidden" name="module" value="profile"/>
        <input type="hidden" name="UserId" value="'.$MemberDetails->UserId.'"/>';      

        $Html.='<label for="firstname">First Name</label>';
          
$Html.='<input class="textinput" type="text" id="firstname" name="FirstName" placeholder="First Name" value="'.$MemberDetails->FirstName.'"/>';

          $Html.='<label for="lastname">Last Name</label>';
          
$Html.='<input class="textinput" type="text" id="lastname" name="LastName" placeholder="Last Name" value="'.$MemberDetails->LastName.'"/>';

          $Html.='<label for="username">User Name</label>';
          
$Html.='<input class="textinput" type="text" id="username" name="UserName" placeholder="User Name" value="'.$MemberDetails->UserName.'"'; 
if(isset($_COOKIE['UID']) || $MemberDetails->LoginType != '')   
    $Html.=' readonly="readonly"';
$Html.='/>';
if($MemberDetails->LoginType == ''){

          $Html.='<label for="password">Password</label>';
          
$Html.='<input class="textinput" type="password" id="password" name="PassWord" placeholder="Password" value="'.$MemberDetails->PassWord.'"/>';

          $Html.='<label for="confirmpassword">Confirm Password</label>';
          
$Html.='<input class="textinput" type="password" id="confirmpassword" name="ConfirmPassWord" placeholder="Confirm Password" value="'.$MemberDetails->PassWord.'"/>';
}
else{

          $Html.='<label for="oauth_provide">Login Type</label>';
          
$Html.='<input class="textinput" type="text" id="oauth_provider" name="oauth_provider" placeholder="Login Type" value="'.$MemberDetails->LoginType.'" readonly="readonly"/>'; 
}

          $Html.='<label for="cell">Cell (+2778000000)</label>';
          
$Html.='<input class="textinput" type="tel" id="cell" name="Cell" value="'.$MemberDetails->Cell.'" placeholder="Cell (+2778000000)"/>';

          $Html.='<label for="email">Email</label>';
          
$Html.='<input class="textinput" type="email" id="email" name="Email" placeholder="Email" value="'.$MemberDetails->Email.'"/>';

          $Html.='<label for="DOB">Date of Birth</label>';
          
$Html.='<input class="textinput" type="date" name="DOB" id="DOB" placeholder="Date of Birth" value="'.$MemberDetails->DOB.'"/>';

 $Html.='<br/><br/>Registered Gym';
 $Html.='<select class="chzn-select" name="AffiliateId" id="AffiliateId" tabindex="2">';
 $Html.='<option value="" data-placeholder="true">Select your Gym</option>';

        foreach($Affiliates AS $Affiliate){
            $Selected = '';
            if($MemberDetails->GymId == $Affiliate->AffiliateId)
                $Selected = 'selected="selected"';
            $Html.='<option value="'.$Affiliate->AffiliateId.'" '.$Selected.'>'.$Affiliate->GymName.'</option>';
        }
        $Html.='</select><br/><br/>';
        
$Html.='System Of Measure
    <fieldset class="controlgroup" data-role="controlgroup" data-type="horizontal">
    <input class="radioinput" type="radio" name="SystemOfMeasure" id="radio-choice-1" value="Metric" onclick="getSystem(\'Metric\');"';
    if($MemberDetails->SystemOfMeasure != 'Imperial')
        $Html.=' checked="checked"';
    $Html.='/>
     	<label for="radio-choice-1">Metric</label>

     	<input class="radioinput" type="radio" name="SystemOfMeasure" id="radio-choice-2" value="Imperial" onclick="getSystem(\'Imperial\');"';
    if($MemberDetails->SystemOfMeasure == 'Imperial')
        $Html.=' checked="checked"';
     $Html.='/>
     	<label for="radio-choice-2">Imperial</label>
</fieldset><br/>';        

$Html.='<div id="weightlabel">Height('.$HeightUnit.')</div>
<input id="weight" class="textinput" type="number" name="Weight" value="'.$MemberDetails->Weight.'"/>
<div id="heightlabel">Weight('.$WeightUnit.')</div>
<input id="height" class="textinput" type="number" name="Height" value="'.$MemberDetails->Height.'"/>
<br/><br/>';

$Html.='Gender
    <fieldset class="controlgroup" data-role="controlgroup" data-type="horizontal">
<label for="male">Male</label>
<input class="radioinput" id="male" type="radio" name="Gender" value="M"';
if($MemberDetails->Gender == 'M' || $MemberDetails->Gender == '') 
    $Html.='checked="checked"';
$Html.='/>
<label for="female">Female</label>
<input class="radioinput" id="female" type="radio" name="Gender" value="F"';
if($MemberDetails->Gender == 'F')
    $Html.='checked="checked"';
$Html.='/>
</fieldset><br/>';
     
$Html.='Custom Workouts Visibility
<fieldset class="controlgroup" data-role="controlgroup" data-type="horizontal">
<label for="private">Private</label>
<input class="radioinput" id="private" type="radio" name="CustomWorkouts" value="Private"';
if($MemberDetails->CustomWorkouts != 'Public') 
    $Html.='checked="checked"';
$Html.='/>
<label for="public">Public</label>
<input class="radioinput" id="public" type="radio" name="CustomWorkouts" value="Public"';
if($MemberDetails->CustomWorkouts == 'Public')
    $Html.='checked="checked"';
$Html.='/>
</fieldset>
<br/>
<input class="buttongroup" type="button" onclick="profilesubmit();" value="Save"/>
</div>
</form><div class="clear"></div><br/>';

        return $Html;
    }
}
?>