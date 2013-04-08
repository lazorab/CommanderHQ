<?php
class VerifyController extends Controller
{
    function __construct()
    {
	parent::__construct();	
	session_start();
	if(isset($_COOKIE['UID']))
            header('location: index.php?module=memberhome');	
    }
    
     function Message()
    {
        $Model = new VerifyModel;
        $Message = $Model->Verify();
        
        return $Message;
    }   
        
    function Output()
    {
        $Model = new VerifyModel;
        $Details = $Model->getMemberVerificationDetails();
            $Html .= '<h2>Verification</h2>
            <form action="index.php" name="verify" id="verifyform" method="post">
            <input type="hidden" name="form" value="submitted"/>
            <input class="hidden" type="text" id="firstname" name="FirstName" value="'.$Details->FirstName.'"/>
            <input class="hidden" type="text" id="lastname" name="LastName" value="'.$Details->LastName.'"/>     
            <input class="hidden" id="email" type="email" name="Email" value="'.$Details->Email.'/>
            <input class="hidden" id="cell" type="number" name="Cell" value="'.$Details->Cell.'"/>
            <input class="textinput" type="text" id="invcode" name="code" placeholder="Verification Code" value="'.$_REQUEST['code'].'"/>  
            <br/>
            <input class="buttongroup" type="button" onClick="verifysubmit();" value="Submit"/>
            <br/>
            </form><div class="clear"</div>';

        return $Html;
    }
}
?>