<?php
class SignupController extends Controller
{
    function __construct()
    {
	parent::__construct();	
	session_start();	
    }
    
    function Validate()
    {
        $Model = new SignupModel;
        $Validate = new ValidationUtils;		
        $Message = 'Success';       
        if(!$Validate->CheckMobileNumber(trim($_REQUEST['Cell'])))
            $Message = 'Please enter a valid Cell number!';
        else if($_REQUEST['Email'] != '' && !$Validate->CheckEmailAddress(trim($_REQUEST['Email'])))
            $Message = 'Email Address invalid!';
            
        return $Message;
    }
    
     function Message()
    {
        $Model = new SignupModel;
        $Message = $this->Validate();
        if($Message == 'Success')
            $Message = $Model->Verify();
        
        return $Message;
    }   
        
    function Output()
    {
            $Html .= '<h2>Sign Up</h2><br/>
            <form action="index.php" name="refer" id="verifyform" method="post">
            <input type="hidden" name="form" value="submitted"/>
            <input class="textinput" id="email" type="email" name="Email" value="'.trim($_REQUEST['Email']).'" placeholder="Email Address"/>
            <br/>
            <input class="textinput" id="cell" type="number" name="Cell" value="'.trim($_REQUEST['Cell']).'" placeholder="Cell ('.DEFAULT_SUB_NUMBER.')"/>
            <br/><br/>
            <input class="buttongroup" type="button" onClick="verifysubmit();" value="Submit"/>
            </form>';

        return $Html;
    }
}
?>