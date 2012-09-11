<?php
class ProfileController extends Controller
{
	var $Message;
	var $MemberDetails;
	var $Weight;
	var $Height;	
	var $System;
	var $AlternateSystem;	
	
	function __construct()
	{
		parent::__construct();
		session_start();
        }
        
        function Validate()
        {
            $Model = new ProfileModel;
            $Validate = new ValidationUtils;		
            $Message = 'Success';
            if($_REQUEST['FirstName'] == '')
                $Message = 'Firstname Required';
            elseif($_REQUEST['LastName'] == '')
                $Message = 'Lastname Required';
            elseif($_REQUEST['Cell'] == '' && $_REQUEST['Email'] == '')
                $Message = 'Either a Cell or Email Required';
            elseif($_REQUEST['Cell'] != '' && !$Validate->CheckMobileNumber($_REQUEST['Cell']))
                $Message = 'Cell number invalid!';
            elseif($_REQUEST['Email'] != '' && !$Validate->CheckEmailAddress($_REQUEST['Email']))
                $Message = 'Email Address invalid!';
            elseif($_REQUEST['DOB'] == '')
                $Message = 'Invalid Date of Birth';				
            elseif($_REQUEST['Weight'] == '')
                $Message = 'Weight Required';
            elseif($_REQUEST['Height'] == '')
                $Message = 'Height Required';
            elseif($_REQUEST['Gender'] == '')		
                $Message = 'Select Gender';
		
            return $Message;	
	}
    
    function Save()
    {
        $Model = new ProfileModel;
        $Message = $this->Validate();
        if($Message == 'Success')
        {
            if(isset($_SESSION['UID'])){
                $Model->Update($_SESSION['UID']);
            }else if(isset($_SESSION['NEW'])){
                $Model->Update($_SESSION['NEW']);
            }else{
                $Model->Register();
            }
        }
        return $Message;
    }
        
    function Output()
    {
        $Message = '';
        $Model = new ProfileModel;
        $Html = '';
        if($_REQUEST['action'] == 'save'){
            $Message = $this->Save();
        }
        if($Message != 'Success'){
            $Html .= '<div id="message">' . $Message . '</div>';

        $Id=0;
        if(isset($_SESSION['UID'])){
            $Id = $_SESSION['UID'];
        }else if(isset($_SESSION['NEW'])){
            $Id = $_SESSION['NEW'];
        }       

        if($Id == 0)
            $MemberDetails = $Model->getPostedDetails();
        else
            $MemberDetails = $Model->getMemberDetails($Id);
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
        <input type="hidden" name="action" value="save"/>
        <input type="hidden" name="UserId" value="'.$MemberDetails->UserId.'"/>
        <input id="systemofmeasure" type="hidden" name="SystemOfMeasure" value="'.$MemberDetails->SystemOfMeasure.'"/>
<label for="firstname">First Name</label>
<input style="width:75%;" class="textinput" type="text" id="firstname" name="FirstName" value="'.$MemberDetails->FirstName.'"/>
<label for="lastname">Last Name</label>
<input style="width:75%;" class="textinput" type="text" id="lastname" name="LastName" value="'.$MemberDetails->LastName.'"/>
<label for="username">User Name</label>
<input style="width:75%;" class="textinput" type="text" id="username" name="UserName" value="'.$MemberDetails->UserName.'" readonly="readonly"/>
<label for="password">Password</label>
<input style="width:75%;" class="textinput" type="password" id="password" name="PassWord" value="'.$MemberDetails->PassWord.'"/>
<label for="cell">Cell</label>
<input style="width:75%;" class="textinput" type="tel" id="cell" name="Cell" value="'.$MemberDetails->Cell.'" placeholder="+2778000000"/>
<label for="email">Email</label>
<input style="width:75%;" class="textinput" type="email" id="email" name="Email" value="'.$MemberDetails->Email.'"/>
<label for="DOB">Date of Birth</label>
<input style="width:75%;" class="textinput" type="date" name="DOB" id="DOB" value="'.$MemberDetails->DOB.'"/>
<br/><br/>
<fieldset class="controlgroup" data-role="controlgroup" data-type="horizontal">
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
<input style="width:75%;" id="weight" class="textinput" type="text" name="Weight" value="'.$MemberDetails->Weight.'"/>
<div id="heightlabel">Weight('.$WeightUnit.')</div>
<input style="width:75%;" id="height" class="textinput" type="text" name="Height" value="'.$MemberDetails->Height.'"/>
<br/><br/>	
<fieldset class="controlgroup" data-role="controlgroup" data-type="horizontal">
    <input class="radioinput" type="radio" name="system" id="radio-choice-1" value="Metric" onclick="getSystem(\'Metric\');"';
    if($MemberDetails->SystemOfMeasure == 'Metric')
        $Html.=' checked="checked""';
    $Html.='/>
     	<label for="radio-choice-1">Metric</label>

     	<input class="radioinput" type="radio" name="system" id="radio-choice-2" value="Imperial" onclick="getSystem(\'Imperial\');"';
    if($MemberDetails->SystemOfMeasure == 'Imperial')
        $Html.=' checked="checked""';
     $Html.='/>
     	<label for="radio-choice-2">Imperial</label>
</fieldset>

<br/>
<input class="buttongroup" type="button" onclick="profilesubmit();" value="Save"/><br/><br/>
</div>
</form>';
        }
        else{
            $Html = $Message;
        }
        return $Html;
    }

    function Height()
    {
        if($this->Height == '')
            return 0;
        else
        return $this->Height;
    }

    function Weight()
    {
        if($this->Weight == '')
            return 0;
        else
        return $this->Weight;
    }
	
	function Message()
	{
		return $this->Message;
	}
}
?>