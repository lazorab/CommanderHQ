<?php
class ReferController extends Controller
{
    function __construct()
    {
	parent::__construct();	
	session_start();	
    }
    
    function Validate()
    {
        $Validate = new ValidationUtils;		
        $Message = 'Success';       
        if($_REQUEST['FriendName'] == '')
            $Message = 'Name Required';
        else if($_REQUEST['FriendCell'] == '' && $_REQUEST['FriendEmail'] == '')
            $Message = 'Either a Cell or Email Required';
        else if($_REQUEST['FriendCell'] == '' || !$Validate->CheckMobileNumber($_REQUEST['FriendCell']))
            $Message = 'Cell number invalid!';
        else if($_REQUEST['FriendEmail'] != '' && !$Validate->CheckEmailAddress($_REQUEST['FriendEmail']))
            $Message = 'Email Address invalid!';      
            
        return $Message;
    }
        
    function Output()
    {
        $Message = '';
        $Model = new ReferModel;
        $Html = '';
        if($_REQUEST['submit'] == 'Submit'){
            $Message = $this->Validate();
            if($Message == 'Success')
                $Message = $Model->ReferFriend();
        }
            $Html .= '<div id="message">' . $Message . '</div>
            <div id="container" style="color:#fff;height:350px;padding-left:20%">
            <br/><br/>
            <form action="index.php" name="refer" id="referform" method="post">
            <input type="hidden" name="module" value="refer"/>
            <input type="hidden" name="submit" value="Submit"/>
            <label for="name">Friend\'s Name</label>
            <input class="textinput" style="margin:0 5% 2% 5%;width:50%;" id="name" type="text" name="FriendName" placeholder="Friend\'s name"/>                
            <label for="email">Friend\'s Email</label>
            <input class="textinput" style="margin:0 5% 2% 5%;width:50%;" id="email" type="email" name="FriendEmail" placeholder="Friend\'s Email Address"/>
            <label for="cell">Friend\'s Cell</label>
            <input class="textinput" style="margin:0 5% 2% 5%;width:50%;" id="cell" type="number" name="FriendCell" placeholder="'.DEFAULT_SUB_NUMBER.'"/>
            <input class="buttongroup" type="button" onClick="refersubmit();" value="Submit"/>
            </form>
            </div>';

        return $Html;
    }
}
?>