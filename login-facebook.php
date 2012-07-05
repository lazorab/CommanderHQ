<?php

require 'facebook/facebook.php';
require 'config/fbconfig.php';
require 'config/functions.php';

$facebook = new Facebook(array(
            'appId' => APP_ID,
            'secret' => APP_SECRET,
            'cookie' => true
        ));

$session = $facebook->getSession();

if (!empty($session)) {
    # Active session, let's try getting the user id (getUser()) and user info (api->('/me'))
    try {
        $uid = $facebook->getUser();
        $user_info = new UserObject($facebook->api('/me'));
    } catch (Exception $e) {


    }

    if (!empty($user_info)) {
        $fb_user = new User();
        $userdata = $fb_user->checkUser($user_info, 'facebook');
        if(!empty($userdata)){
            session_start();
            $_SESSION['oauth_id'] = $uid;
            $_SESSION['oauth_provider'] = $userdata['oauth_provider'];
            $Redirect = $userdata['redirect'];
            header("Location: index.php?module=".$Redirect."");
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
    
class UserObject{
    var $id;
    var $name;
    var $username;
    var $gender;
    
    function __construct($Array)
    {
        $this->id = $Array['id'];
        $this->name = $Array['name'];
        $this->username = $Array['username'];
        $this->gender = $Array['gender'];
    }
}
?>
