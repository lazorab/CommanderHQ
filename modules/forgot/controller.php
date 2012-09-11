<?php
class ForgotController extends Controller
{
	
    function __construct()
    {
	parent::__construct();	
	session_start();	
    }
        
    function Output()
    {
        $Message = '';
        $Model = new ForgotModel;
        $Html = '';
        if($_REQUEST['submit'] == 'Submit'){
            $Message = $Model->RetrievePassword();
        }
        if($Message != 'Success'){
            $Html .= '<div id="message">' . $Message . '</div>
            <div id="container" style="color:#fff;height:350px;padding-left:20%">
            <br/><br/>
            <form action="index.php" name="forgot" id="forgotform" method="post">
            <input type="hidden" name="module" value="forgot"/>
            <input type="hidden" name="submit" value="Submit"/>
            <input style="margin:0 5% 2% 5%;width:50%;" type="email" name="email" placeholder="Email Address"/>
            <input type="button" onClick="forgotsubmit();" value="Submit"/>
            </form>
            </div>';
         
        }else{
            $Html = $Message;
        }
        return $Html;
    }
}
?>