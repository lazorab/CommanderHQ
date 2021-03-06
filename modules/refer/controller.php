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
        $Model = new ReferModel;
        $Validate = new ValidationUtils;		
        $Message = 'Success';       
        if($_REQUEST['FriendName'] == '')
            $Message = 'Name Required';
        else if($_REQUEST['FriendEmail'] != '' && !$Validate->CheckEmailAddress($_REQUEST['FriendEmail']))
            $Message = 'Email Address invalid!';        
        else if(!$Validate->CheckMobileNumber($_REQUEST['FriendCell']))
            $Message = 'Please enter a valid Cell number!'; 
        else if($Model->CheckFriendExists())
            $Message = 'Friend has been invited already!';
            
        return $Message;
    }
    
     function Message()
    {
        $Model = new ReferModel;
        $Message = $this->Validate();
        if($Message == 'Success')
            $Message = $Model->ReferFriend();
        
        return $Message;
    }   
        
    function Output()
    {
            $Html .= '<h2>Refer a friend</h2><br/>
            <form action="index.php" name="refer" id="referform" method="post">
            <input type="hidden" name="form" value="submitted"/>
            <input class="textinput" id="name" type="text" name="FriendName" placeholder="Friend\'s Name"/>                
            <br/>
            <input class="textinput" id="email" type="email" name="FriendEmail" placeholder="Friend\'s Email Address"/>
            <br/>
            <input class="textinput" id="cell" type="tel" name="FriendCell" placeholder="Friend\'s Cell ('.DEFAULT_SUB_NUMBER.')"/>
            <br/><br/>
            <input class="buttongroup" type="button" onClick="refersubmit();" value="Submit"/>
            </form>';

        return $Html;
    }
}
?>