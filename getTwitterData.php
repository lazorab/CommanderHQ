<?php

require("twitter/twitteroauth.php");
require 'config/functions.php';
require 'config/twconfig.php';
session_start();

if (!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])) {
    // We've got everything we need
    $twitteroauth = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
// Let's request the access token
    $access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);
// Save it in a session var
    $_SESSION['access_token'] = $access_token;
// Let's get the user's info
    $user_info = $twitteroauth->get('account/verify_credentials');
    if (isset($user_info->error)) {
        // Something's wrong, go back to square 1  
        header('Location: index.php?module=login');
    } else {
        $uid = $user_info->id;
        $username = $user_info->name;
        $user = new User();
        $userdata = $user->checkUser($user_info, 'twitter');
        if(!empty($userdata)){
            session_start();
            $_SESSION['UID'] = $userdata['UserId'];
            $_SESSION['oauth_id'] = $uid;
            $_SESSION['UserName'] = $userdata['UserName'];
            $_SESSION['FirstName'] = $userdata['FirstName'];
            $_SESSION['oauth_provider'] = $userdata['oauth_provider'];
            $Redirect = $userdata['redirect'];
            header("Location: index.php?module=".$Redirect."");
        }
    }
} else {
    // Something's missing, go back to square 1
    header('Location: index.php?module=login');
}
?>
