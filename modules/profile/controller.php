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

        $Model = new ProfileModel;
		$Validate = new ValidationUtils;		
		$this->Message = '';
		
		if($_REQUEST['formsubmitted'] == 'yes')
		{

            if($_REQUEST['FirstName'] == '')
                $this->Message = 'Firstname Required';
            elseif($_REQUEST['LastName'] == '')
                $this->Message = 'Lastname Required';
            elseif($_REQUEST['Cell'] == '' && $_REQUEST['Email'] == '')
                $this->Message = 'Either a Cell or Email Required';
            elseif($_REQUEST['Cell'] != '' && !$Validate->CheckMobileNumber($_REQUEST['Cell']))
                $this->Message = 'Cell number invalid!';
            elseif($_REQUEST['Email'] != '' && !$Validate->CheckEmailAddress($_REQUEST['Email']))
                $this->Message = 'Email Address invalid!';
            elseif($_REQUEST['DOB'] == '')
                $this->Message = 'Invalid Date of Birth';				
            elseif($_REQUEST['Weight'] == '')
                $this->Message = 'Weight Required';
            elseif($_REQUEST['Height'] == '')
                $this->Message = 'Height Required';
            elseif($_REQUEST['Gender'] == '')		
                $this->Message = 'Select Gender';
		
            if($this->Message == '')
            {
                if(isset($_SESSION['UID'])){
                    $Model->Update($_SESSION['UID']);
                }else if(isset($_SESSION['NEW'])){
                    $Model->Update($_SESSION['NEW']);
                }else{
                    $Model->Register();
                }
            
                header('location: index.php?module=memberhome');
            }
        }	
	}
    
    function Output()
    {
        $Model = new ProfileModel;
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
        if($MemberDetails->DOB == '')
           $DOB = '';
        else
            $DOB = date('j M Y',strtotime($MemberDetails->DOB));

        $WeightUnit = 'kg';
        $HeightUnit = 'cm';
        
        if($MemberDetails->SystemOfMeasure == 'Imperial'){
            $WeightUnit = 'lbs';
            $HeightUnit = 'inches';
        }
        $Html='
        <form action="index.php" method="post">
        <div data-role="fieldcontain">
        <input type="hidden" name="module" value="profile"/>
        <input type="hidden" name="formsubmitted" value="yes"/>
        <input type="hidden" name="UserId" value="'.$MemberDetails->UserId.'"/>
<input id="systemofmeasure" type="hidden" name="SystemOfMeasure" value="'.$MemberDetails->SystemOfMeasure.'"/>
<label for="firstname">First Name</label>
<input style="width:75%;" type="text" id="firstname" name="FirstName" value="'.$MemberDetails->FirstName.'"/>
<label for="lastname">Last Name</label>
<input style="width:75%;" type="text" id="lastname" name="LastName" value="'.$MemberDetails->LastName.'"/>
<label for="cell">Cell</label>
<input style="width:75%;" type="tel" id="cell" name="Cell" value="'.$MemberDetails->Cell.'" placeholder="+2778000000"/>
<label for="email">Email</label>
<input style="width:75%;" type="email" id="email" name="Email" value="'.$MemberDetails->Email.'"/>
<label for="DOB">Date of Birth</label>
<input style="width:75%;" type="date" name="DOB" id="DOB" value="'.$DOB.'"/>	
Male
<input id="male" type="radio" name="Gender" value="M" data-role="none"';
if($MemberDetails->Gender == 'M') 
    $Html.='checked="checked"';
$Html.='/>
<br/>
Female
<input id="female" type="radio" name="Gender" value="F" data-role="none"';
if($MemberDetails->Gender == 'F')
    $Html.='checked="checked"';
$Html.='/><br/><br/>
<div id="weightlabel">Height('.$HeightUnit.')</div>
<input style="width:75%;" id="weight" type="text" name="Weight" value="'.$MemberDetails->Weight.'"/>
<div id="heightlabel">Weight('.$WeightUnit.')</div>
<input style="width:75%;" id="height" type="text" name="Height" value="'.$MemberDetails->Height.'"/>
<br/>
<label for="system">Preferred Sytem of Measurement</label>
<select style="width:75%;" id="system" name="system" class="select" onchange="getSystem(this.value);">
<option value="Metric"';
if($MemberDetails->SystemOfMeasure == 'Metric')
    $Html.=' selected="selected"';
$Html.='>Metric</option>
<option value="Imperial"';
if($MemberDetails->SystemOfMeasure == 'Imperial')
    $Html.=' selected="selected"';
$Html.='>Imperial</option>
</select>
<br/><br/>
<input type="submit" name="submit" value="Save" data-role="none"/><br/><br/>
</div>
</form>';
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