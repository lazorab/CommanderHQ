<?php
class VerifyController extends Controller
{
    function __construct()
    {
	parent::__construct();	
	session_start();	
    }
    
    function Validate()
    {
        $Model = new VerifyModel;
        $Validate = new ValidationUtils;		
        $Message = 'Success';       
        if(!$Validate->CheckMobileNumber($_REQUEST['Cell']))
            $Message = 'Cell number invalid!';
        else if($_REQUEST['Email'] != '' && !$Validate->CheckEmailAddress($_REQUEST['Email']))
            $Message = 'Email Address invalid!';
            
        return $Message;
    }
    
     function Message()
    {
        $Model = new VerifyModel;
        $Message = $this->Validate();
        if($Message == 'Success')
            $Message = $Model->Verify();
        
        return $Message;
    }   
        
    function Output()
    {
            $Html .= '<h2>Verification</h2><br/>
            <form action="index.php" name="refer" id="verifyform" method="post">
            <input type="hidden" name="module" value="verify"/>
            <input type="hidden" name="form" value="submitted"/>
            <input class="textinput" id="email" type="email" name="Email" value="'.$_REQUEST['Email'].'" placeholder="Email Address"/>
            <br/>
            <input class="textinput" id="cell" type="number" name="Cell" value="'.$_REQUEST['Cell'].'" placeholder="Cell ('.DEFAULT_SUB_NUMBER.')"/>
            <br/><br/>
            <input class="buttongroup" type="button" onClick="verifysubmit();" value="Submit"/>
            </form>';

        return $Html;
    }
}
?>