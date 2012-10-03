<?php
class ReferController extends Controller
{
    function __construct()
    {
	parent::__construct();	
	session_start();	
    }
        
    function Output()
    {
        $Message = '';
        $Model = new ReferModel;
        $Html = '';
        if($_REQUEST['submit'] == 'Submit'){
            $Message = $Model->ReferFriend();
        }
            $Html .= '<div id="message">' . $Message . '</div>
            <div id="container" style="color:#fff;height:350px;padding-left:20%">
            <br/><br/>
            <form action="index.php" name="refer" id="referform" method="post">
            <input type="hidden" name="module" value="refer"/>
            <input type="hidden" name="submit" value="Submit"/>
            <input type="hidden" name="MemberId" value="'.$_SESSION['UID'].'"/>
            <input class="textinput" style="margin:0 5% 2% 5%;width:50%;" type="email" name="FriendEmail" placeholder="Friend\'s Email Address"/>
            <input class="buttongroup" type="button" onClick="refersubmit();" value="Submit"/>
            </form>
            </div>';

        return $Html;
    }
}
?>