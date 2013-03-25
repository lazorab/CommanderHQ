<?php

require 'facebook/facebook.php';
require 'config/fbconfig.php';
require 'config/functions.php';

   $app_id = APP_ID;
   $app_secret = APP_SECRET;
   $my_url = REDIRECT_URL;

   session_start();
   
   $code = $_REQUEST["code"];

   if(empty($code)) {
     $_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
     $dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" 
       . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
       . $_SESSION['state'] . "";

     header("Location: " . $dialog_url);
   }   
   
   if($_SESSION['state'] && ($_SESSION['state'] === $_REQUEST['state'])) {
     $token_url = "https://graph.facebook.com/oauth/access_token?"
       . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
       . "&client_secret=" . $app_secret . "&code=" . $code;
     
     $response = file_get_contents($token_url);

     $params = null;
     parse_str($response, $params);

     $_SESSION['access_token'] = $params['access_token'];

     $graph_url = "https://graph.facebook.com/me?access_token=" 
       . $params['access_token'];
    
     $user = json_decode(file_get_contents($graph_url));
     //$user_info = new UserObject($user);

        $fb_user = new User();
        $userdata = $fb_user->checkUser($user, 'facebook');

        if(!empty($userdata)){
            session_start();
            $_SESSION['oauth_id'] = $user->id;
            $_SESSION['oauth_provider'] = $userdata->oauth_provider;
            $Redirect = $userdata->redirect;
            header("Location: index.php?module=".$Redirect."");
        }     
   }
   else {
     echo("The state does not match. You may be a victim of CSRF.");
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
