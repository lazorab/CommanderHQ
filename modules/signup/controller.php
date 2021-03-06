<?php
class SignupController extends Controller
{
    function __construct()
    {
	parent::__construct();	
	session_start();
	if(isset($_COOKIE['UID']))
            header('location: index.php?module=memberhome');	
    }
    
    function Validate()
    {
        $Model = new SignupModel;
        $Validate = new ValidationUtils;		
        $Message = 'Success';       
        if($_REQUEST['FirstName'] == '')
            $Message = 'Error - Please enter your First Name!';
        else if($_REQUEST['LastName'] == '')
            $Message = 'Error - Please enter your Last Name!';
        else if(!isset($_SESSION['NEW_USER']) && $Model->CheckUserNameExists($_REQUEST['UserName']))
            $Message = 'Error - Username already exists!';
        else if(!isset($_SESSION['NEW_USER']) && $_REQUEST['UserName'] == '')
            $Message = 'Error - Invalid Username!';
        else if(!isset($_SESSION['NEW_USER']) && $_REQUEST['PassWord'] == '')
            $Message = 'Error - Invalid Password!';
        else if(!isset($_SESSION['NEW_USER']) && trim($_REQUEST['PassWord']) != trim($_REQUEST['ConfirmPassWord']))
            $Message = 'Error - Passwords do not match!';  
        else if($Model->CheckEmailExists(trim($_REQUEST['Email'])))
            $Message = 'Error - Email already exists!';
        else if($_REQUEST['Email'] == '')
            $Message = 'Error - Email Address required!';        
        else if($_REQUEST['Email'] != '' && !$Validate->CheckEmailAddress(trim($_REQUEST['Email'])))
            $Message = 'Error - Email Address invalid!';  
        else if(!$Validate->CheckMobileNumber(trim($_REQUEST['Cell'])))
            $Message = 'Error - Please enter a valid Cell number!';       
        else if($Model->CheckCellExists(trim($_REQUEST['Cell'])))
            $Message = 'Error - Cell Number already exists!';
        else if($_REQUEST['Gender'] == '')
            $Message = 'Error - Must Select Gender!';        
        else if($_REQUEST['SystemOfMeasure'] == '')
            $Message = 'Error - Must Select System of Measure!';        
            
        return $Message;
    }
    
     function Message()
    {
        $Model = new SignupModel;
        $Message = $this->Validate();
        if($Message == 'Success')
            $Message = $Model->Signup();
        
        return $Message;
    }   
        
    function Output()
    {
            $Html .= '<h2>Sign Up</h2>
            * All fields are required    
            <form action="index.php" name="refer" id="verifyform" method="post">
            <input type="hidden" name="form" value="submitted"/>
            <input class="textinput" type="text" id="firstname" name="FirstName" placeholder="First Name" value="'.trim($_REQUEST['FirstName']).'"/>
            <br/>    
            <input class="textinput" type="text" id="lastname" name="LastName" placeholder="Last Name" value="'.trim($_REQUEST['LastName']).'"/>';
            if(!isset($_SESSION['NEW_USER'])){ 
            $Html .= '<br/>   
            <input class="textinput" type="text" id="username" name="UserName" placeholder="User Name" value="'.trim($_REQUEST['UserName']).'"/>
            <br/>    
            <input class="textinput" type="password" id="password" name="PassWord" placeholder="Password" value="'.trim($_REQUEST['PassWord']).'"/>
            <br/>    
            <input class="textinput" type="password" id="password" name="ConfirmPassWord" placeholder="Confirm Password" value="'.trim($_REQUEST['ComfirmPassWord']).'"/>';
            }
            $Html .= '<br/>
            <input class="textinput" id="email" type="email" name="Email" value="'.trim($_REQUEST['Email']).'" placeholder="Email Address"/>
            <br/>
            <input class="textinput" id="cell" type="tel" name="Cell" value="'.trim($_REQUEST['Cell']).'" placeholder="Cell ('.DEFAULT_SUB_NUMBER.')"/> 
            <br/>';  
            
 $Html.='<fieldset class="controlgroup" data-role="controlgroup" data-type="horizontal">
<label for="male">Male</label>
<input class="radioinput" id="male" type="radio" name="Gender" value="M"/>
<label for="female">Female</label>
<input class="radioinput" id="female" type="radio" name="Gender" value="F"/>
</fieldset><br/>';           
            
$Html.='System Of Measure
    <fieldset class="controlgroup" data-role="controlgroup" data-type="horizontal">
    <input class="radioinput" type="radio" name="SystemOfMeasure" id="radio-choice-1" value="Metric"/>
     	<label for="radio-choice-1">Metric</label>
     	<input class="radioinput" type="radio" name="SystemOfMeasure" id="radio-choice-2" value="Imperial"/>
     	<label for="radio-choice-2">Imperial</label>
</fieldset><br/>            
            <input class="buttongroup" type="button" onClick="verifysubmit();" value="Submit"/>
            <br/>
            </form><div class="clear"></div>';

        return $Html;
    }
}
?>