<?php
class LoginController extends Controller
{
	var $Message='';
	
	function __construct()
	{
		parent::__construct();	
		$Model = new LoginModel();
		session_start();
		if(isset($_SESSION['UID'])){
			header('location: index.php?module=memberhome');	
		}
		else if($_REQUEST['action'] == 'Login')
		{
			$UserId = $Model->Login($_REQUEST['username'], $_REQUEST['password']);	
			if(!$UserId){
				$this->Message = 'Invalid Credentials, Please try again.';
			}
			else{
				if($_REQUEST['remember'] == 'yes'){
					setcookie("CommanderUsername", $_REQUEST['username'], time() + (20 * 365 * 24 * 60 * 60), '/', 'crossfit.be-mobile.co.za', false, false);
					setcookie("CommanderPassword", $_REQUEST['password'], time() + (20 * 365 * 24 * 60 * 60), '/', 'crossfit.be-mobile.co.za', false, false);
				}			
				$_SESSION['UID'] = $UserId;

				header('location: index.php?module=memberhome');
			}		
		}	
        else if($_REQUEST['oauth_provider'] == 'twitter')
		{
            header("Location: login-twitter.php");		
		}
        else if($_REQUEST['action'] == 'google')
		{
            
		}
        else if($_REQUEST['action'] == 'facebook')
		{
            $facebook = new Facebook(array(
                                           'appId' => FB_APP_ID,
                                           'secret' => FB_APP_SECRET,
                                           'cookie' => true
                                           ));
            
            $session = $facebook->getSession();
            
            if (!empty($session)) {
                # Active session, let's try getting the user id (getUser()) and user info (api->('/me'))
                try {
                    $uid = $facebook->getUser();
                    $user = $facebook->api('/me');
                } catch (Exception $e) {
                    
                    
                    
                    
                }
                
                if (!empty($user)) {
                    # User info ok? Let's print it (Here we will be adding the login and registering routines)
                    echo '<pre>';
                    print_r($user);
                    echo '</pre><br/>';
                    $username = $user['name'];
                    $userdata = $Model->checkUser($uid, 'facebook', $username);
                    if(!empty($userdata)){
                        $_SESSION['UID'] = $userdata['id'];
                        $_SESSION['oauth_id'] = $uid;
                        
                        $_SESSION['username'] = $userdata['username'];
                        $_SESSION['oauth_provider'] = $userdata['oauth_provider'];
                        header("Location: index.php?module=memberhome");
                    }
                } else {
                    # For testing purposes, if there was an error, let's kill the script
                    die("There was an error.");
                }
            } else {
                # There's no active session, let's generate one
                $login_url = $facebook->getLoginUrl();
                header("Location: " . $login_url);  
            }
		}
		else if($_REQUEST['action'] == 'Retrieve')
		{
			$Model = new LoginModel();
			if($_REQUEST['username'] == '')
				$this->Message = 'You must enter your Username';
			if($_REQUEST['email'] == '')
				$this->Message = 'You must enter your Email Address';
			if($Message == '')
			{
				$Successful = $Model->RetrievePassword($_REQUEST['username'], $_REQUEST['email']);
				if(!$Successful)
					$this->Message = 'Error sending email';
				else
					$this->Message = 'You have been sent an email';
			}
		}
	}	
}
?>