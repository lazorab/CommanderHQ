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
                $this->UserId = $_SESSION['UID'];
            }
        }
        
        function Validate()
        {
            $Model = new ProfileModel;
            $Validate = new ValidationUtils;		
            $Message = 'Success';
            if(isset($_REQUEST['InvCode']) && !$Model->CheckInvitationCode($_REQUEST['InvCode']))
                $Message = 'Invalid Invitation Code';
            else if($_REQUEST['FirstName'] == '')
                $Message = 'Firstname Required';
            else if($_REQUEST['LastName'] == '')
                $Message = 'Lastname Required';
            else if(!isset($_SESSION['UID']) && $Model->CheckUserNameExists($_REQUEST['UserName']))
                $Message = 'Username already exists. Please choose another.';
            else if($_REQUEST['PassWord'] != $_REQUEST['ConfirmPassWord'])
                $Message = 'Passwords do not match!';
            else if($_REQUEST['Cell'] == '' && $_REQUEST['Email'] == '')
                $Message = 'Either a Cell or Email Required';
            else if($_REQUEST['Cell'] == '' || !$Validate->CheckMobileNumber($_REQUEST['Cell']))
                $Message = 'Cell number invalid!';
            else if($_REQUEST['Email'] != '' && !$Validate->CheckEmailAddress($_REQUEST['Email']))
                $Message = 'Email Address invalid!';
            else if(!isset($_SESSION['UID']) && $Model->CheckEmailExists($_REQUEST['Email']))
                $Message = 'Email Address already exists!';
            else if($_REQUEST['DOB'] == '')
                $Message = 'Invalid Date of Birth';				
            else if($_REQUEST['Weight'] == '')
                $Message = 'Weight Required';
            else if($_REQUEST['Height'] == '')
                $Message = 'Height Required';
            else if($_REQUEST['Gender'] == '')		
                $Message = 'Select Gender';
            else if($_REQUEST['CustomWorkouts'] == '')		
                $Message = 'Select access to your Custom Workouts';
		
            return $Message;	
	}
    
    function Message()
    {
        $Message = $this->Validate();
        if($Message == 'Success')
        {
            $Model = new ProfileModel; 
            if(isset($_SESSION['UID'])){
                $this->UserId = $_SESSION['UID'];
                $Model->Update($_SESSION['UID']);
            }else if(isset($_SESSION['NEW_USER'])){
                $this->UserId = $_SESSION['NEW_USER'];
                $Model->Update($_SESSION['NEW_USER']);
            }else{
                $Model->Register();
                $this->UserId = $_SESSION['UID'];
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
      if(!isset($_SESSION['UID'])){
          $Html.='
            <input style="width:75%;" class="textinput" type="text" id="invcode" name="InvCode" placeholder="Invitation Code" value="'.$_REQUEST['InvCode'].'"/>';
      }      
$Html.='<br/><br/>
<input style="width:75%;" class="textinput" type="text" id="firstname" name="FirstName" placeholder="First Name" value="'.$MemberDetails->FirstName.'"/>
<br/><br/>
<input style="width:75%;" class="textinput" type="text" id="lastname" name="LastName" placeholder="Last Name" value="'.$MemberDetails->LastName.'"/>
<br/><br/>
<input style="width:75%;" class="textinput" type="text" id="username" name="UserName" placeholder="User Name" value="'.$MemberDetails->UserName.'"'; 
if(isset($_SESSION['UID']) || $MemberDetails->LoginType != '')   
    $Html.=' readonly="readonly"';
$Html.='/>';
if($MemberDetails->LoginType == ''){
$Html.='<br/><br/>
<input style="width:75%;" class="textinput" type="password" id="password" name="PassWord" placeholder="Password" value="'.$MemberDetails->PassWord.'"/>
<br/><br/>
<input style="width:75%;" class="textinput" type="password" id="confirmpassword" name="ConfirmPassWord" placeholder="Confirm Password" value="'.$MemberDetails->PassWord.'"/>';
}
else{
   $Html.='<br/><br/>
<input style="width:75%;" class="textinput" type="text" id="oauth_provider" name="oauth_provider" placeholder="Login Type" value="'.$MemberDetails->LoginType.'" readonly="readonly"/>'; 
}
$Html.='<br/><br/>
<input style="width:75%;" class="textinput" type="tel" id="cell" name="Cell" value="'.$MemberDetails->Cell.'" placeholder="Cell (+2778000000)"/>
<br/><br/>
<input style="width:75%;" class="textinput" type="email" id="email" name="Email" placeholder="Email" value="'.$MemberDetails->Email.'"/>
<br/><br/>
<input style="width:75%;" class="textinput" type="date" name="DOB" id="DOB" placeholder="Date of Birth" value="'.$MemberDetails->DOB.'"/>
<br/><br/>';

 $Html.='<select class="select" name="AffiliateId" id="AffiliateId">
            <option value="">Select your Gym</option>';
        foreach($Affiliates AS $Affiliate){
            $Html.='<option value="'.$Affiliate->AffiliateId.'">'.$Affiliate->GymName.'</option>';
        }
        $Html.='</select><br/><br/>';

$Html.='<fieldset class="controlgroup" data-role="controlgroup" data-type="horizontal">
<label for="male">Male</label>
<input class="radioinput" id="male" type="radio" name="Gender" value="M"';
if($MemberDetails->Gender == 'M') 
    $Html.='checked="checked"';
$Html.='/>
<label for="female">Female</label>
<input class="radioinput" id="female" type="radio" name="Gender" value="F"';
if($MemberDetails->Gender == 'F')
    $Html.='checked="checked"';
$Html.='/>
</fieldset>
<br/><br/>
<div id="weightlabel">Height('.$HeightUnit.')</div>
<input style="width:75%;" id="weight" class="textinput" type="number" name="Weight" value="'.$MemberDetails->Weight.'"/>
<div id="heightlabel">Weight('.$WeightUnit.')</div>
<input style="width:75%;" id="height" class="textinput" type="number" name="Height" value="'.$MemberDetails->Height.'"/>
<br/><br/>
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
</fieldset>
<br/><br/>
Custom Workouts Visibility
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
<input class="buttongroup" type="button" onclick="profilesubmit();" value="Save"/><br/><br/>
</div>
</form>';

        return $Html;
    }
}
?>