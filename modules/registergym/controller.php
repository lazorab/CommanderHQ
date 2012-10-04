<?php
class RegistergymController extends Controller
{		
    function __construct()
    {
	parent::__construct();	
    }
    
    function Save()
    {
        $Validate = new ValidationUtils;		
        $Message = '';
        if($_REQUEST['gymname'] == '')
            $Message = 'Gym Name Required';
        else if($_REQUEST['url'] == '')
            $Message = 'Please enter URL for gym';
        else if($_REQUEST['email'] != '' && !$Validate->CheckEmailAddress($_REQUEST['email']))
            $Message = 'Invalid Email Address';
		
        if($Message == ''){
            $Model = new RegistergymModel;
            $Message=$Model->Register();
        }
        return $Message;       
    }
    
    function Output()
    {
        $Html='';
        if($_REQUEST['save'] == 'Save'){	
            $Message = $this->Save();
	}
        if($Message != 'Success'){
            $Html .= '<div id="message">' . $Message . '</div>';
        $Html.='<form action="index.php" method="post" name="form" id="gymform">
<div data-role="fieldcontain">
<input type="hidden" name="module" value="registergym"/>
<input type="hidden" name="save" value="Save"/>
<label for="gymname">Gym Name</label>
<input class="textinput" style="width:75%;" type="text" id="gymname" name="gymname" value="'.$_REQUEST['gymname'].'"/><br/>
<label for="country">Country</label>
<input class="textinput" style="width:75%;" type="text" id="country" name="country" value="'.$_REQUEST['country'].'"/><br/>
<label for="region">Region</label>
<input class="textinput" style="width:75%;" type="text" id="region" name="region" value="'.$_REQUEST['region'].'"/><br/>
<label for="tel">Tel</label>
<input class="textinput" style="width:75%;" type="tel" id="tel" name="tel" value="'.$_REQUEST['tel'].'" placeholder="+2778000000"/>
<label for="email">Email</label>
<input class="textinput" style="width:75%;" type="email" id="email" name="email" value="'.$_REQUEST['email'].'"/><br/>
<label for="url">Data Feed URL</label>
<input class="textinput" style="width:75%;" type="text" id="feedurl" name="feedurl" value="'.$_REQUEST['feedurl'].'"/><br/>    
<label for="url">Web URL</label>
<input class="textinput" style="width:75%;" type="text" id="weburl" name="weburl" value="'.$_REQUEST['weburl'].'"/><br/>
<br/><br/>
<input class="buttongroup" type="button" onclick="gymformsubmit();" value="Save"/>
</div>
</form>
<br/>';
        }
        else{
            $Html = $Message;
        }
        return $Html;
    }
}
?>